<?php

// No direct access
defined('ABSPATH') || die();

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

function wicket_add_editor_styles()
{
    add_editor_style('editor-style.css');
}
add_action('admin_init', 'wicket_add_editor_styles');

function wicket_add_css_variables()
{
    echo '<style type="text/css">';
    echo get_customizations_inline_css();
    echo '</style>';
}
add_action('admin_head', 'wicket_add_css_variables');

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

function wicket_enqueue_style($name, $path, $external = false)
{
    if ($external) {
        wp_enqueue_style($name, $path, false, false, 'all');
    } else {
        wp_enqueue_style(
            $name,
            get_template_directory_uri() . $path,
            false,
            filemtime(get_template_directory() . $path),
            'all'
        );
    }
}

function wicket_enqueue_script($handle, $path, $external = false, $dependencies = [], $in_footer = true, $defer = false, $async = false)
{
    $strategy = '';
    if ($defer) {
        $strategy = 'defer';
    }
    if ($async) {
        $strategy = 'async';
    }
    $args = [
        'in_footer' => $in_footer ? true : false,
        'strategy'  => $strategy,
    ];

    if ($external) {
        wp_enqueue_script($handle, $path, $dependencies, false, $args);
    } else {
        wp_enqueue_script(
            $handle,
            get_template_directory_uri() . $path,
            $dependencies,
            filemtime(get_template_directory() . $path),
            $args
        );
    }
}

// Get the customizations from the ACF options page and add them into a single CSS file
function get_customizations_inline_css()
{
    $customized_fields = acf_get_fields('group_66f2d49c4ce0d');
    $css = ':root {';

    foreach ($customized_fields as $field) {
        if (isset($field['sub_fields'])) {
            $group = get_field($field['name'], 'option');

            foreach ($field['sub_fields'] as $sub_field) {
                $sub_field_name = $sub_field['name'];

                // Skip acf fields that are not meant to be used as CSS variables
                if (in_array($sub_field_name, ['head-font-html-code'])) {
                    continue;
                }

                $sub_field_value = is_numeric($group[$sub_field_name]) ? $group[$sub_field_name] . 'px' : $group[$sub_field_name];

                $css .= '--' . $sub_field_name . ': ' . $sub_field_value . ';';
            }
        }
    }

    $css .= '}';

    return $css;
}

function wicket_add_theme_assets()
{
    // wicket_enqueue_style( 'fontawesome', '/assets/fonts/FontAwesome/web-fonts-with-css/css/fontawesome-all.min.css' );
    wicket_enqueue_style('font-awesome', '/font-awesome/css/fontawesome.css');
    wicket_enqueue_style('font-awesome-brands', '/font-awesome/css/brands.css');
    wicket_enqueue_style('font-awesome-solid', '/font-awesome/css/solid.css');
    wicket_enqueue_style('font-awesome-regular', '/font-awesome/css/regular.css');
    wicket_enqueue_style('theme', '/assets/styles/min/wicket.min.css');

    wp_add_inline_style('theme', get_customizations_inline_css());

    wicket_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js', true);
    wicket_enqueue_script('wicket', '/assets/scripts/min/wicket.min.js', false, ['jquery'], false, true);

    // Conditional Bootstrap enqueue:
    if (isset($_GET['bootstrap'])) {
        wicket_enqueue_style('boostrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', true);
        wicket_enqueue_script('boostrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js', true);
    }
}
add_action('wp_enqueue_scripts', 'wicket_add_theme_assets');

/* Gutenberg scripts and styles */
function wicket_gutenberg_scripts()
{
    $array_dependencies = ['wp-blocks', 'wp-dom-ready'];
    $screen = get_current_screen();

    switch ($screen->base) {
        case 'post':
            $array_dependencies[] = 'wp-edit-post';
            break;
        case 'widgets':
            $array_dependencies[] = 'wp-edit-widgets';
            break;
        case 'site-editor':
            $array_dependencies[] = 'wp-edit-site';
            break;
    }

    wp_enqueue_script(
        'theme-editor',
        get_theme_file_uri('/assets/scripts/wp-admin/editor.js'),
        $array_dependencies,
        filemtime(get_theme_file_path('/assets/scripts/wp-admin/editor.js')),
        true
    );
}
add_action('enqueue_block_editor_assets', 'wicket_gutenberg_scripts');

/* Admin scripts and styles */
function wicket_admin_styles()
{
    wp_enqueue_style('admin-styles', get_template_directory_uri() . '/assets/styles/min/admin.min.css');
    wicket_enqueue_script('wicket-admin-script', '/assets/scripts/min/wicket-wp-admin.min.js');
}
add_action('admin_enqueue_scripts', 'wicket_admin_styles');

/* Outputs the language toggle */
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

/* Checks if string is empty */
function empty_content($str)
{
    return trim(str_replace('&nbsp;', '', strip_tags($str))) == '';
}

function translate_date_format($format)
{
    if (function_exists('icl_translate')) {
        $format = icl_translate('Formats', $format, $format);
    }

    return $format;
}
add_filter('option_date_format', 'translate_date_format');

function post_remove()
{
    //remove_menu_page( 'edit.php' );
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'post_remove');

function custom_excerpt_length($length)
{
    return 40;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function add_wicket_theme_classes($classes)
{
    $classes[] = 'wicket-theme-v2';

    return $classes;
}

add_filter('body_class', 'add_wicket_theme_classes');
