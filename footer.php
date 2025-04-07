<?php

?>
<footer class="site-footer">
	<?php
    $newsletter = get_field('newsletter', 'option');
if (!empty($newsletter['title'])) : ?>
		<div class="newsletter-section">
			<div class="container">
				<div class="flex flex-col gap-5 items-start lg:flex-row lg:justify-between ">
					<div class="flex-1">
						<?php if ($newsletter['title']) : ?>
							<div class="newsletter-section__title">
								<?php echo $newsletter['title']; ?>
							</div>
						<?php endif; ?>

						<?php if ($newsletter['description']) : ?>
							<div class="newsletter-section__description">
								<?php echo $newsletter['description']; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if (!empty($newsletter['link'])) {

                        $newsletter_link_title = empty($newsletter['link']['title']) ? __('Subscribe to our newsletter', 'wicket') : $newsletter['link']['title'];

					    get_component('button', [
					        'variant'     => 'primary',
					        'link'        => $newsletter['link']['url'],
					        'link_target' => $newsletter['link']['target'],
					        'a_tag'       => true,
					        'reversed'    => true,
					        'label'       => $newsletter_link_title,
					        'prefix_icon' => 'fa-regular fa-envelope',
					        'suffix_icon' => '',
					        'classes'     => ['newsletter-button'],
					    ]);
					} ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="main-footer-section container">
		<?php if (have_rows('footer_columns', 'option')) :
		    $column_count = count(get_field('footer_columns', 'option'));
		    ?>
			<div class="grid gap-4 grid-cols-1 lg:grid-cols-<?php echo $column_count ?>">
				<?php
		            $col_number = 1;
		    ?>
				<?php while (have_rows('footer_columns', 'option')) :
				    the_row();
				    $section_title = get_sub_field('section_title');
				    $section_id = sanitize_title($section_title);
				    $row = get_row();
				    $is_menu_column = false;

				    foreach ($row as $layout) {
				        if (is_array($layout) && array_key_exists('acf_fc_layout', $layout[0])) {
				            if ($layout[0]['acf_fc_layout'] == 'menu') {
				                $is_menu_column = true;
				            }
				        }
				    }
				    ?>
					<div
						class="footer-column col-num-<?php echo $col_number; ?> <?php echo $is_menu_column ? 'is-menu-column' : '' ?>" 
						x-data="{
							windowWidth: window.innerWidth,
							isOpen : false,
						}"
						x-on:resize.window="windowWidth= window.innerWidth">
						<?php if ($section_title) { ?>
							<?php if ($is_menu_column) : ?>
								<button type="button" class="section-title-button"
									x-on:click="isOpen = !isOpen">
									<?php echo $section_title ?>
									<i class="fa-solid fa-caret-down" :class="!isOpen || 'rotate-180'"></i>
								</button>
							<?php else : ?>
								<div class="section-title font-bold lg:hidden">
									<?php echo $section_title ?>
								</div>
							<?php endif; ?>

							<div class="section-title">
								<?php echo $section_title ?>
							</div>

							<div class="footer-section w-full" id="<?php echo $section_id ?>" <?php if ($is_menu_column) : ?>x-show="windowWidth < 1024 ? isOpen : true" <?php endif; ?>>
							<?php } ?>

							<?php if (have_rows('content')) :
							    while (have_rows('content')) :
							        the_row(); ?>
									<div class="<?php echo get_row_layout(); ?>">
										<?php
							            // Image layout.
							            if (get_row_layout() == 'image') {
							                $image = get_sub_field('image');
							                echo wp_get_attachment_image($image['id'], 'full');
							            }

							            // Text layout.
							            elseif (get_row_layout() == 'text') {
							                $text = get_sub_field('text');
							                echo '<div class="">' . $text . '</div>';
							            }

							            // Contact info layout.
							            elseif (get_row_layout() == 'contact_info') {
							                $address = get_sub_field('address');
							                $phone = get_sub_field('phone_number');
							                $email = get_sub_field('email');

							                if ($email) {
							                    get_component(
							                        'link',
							                        [
							                            'classes'    => ['main-footer-section__email-link'],
							                            'url'        => "mailto:{$email}",
							                            'text'       => $email,
							                            'icon_start' => [
							                                'icon' => 'fa-regular fa-envelope',
							                            ],
							                        ]
							                    );
							                }

							                if ($phone) {
							                    get_component(
							                        'link',
							                        [
							                            'classes'    => ['main-footer-section__phone-link'],
							                            'url'        => "tel:{$phone}",
							                            'text'       => $phone,
							                            'icon_start' => [
							                                'icon' => 'fa-regular fa-phone',
							                            ],
							                        ]
							                    );
							                }
							            }

							            // Menu layout.
							            elseif (get_row_layout() == 'menu') {
							                $menu = get_sub_field('menu');

							                echo '<div class="footer-col-menu">';
							                wp_nav_menu([
							                    'menu'        => $menu,
							                    'container'   => '',
							                    'fallback_cb' => false,
							                ]);
							                echo '</div>';
							            }

							            // Social Sharing layout.
							            elseif (get_row_layout() == 'social_sharing') {
							                get_component('social-sharing', ['reversed' => false]);
							            }

							            // Embed layout.
							            elseif (get_row_layout() == 'embed') {
							                $embed = get_sub_field('embed');
							                echo $embed;
							            }

							            // Form layout.
							            elseif (get_row_layout() == 'form') {
							                $description = get_sub_field('description');
							                $newsletter_page = get_sub_field('newsletter_page');

							                if ($description) {
							                    echo '<div class="mb-4">' . $description . '</div>';
							                }

							                if ($newsletter_page) {
                                                $newsletter_page_link_title = empty($newsletter_page['link']['title']) ? __('Subscribe to our newsletter', 'wicket') : $newsletter_page['link']['title'];

							                    get_component('button', [
							                        'variant'     => 'secondary',
							                        'link'        => $newsletter_page['url'],
							                        'link_target' => $newsletter_page['target'],
							                        'a_tag'       => true,
							                        'reversed'    => false,
							                        'label'       => $newsletter_page_link_title,
							                        'prefix_icon' => 'fa-regular fa-envelope',
							                        'suffix_icon' => '',
							                        'classes'     => ['newsletter-button'],
							                    ]);
							                }
							            }

							        ?>
									</div>
								<?php endwhile;
				    endif; ?>

							<?php if (get_sub_field('section_title')) { ?>
							</div>
						<?php } ?>
					</div>
					<hr class="footer-column-border">
					<?php $col_number++; ?>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<?php
        $hide_social_links = get_field('footer_hide_social_links', 'option');
if (have_rows('social_media_links', 'option') && $hide_social_links === false) : ?>
			<div class="social-links-section">
				<?php get_component('social-links', [
				    'reversed'       => false,
				    'button-variant' => 'secondary',
				]); ?>
			</div>
		<?php endif; ?>

		<?php if (has_nav_menu('footer')) : ?>
			<div class="footer-nav-menu">
				<?php wp_nav_menu([
				    'theme_location' => 'footer',
				    'container'      => '',
				    'fallback_cb'    => false,
				    'menu_class'     => 'footer-nav-menu__items',
				]); ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom-text">
			<span>
				<?php echo sprintf('© %s %s', date('Y'), get_field('footer_copyright', 'option')); ?>
			</span>
			<?php if (has_nav_menu('footer-utility')) {
			    wp_nav_menu([
			        'theme_location' => 'footer-utility',
			        'container'      => '',
			        'fallback_cb'    => false,
			        'menu_class'     => 'utility-menu',
			    ]);
			} ?>
		</div>
	</div>

</footer>

<?php wp_footer(); ?>

</body>

</html>