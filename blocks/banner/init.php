<?php
/**
 * Wicket Banner block
 *
 **/

namespace Wicket\Blocks\Wicket_Banner;

/**
 * Banner block registration function
 */
function init( $block = [] ) {

	$attrs = get_block_wrapper_attributes();

	$title            = get_field( 'banner_title' ) ?: get_the_title();
	$show_breadcrumbs = get_field( 'banner_show_breadcrumbs' );
	$intro            = get_field( 'banner_intro' );
	$show_share       = get_field( 'banner_show_share' );
	$member_only      = is_member_only( get_the_ID() );
	$text_alignment   = get_field( 'banner_text_alignment' );
	$image            = get_field( 'banner_image' );
	$custom_image     = get_field( 'banner_custom_image' );
	$call_to_action   = get_field( 'banner_call_to_action' );
	$background_style = get_field( 'banner_background_style' );
	$background_image = get_field( 'banner_background_image' );

	echo '<div ' . $attrs . '>';
	get_component( 'banner', [ 
		'title'            => $title,
		'show_breadcrumbs' => $show_breadcrumbs,
		'intro'            => $intro,
		'show_share'       => $show_share,
		'member_only'      => $member_only,
		'text_alignment'   => $text_alignment,
		'image'            => $image,
		'custom_image'     => $custom_image,
		'call_to_action'   => $call_to_action,
		'background_style' => $background_style,
		'background_image' => $background_image,
	] );
	echo '</div>';
}
