<?php get_header(); ?>

<?php 

  $options_group           = get_field( 'search_listing_page', 'option' );
  //wicket_write_log($options_group, true);

  $show_search_bar         = $options_group['show_search_bar'] ?? true;

  // Filter configs
  $excluded_post_types     = $options_group['excluded_post_types'] ?? '';
  $excluded_post_ids       = $options_group['excluded_post_ids'] ?? '';
  $posts_per_page          = $options_group['posts_per_page'] ?? 10;
  $show_filter_bar         = $options_group['show_filter_bar'] ?? true;
  $taxonomy_filters_field  = $options_group['taxonomy_filters'] ?? '';
  $show_filter_by_pub_date = $options_group['show_filter_by_published_date'] ?? true;

  // Card listing view configs
  $show_featured_image     = $options_group['card_show_featured_image'] ?? true;
  $show_content_type_tags  = $options_group['card_show_content_type_tags'] ?? true; // TODO: Update
  $show_pub_date           = $options_group['card_show_published_date'] ?? true;
  $show_excerpt            = $options_group['card_show_excerpt'] ?? true;

  // TODO: Add support for advanced/elastic search

  $search_term = $_GET['s'] ?? '';


  // Set the page sorting based on parameter
  $order = 'DESC';
  if( isset( $_GET['sortby'] ) ) {
    if( $_GET['sortby'] == 'old-to-new' ) {
      $order = 'ASC';
    }
  }

  // Set excluded post types
  $excluded_post_types = explode( ',', $excluded_post_types );
  $all_post_types = get_post_types();
  $post_types = array_keys( array_diff( $all_post_types, $excluded_post_types ) );

  // Set excluded post IDs
  $excluded_post_ids = explode( ',', $excluded_post_ids );

  // Create taxonomy filters array
  $taxonomy_filters_field = explode( ',', $taxonomy_filters_field );
  $taxonomy_filters = [];
  foreach( $taxonomy_filters_field as $taxonomy ) {
    $taxonomy_filters[] = [
      'slug'    => $taxonomy,
      'tooltip' => '',
    ];
  }

  // Loop through each taxonomy, check if it is a URL param, and build the tax_query based on those
  $tax_query = [ 
		'relation' => 'AND',
	];

  foreach( $taxonomy_filters_field as $taxonomy_slug ) {
    if( isset( $_GET[$taxonomy_slug] ) ) {
      $taxonomy_args = [ 
        'taxonomy' => $taxonomy_slug,
        'field'    => 'slug',
        'operator' => 'IN',
        'terms'    => $_GET[$taxonomy_slug],
      ];
      array_push( $tax_query, $taxonomy_args );
    }
  }

  $args = [ 
    'post_type'      => $post_types,
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => $order,
    's'              => $search_term,
    'post__not_in'   => $excluded_post_ids,
    'tax_query'      => $tax_query,
  ];

  /* Add start date and end date to tax query if they are set */
  if ( isset( $_GET['start_date'] ) && isset( $_GET['end_date'] ) ) {
    $start_date = $_GET['start_date'];
    $end_date   = $_GET['end_date'];

    $args['date_query'] = [ 
      'after'     => $start_date,
      'before'    => $end_date,
      'inclusive' => true,
    ];
  }

  $query       = new WP_Query( $args );
  $posts       = $query->posts;
  $total_posts = $query->found_posts;
  $page_num    = ( $paged == 0 ) ? 1 : $paged;
  $start_page  = ($page_num * $posts_per_page) - ($posts_per_page - 1);
  $end_page    = ($page_num * $posts_per_page);
  $end_page    = ($total_posts < $end_page) ? $total_posts : $end_page;

?>

<form action="" x-data="
  { foo: 'bar', 
    updateUrlParam(url, param, value) {
      let the_url = new URL(url);
      let search_params = the_url.searchParams;
      search_params.set(param, value);

      the_url.search = search_params.toString();

      return the_url.toString();
    }
  }">
  <?php /** 
          * Add the value of s as a hidden form field so the filter-form bar will pass along its 
          * value and keep us on the search page.
          * 
          * Might add a duplicate 's' param to URL in some cases, but that won't cause error and will
          * Ensure we're staying on the search page when filters are applied.
          */
  ?>
  <input type="hidden" name="s" value="<?php echo $search_term; ?>" />

  <div class="px-4 py-5 lg:px-0">
      <div class="container max-w-screen-md mx-auto">
        <h1 class="text-heading-md font-semibold text-center"><?php _e( 'Search Results', 'wicket' ); ?></h1>
      </div>
    </div>

  <?php if ( $show_search_bar ) : ?>
    <div class="px-4 pb-12 lg:px-0">
      <div class="max-w-screen-md mx-auto">
        <p class="text-heading-xs mb-8 text-center"><?php echo $total_posts; ?> <?php _e( 'Results for:', 'wicket' ); ?></p>
        <?php 
        if( $_GET['s'] == 'clearresults' ) {
          $_GET['s'] = '';
        }
        get_component( 'search-form', [
          'url-param' => 's'
        ] ); ?>
        <a href="/?s=clearresults" class="block text-body-md text-center mt-4"><i class="fa-solid fa-x"></i> <?php _e( 'Clear Search', 'wicket' ); ?></a>

      </div>
    </div>
  <?php endif; ?>

  <?php
  echo '<div class="bg-light-010 bg-opacity-15 overflow-x-hidden">';
  ?>

  <div class="container">
    <div class="flex flex-col lg:flex-row gap-4">

      <?php if( $show_filter_bar ): ?>
        <div
          class="basis-1/4 bg-white relative after:content-[''] after:absolute after:top-0 after:bottom-0 after:right-full after:bg-white after:w-[30vw] before:block lg:before:hidden before:content-[''] before:absolute before:top-0 before:bottom-0 before:left-full before:bg-white before:w-[30vw]">
          <?php
          get_component( 'filter-form', [ 
            'taxonomies'       => $taxonomy_filters,
            'hide_date_filter' => ! $show_filter_by_pub_date,
          ] );
          ?>
        </div>
      <?php endif; // End if $show_filter_bar ?>

      <div class="basis-3/4 pt-4 lg:pt-10 <?php if( !$show_filter_bar ) { echo 'max-w-screen-md lg:mx-auto'; } ?>">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-7 px-4 lg:px-0">
          <div>Displaying:
            <?php
            if ( $total_posts === 0 ) {
              echo '<span class="font-bold">0</span>' . __( ' Results', 'wicket' );
            } else {
              echo '<span class="font-bold">' . $start_page . '-' . $end_page . '</span> of ' . $total_posts . ' Results';
            }
            ?>
          </div>
          <div class="flex items-center">
            <div class="font-bold mr-4"><?php _e('Sort by', 'wicket'); ?></div>
            <select x-on:change="window.location.href = updateUrlParam(window.location.href, 'sortby', $el.value);" class="pr-8">
              <option value="new-to-old" <?php if(isset($_GET['sortby'])) { if ($_GET['sortby'] == 'new-to-old') {echo 'selected';} } ?>><?php _e('Date (Newest - Oldest)', 'wicket'); ?></option>
              <option value="old-to-new" <?php if(isset($_GET['sortby'])) { if ($_GET['sortby'] == 'old-to-new') {echo 'selected';} } ?>><?php _e('Date (Oldest - Newest)', 'wicket'); ?></option>
            </select>
          </div>
          
        </div>

        <?php
        if ( $query->have_posts() && $_GET['s'] != 'clearresults' ) : ?>
          <div class="pb-24 px-4 lg:px-0">
            <?php
            while ( $query->have_posts() ) :
              $query->the_post();
              $post_id              = get_the_ID();
              $permalink            = get_the_permalink( $post_id );
              // TODO: Update taxonomies array this reads from
              $content_type         = ! is_wp_error( get_the_terms( $post_id, 'categories' ) ) ? get_the_terms( $post_id, 'categories' ) : [];
              $title                = get_the_title( $post_id );
              $excerpt              = get_the_excerpt( $post_id );
              $pub_date             = get_the_date( 'M d, Y', $post_id );
              $featured_image       = get_post_thumbnail_id( $post_id );
              $member_only          = is_member_only( $post_id );

              $card_params = [ 
                'classes'           => [ 'mb-6' ],
                //'content_type'      => $content_type,
                'date'              => $show_pub_date ? $pub_date : '',
                'topics'            => $show_content_type_tags && !empty($content_type) ? $content_type[0]->name : '',
                'title'             => $title,
                'excerpt'           => $show_excerpt ? $excerpt : '',
                'featured_image'    => $show_featured_image ? $featured_image : '',
                'cta_style'         => 'button',
                'link'              => [ 
                  'url'       => $permalink,
                  'text'      => 'Read more',
                  'target'    => '_self',
                ],
                'link_type'         => 'button',
                'member_only'       => $member_only,
              ];

              get_component( 'card-listing', $card_params );

            endwhile;
            the_wicket_pagination( [ 
              'total' => $query->max_num_pages,
              'format' => '?paged=%#%',
            ] );
            ?>
          </div>
          <?php
        else : ?>
          <div class="p-10">
            <h2 class="text-center font-bold text-heading-md mb-6">
              <?php echo __( 'No results found.', 'wicket' ) ?>
            </h2>
            <div class="text-center">
              <?php echo __( 'Try adjusting your search or filter to find what you are looking for.', 'wicket' ) ?>
            </div>
          </div>
          <?php
        endif; ?>
      </div>
    </div>
  </div>

  </div>
</form>

<?php get_footer();