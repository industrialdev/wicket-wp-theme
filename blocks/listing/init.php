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

	$post_type        = get_field( 'listing_post_type' );
	$posts_per_page   = get_field( 'listing_posts_per_page' );
	$taxonomy_filters = get_field( 'listing_taxonomy_filters' );
	$paged            = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$orderby          = 'date';
	$order            = 'DESC';


	if ( isset( $_GET['sort-by'] ) ) {
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

	echo '<div class="bg-light-010">';
	if ( is_admin() && ! $post_type ) {
		echo "<p>" . __( 'Use the Block controls in edit mode or on the right to configure listing.', 'wicket' ) . "</p>";
	} ?>

	<div class="container">
		<form action="">
			<div class="flex flex-row">
				<div class="basis-1/4">
					Filters
				</div>
				<div class="basis-3/4 pt-10">
					<?php

					$args = [ 
						'post_type'      => $post_type,
						'posts_per_page' => $posts_per_page,
						'paged'          => $paged,
						'orderby'        => $orderby,
						'order'          => $order,
					];

					if ( $taxonomy_filters ) {
						$args['tax_query'] = [];
						foreach ( $taxonomy_filters as $filter ) {
							$args['tax_query'][] = [ 
								'taxonomy' => $filter['taxonomy'],
								'field'    => 'slug',
								'terms'    => $filter['terms'],
							];
						}
					}

					$query       = new \WP_Query( $args );
					$posts       = $query->posts;
					$total_posts = $query->found_posts;
					?>

					<div class="flex justify-between items-center gap-4 mb-7">
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
								if ( isset( $_GET['sort-by'] ) ) : ?>
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
						<div class="pb-24">
							<?php
							while ( $query->have_posts() ) :
								$query->the_post();

								$post_id        = get_the_ID();
								$post_type      = get_post_type( $post_id );
								$title          = get_the_title( $post_id );
								$excerpt        = get_the_excerpt( $post_id );
								$date           = get_the_date( 'F j, Y', $post_id );
								$featured_image = get_post_thumbnail_id( $post_id );
								$permalink      = get_the_permalink( $post_id );
								$member_only    = is_member_only( $post_id );
								$topics         = get_the_terms( $post_id, 'listing-type' );

								$card_params = [ 
									'classes'        => [ 'mb-6' ],
									'content_type'   => $post_type,
									'title'          => $title,
									'excerpt'        => $excerpt,
									'date'           => $date,
									'featured_image' => $featured_image,
									'link'           => [ 
										'url'    => $permalink,
										'text'   => 'Read more',
										'target' => '_self',
									],
									'member_only'    => $member_only,
									'topics'         => $topics,
								];

								if ( component_exists( 'card-' . $post_type ) ) {
									get_component( 'card-' . $post_type, $card_params );
								} else {
									get_component( 'card', $card_params );
								}

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

					<?php


					?>
				</div>
			</div>
		</form>
	</div>

	<?php echo '</div>';
}
