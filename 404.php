<?php get_header(); ?>

<main id="main-content">
	<section id="page-content">
		<div class="container">
			<div class="page-not-found" >
				<h1 class="page-not-found__title" >404</h1>
				<h2 class="page-not-found__subtitle" ><?php _e('Page not found', 'wicket'); ?></h2>
				<div class="page-not-found__content" >
					<p><?php _e("The page you're looking for cannot be found.", 'wicket'); ?></p>
				</div>
				<?php get_component( 'button', [
					'variant' => 'secondary',
					'a_tag'   => true,
					'label'   => __( 'Go back to the Homepage', 'wicket' ),
					'link'    => home_url(),
				] ) ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer();
