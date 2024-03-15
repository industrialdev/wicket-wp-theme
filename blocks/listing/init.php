<?php
/**
 * Wicket Listing Block
 *
 **/

namespace Wicket\Blocks\Wicket_Listing;

/**
 * Listing block registration function
 */
function init( $block = [] ) {

	$post_type           = get_field( 'listing_post_type' );
	$news_types          = get_field( 'listing_news_type' );
	$resource_types      = get_field( 'listing_resource_type' );
	$topics_types        = get_field( 'listing_topic' );
	$posts_per_page      = get_field( 'listing_posts_per_page' );
	$taxonomy_filters    = get_field( 'listing_taxonomy_filters' );
	$hide_search         = get_field( 'listing_hide_search' );
	$hide_type_taxonomy  = get_field( 'listing_hide_type_taxonomy' );
	$hide_featured_image = get_field( 'listing_hide_featured_image' );
	$hide_excerpt        = get_field( 'listing_hide_excerpt' );

	$paged   = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$orderby = 'date';
	$order   = 'DESC';
	$keyword = '';

	if ( isset ( $_GET['sort-by'] ) ) {
		if ( $_GET['sort-by'] == 'date-desc' ) {
			$orderby = 'date';
			$order   = 'DESC';
		}
		if ( $_GET['sort-by'] == 'date-asc' ) {
			$orderby = 'date';
			$order   = 'ASC';
		}
		if ( $_GET['sort-by'] == 'alpha-asc' ) {
			$orderby = 'title';
			$order   = 'ASC';
		}
		if ( $_GET['sort-by'] == 'alpha-desc' ) {
			$orderby = 'title';
			$order   = 'DESC';
		}
	}

	if ( isset ( $_GET['keyword'] ) ) {
		$keyword = $_GET['keyword'];
	}

	$tax_query = [ 
		'relation' => 'AND',
	];

	/* Add news type taxonomy to tax query if it is set */
	if ( ! empty ( $news_types ) && ! isset ( $_GET['news_type'] ) ) {
		$terms = [];
		foreach ( $news_types as $term ) {
			array_push( $terms, $term->slug );
		}

		$taxonomy_args = [ 
			'taxonomy' => 'news_type',
			'field'    => 'slug',
			'operator' => 'IN',
			'terms'    => $terms,
		];
		array_push( $tax_query, $taxonomy_args );
	}

	/* Add resource type taxonomy to tax query if it is set */
	if ( ! empty ( $resource_types ) && ! isset ( $_GET['resource_type'] ) ) {
		$terms = [];
		foreach ( $resource_types as $term ) {
			array_push( $terms, $term->slug );
		}

		$taxonomy_args = [ 
			'taxonomy' => 'resource_type',
			'field'    => 'slug',
			'operator' => 'IN',
			'terms'    => $terms,
		];
		array_push( $tax_query, $taxonomy_args );
	}

	/* Add topic taxonomy to tax query if it is set */
	if ( ! empty ( $topics_types ) && ! isset ( $_GET['topics'] ) ) {
		$terms = [];
		foreach ( $topics_types as $term ) {
			array_push( $terms, $term->slug );
		}

		$taxonomy_args = [ 
			'taxonomy' => 'topics',
			'field'    => 'slug',
			'operator' => 'IN',
			'terms'    => $terms,
		];
		array_push( $tax_query, $taxonomy_args );
	}

	if ( is_array( $taxonomy_filters ) ) {
		foreach ( $taxonomy_filters as $taxonomy ) {
			if ( isset ( $_GET[ $taxonomy['slug'] ] ) ) {
				$taxonomy_args = [ 
					'taxonomy' => $taxonomy['slug'],
					'field'    => 'slug',
					'operator' => 'IN',
					'terms'    => $_GET[ $taxonomy['slug'] ],
				];
				array_push( $tax_query, $taxonomy_args );
			}
		}
	} ?>

	<?php if ( ! $hide_search ) : ?>
		<div class="bg-dark-010 px-4 py-5 lg:px-0">
			<div class="container">
				<?php get_component( 'search-form' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	echo '<div class="bg-light-010 overflow-x-hidden">';
	if ( is_admin() && ! $post_type ) {
		echo "<p>" . __( 'Use the Block controls in edit mode or on the right to configure listing.', 'wicket' ) . "</p>";
	} ?>

	<div class="container">
		<form action="">
			<div class="flex flex-col lg:flex-row gap-4">
				<div
					class="basis-1/4 bg-white relative after:content-[''] after:absolute after:top-0 after:bottom-0 after:right-full after:bg-white after:w-[30vw] before:block lg:before:hidden before:content-[''] before:absolute before:top-0 before:bottom-0 before:left-full before:bg-white before:w-[30vw]">
					<?php
					get_component( 'filter-form', [ 
						'taxonomies' => $taxonomy_filters,
					] )
						?>
				</div>
				<div class="basis-3/4 pt-4 lg:pt-10">
					<?php

					$args = [ 
						'post_type'      => $post_type,
						'posts_per_page' => $posts_per_page,
						'paged'          => $paged,
						'orderby'        => $orderby,
						'order'          => $order,
						's'              => $keyword,
						'tax_query'      => $tax_query,
					];

					$query       = new \WP_Query( $args );
					$posts       = $query->posts;
					$total_posts = $query->found_posts;
					?>

					<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-7 px-4 lg:px-0">
						<div class="font-bold">
							<?php echo $paged . '-' . count( $posts ); ?> of
							<?php echo $total_posts; ?> posts
						</div>
						<div class="flex items-center gap-3">
							<label for="sort-by">
								<?php echo __( 'Sort by', 'wicket' ); ?>
							</label>
							<select name="sort-by" id="sort-by" class="min-w-[260px]" onchange="this.form.submit()">
								<?php
								$date_desc_label = __( 'Date (newest-oldest)', 'industrial' );
								$date_asc_label  = __( 'Date (oldest-newest)', 'industrial' );
								if ( isset ( $_GET['sort-by'] ) ) : ?>
									<option value="date-desc" <?php if ( $_GET['sort-by'] == 'date-desc' ) : ?>selected<?php endif; ?>>
										<?php echo $date_desc_label; ?>
									</option>
									<option value="date-asc" <?php if ( $_GET['sort-by'] == 'date-asc' ) : ?>selected<?php endif; ?>>
										<?php echo $date_asc_label; ?>
									</option>
									<option value="alpha-asc" <?php if ( $_GET['sort-by'] == 'alpha-asc' ) : ?>selected<?php endif; ?>>
										<?php echo __( 'Alphabetical (a-z)', 'industrial' ); ?>
									</option>
									<option value="alpha-desc" <?php if ( $_GET['sort-by'] == 'alpha-desc' ) : ?>selected<?php endif; ?>>
										<?php echo __( 'Alphabetical (z-a)', 'industrial' ); ?>
									</option>
									<?php
								else : ?>
									<option value="date-desc" selected>
										<?php echo $date_desc_label; ?>
									</option>
									<option value="date-asc">
										<?php echo $date_asc_label; ?>
									</option>
									<option value="alpha-asc">
										<?php echo __( 'Alphabetical (a-z)', 'industrial' ); ?>
									</option>
									<option value="alpha-desc">
										<?php echo __( 'Alphabetical (z-a)', 'industrial' ); ?>
									</option>
									<?php
								endif; ?>
							</select>
						</div>
					</div>

					<?php
					if ( $query->have_posts() ) : ?>
						<div class="pb-24 px-4 lg:px-0">
							<?php
							while ( $query->have_posts() ) :
								$query->the_post();
								$post_id              = get_the_ID();
								$related_content_type = get_related_content_type( get_post_type( $post_id ) );
								$content_type         = ! is_wp_error( get_the_terms( $post_id, $related_content_type ) ) ? get_the_terms( $post_id, $related_content_type ) : [];
								$title                = get_the_title( $post_id );
								$excerpt              = get_the_excerpt( $post_id );
								$date                 = get_the_date( 'F j, Y', $post_id );
								$featured_image       = get_post_thumbnail_id( $post_id );
								$permalink            = get_the_permalink( $post_id );
								$member_only          = is_member_only( $post_id );
								$related_topic_type   = get_related_topic_type( get_post_type( $post_id ) );
								$topics               = get_the_terms( $post_id, $related_topic_type );

								$card_params = [ 
									'classes'        => [ 'mb-6' ],
									'content_type'   => ! $hide_type_taxonomy ? $content_type[0]->name : '',
									'title'          => $title,
									'excerpt'        => ! $hide_excerpt ? $excerpt : '',
									'date'           => $date,
									'featured_image' => ! $hide_featured_image ? $featured_image : '',
									'link'           => [ 
										'url'    => $permalink,
										'text'   => 'Read more',
										'target' => '_self',
									],
									'member_only'    => $member_only,
									'topics'         => $topics,
								];

								get_component( 'card-listing', $card_params );

							endwhile;
							the_wicket_pagination( [ 
								'total' => $query->max_num_pages,
							] );
							?>
						</div>
						<?php
					else : ?>
						<div class="listing-results">
							<p>Sorry, no results were found</p>
						</div>
						<?php
					endif; ?>
				</div>
			</div>
		</form>
	</div>

	<?php echo '</div>';
}
