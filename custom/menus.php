<?php

// Takes in a WP Menu array (typically creatd by wp_get_nav_menu_items()) and returns
// a structured associative array of the menu items.
// Currently supports up to 3 levels of menu items.
function wicket_generate_structured_menu( $wp_nav_items ) {
	$nav_items_structured = [];
	// Initial pass to add all parent items
	foreach(  $wp_nav_items as  $wp_nav_item ) {
				if(  $wp_nav_item->menu_item_parent == 0 ) {
							$nav_items_structured[ $wp_nav_item->ID ] = (array) $wp_nav_item;
							$nav_items_structured[ $wp_nav_item->ID ]['child_count'] = 0;
							$nav_items_structured[ $wp_nav_item->ID ]['grand_child_count'] = 0;
				}
	}
	// Second pass to add all 2nd tier child items
	foreach(  $wp_nav_items as  $wp_nav_item ) {
				if(  $wp_nav_item->menu_item_parent != 0 ) {
							// Add this as a child element if its parent item is present
							if( isset( $nav_items_structured[ $wp_nav_item->menu_item_parent] ) ) {
										$nav_items_structured[ $wp_nav_item->menu_item_parent]['children'][ $wp_nav_item->ID] = (array) $wp_nav_item;
										// Update child count of the parent item
										$current_child_count = 0;
										if( isset( $nav_items_structured[ $wp_nav_item->menu_item_parent]['child_count'] ) ) {
											$current_child_count = $nav_items_structured[ $wp_nav_item->menu_item_parent]['child_count'];
										}
										$current_child_count++;
										$nav_items_structured[ $wp_nav_item->menu_item_parent]['child_count'] = $current_child_count;

										// Set initial value for the child count of this item, if not already set
										$current_child_count = 0;
										if( isset( $nav_items_structured[ $wp_nav_item->menu_item_parent]['children'][ $wp_nav_item->ID]['child_count'] ) ) {
											$current_child_count = $nav_items_structured[ $wp_nav_item->menu_item_parent]['children'][ $wp_nav_item->ID]['child_count'];
										}
										$nav_items_structured[ $wp_nav_item->menu_item_parent]['children'][ $wp_nav_item->ID]['child_count'] = $current_child_count;
							
								}
				}
	}
	// Third pass to add all 3rd tier child items
	foreach(  $wp_nav_items as  $wp_nav_item ) {
				// Traverse the child items of each parent array in the structured array
				foreach( $nav_items_structured as $nav_structured_item ) {
							if( isset( $nav_structured_item['children'] ) ) {
										foreach( $nav_structured_item['children'] as $second_tier_child_item ) {
													// $second_tier_child_item is array->parent_item->child_item
													if(  $wp_nav_item->menu_item_parent == $second_tier_child_item['ID'] ) {
																$nav_items_structured[ $nav_structured_item['ID'] ]['children'][ $second_tier_child_item['ID'] ]['children'][ $wp_nav_item->ID] = (array) $wp_nav_item;

																// Update child count of the parent items
																$current_grand_child_count = 0;
																$current_child_count = 0;
																if( isset( $nav_items_structured[ $nav_structured_item['ID'] ]['grand_child_count'] ) ) {
																	$current_grand_child_count = $nav_items_structured[ $nav_structured_item['ID'] ]['grand_child_count'];
																}
																if( isset( $nav_items_structured[ $nav_structured_item['ID'] ]['children'][ $second_tier_child_item['ID'] ]['child_count'] ) ) {
																	$current_child_count = $nav_items_structured[ $nav_structured_item['ID'] ]['children'][ $second_tier_child_item['ID'] ]['child_count'];
																}
																$current_grand_child_count++;
																$current_child_count++;

																$nav_items_structured[ $nav_structured_item['ID'] ]['grand_child_count'] = $current_grand_child_count;
																$nav_items_structured[ $nav_structured_item['ID'] ]['children'][ $second_tier_child_item['ID'] ]['child_count'] = $current_child_count;

													}
										}
							}
				}
	}

	return $nav_items_structured;
}