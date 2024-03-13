<?php
function register_cpt( $singular, $plural = false, $args = [] ) {
	if ( $plural === false ) :
		$plural = $singular . 's';
	endif;

	$labels = [ 
		'name'               => _x( $singular, 'post type general name' ),
		'singular_name'      => _x( $singular, 'post type singular name' ),
		'menu_name'          => _x( $plural, 'admin menu' ),
		'name_admin_bar'     => _x( $singular, 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', $singular ),
		'add_new_item'       => __( "Add New $singular" ),
		'new_item'           => __( "New $singular" ),
		'edit_item'          => __( "Edit $singular" ),
		'view_item'          => __( "View $singular" ),
		'all_items'          => __( "All $plural" ),
		'search_items'       => __( "Search $plural" ),
		'parent_item_colon'  => __( "Parent $plural:" ),
		'not_found'          => __( "No $plural found." ),
		'not_found_in_trash' => __( "No $plural found in Trash." ),
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
		'supports'            => array( 'title' ),
		'show_in_rest'        => true,
		'taxonomies'          => [],
	];

	$args = wp_parse_args( $args, $defaults );

	register_post_type( sanitize_title( $singular ), $args );
}

add_action( 'init', function () {

	/* News Post Type */
	register_cpt( 'News', 'News',
		[ 
			'menu_icon' => 'dashicons-nametag',
			'supports'  => array ( 'title', 'editor', 'excerpt', 'custom-fields', 'revisions' ),
			'template'  => array (
				array ( 'wicket/banner', [ 
					'data'  => [ 
						'banner_show_breadcrumbs' => false,
						'banner_show_post_type'   => true,
						'banner_back_link'        => home_url( '/blog' ),
						'banner_show_date'        => true,
					],
					'align' => 'full',
					'lock'  => array (
						'move'   => true,
						'remove' => true,
					),
				] ),
				array ( 'core/paragraph', [ 
					'content' => '<b>Topics:</b>',
					'style'   => [ 
						'spacing' => [ 
							'padding' => [ 
								'top'    => '1.5rem',
								'bottom' => '0',
							],
						] ],
				] ),
				array ( 'core/post-terms', [ 
					'term' => 'post_tag',
				] ),
				array ( 'wicket/manually-related-content' ),
			),
		] );

	/* Resource Post Type */
	register_cpt( 'Resources', 'Resources',
		[ 
			'menu_icon' => 'dashicons-book-alt',
			'supports'  => array ( 'title', 'editor', 'excerpt', 'custom-fields', 'revisions' ),
			'template'  => array (
				array ( 'wicket/banner', [ 
					'data'  => [ 
						'banner_show_breadcrumbs' => false,
						'banner_show_post_type'   => true,
						'banner_back_link'        => home_url( '/blog' ),
						'banner_show_date'        => true,
					],
					'align' => 'full',
					'lock'  => array (
						'move'   => true,
						'remove' => true,
					),
				] ),
				array ( 'core/paragraph', [ 
					'content' => '<b>Topics:</b>',
					'style'   => [ 
						'spacing' => [ 
							'padding' => [ 
								'top'    => '1.5rem',
								'bottom' => '0',
							],
						] ],
				] ),
				array ( 'core/post-terms', [ 
					'term' => 'post_tag',
				] ),
				array ( 'wicket/manually-related-content' ),
			),
		] );

} );