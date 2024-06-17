<?php
/**
 * Wicket Org Search Select block
 *
 **/

namespace Wicket\Blocks\Wicket_Org_Search_Select;

/**
 * Org Search Select block registration function
 */
function init( $block = [] ) {

	$attrs = get_block_wrapper_attributes();

	$search_mode                         = get_field( 'orgss_search_mode' );
  $search_org_type                     = get_field( 'orgss_search_org_type' );
  $relationship_type_upon_org_creation = get_field( 'orgss_relationship_type_upon_org_creation' );
  $relationship_mode                   = get_field( 'orgss_relationship_mode' );
  $new_org_type_override               = get_field( 'orgss_new_org_type_override' );

	echo '<div ' . $attrs . '>';
  // $args = [ 
  //   'classes'                             => [],
  //   'search_mode'                         => 'org', // Options: org, groups, ...
  //   'search_org_type'                     => '',
  //   'relationship_type_upon_org_creation' => 'employee',
  //   'relationship_mode'                   => 'person_to_organization',
  //   'new_org_type_override'               => '',
	// ];
  // require_once( __DIR__ . '../../../../../plugins/wicket-wp-base-plugin/includes/components/org-search-select.php' );
  
  // TODO: Make these options dynamic
	get_component( 'org-search-select', [ 
    'classes'                             => [],
    'search_mode'                         => 'org', // Options: org, groups, ...
    'search_org_type'                     => '',
    'relationship_type_upon_org_creation' => 'employee',
    'relationship_mode'                   => 'person_to_organization',
    'new_org_type_override'               => '',
	] );
	echo '</div>';

	
}
