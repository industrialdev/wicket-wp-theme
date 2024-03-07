<?php

// Define the custom taxonomies for the post type
function get_wicket_post_taxonomies() {

	$taxonomies = array(
		array(
			'slug'                => 'content_type',
			'single_name'         => 'Content Type',
			'plural_name'         => 'Content Types',
			'hierarchical'        => true,
			'has_archive'         => false,
			'public'              => true,
			'exclude_from_search' => true,
			'rewrite'             => array( 'slug' => 'group', 'with_front' => false ),
			'post_type'           => array( 'post', 'page' ),
			'show_in_rest'        => true,
		),
	);

	return $taxonomies;

}

/**
 * Register custom taxonomies for posts
 */
function register_wicket_post_taxonomies() {

	$taxonomies = get_wicket_post_taxonomies();

	foreach ( $taxonomies as $taxonomy ) {
		$labels = array(
			'name'              => $taxonomy['plural_name'],
			'singular_name'     => $taxonomy['single_name'],
			'search_items'      => 'Search ' . $taxonomy['plural_name'],
			'all_items'         => 'All ' . $taxonomy['plural_name'],
			'parent_item'       => 'Parent ' . $taxonomy['single_name'],
			'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
			'edit_item'         => 'Edit ' . $taxonomy['single_name'],
			'update_item'       => 'Update ' . $taxonomy['single_name'],
			'add_new_item'      => 'Add New ' . $taxonomy['single_name'],
			'new_item_name'     => 'New ' . $taxonomy['single_name'] . ' Name',
			'menu_name'         => $taxonomy['plural_name'],
		);

		$args = array(
			'hierarchical'        => $taxonomy['hierarchical'],
			'labels'              => $labels,
			'show_ui'             => true,
			'show_admin_column'   => true,
			'query_var'           => true,
			'rewrite'             => $taxonomy['rewrite'],
			'show_in_rest'        => $taxonomy['show_in_rest'],
			'public'              => $taxonomy['public'],
			'exclude_from_search' => $taxonomy['exclude_from_search'],
			'has_archive'         => $taxonomy['has_archive'],
		);

		register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], $args );
	}
}
add_action( 'init', 'register_wicket_post_taxonomies' );