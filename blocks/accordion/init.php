<?php
/**
 * Wicket Accordion
 *
 **/

namespace Wicket\Blocks\Wicket_Accordion;

/**
 * Accordion block registration function
 */
function init( $block = [] ) {

	$attrs = get_block_wrapper_attributes();

	$items                 = get_field( 'accordion_items' );
	$icon_type             = get_field( 'icon_type' );
	$spacing_between_items = get_field('spacing_between_items');
	$separate_title_body   = get_field('separate_title_body');

	echo '<div ' . $attrs . '>';
	get_component( 'accordion', [ 
		'items'                 => $items,
		'icon-type'             => $icon_type,
		'spacing-between-items' => $spacing_between_items,
		'separate-title-body'   => $separate_title_body
	] );
	echo '</div>';

	
}
