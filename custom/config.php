<?php

// No direct access
defined('ABSPATH') || exit;

/*
 * Remote media proxy
 *
 * Allows local dev sites to proxy remote media assets to a remote site.
 * Helps to work locally, without having to download assets from the server and to not experience local slowdowns because of missing "uploads" content.
 *
 * Copy the following snippet (the while add_filter) into your child theme, and set the URL to your remote media site (generally: staging site).
 *
 * Example:
 *
 * return 'https://wordpress-baseline-sandbox.ind.ninja/';
 */
/*add_filter('wicket_remote_media_proxy_url', function () {
    return '';
});*/

// do not send default Wordpress emails on manual user creation in the current thread
add_filter('send_password_change_email', '__return_false');
add_filter('send_email_change_email', '__return_false');

/**
 * Theme setup.
 *
 * @return void
 */
function wicket_setup()
{
    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */

    // Editor Styles
    add_theme_support('editor-styles');
    add_editor_style('assets/styles/min/wicket.min.css');
    add_editor_style('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700');

    // Register Custom Post Types
    foreach (glob(dirname(__FILE__) . '/post-types/*.php') as $class_path) {
        include_once $class_path;
    }

    add_theme_support('post-thumbnails');

    set_post_thumbnail_size(390, 200);

    add_image_size('wicket-featured-image', 2000, 1200, true);

    add_image_size('sassqutch-thumbnail-avatar', 100, 100, true);

    register_nav_menus([
        'header-utility'   => __('Header Utility Menu', 'wicket'),
        'header-secondary' => __('Header Secondary Menu', 'wicket'),
        'header'           => __('Header Menu', 'wicket'),
        'social'           => __('Social Menu', 'wicket'),
        'footer'           => __('Secondary Footer Menu', 'wicket'),
        'footer-utility'   => __('Footer Utility Menu', 'wicket'),
    ]);

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', [
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);

    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */
    add_theme_support('post-formats', [
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
        'superscript',
        'subscript',
    ]);

    // Add theme support for Custom Logo.
    add_theme_support('custom-logo', [
        'width'      => 250,
        'height'     => 250,
        'flex-width' => true,
    ]);

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');
    // add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

}
add_action('after_setup_theme', 'wicket_setup');

/**
 * Outputs the language toggle.
 *
 * @return void
 */
function icl_post_languages()
{
    $languages = icl_get_languages('skip_missing=1');
    if (1 < count($languages)) {
        foreach ($languages as $l) {
            $activeClass = '';
            if ($l['active']) {
                $langs[] = '<li class="nav__item--language-toggle active" lang="'
                    . $l['language_code'] . '-CA"><span aria-hidden="true">'
                    . $l['language_code'] . '</span><span class="webaim-hidden">'
                    . $l['native_name'] . '</span></li>';
            } else {
                $langs[] = '<li class="nav__item--language-toggle active" lang="'
                    . $l['language_code'] . '-CA"><a href="' . $l['url']
                    . '"><span aria-hidden="true">' . $l['language_code']
                    . '</span><span class="webaim-hidden">' . $l['native_name']
                    . '</span></a></li>';
            }
        }

        return implode('', $langs);
    }
}

/**
 * Translate date format.
 *
 * @param $format
 *
 * @return string
 */
function wicket_translate_date_format($format)
{
    if (function_exists('icl_translate')) {
        $format = icl_translate('Formats', $format, $format);
    }

    return $format;
}
add_filter('option_date_format', 'wicket_translate_date_format');

/**
 * Remove menu items.
 *
 * @return void
 */
function wicket_admin_post_remove()
{
    //remove_menu_page( 'edit.php' );
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'wicket_admin_post_remove');

/**
 * Change the excerpt length.
 *
 * @param $length
 *
 * @return int
 */
function wicket_custom_excerpt_length($length)
{
    return 40;
}
add_filter('excerpt_length', 'wicket_custom_excerpt_length', 999);

/**
 * Add classes to the body.
 *
 * @param $classes
 *
 * @return array
 */
function wicket_add_theme_classes($classes)
{
    $classes[] = 'wicket-theme-v2';

    return $classes;
}

add_filter('body_class', 'wicket_add_theme_classes');

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
});
