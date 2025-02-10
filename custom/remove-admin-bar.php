<?php
/**
 * Remove WP admin bar for certain roles.
 *
 * @return bool
 */
function wicket_should_show_admin_bar()
{
    $curr_user = wp_get_current_user();
    $is_admin = false;
    if (in_array('administrator', (array) $curr_user->roles) || in_array('wordpress_admin', (array) $curr_user->roles) || in_array('Wordpress_Admin', (array) $curr_user->roles)) {
        $is_admin = true;
    }

    return $is_admin || is_admin();
}
add_filter('show_admin_bar', 'wicket_should_show_admin_bar', PHP_INT_MAX); // Using PHP_INT_MAX to make this the final filter in chain in case of competing plugin
