<?php get_header(); ?>

<main class="my-5">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php if ( is_singular() ) : ?>
			<?php else : ?>
				<h1 class="text-heading-md bold mb-4">
					<?= get_post_type_object( get_post_type() )->labels->archives; ?>
				</h1>
			<?php endif; ?>

			<?php while ( have_posts() ) :
				the_post();
				$post_type     = get_post_type();
				$listing_types = get_the_terms( get_the_ID(), 'listing-type' );

				get_component( 'card-' . $post_type, [ 
					'classes'        => [ 'mb-6' ],
					'content_type'   => $post_type,
					'title'          => get_the_title(),
					'excerpt'        => get_the_excerpt(),
					'date'           => get_the_date( 'F j, Y' ),
					'featured_image' => get_post_thumbnail_id(),
					'link'           => [ 
						'url'    => get_the_permalink(),
						'text'   => 'Read more',
						'target' => '_self',
					],
					'member_only'    => is_member_only( get_the_ID() ),
					'topics'         => $listing_types ? $listing_types : '',
				] );
				?>
			<?php endwhile; ?>
			<?php the_wicket_pagination(); ?>
		<?php else : ?>
			<?php
			$postType = get_post_type();
			$notFound = "No pages found.";
			if ( $postType ) {
				$notFound = get_post_type_object( get_post_type() )->labels->not_found;
			}
			?>
			<h2>
				<?php echo $notFound; ?>
			</h2>
			<p><i class="fal fa-map-marked-alt fa-9x" aria-hidden="true"></i></p>
			<p><a href="/" class="button button--primary">Go home</a></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer();
