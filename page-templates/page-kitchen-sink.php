<?php
/**
 * Template Name: Kitchen Sink Page
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>

		<main class="py-5">
			<div class="container">
				<!--Find all files inside of the components folder and loop through them-->
				<?php foreach ( glob( get_components_dir() . '*.php' ) as $filename ) { ?>

					<?php
					// Create an array of excluded files
					$excluded_files = [ 
						'card-product.php',
						'org-search-select.php',
						'accordion.php',
						'social-sharing.php',
						'tabs.php',
						'alert.php',
						'author.php',
						'banner.php',
						'button.php',
						'card-call-out.php',
						'card-contact.php',
						'card-featured.php',
						'icon-grid.php',
						'icon.php',
						'image.php',
						'link.php',
						'card-listing.php',
						'card-related.php',
						'card.php',
						'featured-posts.php',
						'filter-form.php',
						'tag.php',
					];

					// If the current file is in the excluded files array, skip it
					if ( in_array( basename( $filename ), $excluded_files ) ) {
						continue;
					}
					?>
					<div class="mb-3">
						<h2 class="text-heading-lg capitalize mb-3"><?php echo basename( $filename, '.php' ) ?></h2>
						<?php get_component( basename( $filename, '.php' ) ); ?>
					</div>
				<?php } ?>

				<hr>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Link</h2>
					<div class="mb-6">
						<?php get_component( 'link', [
							'text'    => __( 'Go back to the homepage', 'wicket' ),
							'url'    => get_home_url(),
						] ) ?>
					</div>
					<div class="mb-6">
						<h2 class="text-heading-md mb-3">Link with icon (Default style - Small)</h2>
						<?php get_component(
							'link', [ 
								'default_link_style' => true,
								'size' => 'sm',
								'url'        => get_home_url(),
								'text'       => __( 'Home', 'wicket' ),
								'icon_start' => [ 
									'icon' => 'fa-regular fa-house',
								],
								'icon_end'   => [],
						] ) ?>
					</div>
					<div class="mb-6">
						<h2 class="text-heading-md mb-3">Link with icon (Default style - Medium)</h2>
						<?php get_component(
							'link', [ 
								'default_link_style' => true,
								'size' => 'md',
								'url'        => get_home_url(),
								'text'       => __( 'Home', 'wicket' ),
								'icon_start' => [ 
									'icon' => 'fa-regular fa-house',
								],
								'icon_end'   => [],
						] ) ?>
					</div>
					<div class="mb-6">
						<h2 class="text-heading-md mb-3">Link with icon (Default style - Large)</h2>
						<?php get_component(
							'link', [ 
								'default_link_style' => true,
								'size' => 'lg',
								'url'        => get_home_url(),
								'text'       => __( 'Home', 'wicket' ),
								'icon_start' => [ 
									'icon' => 'fa-regular fa-house',
								],
								'icon_end'   => [],
						] ) ?>
					</div>
					<div class="mb-6">
						<h2 class="text-heading-md mb-3">Link with icon</h2>
						<?php get_component(
							'link', [ 
								'default_link_style' => false,
								'url'        => get_home_url(),
								'text'       => __( 'Home', 'wicket' ),
								'icon_start' => [ 
									'icon' => 'fa-regular fa-house',
								],
								'icon_end'   => [],
						] ) ?>
					</div>
					<div class="mb-6 bg-black p-3">
						<h2 class="text-heading-md text-white mb-3">Link with icon (Reversed)</h2>
						<?php get_component(
							'link', [ 
								'reversed' => true,
								'default_link_style' => false,
								'url'        => get_home_url(),
								'text'       => __( 'Home', 'wicket' ),
								'icon_start' => [ 
									'icon' => 'fa-regular fa-house',
								],
								'icon_end'   => [],
						] ) ?>
					</div>
					<div class="mb-6 bg-black p-3">
						<h2 class="text-heading-md text-white mb-3">Link with icon (Reversed, Default style)</h2>
						<?php get_component(
							'link', [ 
								'reversed' => true,
								'default_link_style' => true,
								'url'        => get_home_url(),
								'text'       => __( 'Home', 'wicket' ),
								'icon_start' => [ 
									'icon' => 'fa-regular fa-house',
								],
								'icon_end'   => [],
						] ) ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Tabs</h2>
					<div class="mb-6">
						<?php
							$items = array (
								0 => 
								array (
									'title' => 'Nulla sit amet est',
									'body_content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#8217;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
									'call_to_action' => 
									array (
										'button_style' => 'secondary',
										'link_and_label' => 
										array (
											'title' => 'Secondary',
											'url' => '#',
											'target' => '',
										),
									),
								),
								1 => 
								array (
									'title' => 'Aldus PageMaker',
									'body_content' => '<p>There are many <strong>variations</strong> of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#8217;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#8217;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>',
									'call_to_action' => 
									array (
										'button_style' => 'primary',
										'link_and_label' => 
										array (
											'title' => 'Primary Button',
											'url' => '#',
											'target' => '',
										),
									),
								),
								2 => 
								array (
									'title' => 'Hello World',
									'body_content' => '<p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#8217;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>',
									'call_to_action' => 
									array (
										'button_style' => 'ghost',
										'link_and_label' => 
										array (
											'title' => 'Ghost button',
											'url' => '#',
											'target' => '',
										),
									),
								),
							);

							get_component( 'tabs', [ 
								'items' => $items,
							] );
						?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Accordion</h2>
					<?php foreach ( [ 'list', 'card' ] as $accordion_type ) : ?>
						<div class="mb-6">
							<?php
								$items = array (
									0 => 
									array (
										'title' => 'Lorem Ipsum',
										'title_is_a_link' => false,
										'title_link' => NULL,
										'body_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
										'call_to_action' => 
										array (
											'button_link_style' => 'primary',
											'link_and_label' => 
											array (
												'title' => 'Lorem Link',
												'url' => '#',
												'target' => '',
											),
										),
										'open_by_default' => true,
									),
									1 => 
									array (
										'title' => 'PageMaker',
										'title_is_a_link' => true,
										'title_link' => 
										array (
											'title' => 'Hello World',
											'url' => '#',
											'target' => '',
										),
										'body_content' => 'Lorem Ipsum is simply dummy standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting.',
										'call_to_action' => 
										array (
											'button_link_style' => 'secondary',
											'link_and_label' => 
											array (
												'title' => 'Hello',
												'url' => '#',
												'target' => '',
											),
										),
										'open_by_default' => false,
									),
								);

								get_component( 'accordion', [ 
									'items'                 => $items,
									'icon-type'             => 'plus-minus',
									'accordion-type'        => $accordion_type,
									'separate-title-body'   => false
								] );
							?>
						</div>
					<?php endforeach; ?>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Table</h2>
					<div class="mb-6">
						<figure class="wp-block-table" >
							<table>
								<thead>
									<tr>
										<th scope="col">Person</th>
										<th scope="col">Most interest in</th>
										<th scope="col">Age</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th scope="row">Chris</th>
										<td>HTML tables</td>
										<td>22</td>
									</tr>
									<tr>
										<th scope="row">Dennis</th>
										<td>Web accessibility</td>
										<td>45</td>
									</tr>
									<tr>
										<th scope="row">Sarah</th>
										<td>JavaScript frameworks</td>
										<td>29</td>
									</tr>
									<tr>
										<th scope="row">Karen</th>
										<td>Web performance</td>
										<td>36</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td scope="row" colspan="2">Average age</th>
										<td>33</td>
									</tr>
								</tfoot>
							</table>
						</figure>
					</div>
				</section>

				<h2 class="text-heading-lg mb-3">Pagination</h2>
				<?php
					$args = array(
						'post_type'      => 'page',
						'posts_per_page' => 1,
						'orderby'        => 'date',
						'order'          => 'DESC',
						'paged'		  		 => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
					);

					$query = new WP_Query( $args );

					the_wicket_pagination( [ 
						'total' => $query->max_num_pages,
					] );

					wp_reset_postdata();
				?>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Primary buttons</h2>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'primary',
							'size'        => 'lg',
							'label'       => __( 'Primary large', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'primary',
							'size'        => 'lg',
							'label'       => __( 'Primary large disabled', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
							'disabled'    => true,
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'primary',
							'label'       => __( 'Primary default', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'primary',
							'size'        => 'sm',
							'label'       => __( 'Primary small', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Secondary buttons</h2>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'secondary',
							'size'        => 'lg',
							'label'       => __( 'Secondary large', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'secondary',
							'size'        => 'lg',
							'label'       => __( 'Secondary large disabled', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
							'disabled'    => true,
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'secondary',
							'label'       => __( 'Secondary default', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'secondary',
							'size'        => 'sm',
							'label'       => __( 'Secondary small', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Ghost buttons</h2>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'ghost',
							'size'        => 'lg',
							'label'       => __( 'Ghost large', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'ghost',
							'size'        => 'lg',
							'label'       => __( 'Ghost large disabled', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
							'disabled'    => true,
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'ghost',
							'label'       => __( 'Ghost default', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
					<div class="mb-3">
						<?php get_component( 'button', [ 
							'variant'     => 'ghost',
							'size'        => 'sm',
							'label'       => __( 'Ghost small', 'wicket' ),
							'prefix_icon' => 'fa fa-calendar-alt',
							'suffix_icon' => 'fa fa-external-link-alt',
						] ) ?>
					</div>
				</section>

				<section class="bg-black p-8 mb-6">
					<div class="py-3">
						<h2 class="text-heading-lg mb-3 text-white">Primary reversed</h2>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'primary',
								'size'        => 'lg',
								'label'       => __( 'Primary large', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'primary',
								'size'        => 'lg',
								'label'       => __( 'Primary large disabled', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
								'disabled'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'primary',
								'label'       => __( 'Primary default', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'primary',
								'size'        => 'sm',
								'label'       => __( 'Primary small', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>

						<h2 class="text-heading-lg my-3 text-white">Secondary reversed</h2>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'secondary',
								'size'        => 'lg',
								'label'       => __( 'Secondary large', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'secondary',
								'size'        => 'lg',
								'label'       => __( 'Secondary large disabled', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
								'disabled'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'secondary',
								'label'       => __( 'Secondary default', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'secondary',
								'size'        => 'sm',
								'label'       => __( 'Secondary small', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>

						<h2 class="text-heading-lg my-3 text-white">Ghost reversed</h2>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'ghost',
								'size'        => 'lg',
								'label'       => __( 'Ghost large', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'ghost',
								'size'        => 'lg',
								'label'       => __( 'Ghost large disabled', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
								'disabled'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'ghost',
								'label'       => __( 'Ghost default', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>
						<div class="mb-3">
							<?php get_component( 'button', [ 
								'variant'     => 'ghost',
								'size'        => 'sm',
								'label'       => __( 'Ghost small', 'wicket' ),
								'prefix_icon' => 'fa fa-calendar-alt',
								'suffix_icon' => 'fa fa-external-link-alt',
								'reversed'    => true,
							] ) ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Icon</h2>
					<div class="row mb-6">
						<div class="col-sm-4">
							<?php get_component( 'icon', [ 
								'classes' => [ 'custom-icon-class' ],
								'icon'    => 'fa fa-check', // Replace with the desired Font Awesome classes
								'text'    => __( 'Icon Text' ),
							] ); ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Social Sharing</h2>
					<div class="mb-6">
						<?php get_component( 'social-sharing' ); ?>
					</div>
					<div class="mb-6 p-4 bg-black">
						<?php get_component( 'social-sharing', [ 
							'reversed' => true,
						] ); ?>
					</div>
				</section>
				
				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Tooltip</h2>
					<div class="mb-6">
						<?php get_component( 'tooltip', [
							'content'  => __( 'Tooltip content', 'wicket' ),
							'position' => 'right',
						] ); ?>
					</div>
					<div class="mb-6">
						<?php get_component( 'tooltip', [
							'content'  => __( 'Tooltip content', 'wicket' ),
							'position' => 'left',
						] ); ?>
					</div>
					<div class="mb-6">
						<?php get_component( 'tooltip', [
							'content'  => __( 'Tooltip content', 'wicket' ),
							'position' => 'top',
						] ); ?>
					</div>
					<div class="mb-6">
						<?php get_component( 'tooltip', [
							'content'  => __( 'Tooltip content', 'wicket' ),
							'position' => 'bottom',
						] ); ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Social Media Links</h2>
					<div class="row mb-6">
						<div class="col-sm-4">
							<?php get_component( 'social-links', [ 
								'variant' => 'default' // 'default' or 'reversed'
							] ); ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Tag</h2>
					<div class="mb-6">
						<div class="mb-4">
							<?php get_component( 'tag', [ 
								'label' => __( 'Members Only', 'wicket' ),
								'icon'  => 'fa-regular fa-lock',
							] ); ?>
						</div>
						
						<div class="bg-black p-5 m-3">
							<div>
								<?php get_component( 'tag', [ 
									'label'    => __( 'Members Only', 'wicket' ),
									'icon'     => 'fa-regular fa-lock',
									'reversed' => true,
								] ); ?>
							</div>
						</div>
						<div class="mb-4">
							<?php get_component( 'tag', [ 
								'label' => __( '', 'wicket' ),
								'icon'  => 'fa-regular fa-lock',
							] ); ?>
						</div>
						<div class="mb-4">
							<?php get_component( 'tag', [ 
								'label'    => __( '', 'wicket' ),
								'icon'     => 'fa-regular fa-lock',
								'reversed' => true,
							] ); ?>
						</div>
						<div class="mb-4">
							<?php get_component( 'tag', [ 
								'label' => __( 'Topic tag', 'wicket' ),
								'link'  => 'https://wicket.io/',
								'icon'  => '',
							] ); ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Link</h2>
					<div class="mb-6">
						<div class="mb-4">
							<?php get_component( 'link', [ 
								'url' => '#',
							] ); ?>
						</div>
						<div class="mb-4">
							<?php get_component( 'link', [ 
								'url'        => '#',
								'text'       => 'Link label',
								'icon_start' => [ 
									'icon' => 'fa-regular fa-suitcase',
									'text' => 'Icon text',
								],
								'icon_end'   => [ 
									'icon' => 'fa-solid fa-arrow-right',
									'text' => 'Icon text',
								],
							] ); ?>
						</div>
						<div class="bg-black p-8">
							<div class="mb-4">
								<?php get_component( 'link', [ 
									'reversed'   => true,
									'url'        => '#',
									'text'       => 'Reversed link',
									'icon_start' => [ 
										'icon' => 'fa-regular fa-suitcase',
										'text' => 'Icon text',
									],
									'icon_end'   => [ 
										'icon' => 'fa-solid fa-arrow-right',
										'text' => 'Icon text',
									],
								] ); ?>
							</div>
						</div>
					</div>
				</section>

				<section class="p-8 bg-light-020">
					<h2 class="text-heading-lg mb-3">Listing Card</h2>
					<?php
					$args = array(
						'post_type'      => 'listing',
						'posts_per_page' => 2,
						'orderby'        => 'date',
						'order'          => 'DESC',
					);

					$query = new WP_Query( $args );

					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();

							$post_type      = get_post_type_object( get_post_type() );
							$title          = get_the_title();
							$excerpt        = get_the_excerpt();
							$post_date      = get_the_date( 'F j, Y' );
							$featured_image = get_post_thumbnail_id();
							$member_only    = is_member_only( get_the_ID() );

							get_component( 'card-listing', [ 
								'classes'        => [ 'mb-6' ],
								'content_type'   => $post_type->label,
								'title'          => $title,
								'excerpt'        => $excerpt,
								'date'           => $post_date,
								'featured_image' => $featured_image,
								'topics'         => [],
								'link'           => [ 
									'url'    => '#',
									'text'   => 'Go somewhere',
									'target' => '_self',
								],
								'member_only'    => $member_only,
							] );
						}
						wp_reset_postdata();
					}

					?>
				</section>

			</div>
		</main>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>