<?php get_header(); ?>

<?php if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>

		<main>
			<?php the_content(); ?>

			<?php
			$related_posts = get_posts( [ 
				'posts_per_page' => 3,
				'post__not_in'   => [ get_the_ID() ],
				'orderby'        => 'rand',
			] );

			if ( ! empty( $related_posts ) ) {
				get_component( 'related-posts', [ 
					'title' => 'Related',
					'posts' => $related_posts,
				] );
			}
			?>
		</main>

	<?php endwhile; endif; ?>

<?php get_footer();
