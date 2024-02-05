<?php
/**
 * Wicket Sidebar/Contextual Nav
 *
 **/

namespace Wicket\Blocks\Wicket_SidebarContextualNav;

/**
 * Accordion block registration function
 */
function init( $block = [] ) {

	$attrs = get_block_wrapper_attributes();

	echo '<div ' . $attrs . '>';
	get_component( 'sidebar-contextual-nav', [ ] );
	echo '</div>';
  
}
