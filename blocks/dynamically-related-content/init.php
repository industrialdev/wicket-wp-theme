<?php
/**
 * Wicket Dynamically Related Content Block
 *
 **/

namespace Wicket\Blocks\Wicket_Dynamically_Related_Content;

/**
 * Featured posts block registration function
 */
function init( $block = [] ) {

	$attrs               = get_block_wrapper_attributes();
	$title               = get_field( 'related_content_title' );
	$column_count        = get_field( 'related_content_column_count' );
	$max_posts           = get_field( 'related_content_max_posts' );
	$post_type           = get_field( 'related_content_post_type' );
	$taxonomies          = get_field( 'related_content_taxonomies' );
	$hide_excerpt        = get_field( 'related_content_hide_excerpt' );
	$hide_date           = get_field( 'related_content_hide_date' );
	$hide_featured_image = get_field( 'related_content_hide_featured_image' );
	$hide_content_type   = get_field( 'related_content_hide_content_type' );
	$show_cta            = get_field( 'related_content_show_cta' );
	$show_view_all       = get_field( 'related_content_show_view_all' );
	$cta_style           = get_field( 'related_content_cta_style' );
	$current_post_id     = get_the_ID();

	$placeholder_styles = '';

	echo '<div ' . $attrs . ' ' . $placeholder_styles . '>';

	get_component( 'featured-posts', [ 
		'title'               => $title,
		'column_count'        => $column_count,
		'max_posts'           => $max_posts,
		'post_type'           => $post_type,
		'taxonomies'          => $taxonomies,
		'hide_excerpt'        => $hide_excerpt,
		'hide_date'           => $hide_date,
		'hide_featured_image' => $hide_featured_image,
		'hide_content_type'   => $hide_content_type,
		'show_cta'            => $show_cta,
		'show_view_all'       => $show_view_all,
		'cta_style'           => $cta_style,
		'current_post_id'     => $current_post_id,
	] );
	echo '</div>';
}
