<?php

function get_component( $slug, array $args = array(), $output = true ) {
	/* $args will be available in the component file */
	if ( ! $output ) {
		ob_start();
	}
	$template_file = locate_template( "components/{$slug}.php", false, false );
	if ( file_exists( $template_file ) ) :
		require( $template_file );
	else :
		throw new \RuntimeException( "Could not find component $slug" );
	endif;
	if ( ! $output ) {
		return ob_get_clean();
	}
}

// Debug log helper function that accepts strings, objects, and arrays.
// Has an option to print to screen with the value wrapped in <pre> tags.
// Usage example: write_log( 'The variable value is: ' . $myVariable );
// Usage example 2: write_log( $myVariable, true );
if ( ! function_exists( 'wicket_write_log' ) ) {
	function wicket_write_log( $log, $print_preformatted_to_screen = false ) {
		if ( $print_preformatted_to_screen ) {
			print_r( "<pre>" );
			print_r( $log );
			print_r( "</pre>" );
		} else {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

function is_member_only( $post_id ) {
	$visibility = get_post_meta( $post_id, '_wppcp_post_page_visibility', true );
	return $visibility === 'member';
}