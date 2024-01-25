<?php 

/*
* Create Custom Post Type For Listings
*/

function post_type_listing() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Listings', 'Post Type General Name', 'wicket' ),
		'singular_name'       => _x( 'Listing', 'Post Type Singular Name', 'wicket' ),
		'menu_name'           => __( 'Listings', 'wicket' ),
		'parent_item_colon'   => __( 'Parent Listing', 'wicket' ),
		'all_items'           => __( 'All Listings', 'wicket' ),
		'view_item'           => __( 'View Listing', 'wicket' ),
		'add_new_item'        => __( 'Add New Listing', 'wicket' ),
		'add_new'             => __( 'Add New Listing', 'wicket' ),
		'edit_item'           => __( 'Edit Listing Details', 'wicket' ),
		'update_item'         => __( 'Update Listing', 'wicket' ),
		'search_items'        => __( 'Search Listing', 'wicket' ),
		'not_found'           => __( 'Not Found', 'wicket' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'wicket' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'listings', 'wicket' ),
		'description'         => __( 'Listings', 'wicket' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'thumbnail', 'editor' ),
		// A hierarchical CPT is like Pages and can have Parent and child items. A non-hierarchical CPT is like Posts.
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'menu_icon'			  => 'dashicons-id-alt',
		'can_export'          => true,
        'has_archive'         => 'listings',
        'rewrite'             => array( 'slug' => 'listing' ),
        'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		// Enable Gutenberg
        'show_in_rest' => true,
        'template'     => array(
            array( 'core/pattern', array(
                'slug' => 'wicket/listing-block-template',
            ) ),
        ),
		//'template_lock' => 'all',
	);
	
	// Registering your Custom Post Type
	register_post_type( 'listing', $args );

}
add_action( 'init', 'post_type_listing', 0 );

/**
 * Get Listings taxonomies initial information.
 *
 * @return array
 */
function get_wicket_listing_taxonomies() {

    $taxonomies = array(
        array(
            'slug'         => 'listing-type',
            'single_name'  => 'Type',
            'plural_name'  => 'Types',
	        'hierarchical'  => true,
	        'has_archive'  => false,
			'public'	   => false,
			'exclude_from_search'  => true,
			'rewrite' => array( 'slug' => 'group', 'with_front' => false ),
            'post_type'    => array('listing'),
			// Enable Gutenberg
            'show_in_rest' => true,
        ),
    );

    return $taxonomies;

}

/**
 * Register Custom Taxonomies for Wrestler CPT
 */
function register_wicket_listing_taxonomies() {

    $taxonomies = get_wicket_listing_taxonomies();

    foreach( $taxonomies as $taxonomy ) {
        $labels = array(
            'name' => $taxonomy['plural_name'],
            'singular_name' => $taxonomy['single_name'],
            'search_items' =>  'Search ' . $taxonomy['plural_name'],
            'all_items' => 'All ' . $taxonomy['plural_name'],
            'parent_item' => 'Parent ' . $taxonomy['single_name'],
            'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
            'edit_item' => 'Edit ' . $taxonomy['single_name'],
            'update_item' => 'Update ' . $taxonomy['single_name'],
            'add_new_item' => 'Add New ' . $taxonomy['single_name'],
			'view_item' => 'View  ' . $taxonomy['single_name'],
            'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
            'menu_name' => $taxonomy['plural_name']
        );

        $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
        $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;
        $has_archive = isset( $taxonomy['has_archive'] ) ? $taxonomy['has_archive'] : true;
        $public = isset( $taxonomy['public'] ) ? $taxonomy['public'] : true;
        $show_in_rest = isset( $taxonomy['show_in_rest'] ) ? $taxonomy['show_in_rest'] : true;

        register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
            'hierarchical' => $hierarchical,
            'has_archive' => $has_archive,
            'public' => $public,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => $rewrite,
            'show_in_rest' => $show_in_rest,
        ));
    }

}
add_action( 'init', 'register_wicket_listing_taxonomies' );