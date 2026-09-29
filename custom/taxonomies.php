<?php

add_action('init', function () {

    /* News Type Taxonomy */
    register_taxonomy(
        'news_type',
        ['news'],
        [
            'label'             => _x('News Type', 'taxonomy name', 'wicket-theme'),
            'rewrite'           => ['slug' => 'news-type'],
            'show_admin_column' => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
        ]
    );

    /* Resource Type Taxonomy */
    register_taxonomy(
        'resource_type',
        ['resources'],
        [
            'label'             => _x('Resource Type', 'taxonomy name', 'wicket-theme'),
            'rewrite'           => ['slug' => 'resource-type'],
            'show_admin_column' => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
        ]
    );

    /* Topics Taxonomy */
    register_taxonomy(
        'topics',
        ['news', 'resources'],
        [
            'label'             => _x('Topics', 'taxonomy name', 'wicket-theme'),
            'rewrite'           => ['slug' => 'topics'],
            'show_admin_column' => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
        ]
    );

});
