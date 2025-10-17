<?php

/**
 * Gravity Wiz // Gravity Forms // Dynamically Populating User Role
 * https://gravitywiz.com/dynamically-populating-user-role/
 * https://app.asana.com/1/1138832104141584/project/1209323207058868/task/1210537609884684?focus=true.
 *
 * Use this snippet in conjunction with Gravity Forms dynamic population
 * functionality to populate the current user's role into any form field.
 *
 * @version  1.0
 * @author   David Smith <david@gravitywiz.com>
 * @license  GPL-2.0+
 * @link     https://gravitywiz.com/
 */
add_filter('gform_field_value_user_role', 'gform_populate_user_role');
function gform_populate_user_role($value)
{
    $user = wp_get_current_user();

    if (empty($user->roles)) {
        return '';
    }

    // Return all roles as a comma-separated string (or use another delimiter)
    return implode(',', $user->roles);
}
