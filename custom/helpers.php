<?php

function get_component( $slug, array $args = array(), $output = true ) {
	/* $args will be available in the component file */
	if ( ! $output ) {
		ob_start();
	}
	$template_file = locate_template( "components/{$slug}.php", false, false );
	if ( file_exists( $template_file ) ) :
		require ( $template_file );
	else :
		throw new \RuntimeException( "Could not find component $slug" );
	endif;
	if ( ! $output ) {
		return ob_get_clean();
	}
}

function component_exists( $slug ) {
	$template_file = locate_template( "components/{$slug}.php", false, false );
	if ( file_exists( $template_file ) ) {
		return true;
	}
	return false;
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

function get_social_link_label( $links, $name ) {
	foreach ( $links as $link ) {
		if ( $link['name'] === $name ) {
			return $link['label'];
		}
	}
}

function wicket_get_site_root_url() {
	if ( defined( 'WP_HOME' ) ) {
		return WP_HOME;
	}

	$site_url = get_site_url();

	// Remove /wp/ if present in the site_url (present for Bedrock)
	if ( str_contains( $site_url, '/wp//' ) ) {
		$site_url = str_replace( '/wp//', '', $site_url );
	}

	// Remove /wp if present in the site_url (present for Bedrock)
	if ( str_contains( $site_url, '/wp' ) ) {
		$site_url = str_replace( '/wp', '', $site_url );
	}

	return $site_url;
}

function get_related_content_type( $post_type ) {
	// Switch case to return the related content type for a given post type
	switch ( $post_type ) {
		case 'news':
			return 'news_type';
		case 'resources':
			return 'resource_type';
		case 'post':
			return 'category';
		default:
			return '';
	}
}

function get_related_content_type_term( $post_id ) {
	$related_content_type = get_related_content_type( get_post_type( $post_id ) );
	$content_type         = ! is_wp_error( get_the_terms( $post_id, $related_content_type ) ) ? get_the_terms( $post_id, $related_content_type ) : [];

	if ( $content_type ) {
		return $content_type[0]->name;
	} else {
		return get_post_type_object( get_post_type( $post_id ) )->labels->singular_name;
	}
}

function get_related_topic_type( $post_type ) {
	switch ( $post_type ) {
		case 'news':
			return 'topics';
		case 'resources':
			return 'topics';
		case 'post':
			return 'post_tag';
		default:
			return '';
	}
}