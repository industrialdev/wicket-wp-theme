<?php

// No direct access
defined('ABSPATH') || exit;

define('WICKET_THEME_PATH', get_template_directory());
define('WICKET_THEME_URL', get_template_directory_uri());
define('WICKET_CHILD_THEME_PATH', get_stylesheet_directory());
define('WICKET_CHILD_THEME_URL', get_stylesheet_directory_uri());
define('WICKET_UPLOADS_PATH', wp_get_upload_dir()['basedir'] . '/wicket-theme/');
define('WICKET_UPLOADS_URL', wp_get_upload_dir()['baseurl'] . '/wicket-theme/');
define('WICKET_THEME_PREFIX', 'wicket_theme_');

/**
 * Wicket Includes.
 */
$wicket_includes = [
    'config.php',
    'helpers.php',
    'styling-scripts.php',
    'remote-media-proxy.php',
    'constants.php',
    'acf.php',
    'blocks.php',
    'menus.php',
    'logger.php',
    'pagination.php',
    'widgets.php',
    'dates.php',
    'remove_wp_toolbar_except_admins.php',
    'remove-admin-bar.php',
    'curl_timeout.php',
    'private_content_redirect.php',
    'woocommerce.php',
    'switch_to_user_wicket_sync.php',
    'woocommerce_max_webhook_delivery_failures.php',
    'wpml_translator_override.php',
    'breadcrumbs.php',
    'post-types.php',
    'taxonomies.php',
    'redirections.php',
    'search.php',
    'api-rate-limiting.php',
    'force_gd_image_library.php',
    'job-manager.php',
    'hide_health_status.php',
];

if (is_array($wicket_includes)) {

    foreach ($wicket_includes as $wicket_inc) {
        $file_inc = get_template_directory() . '/custom/' . $wicket_inc;

        if (!file_exists($file_inc)) {
            continue;
        }
        require_once $file_inc;
    }
}

/*
 * DO NOT ADD ANYTHING BELOW THIS COMMENT
 * DO NOT ADD ANYTHING BELOW THIS COMMENT
 * DO NOT ADD ANYTHING BELOW THIS COMMENT
 *
 * Be thoughtful and considerate of your fellow developers, please.
 * This will make it easier for everyone, including you, to maintain this work in the future.
 *
 * Feel free to use existing files or create new files or subfolders on /custom/, to add functionality to the theme.
 * Don't forget to add your new files, into the $wicket_includes array above.
 *
 * Thanks!
 */
