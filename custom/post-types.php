<?php

/**
 * Register Custom Post Types
 */
function wicket_register_post_types()
{
    $post_types = [
        'news' => [
            'singular' => 'News',
            'plural'   => 'News',
            'args'     => [
                'menu_icon'   => 'dashicons-nametag',
                'has_archive' => 'news-archive',
                'template'    => [
                    ['wicket/banner', [
                        'data'  => [
                            'banner_show_breadcrumbs' => false,
                            'banner_show_post_type'   => true,
                            'banner_back_link'        => '',
                            'banner_show_date'        => true,
                        ],
                        'align' => 'full',
                        'lock'  => [
                            'move'   => true,
                            'remove' => true,
                        ],
                    ]],
                    ['core/paragraph', [
                        'content' => '<b>Topics:</b>',
                        'style'   => [
                            'spacing' => [
                                'padding' => [
                                    'top'    => '1.5rem',
                                    'bottom' => '0',
                                ],
                            ]],
                    ]],
                    ['core/post-terms', [
                        'term' => 'post_tag',
                    ]],
                    ['wicket/manually-related-content'],
                    ['wicket/dynamically-related-content', [
                        'data' => [
                            'related_content_max_posts'    => 3,
                            'related_content_column_count' => 3,
                            'post_type'                    => 'news',
                        ],
                    ]],
                ],
            ],
        ],
        'resources' => [
            'singular' => 'Resources',
            'plural'   => 'Resources',
            'args'     => [
                'menu_icon'   => 'dashicons-book-alt',
                'has_archive' => 'resources-archive',
                'template'    => [
                    ['wicket/banner', [
                        'data'  => [
                            'banner_show_breadcrumbs' => false,
                            'banner_show_post_type'   => true,
                            'banner_back_link'        => '',
                            'banner_show_date'        => true,
                        ],
                        'align' => 'full',
                        'lock'  => [
                            'move'   => true,
                            'remove' => true,
                        ],
                    ]],
                    ['core/paragraph', [
                        'content' => '<b>Topics:</b>',
                        'style'   => [
                            'spacing' => [
                                'padding' => [
                                    'top'    => '1.5rem',
                                    'bottom' => '0',
                                ],
                            ]],
                    ]],
                    ['core/post-terms', [
                        'term' => 'post_tag',
                    ]],
                    ['wicket/manually-related-content'],
                    ['wicket/dynamically-related-content', [
                        'data' => [
                            'related_content_max_posts'    => 3,
                            'related_content_column_count' => 3,
                            'post_type'                    => 'resources',
                        ],
                    ]],
                ],
            ],
        ],
    ];

    foreach ($post_types as $key => $pt) {
        $singular = $pt['singular'];
        $plural   = $pt['plural'];
        $args     = $pt['args'];

        $labels = [
            'name'               => _x($singular, 'post type general name', 'wicket'),
            'singular_name'      => _x($singular, 'post type singular name', 'wicket'),
            'menu_name'          => _x($plural, 'admin menu', 'wicket'),
            'name_admin_bar'     => _x($singular, 'add new on admin bar', 'wicket'),
            'add_new'            => _x('Add New', $singular, 'wicket'),
            'add_new_item'       => __('Add New ', 'wicket') . $singular,
            'new_item'           => __('New ', 'wicket') . $singular,
            'edit_item'          => __('Edit ', 'wicket') . $singular,
            'view_item'          => __('View ', 'wicket') . $singular,
            'all_items'          => __('All ', 'wicket') . $plural,
            'search_items'       => __('Search ', 'wicket') . $plural,
            'parent_item_colon'  => __('Parent ', 'wicket') . $plural . ':',
            'not_found'          => __('No ', 'wicket') . $plural . __(' found.', 'wicket'),
            'not_found_in_trash' => __('No ', 'wicket') . $plural . __(' found in Trash.', 'wicket'),
        ];

        $rewrite = [
            'slug'       => sanitize_title($singular) . '-post',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        ];

        $defaults = [
            'labels'              => $labels,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'hierarchical'        => true,
            'menu_icon'           => 'dashicons-database',
            'menu_position'       => 6,
            'public'              => true,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'show_in_menu'        => true,
            'show_ui'             => true,
            'show_in_rest'        => true,
            'taxonomies'          => [],
            'rewrite'             => $rewrite,
            'supports'            => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'],
        ];

        $final_args = wp_parse_args($args, $defaults);

        $filter_args = apply_filters('wicket_post_type_args', $final_args, sanitize_title($singular));
        if (!empty($filter_args)) {
            $final_args = wp_parse_args($filter_args, $defaults);
        }

        register_post_type(sanitize_title($singular), $final_args);
    }
}
add_action('init', 'wicket_register_post_types');
