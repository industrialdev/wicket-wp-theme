<?php

/**
 * Register Custom Post Types.
 */
function wicket_register_post_types()
{
    $post_types = [
        'news' => [
            'singular'       => 'News',
            'plural'         => 'News',
            'singular_label' => _x('News', 'post type singular name', 'wicket-theme'),
            'plural_label'   => _x('News', 'post type general name', 'wicket-theme'),
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
            'singular'       => 'Resources',
            'plural'         => 'Resources',
            'singular_label' => _x('Resources', 'post type singular name', 'wicket-theme'),
            'plural_label'   => _x('Resources', 'post type general name', 'wicket-theme'),
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
        $plural = $pt['plural'];
        $args = $pt['args'];
        // Raw $singular/$plural stay untranslated: they drive the rewrite slug and filter key.
        $singular_label = $pt['singular_label'];
        $plural_label = $pt['plural_label'];

        $labels = [
            'name'               => $plural_label,
            'singular_name'      => $singular_label,
            'menu_name'          => $plural_label,
            'name_admin_bar'     => $singular_label,
            'add_new'            => __('Add New', 'wicket-theme'),
            /* translators: %s: post type singular name. */
            'add_new_item'       => sprintf(_x('Add New %s', 'post type label', 'wicket-theme'), $singular_label),
            /* translators: %s: post type singular name. */
            'new_item'           => sprintf(_x('New %s', 'post type label', 'wicket-theme'), $singular_label),
            /* translators: %s: post type singular name. */
            'edit_item'          => sprintf(_x('Edit %s', 'post type label', 'wicket-theme'), $singular_label),
            /* translators: %s: post type singular name. */
            'view_item'          => sprintf(_x('View %s', 'post type label', 'wicket-theme'), $singular_label),
            /* translators: %s: post type plural name. */
            'all_items'          => sprintf(_x('All %s', 'post type label', 'wicket-theme'), $plural_label),
            /* translators: %s: post type plural name. */
            'search_items'       => sprintf(_x('Search %s', 'post type label', 'wicket-theme'), $plural_label),
            /* translators: %s: post type plural name. */
            'parent_item_colon'  => sprintf(_x('Parent %s:', 'post type label', 'wicket-theme'), $plural_label),
            /* translators: %s: post type plural name. */
            'not_found'          => sprintf(_x('No %s found.', 'post type label', 'wicket-theme'), $plural_label),
            /* translators: %s: post type plural name. */
            'not_found_in_trash' => sprintf(_x('No %s found in Trash.', 'post type label', 'wicket-theme'), $plural_label),
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
