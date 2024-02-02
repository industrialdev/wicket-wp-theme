<?php
/**
 * Wicket Featured posts block
 *
 **/

namespace Wicket\Blocks\Wicket_Featured_Posts;

/**
 * Featured posts block registration function
 */
function init( $block = [] ) {

	$attrs               = get_block_wrapper_attributes();
	$title               = get_field( 'featured_posts_title' );
	$posts               = get_field( 'featured_posts_posts' );
	$hide_date           = get_field( 'featured_posts_hide_date' );
	$hide_featured_image = get_field( 'featured_posts_hide_featured_image' );
	$hide_content_type   = get_field( 'featured_posts_hide_content_type' );
	$style               = get_field( 'featured_posts_style' );
	$column_count        = get_field( 'featured_posts_column_count' );

	if ( ! $posts ) {
		return;
	}

	echo '<div ' . $attrs . '>';
	get_component( 'featured-posts', [ 
		'title'               => $title,
		'posts'               => $posts,
		'hide_date'           => $hide_date,
		'hide_featured_image' => $hide_featured_image,
		'hide_content_type'   => $hide_content_type,
		'style'               => $style,
		'column_count'        => $column_count,
	] );
	echo '</div>';
}
