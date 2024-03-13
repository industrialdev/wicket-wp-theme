<?php

add_action( 'init', function () {

	/* News Type Taxonomy */
	register_taxonomy(
		'content_type',
		[ 'news' ],
		array (
			'label'             => __( 'News Type' ),
			'rewrite'           => array ( 'slug' => 'news-type' ),
			'show_admin_column' => true,
			'hierarchical'      => true,
		)
	);

	/* Resource Type Taxonomy */
	register_taxonomy(
		'resource_type',
		[ 'resources' ],
		array (
			'label'             => __( 'Resource Type' ),
			'rewrite'           => array ( 'slug' => 'resource-type' ),
			'show_admin_column' => true,
			'hierarchical'      => true,
		)
	);

	/* Topics Taxonomy */
	register_taxonomy(
		'topics',
		[ 'news', 'resources' ],
		array (
			'label'             => __( 'Topics' ),
			'rewrite'           => array ( 'slug' => 'topics' ),
			'show_admin_column' => true,
			'hierarchical'      => true,
		)
	);


} );