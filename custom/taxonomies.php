<?php

add_action('init', function () {

    /* News Type Taxonomy */
    register_taxonomy(
        'news_type',
        [ 'news' ],
        [
            'label'             => __('News Type'),
            'rewrite'           => [ 'slug' => 'news-type' ],
            'show_admin_column' => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
        ]
    );

    /* Resource Type Taxonomy */
    register_taxonomy(
        'resource_type',
        [ 'resources' ],
        [
            'label'             => __('Resource Type'),
            'rewrite'           => [ 'slug' => 'resource-type' ],
            'show_admin_column' => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
        ]
    );

    /* Topics Taxonomy */
    register_taxonomy(
        'topics',
        [ 'news', 'resources' ],
        [
            'label'             => __('Topics'),
            'rewrite'           => [ 'slug' => 'topics' ],
            'show_admin_column' => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
        ]
    );


});
