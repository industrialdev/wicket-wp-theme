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

// Takes in a post_id and finds all ancestor/parent pages (up to 5 levels up), and
// then finds all child pages. Returns them all in an array and notes what level 
// the current post_id is located in
function wicket_get_all_parent_and_child_pages( $post_id ) {
	$ancestry_array = [ 
		'levels_top_to_bottom' => []
	];

	// =====================
	// Get the parents
	// =====================
	$post_ancestors = get_post_ancestors($post_id);
	$post_ancestors = array_reverse( $post_ancestors );
	$ancestry_array['levels_top_to_bottom'] = $post_ancestors;
	$ancestry_array['levels_top_to_bottom'][] = $post_id;

	// =====================
	// Get the children
	// =====================
	$levels_down_to_traverse = 5;
	$current_parent_id = $post_id;
	for( $i = 0; $i < $levels_down_to_traverse; $i++ ) {
		$post_children = get_children( [
			'post_status' => 'published',
			'post_parent' => $current_parent_id
		], 'ARRAY_N' );
		if( !empty( $post_children ) ) {
			$children_ids_to_add = [];
			foreach( $post_children as $child_id => $child_data ) {
				$children_ids_to_add[] = $child_id;
				// Make the $current_parent_id the last child found in this loop
				// TODO: Add loop that will try each sibling to see which one has children
				$current_parent_id = $child_id;
			}
			// if( count( $children_ids_to_add ) == 1 ) {
			// 	$ancestry_array['levels_top_to_bottom'][] = $children_ids_to_add[0];
			// } else {
			// 	$ancestry_array['levels_top_to_bottom'][] = $children_ids_to_add;
			// }
			// Only add the first child found as we'll go back over to grab siblings
			$ancestry_array['levels_top_to_bottom'][] = $children_ids_to_add[0];
		}
	}

	// ================================================
	// Note the current page's pos. in the hierarchy
	// ================================================
	$ancestry_array['curr_page_level_from_zero'] = array_search( $post_id, $ancestry_array['levels_top_to_bottom'] );
	$ancestry_array['num_levels'] = count( $ancestry_array['levels_top_to_bottom'] );

	// ================================================
	// Get the siblings (except for the topmost parent)
	// ================================================
	$ancestry_array['levels_top_to_bottom_with_siblings'] = '...';

	

	wicket_write_log($ancestry_array, true);
}