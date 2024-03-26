<?php
$defaults            = array(
	'classes'             => [ 'px-4', 'py-10', 'lg:px-0', 'bg-light-010' ],
	'title'               => '',
	'column_count'        => 3,
	'max_posts'           => 3,
	'post_type'           => '',
	'taxonomies'          => [],
	'hide_excerpt'        => false,
	'hide_date'           => false,
	'hide_featured_image' => false,
	'hide_content_type'   => false,
	'show_cta'            => false,
	'show_view_all'       => false,
	'cta_style'           => 'primary',
	'current_post_id'     => '',
);
$args                = wp_parse_args( $args, $defaults );
$classes             = $args['classes'];
$title               = $args['title'];
$column_count        = $args['column_count'];
$max_posts           = $args['max_posts'];
$post_type           = $args['post_type'];
$taxonomies          = $args['taxonomies'];
$hide_excerpt        = $args['hide_excerpt'];
$hide_date           = $args['hide_date'];
$hide_featured_image = $args['hide_featured_image'];
$hide_content_type   = $args['hide_content_type'];
$show_cta            = $args['show_cta'];
$show_view_all       = $args['show_view_all'];
$cta_style           = $args['cta_style'];
$current_post_id     = $args['current_post_id'];

// WP_Query arguments
$query_args = array(
	'post_type'      => $post_type,
	'posts_per_page' => $max_posts,
	'post__not_in'   => [ $current_post_id ],
);
// If taxonomies are set, add them to the query
if ( ! empty ( $taxonomies ) ) {
	$query_args['tax_query'] = array(
		'relation' => 'OR',
	);
	foreach ( $taxonomies as $taxonomy ) {
		$terms = get_the_terms( $current_post_id, $taxonomy );
		if ( ! empty ( $terms ) ) {
			$term_ids                  = wp_list_pluck( $terms, 'term_id' );
			$query_args['tax_query'][] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'term_id',
				'terms'    => $term_ids,
			);
		}
	}
}
// The Query
$related_posts = new WP_Query( $query_args );

// Get post type plural label
$post_type_object = get_post_type_object( $post_type );
$post_type_label  = $post_type_object->labels->name;

// Get post type archive link
$post_type_archive_link = get_post_type_archive_link( $post_type );

$classes[] = 'component-related-posts';
?>

<div class="<?php echo implode( ' ', $classes ) ?>">
	<div class="container">
		<?php if ( $title ) : ?>
			<div class=" mb-12">
				<span class="text-heading-sm font-bold">
					<?php echo $title; ?>
					<?php echo $post_type_label; ?>
				</span>
				<a href="<?php echo $post_type_archive_link ?>" class="underline ml-4 pl-4 border-l border-dark-070">
					<?php echo __( 'View All', 'wicket' ) ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="grid gap-4 grid-cols-1 lg:grid-cols-3">
			<?php
			// The Loop
			if ( $related_posts->have_posts() ) {
				while ( $related_posts->have_posts() ) {
					$related_posts->the_post();
					$post_id = get_the_ID();

					get_component( 'card-listing', [ 
						'title'        => get_the_title( $post_id ),
						'content_type' => get_post_type( $post_id ),
						'date'         => $post_date,
						'member_only'  => is_member_only( $post_id ),
						'link'         => [ 
							'url'    => get_permalink( $post_id ),
							'target' => '',
						],
					] );
				}
			} else {
				// no posts found
			}
			?>
		</div>
	</div>
</div>