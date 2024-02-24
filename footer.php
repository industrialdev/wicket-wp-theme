<footer class="bg-dark-100">
	<?php
	$newsletter = get_field( 'newsletter', 'option' );
	if ( ! empty( $newsletter['title'] ) ) { ?>
		<div class="bg-dark-060 py-5 px-4 md:px-0">
			<div class="container">
				<div class="flex flex-col gap-5 items-start lg:flex-row lg:justify-between ">
					<div class="flex-1">
						<?php if ( $newsletter['title'] ) : ?>
							<div class="text-body-lg text-white mb-2 font-bold">
								<?php echo $newsletter['title']; ?>
							</div>
						<?php endif; ?>

						<?php if ( $newsletter['description'] ) : ?>
							<div class="text-white">
								<?php echo $newsletter['description']; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $newsletter['link'] ) ) {
						get_component( 'button', [ 
							'variant'     => 'primary',
							'link'        => $newsletter['link']['url'],
							'link_target' => $newsletter['link']['target'],
							'a_tag'       => true,
							'reversed'    => true,
							'label'       => __( 'Subscribe to our newsletter', 'wicket' ),
							'prefix_icon' => 'fa-regular fa-envelope',
							'suffix_icon' => '',
						] );
					} ?>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="container py-8 px-4 md:px-0">
		<?php if ( have_rows( 'footer_columns', 'option' ) ) :
			$column_count = count( get_field( 'footer_columns', 'option' ) );
			?>
			<div class="grid gap-4 grid-cols-1 lg:grid-cols-<?php echo $column_count ?>">
				<?php while ( have_rows( 'footer_columns', 'option' ) ) :
					the_row();
					$section_title  = get_sub_field( 'section_title' );
					$section_id     = sanitize_title( $section_title );
					$row            = get_row();
					$is_menu_column = false;

					foreach ( $row as $layout ) {
						if ( is_array( $layout ) && array_key_exists( 'acf_fc_layout', $layout[0] ) ) {
							if ( $layout[0]['acf_fc_layout'] == 'menu' ) {
								$is_menu_column = true;
							}
						}
					}
					?>
					<div class="footer-column flex flex-col items-start gap-5" x-data="{
						windowWidth: window.innerWidth,
						isOpen : false,
					}" x-on:resize.window="windowWidth= window.innerWidth">
						<?php if ( $section_title ) { ?>
							<?php if ( $is_menu_column ) : ?>
								<button type="button" class="font-bold text-white w-full flex items-center justify-between lg:hidden"
									x-on:click="isOpen = !isOpen">
									<?php echo $section_title ?>
									<i class="fa-solid fa-caret-down" :class="!isOpen || 'rotate-180'"></i>
								</button>
							<?php else : ?>
								<div class="font-bold text-white lg:hidden">
									<?php echo $section_title ?>
								</div>
							<?php endif; ?>

							<div class="font-bold text-white hidden lg:block">
								<?php echo $section_title ?>
							</div>

							<div class="footer-section w-full" id="<?php echo $section_id ?>" <?php if ( $is_menu_column ) : ?>x-show="windowWidth < 1024 ? isOpen : true" <?php endif; ?>>
							<?php } ?>

							<?php if ( have_rows( 'content' ) ) :
								while ( have_rows( 'content' ) ) :
									the_row(); ?>
									<div class="<?php echo get_row_layout(); ?>">
										<?php
										// Image layout.
										if ( get_row_layout() == 'image' ) {
											$image = get_sub_field( 'image' );
											echo wp_get_attachment_image( $image['id'], 'full' );
										}

										// Text layout.
										elseif ( get_row_layout() == 'text' ) {
											$text = get_sub_field( 'text' );
											echo '<div class="text-white">' . $text . '</div>';
										}

										// Contact info layout.
										elseif ( get_row_layout() == 'contact_info' ) {
											$address = get_sub_field( 'address' );
											$phone   = get_sub_field( 'phone_number' );
											$email   = get_sub_field( 'email' );

											if ( $email ) {
												echo '<a class="text-white mb-4 font-bold flex items-center gap-1.5 hover:no-underline group" href="mailto:' . $email . '"><i class="fa-regular fa-envelope group-hover:no-underline"></i><span class="sr-only">'.__( 'Send email to: ', 'wicket' ).'</span><span class="group-hover:underline">' . $email . '</span></a>';
											}

											if ( $phone ) {
												echo '<a class="text-white font-bold flex items-center gap-1.5 hover:no-underline group" href="tel:' . $phone . '"><i class="fa-regular fa-phone group-hover:no-underline"></i><span class="sr-only">'.__( 'Call: ', 'wicket' ).'</span><span class="group-hover:underline">' . $phone . '</span></a>';
											}
										}

										// Menu layout.
										elseif ( get_row_layout() == 'menu' ) {
											$menu = get_sub_field( 'menu' );

											echo '<div class="text-white [&>ul>li>a]:mb-3 [&>ul>li>a]:inline-flex">';
											wp_nav_menu( array(
												'menu'        => $menu,
												'container'   => '',
												'fallback_cb' => false,
											) );
											echo '</div>';
										}

										// Social Sharing layout.
										elseif ( get_row_layout() == 'social_sharing' ) {
											get_component( 'social-sharing', array( 'reversed' => true ) );
										}

										// Embed layout.
										elseif ( get_row_layout() == 'embed' ) {
											$embed = get_sub_field( 'embed' );
											echo $embed;
										}

										// Form layout.
										elseif ( get_row_layout() == 'form' ) {
											$description     = get_sub_field( 'description' );
											$newsletter_page = get_sub_field( 'newsletter_page' );

											if ( $description ) {
												echo '<div class="text-white mb-4">' . $description . '</div>';
											}

											if ( $newsletter_page ) {
												get_component( 'button', [ 
													'variant'     => 'primary',
													'link'        => $newsletter_page['url'],
													'link_target' => $newsletter_page['target'],
													'a_tag'       => true,
													'reversed'    => true,
													'label'       => __( 'Subscribe to our newsletter', 'wicket' ),
													'prefix_icon' => 'fa-regular fa-envelope',
													'suffix_icon' => '',
												] );
											}
										}

										?>
									</div>
								<?php endwhile;
							endif; ?>

							<?php if ( get_sub_field( 'section_title' ) ) { ?>
							</div>
						<?php } ?>
					</div>
					<hr class="border-b-1 border-[#7B7F83] lg:hidden">
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<?php
		$hide_social_links = get_field( 'footer_hide_social_links', 'option' );
		if ( have_rows( 'social_media_links', 'option' ) && $hide_social_links === false ) : ?>
			<div class="py-8 flex justify-center">
				<?php get_component( 'social-links', array( 'reversed' => true ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<div class="py-8 border-t border-[#7B7F83] <?php echo $hide_social_links === true ? 'mt-8' : '' ?>">
				<?php wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => '',
					'fallback_cb'    => false,
					'menu_class'     => 'flex flex-col md:flex-row gap-8 font-bold text-white md:justify-center',
				) ); ?>
			</div>
		<?php endif; ?>

		<div class="flex justify-center text-white text-body-sm">
			<?php echo sprintf( '© %s %s', date( 'Y' ), get_field( 'footer_copyright', 'option' ) ); ?>
			<?php if ( has_nav_menu( 'footer-utility' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'footer-utility',
					'container'      => '',
					'fallback_cb'    => false,
					'menu_class'     => 'flex gap-2 items-center [&>li>a]:underline [&>li>a:hover]:no-underline border-l border-white pl-2 ml-2',
				) );
			} ?>
		</div>
	</div>

</footer>

<?php wp_footer(); ?>

</body>

</html>