<?php
/**
 * ACF Blocks
 *
 **/


/* Add Gutenberg Theme Support */
add_theme_support( 'wp-block-styles' );
add_theme_support( 'align-wide' );

/* Remove Core patterns */
remove_theme_support( 'core-block-patterns' );

/* Remove WooCommerce patterns
 * This does not work, support may be coming in future version
 */
// remove_theme_support( 'woocommerce-block-patterns' );

/**
 * Create Wicket pattern categories
 */
if ( function_exists( 'register_block_pattern_category' ) ) {
	register_block_pattern_category(
		'wicket',
		array(
			'label'       => __( 'Wicket', 'wicket' ),
			'description' => __( 'Custom pre-made patterns', 'wicket' ),
		)
	);
}

/**
 * Load ACF Blocks
 */
function load_acf_blocks() {
	$blocks = get_blocks();
	foreach ( $blocks as $block ) {
		if ( file_exists( get_template_directory() . '/blocks/' . $block . '/block.json' ) ) {
			// Check if Block is already registered
			$registry = WP_Block_Type_Registry::get_instance();
			if ( ! $registry->get_registered( 'wicket/' . $block ) ) {
				register_block_type( get_template_directory() . '/blocks/' . $block . '/block.json' );
				if ( file_exists( get_template_directory() . '/blocks/' . $block . '/style.css' ) ) {
					wp_register_style( 'block-' . $block, get_template_directory_uri() . '/blocks/' . $block . '/style.css', array(), filemtime( get_template_directory() . '/blocks/' . $block . '/style.css' ) );
				}
				if ( file_exists( get_template_directory() . '/blocks/' . $block . '/init.php' ) ) {
					include_once get_template_directory() . '/blocks/' . $block . '/init.php';
				}
			}
		}
	}
}
add_action( 'init', 'load_acf_blocks', 5 );

/**
 * Load ACF field groups for blocks
 */
function load_acf_blocks_field_group( $paths ) {
	$blocks = get_blocks();
	foreach ( $blocks as $block ) {
		$paths[] = get_template_directory() . '/blocks/' . $block;
	}
	return $paths;
}
add_filter( 'acf/settings/load_json', 'load_acf_blocks_field_group' );

/**
 * Get ACF Blocks
 */
function get_blocks() {
	$blocks = scandir( get_template_directory() . '/blocks/' );
	$blocks = array_values( array_diff( $blocks, array( '..', '.', '.DS_Store', '_base-block' ) ) );
	return $blocks;
}