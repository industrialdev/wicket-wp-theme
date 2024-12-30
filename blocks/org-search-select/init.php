<?php
/**
 * Wicket Org Search Select block.
 *
 **/

namespace Wicket\Blocks\Wicket_Org_Search_Select;

/**
 * Org Search Select block registration function.
 */
function init($block = [])
{

    $attrs = get_block_wrapper_attributes();

    $search_mode = get_field('orgss_search_mode');
    $search_org_type = get_field('orgss_search_org_type');
    $relationship_type_upon_org_creation = get_field('orgss_relationship_type_upon_org_creation');
    $relationship_mode = get_field('orgss_relationship_mode');
    $new_org_type_override = get_field('orgss_new_org_type_override');

    $disable_ability_to_create_new_orgentity = get_field('orgss_disable_ability_to_create_new_orgentity');
    $disable_ability_to_select_orgs_with_active_membership = get_field('orgss_disable_ability_to_select_orgs_with_active_membership');
    $grant_roster_management_on_next_purchase = get_field('orgss_grant_roster_management_on_next_purchase');
    $grant_org_editor_role_on_selection = get_field('orgss_grant_org_editor_role_on_selection');
    $name_singular = get_field('orgss_name_singular');
    $name_plural = get_field('orgss_name_plural');
    $hide_remove_buttons = get_field('orgss_hide_remove_buttons');
    $hide_select_buttons = get_field('orgss_hide_select_buttons');
    $no_results_found_message = get_field('orgss_no_results_found_message');
    $new_org_created_checkbox_id = get_field('orgss_new_org_created_checkbox_id');
    $display_removal_alert_message = get_field('orgss_display_removal_alert_message');

    echo '<div ' . $attrs . '>';

    get_component('org-search-select', [
        'classes'                             => [],
        'search_mode'                         => $search_mode,
        'search_org_type'                     => $search_org_type,
        'relationship_type_upon_org_creation' => $relationship_type_upon_org_creation,
        'relationship_mode'                   => $relationship_mode,
        'new_org_type_override'               => $new_org_type_override,
        'disable_create_org_ui'               => $disable_ability_to_create_new_orgentity,
        'disable_selecting_orgs_with_active_membership' => $disable_ability_to_select_orgs_with_active_membership,
        'grant_roster_man_on_purchase'        => $grant_roster_management_on_next_purchase,
        'grant_org_editor_on_select'          => $grant_org_editor_role_on_selection,
        'org_term_singular'                   => $name_singular,
        'org_term_plural'                     => $name_plural,
        'hide_remove_buttons'                 => $hide_remove_buttons,
        'hide_select_buttons'                 => $hide_select_buttons,
        'no_results_found_message'            => $no_results_found_message,
        'checkbox_id_new_org'                 => $new_org_created_checkbox_id,
        'display_removal_alert_message'       => $display_removal_alert_message,
    ]);

    echo '</div>';

}
