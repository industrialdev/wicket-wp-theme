<?php

/**
 * Template Name: Kitchen Sink Page.
 */
get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>

		<main class="py-5">
			<div class="container">
				<!--Find all files inside of the components folder and loop through them-->
				<?php foreach (glob(get_components_dir() . '*.php') as $filename) { ?>

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
                        'breadcrumbs.php',
                        'author.php',
                        'related-posts.php',
                        'related-events.php',
                        'card-event.php',
                        'tooltip.php',
                        'social-links.php',
                    ];

				    // If the current file is in the excluded files array, skip it
				    if (in_array(basename($filename), $excluded_files)) {
				        continue;
				    }
				    ?>
					<!-- <div class="mb-3">
						<h2 class="text-heading-lg capitalize mb-3"><?php echo basename($filename, '.php') ?></h2>
						<?php get_component(basename($filename, '.php')); ?>
					</div> -->
				<?php } ?>

				<hr>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Typography</h2>
					<div class="mb-6">
						<?php
				            $typography_classes = [
				                'text-heading-3xl',
				                'text-heading-2xl',
				                'text-heading-xl',
				                'text-heading-lg',
				                'text-heading-md',
				                'text-heading-sm',
				                'text-heading-xs',
				                'text-body-lg',
				                'text-body-md',
				                'text-body-sm',
				                'text-quote',
				                'text-placeholder',
				                'text-caption',
				                'text-button-label-lg',
				                'text-button-label-md',
				                'text-button-label-sm',
				                'text-form-label',
				                'text-date-label-md',
				                'text-date-label-sm',
				                'text-label-lg',
				                'text-label-md',
				                'text-label-sm',
				            ];

        foreach ($typography_classes as $classname) {
            echo "<div class='py-1 {$classname}' >{$classname}</div>";
        }
        ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Icon Grid</h2>
					<div class="mb-6">
						<?php get_component('icon-grid', [
						    'title'            => 'Lorem Ipsum',
						    'use-fa-codes'     => true,
						    'use-drop-shadows' => true,
						    'show-arrow-icon'  => true,
						    'icons'            => [
						        [
						            'icon_link_url' => '#',
						            'font-awesome_icon_code' => 'fa-solid fa-arrow-right',
						            'icon_grid_text' => 'Lorem Ipsum',
						        ],
						        [
						            'icon_link_url' => '#',
						            'font-awesome_icon_code' => 'fa-solid fa-lock',
						            'icon_grid_text' => 'Lorem Ipsum',
						        ],
						    ],
						]); ?>
					</div>
					<div class="mb-6">
						<?php get_component('icon-grid', [
						    'title'            => 'Lorem Ipsum',
						    'use-fa-codes'     => false,
						    'use-drop-shadows' => true,
						    'show-arrow-icon'  => true,
						    'icons'            => [
						        [
						            'icon_link_url' => '#',
						            'icon_grid_image' => [
						                'url' => 'https://place-hold.it/56x56',
						            ],
						            'icon_grid_text' => 'Lorem Ipsum',
						        ],
						        [
						            'icon_link_url' => '#',
						            'icon_grid_image' => [
						                'url' => 'https://place-hold.it/56x56',
						            ],
						            'icon_grid_text' => 'Lorem Ipsum is simply dummy text of.',
						        ],
						        [
						            'icon_link_url' => '#',
						            'icon_grid_image' => [
						                'url' => 'https://place-hold.it/56x56',
						            ],
						            'icon_grid_text' => 'Lorem Ipsum',
						        ],
						    ],
						]); ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Search Form</h2>
					<div class="mb-6">
						<form>
							<?php get_component('search-form', [
							    'placeholder' => 'Lorem Ipsum',
							]); ?>
							<div class="bg-black p-3 mt-4" >
								<?php get_component('search-form', [
								    'placeholder' => 'Lorem Ipsum',
								    'button_reversed' => true,
								]); ?>
							</div>
						</form>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Filter Form</h2>
					<div class="mb-6">
						<form>
							<?php get_component('filter-form', [
							    'taxonomies' => [
							        0 => [
							            'slug' => 'category',
							            'tooltip' => 'Hello World',
							        ],
							        1 => [
							            'slug' => 'post_tag',
							            'tooltip' => 'Lorem Ipsum',
							        ],
							    ],
							    'post_types' => [],
							    'hide_date_filter' => false,
							]); ?>
						</form>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Breadcrumbs</h2>
					<div class="mb-6">
						<?php get_component('breadcrumbs', ['style' => 'normal']); ?>
					</div>
					<div class="mb-6 bg-black">
						<?php get_component('breadcrumbs', ['style' => 'reversed']); ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Link</h2>
					<div class="mb-6">
						<?php get_component('link', [
						    'text'    => __('Link Label', 'wicket'),
						    'url'    => get_home_url(),
						]) ?>
					</div>
					<div class="mb-6">
						<h2 class="text-heading-xs mb-3">Link with icon (Small)</h2>
						<?php get_component(
						    'link',
						    [
						        'default_link_style' => true,
						        'size' => 'sm',
						        'url'        => get_home_url(),
						        'text'       => __('Home', 'wicket'),
						        'icon_start' => [
						            'icon' => 'fa-regular fa-house',
						        ],
						        'icon_end'   => [],
						    ]
						) ?>
					</div>
					<div class="mb-6">
						<h2 class="text-heading-xs mb-3">Link with icon (Medium)</h2>
						<?php get_component(
						    'link',
						    [
						        'default_link_style' => true,
						        'size' => 'md',
						        'url'        => get_home_url(),
						        'text'       => __('Home', 'wicket'),
						        'icon_start' => [
						            'icon' => 'fa-regular fa-house',
						        ],
						        'icon_end'   => [],
						    ]
						) ?>
					</div>
					<div class="mb-6">
						<h2 class="text-heading-xs mb-3">Link with icon (Large)</h2>
						<?php get_component(
						    'link',
						    [
						        'default_link_style' => true,
						        'size' => 'lg',
						        'url'        => get_home_url(),
						        'text'       => __('Home', 'wicket'),
						        'icon_start' => [
						            'icon' => 'fa-regular fa-house',
						        ],
						        'icon_end'   => [],
						    ]
						) ?>
					</div>
					<div class="mb-6 bg-black p-3">
						<h2 class="text-heading-xs text-white mb-3">Link with icon (Reversed)</h2>
						<?php get_component(
						    'link',
						    [
						        'reversed' => true,
						        'default_link_style' => false,
						        'url'        => get_home_url(),
						        'text'       => __('Home', 'wicket'),
						        'icon_start' => [
						            'icon' => 'fa-regular fa-house',
						        ],
						        'icon_end'   => [],
						    ]
						) ?>
					</div>
					<div class="mb-6 bg-black p-3">
						<h2 class="text-heading-xs text-white mb-3">Link with icon (Reversed, Default link style)</h2>
						<?php get_component(
						    'link',
						    [
						        'reversed' => true,
						        'default_link_style' => true,
						        'url'        => get_home_url(),
						        'text'       => __('Home', 'wicket'),
						        'icon_start' => [
						            'icon' => 'fa-regular fa-house',
						        ],
						        'icon_end'   => [],
						    ]
						) ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Tabs</h2>
					<div class="mb-6">
						<?php
						$items = [
						    0 => [
						        'title' => 'Nulla sit amet est',
						        'body_content' => '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#8217;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
						        'call_to_action' => [
						            'button_style' => 'secondary',
						            'link_and_label' => [
						                'title' => 'Secondary',
						                'url' => '#',
						                'target' => '',
						            ],
						        ],
						    ],
						    1 => [
						        'title' => 'Aldus PageMaker',
						        'body_content' => '<p>There are many <strong>variations</strong> of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#8217;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#8217;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>',
						        'call_to_action' => [
						            'button_style' => 'primary',
						            'link_and_label' => [
						                'title' => 'Primary Button',
						                'url' => '#',
						                'target' => '',
						            ],
						        ],
						    ],
						    2 => [
						        'title' => 'Hello World',
						        'body_content' => '<p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#8217;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>',
						        'call_to_action' => [
						            'button_style' => 'ghost',
						            'link_and_label' => [
						                'title' => 'Ghost button',
						                'url' => '#',
						                'target' => '',
						            ],
						        ],
						    ],
						];

        get_component('tabs', [
            'items' => $items,
        ]);
        ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Accordion</h2>
					<?php foreach (['list', 'card'] as $accordion_type) : ?>
						<div class="mb-6">
							<?php
            $items = [
                0 => [
                    'title' => 'Lorem Ipsum',
                    'title_is_a_link' => false,
                    'title_link' => null,
                    'body_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                    'call_to_action' => [
                        'button_link_style' => 'primary',
                        'link_and_label' => [
                            'title' => 'Lorem Link',
                            'url' => '#',
                            'target' => '',
                        ],
                    ],
                    'open_by_default' => true,
                ],
                1 => [
                    'title' => 'PageMaker',
                    'title_is_a_link' => true,
                    'title_link' => [
                        'title' => 'Hello World',
                        'url' => '#',
                        'target' => '',
                    ],
                    'body_content' => 'Lorem Ipsum is simply dummy standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting.',
                    'call_to_action' => [
                        'button_link_style' => 'secondary',
                        'link_and_label' => [
                            'title' => 'Hello',
                            'url' => '#',
                            'target' => '',
                        ],
                    ],
                    'open_by_default' => false,
                ],
            ];

					    get_component('accordion', [
					        'items'                 => $items,
					        'icon-type'             => 'plus-minus',
					        'accordion-type'        => $accordion_type,
					        'separate-title-body'   => false,
					    ]);
					    ?>
						</div>
					<?php endforeach; ?>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Table</h2>
					<div class="mb-6">
						<figure class="wp-block-table">
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
                $args = [
                    'post_type'      => 'page',
                    'posts_per_page' => 1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'paged'		  		 => get_query_var('paged') ? intval(get_query_var('paged')) : 1,
                ];

        $query = new WP_Query($args);

        the_wicket_pagination([
            'total' => $query->max_num_pages,
        ]);

        wp_reset_postdata();
        ?>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Primary buttons</h2>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'primary',
						    'size'        => 'lg',
						    'label'       => __('Primary large', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'primary',
						    'size'        => 'lg',
						    'label'       => __('Primary large disabled', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						    'disabled'    => true,
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'primary',
						    'label'       => __('Primary default', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'primary',
						    'size'        => 'sm',
						    'label'       => __('Primary small', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Secondary buttons</h2>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'secondary',
						    'size'        => 'lg',
						    'label'       => __('Secondary large', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'secondary',
						    'size'        => 'lg',
						    'label'       => __('Secondary large disabled', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						    'disabled'    => true,
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'secondary',
						    'label'       => __('Secondary default', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'secondary',
						    'size'        => 'sm',
						    'label'       => __('Secondary small', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Ghost buttons</h2>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'ghost',
						    'size'        => 'lg',
						    'label'       => __('Ghost large', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'ghost',
						    'size'        => 'lg',
						    'label'       => __('Ghost large disabled', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						    'disabled'    => true,
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'ghost',
						    'label'       => __('Ghost default', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
					<div class="mb-3">
						<?php get_component('button', [
						    'variant'     => 'ghost',
						    'size'        => 'sm',
						    'label'       => __('Ghost small', 'wicket'),
						    'prefix_icon' => 'fa fa-calendar-alt',
						    'suffix_icon' => 'fa fa-external-link-alt',
						]) ?>
					</div>
				</section>

				<section class="bg-black p-8 mb-6">
					<div class="py-3">
						<h2 class="text-heading-lg mb-3 text-white">Primary reversed</h2>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'primary',
							    'size'        => 'lg',
							    'label'       => __('Primary large', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'primary',
							    'size'        => 'lg',
							    'label'       => __('Primary large disabled', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							    'disabled'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'primary',
							    'label'       => __('Primary default', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'primary',
							    'size'        => 'sm',
							    'label'       => __('Primary small', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>

						<h2 class="text-heading-lg my-3 text-white">Secondary reversed</h2>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'secondary',
							    'size'        => 'lg',
							    'label'       => __('Secondary large', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'secondary',
							    'size'        => 'lg',
							    'label'       => __('Secondary large disabled', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							    'disabled'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'secondary',
							    'label'       => __('Secondary default', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'secondary',
							    'size'        => 'sm',
							    'label'       => __('Secondary small', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>

						<h2 class="text-heading-lg my-3 text-white">Ghost reversed</h2>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'ghost',
							    'size'        => 'lg',
							    'label'       => __('Ghost large', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'ghost',
							    'size'        => 'lg',
							    'label'       => __('Ghost large disabled', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							    'disabled'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'ghost',
							    'label'       => __('Ghost default', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>
						<div class="mb-3">
							<?php get_component('button', [
							    'variant'     => 'ghost',
							    'size'        => 'sm',
							    'label'       => __('Ghost small', 'wicket'),
							    'prefix_icon' => 'fa fa-calendar-alt',
							    'suffix_icon' => 'fa fa-external-link-alt',
							    'reversed'    => true,
							]) ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Icon</h2>
					<div class="row mb-6">
						<div class="col-sm-1">
							<?php get_component('icon', [
							    'classes' => ['custom-icon-class'],
							    'icon'    => 'fa fa-check',
							    'text'    => __('Icon Text'),
							]); ?>
						</div>
						<div class="col-sm-1">
							<?php get_component('icon', [
							    'classes' => ['custom-icon-class'],
							    'icon'    => 'fa-regular fa-home',
							    'text'    => __('Icon Text'),
							]); ?>
						</div>
						<div class="col-sm-1">
							<?php get_component('icon', [
							    'classes' => ['custom-icon-class'],
							    'icon'    => 'fa-regular fa-lock',
							    'text'    => __('Icon Text'),
							]); ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Social Sharing</h2>
					<div class="mb-6">
						<?php get_component('social-sharing'); ?>
					</div>
					<div class="mb-6 p-4 bg-black">
						<?php get_component('social-sharing', [
						    'reversed' => true,
						]); ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Tooltip</h2>
					<div class="mb-6">
						<?php get_component('tooltip', [
						    'content'  => __('Tooltip content', 'wicket'),
						    'position' => 'right',
						]); ?>
					</div>
					<div class="mb-6">
						<?php get_component('tooltip', [
						    'content'  => __('Tooltip content', 'wicket'),
						    'position' => 'left',
						]); ?>
					</div>
					<div class="mb-6">
						<?php get_component('tooltip', [
						    'content'  => __('Tooltip content', 'wicket'),
						    'position' => 'top',
						]); ?>
					</div>
					<div class="mb-6">
						<?php get_component('tooltip', [
						    'content'  => __('Tooltip content', 'wicket'),
						    'position' => 'bottom',
						]); ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Social Media Links</h2>
					<div class="mb-6 bg-slate-300 p-5">
						<?php get_component('social-links'); ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Tag</h2>
					<div class="mb-6">
						<div class="mb-4">
							<?php get_component('tag', [
							    'label' => __('Members Only', 'wicket'),
							    'icon'  => 'fa-regular fa-lock',
							]); ?>
						</div>
						<div class="mb-4">
							<?php get_component('tag', [
							    'label' => __('', 'wicket'),
							    'icon'  => 'fa-regular fa-lock',
							]); ?>
						</div>

						<div class="mb-4">
							<?php get_component('tag', [
							    'label' => __('Topic tag', 'wicket'),
							    'link'  => 'https://wicket.io/',
							    'icon'  => '',
							]); ?>
						</div>

						<div class="bg-black p-5">
							<div class="mb-4">
								<?php get_component('tag', [
								    'label'    => __('Members Only', 'wicket'),
								    'icon'     => 'fa-regular fa-lock',
								    'reversed' => true,
								]); ?>
							</div>
							<div>
								<?php get_component('tag', [
								    'label'    => __('', 'wicket'),
								    'icon'     => 'fa-regular fa-lock',
								    'reversed' => true,
								]); ?>
							</div>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Author</h2>
					<div class="mb-6">
						<div class="mb-4">
							<?php

                        get_component('author', [
                            'author' => [
                                'ID' => 15,
                                'user_firstname' => 'Mangus',
                                'user_lastname' => 'Awesome',
                                'nickname' => 'author_1',
                                'user_nicename' => 'author_1',
                                'display_name' => 'Mangus Awesome',
                                'user_email' => 'author@nomail.com',
                                'user_url' => 'https://wicket.io',
                                'user_registered' => '2024-10-07 10:37:50',
                                'user_description' => 'Nam commodo suscipit quam. Nulla porta dolor. Fusce fermentum odio nec arcu. Curabitur nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce id purus.',
                                'user_avatar' => '<img src="https://placehold.co/120x120" width="120" height="120" >',
                            ],
                            'hide_profile_image' => false,
                            'hide_bio' => false,
                        ]);

        ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Card</h2>
					<div class="flex gap-3">
						<?php foreach ([1, 2, 3] as $style) : ?>
							<div class="basis-4/12">
								<?php
            get_component('card', [
                'classes'        => [],
                'title'          => 'Lorem Ipsum',
                'subtitle'        => 'Lorem Ipsum Subtitle',
                'subtitle_location' => 'before-excerpt',
                'pre_heading' => 'Lorem Ipsum Pre Headung',
                'excerpt' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s',
                'link'           => [
                    'url'    => '#',
                    'title'   => 'Read more',
                    'target' => '_self',
                ],
                'cta_style'         => 'link',
                'image'             => [
                    'id' => 1787,
                    'alt' => 'Image Alt',
                ],
            ]) ?>
							</div>
						<?php endforeach; ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Card Contact</h2>
					<div class="mb-6">
						<div class="mb-4">
							<?php foreach (['primary', 'secondary'] as $style) : ?>
								<div class="mb-4">
									<?php
                get_component('card-contact', [
                    'classes' => [],
                    'title ' => '',
                    'description' => '
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                    'email' => 'no-reply@wicket.io',
                    'phone' => '555-555-555',
                    'style' => $style,
                    'title' => 'Quisque malesuada placerat nisl',
                ]) ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Card Event</h2>
					<div class="mb-6">
						<div class="mb-4">
							<div class="mb-4">
								<?php
            // get random post id
            $post_id = get_posts([
                'numberposts' => 1,
                'orderby'     => 'rand',
                'post_type'   => 'post',
                'post_status' => 'publish',
            ])[0]->ID;

        get_component('card-event', [
            'classes'                    => [],
            'post_id'                    => $post_id,
            'hide_excerpt'               => false,
            'hide_date'                  => false,
            'hide_event_category'        => false,
            'hide_event_format_location' => false,
            'hide_start_date_indicator'  => false,
            'member_only'                => false,
            'cta'                        => 'primary',
            'cta_label'                  => 'Label',
            'remove_drop_shadow'         => false,
            'show_tags'                  => true,
            'tag_taxonomy'               => [
                'taxonomy' => 'category',
            ],
        ]) ?>
							</div>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Card Call-out</h2>
					<div class="mb-6">
						<div class="mb-4">
							<?php foreach (['primary', 'secondary'] as $style) : ?>
								<div class="mb-4">
									<?php
            get_component('card-call-out', [
                'title'       => 'Lorem Ipsum',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s.',
                'links'       => [
                    [
                        'link_style'    => 'primary',
                        'link' => [
                            'title'  				=> 'Link Primary',
                            'link_style'    => 'primary',
                            'url'    				=> '#',
                            'target' 				=> '_blank',
                        ],
                    ],
                    [
                        'link_style'    => 'ghost',
                        'link' => [
                            'title'  				=> 'Link Ghost',
                            'url'    				=> '#',
                            'target' 				=> '_blank',
                        ],
                    ],
                ],
                'style'       => $style,
            ]) ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Manually Related Content</h2>
					<h2 class="text-heading-md mb-3">Card</h2>
					<div class="mb-6">
						<?php
                            $args = [
                                'classes' => [
                                    0 => 'man-related-content-card',
                                ],
                                'content_type' => 'document',
                                'link' => null,
                                'document' => [
                                    'ID' => 456,
                                    'id' => 456,
                                    'title' => 'dummy',
                                    'filename' => 'dummy.pdf',
                                    'filesize' => 13264,
                                    'url' => 'https://localhost/app/uploads/2024/01/dummy.pdf',
                                    'link' => 'https://localhost/dummy/',
                                    'alt' => '',
                                    'author' => '1',
                                    'description' => '',
                                    'caption' => '',
                                    'name' => 'dummy',
                                    'status' => 'inherit',
                                    'uploaded_to' => 0,
                                    'date' => '2024-01-31 19:44:56',
                                    'modified' => '2024-01-31 19:44:56',
                                    'menu_order' => 0,
                                    'mime_type' => 'application/pdf',
                                    'type' => 'application',
                                    'subtype' => 'pdf',
                                    'icon' => 'https://localhost/wp/wp-includes/images/media/document.png',
                                ],
                                'display_text' => 'Document here',
                                'body_text' => 'Suspendisse potenti. Etiam imperdiet imperdiet orci. Vestibulum eu odio. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Praesent venenatis metus at tortor pulvinar varius.',
                                'icon_type' => 'default',
                                'icon' => false,
                                'layout_style' => 'card',
                                'cta_label_override' => 'Cta Label',
                                'rounded_corners' => false,
                            ];

        get_component('card-related', $args);
        ?>
					</div>
					
					<h2 class="text-heading-md mb-3">List</h2>
					<div class="mb-6">
						<?php
            $args = [
                'classes' => [
                    0 => 'man-related-content-card',
                ],
                'content_type' => 'document',
                'link' => null,
                'document' => [
                    'ID' => 456,
                    'id' => 456,
                    'title' => 'dummy',
                    'filename' => 'dummy.pdf',
                    'filesize' => 13264,
                    'url' => 'https://localhost/app/uploads/2024/01/dummy.pdf',
                    'link' => 'https://localhost/dummy/',
                    'alt' => '',
                    'author' => '1',
                    'description' => '',
                    'caption' => '',
                    'name' => 'dummy',
                    'status' => 'inherit',
                    'uploaded_to' => 0,
                    'date' => '2024-01-31 19:44:56',
                    'modified' => '2024-01-31 19:44:56',
                    'menu_order' => 0,
                    'mime_type' => 'application/pdf',
                    'type' => 'application',
                    'subtype' => 'pdf',
                    'icon' => 'https://localhost/wp/wp-includes/images/media/document.png',
                ],
                'display_text' => 'Document here',
                'body_text' => 'Suspendisse potenti. Etiam imperdiet imperdiet orci. Vestibulum eu odio. Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Praesent venenatis metus at tortor pulvinar varius.',
                'icon_type' => 'default',
                'icon' => false,
                'layout_style' => 'list',
                'cta_label_override' => 'Cta Label',
                'rounded_corners' => false,
            ];

        get_component('card-related', $args);
        ?>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Featured Posts</h2>
					<h2 class="text-heading-md mb-3">One Level</h2>
					<div class="mb-6">
						<?php
            // get all posts
            $posts = get_posts([
                'posts_per_page' => -1,
                'post_type' => 'post',
                'orderby' => 'date',
                'order' => 'DESC',
            ]);

        $args = [
            'classes' => [],
            'title' => 'Lorem Ipsum',
            'hide_block_title' => false,
            'posts' => $posts,
            'hide_excerpt' => false,
            'hide_date' => false,
            'hide_featured_image' => false,
            'hide_content_type' => false,
            'style' => 'one-level',
            'column_count' => '2',
        ];

        get_component('featured-posts', $args);
        ?>
					</div>
					
					<h2 class="text-heading-md mb-3">Primary Secondary Level</h2>
					<div class="mb-6">
						<?php
            $args['style'] = 'primary-secondary-level';
        $args['column_count'] = null;

        get_component('featured-posts', $args);
        ?>
					</div>
				</section>


				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Banner</h2>

					<?php foreach (['light', 'reversed', 'image'] as $style) : ?>
						<div class="mb-6">
							<div class="mb-4">
								<?php
                $featured_image = null;

					    if ($style === 'image') {
					        $featured_image = [
					            'id' => get_post_thumbnail_id(),
					            'alt' => 'Image here',
					        ];
					    }

					    $banner_args = [
					        'classes' => [],
					        'title ' => 'Title Here',
					        'intro' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
					        'show_breadcrumbs' => true,
					        'show_post_type' => true,
					        'show_share' => true,
					        'show_date' => true,
					        'member_only' => true,
					        'text_alignment' => 'left',
					        'image' => 'featured-image',
					        'custom_image' => null,
					        'call_to_action' => null,
					        'background_style' => $style,
					        'background_image' => $featured_image,
					        'back_link' => 'https://google.com',
					        'download_file' => [
					            'url' => '#',
					            'title' => 'Lorem Ipsum',
					        ],
					        // 'download_button_style' => NULL,
					        'download_button_label' => 'Download',
					        'helper_link' => [
					            'url' => '#',
					            'title' => 'Lorem Ipsum',
					            'target' => '_self',
					        ],
					        // 'helper_link_button_style' => NULL,
					        'title' => 'Lorem Ipsum',
					    ];
					    get_component('banner', $banner_args);
					    ?>
							</div>
							<div class="mb-6">
								<?php
					    $banner_args['text_alignment'] = 'center';
					    $banner_args['image'] = '';
					    get_component('banner', $banner_args);
					    ?>
							</div>
							<div class="mb-6">
								<?php
					    $banner_args['text_alignment'] = 'left';
					    $banner_args['image'] = '';
					    $banner_args['call_to_action'] = [
					        'title' => 'Title 1',
					        'description' => 'Aliquam lobortis. Nullam tincidunt adipiscing enim. Donec vitae sapien ut libero venenatis faucibus. Praesent ut ligula non mi varius sagittis. Phasellus viverra nulla ut metus varius laoreet.',
					        'links' => [
					            0 => [
					                'link' => [
					                    'title' => 'Link',
					                    'url' => '#',
					                    'target' => '_blank',
					                ],
					                'variant' => 'primary',
					            ],
					            1 => [
					                'link' => [
					                    'title' => 'Link Two',
					                    'url' => '#',
					                    'target' => '_blank',
					                ],
					                'variant' => 'secondary',
					            ],
					            2 => [
					                'link' => [
					                    'title' => 'Link Three',
					                    'url' => '#',
					                    'target' => '_blank',
					                ],
					                'variant' => 'ghost',
					            ],
					        ],
					    ];
					    get_component('banner', $banner_args);
					    ?>
							</div>
						</div>
					<?php endforeach; ?>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Listing Card</h2>
					<?php
                    $args = [
					    'post_type'      => 'post',
					    'posts_per_page' => 2,
					    'orderby'        => 'date',
					    'order'          => 'DESC',
                    ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $index = 1;
            while ($query->have_posts()) {
                $query->the_post();

                $post_type = get_post_type_object(get_post_type());
                $title = get_the_title();
                $excerpt = get_the_excerpt();
                $post_date = get_the_date('F j, Y');
                $featured_image = get_post_thumbnail_id();
                $member_only = is_member_only(get_the_ID());

                get_component('card-listing', [
                    'classes'        => ['mb-6'],
                    'content_type'   => 'Lorem Ipsum',
                    'title'          => $title,
                    'excerpt'        => $excerpt,
                    'date'           => $post_date,
                    'featured_image' => $featured_image,
                    'topics'         => get_terms(),
                    'link'           => [
                        'url'    => get_permalink(),
                        'text'   => 'Go somewhere',
                        'target' => '_self',
                    ],
                    'helper_link' => [
                        'url'    => '#',
                        'title'   => 'Helper Link',
                        'target' => '_self',
                    ],
                    'document' => '#',
                    'member_only'    => true,
                ]);

                $index++;
            }
            wp_reset_postdata();
        }

        ?>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">AC Callouts</h2>

					<?php
            $ac_types = [
                'callout-become_member' => ['', 'callout-pending_approval'],
                'callout-renewal' => ['callout-grace_period', 'callout-early_renewal'],
                'callout-profile' => [''],
            ];

        foreach ($ac_types as $ac_type => $item) :
            foreach ($item as $subitem) :
                ?>
							<div class="mb-6" >
								<?php
                                $attrs = get_block_wrapper_attributes(['class' => "{$ac_type} {$subitem}"]);
                // echo "<h2 class='text-heading-md mb-3'>{$ac_type} - {$subitem}</h2>";
                echo '<div ' . $attrs . '>';
                get_component('card-call-out', [
                    'title'       => 'Lorem Ipsum',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s.',
                    'links'       => [
                        [
                            'link' => [
                                'title' => 'Link Here',
                                'url' => '#',
                            ],
                        ],
                        [
                            'link_style' => 'ghost',
                            'link' => [
                                'title' => 'Link Here',
                                'url' => '#',
                            ],
                        ],
                    ],
                    'style'       => '',
                ]);
                echo '</div>';
                ?>
							</div>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Welcome Block</h2>

					<div class="flex" >
						<div class="basis-9/12" >
							<?php
                $block_content = '
								<!-- wp:wicket-ac/ac-welcome {"name":"wicket-ac/ac-welcome","data":{"field_66100d9eca323":"1","field_662a9bd181d60":{"title":"Edit Profile","url":"/my-account/edit-profile/","target":""},"field_6613e7dd4c413":"1","field_6613e7dc4c412":"1","field_66ad00c245a65":"1"},"mode":"edit","alignText":"left"} /-->';

        $parsed_blocks = parse_blocks($block_content);

        if ($parsed_blocks) {
            foreach ($parsed_blocks as $block) {
                echo render_block($block);
            }
        }
        ?>
						</div>
					</div>
				</section>

				<section class="py-8">
					<h2 class="text-heading-lg mb-3">AC Profile Picture</h2>

					<div class="flex" >
						<div class="basis-9/12" >
							<?php
            $block_content = '
								<!-- wp:wicket-ac/ac-profile-picture {"name":"wicket-ac/ac-profile-picture","data":{"profile_picture_max_size":"1","_profile_picture_max_size":"field_669ac1a47221e"},"mode":"preview","alignText":"left"} /-->';

        $parsed_blocks = parse_blocks($block_content);

        if ($parsed_blocks) {
            foreach ($parsed_blocks as $block) {
                echo render_block($block);
            }
        }
        ?>
						</div>
					</div>
				</section>
				
				<section class="py-8">
					<h2 class="text-heading-lg mb-3">AC Create Profile</h2>

					<div class="flex" >
						<div class="basis-9/12" >
							<?php
            $block_content = '<!-- wp:wicket/create-account {"name":"wicket/create-account","data":{},"mode":"preview","alignText":"left"} /-->';

        $parsed_blocks = parse_blocks($block_content);

        if ($parsed_blocks) {
            foreach ($parsed_blocks as $block) {
                echo render_block($block);
            }
        }
        ?>
						</div>
					</div>
				</section>
				
				<section class="py-8">
					<h2 class="text-heading-lg mb-3">AC Update Password</h2>

					<div class="flex" >
						<div class="basis-9/12" >
							<?php
            $block_content = '<!-- wp:wicket-ac/ac-password {"name":"wicket-ac/ac-password","data":{},"mode":"preview","alignText":"left"} /-->';

        $parsed_blocks = parse_blocks($block_content);

        if ($parsed_blocks) {
            foreach ($parsed_blocks as $block) {
                echo render_block($block);
            }
        }
        ?>
						</div>
					</div>
				</section>
				
				<section class="py-8">
					<h2 class="text-heading-lg mb-3">Dynamically Related Events</h2>

					<div class="flex" >
						<div class="basis-9/12" >
							<?php
            $block_content = '<!-- wp:wicket/dynamically-related-events {"name":"wicket/dynamically-related-events","data":{"field_66fa740f9c38f":"Dynamically Related Events","field_66fa740f9c791":"0","field_66fa740f9cb73":"1","field_66fa740f9cf5e":"0","field_66fa740f9d72d":"1","field_66fa740f9db12":"15","field_66fa740f9e2de":"","field_66fa740f9eea2":"0","field_66fa740f9f280":"0","field_66fa740f9f671":"0","field_66fa740f9fa54":"0","field_66fa7bf9f4ed0":"0","field_66fa7c8d121d3":"0","field_66fa7deda2a5e":"0","field_66fa7e03a2a5f":"0","field_66fa740f9fe3c":"0","field_66fa7eb4a2a60":"0","field_66fe80efc9500":{"field_66fe80efc9500_field_6602a771ef4a9":"0"},"field_66fa740f9e6cb":"0","field_66fa740f9eab1":""},"mode":"edit","alignText":"left"} /-->';

        $parsed_blocks = parse_blocks($block_content);

        if ($parsed_blocks) {
            foreach ($parsed_blocks as $block) {
                echo render_block($block);
            }
        }
        ?>
						</div>
					</div>
				</section>
				
				<section class="py-8">
					<h2 class="text-heading-lg mb-3"></h2>

					<div class="mb-6" >
						<?php
        get_component('sidebar-contextual-nav', [
            'icon-type'     => 'chevrons', // plus-minus, carets
        ]);
        ?>
					</div>
				</section>

			</div>
		</main>

<?php endwhile;
endif; ?>

<?php get_footer(); ?>