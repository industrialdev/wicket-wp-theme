<?php

// No direct access
defined('ABSPATH') || exit;

/*
NOTE: If you're looking for get_component() or component_exists(), look in the base plugin
as they were moved there, along with the components themselves
*/

/*
 * Debug log helper function that accepts strings, objects, and arrays.
 * Has an option to print to screen with the value wrapped in <pre> tags.
 * Usage example: write_log( 'The variable value is: ' . $myVariable );
 * Usage example 2: write_log( $myVariable, true );
 *
 * @param $log
 * @param bool $print_preformatted_to_screen
 *
 * @return void
 */
if (!function_exists('wicket_write_log')) {
    function wicket_write_log($log, $print_preformatted_to_screen = false)
    {
        if ($print_preformatted_to_screen) {
            print_r('<pre>');
            print_r($log);
            print_r('</pre>');
        } else {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

/**
 * Enqueue styles.
 *
 * @param $name
 * @param $path
 * @param $external
 *
 * @return void
 */
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

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
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

/**
 * Check if post is member only.
 *
 * @param $post_id
 *
 * @return bool
 */
function is_member_only($post_id)
{
    $visibility = get_post_meta($post_id, '_wppcp_post_page_visibility', true);

    // if roles are specified, check if a "member" role is present
    if ($visibility === 'role') {
        $allowed_roles = get_post_meta($post_id, '_wppcp_post_page_roles', true);

        return in_array('member', $allowed_roles);
    }

    return $visibility === 'member';
}

/**
 * Get social link label.
 *
 * @param $links
 * @param $name
 *
 * @return string
 */
function get_social_link_label($links, $name)
{
    foreach ($links as $link) {
        if ($link['name'] === $name) {
            return $link['label'];
        }
    }
}

/**
 * Get site root url.
 *
 * @return string
 */
function wicket_get_site_root_url()
{
    if (defined('WP_HOME')) {
        return WP_HOME;
    }

    $site_url = get_site_url();

    if (empty($site_url)) {
        $site_url = wicket_get_current_url(true);
    }

    // Remove /wp/ if present in the site_url (present for Bedrock)
    if (str_contains($site_url, '/wp//')) {
        $site_url = str_replace('/wp//', '', $site_url);
    }

    // Remove /wp if present in the site_url (present for Bedrock)
    if (str_contains($site_url, '/wp')) {
        $site_url = str_replace('/wp', '', $site_url);
    }

    return $site_url;
}

/**
 * Get current url.
 *
 * @param bool $root_only
 *
 * @return string
 */
function wicket_get_current_url($root_only = false)
{
    // Credit: https://www.javatpoint.com/how-to-get-current-page-url-in-php

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = 'https://';
    } else {
        $url = 'http://';
    }

    // Append the host(domain name, ip) to the URL.
    $url .= $_SERVER['HTTP_HOST'];

    if ($root_only) {
        return $url;
    }

    // Append the requested resource location to the URL
    $url .= $_SERVER['REQUEST_URI'];

    return $url;
}

/**
 * Get lang url.
 *
 * @param string $lang
 * @param string $url
 *
 * @return string
 */
function wicket_get_lang_url($lang, $url = '')
{
    if (empty($url)) {
        $url = wicket_get_current_url();
    }

    if (has_filter('wpml_default_language')) {
        // Filter documentation: https://wpml.org/wpml-hook/wpml_default_language/
        $default_lang = apply_filters('wpml_default_language', null);
    } else {
        $default_lang = 'en';
    }

    // We want to convert to the default language
    if ($lang == $default_lang) {
        $split_url = explode('/', $url);
        if ($default_lang == 'en') {
            if (($key = array_search('fr', $split_url)) !== false) {
                unset($split_url[$key]);
            }
            $new_url = implode('/', $split_url);
            // Todo: add support for more languages
        } else {
            if (($key = array_search('en', $split_url)) !== false) {
                unset($split_url[$key]);
            }
            $new_url = implode('/', $split_url);
        }

        return $new_url;
    }

    if (has_filter('wpml_permalink')) {
        // Filter documentation: https://wpml.org/wpml-hook/wpml_permalink/
        return apply_filters('wpml_permalink', $url, $lang);
    } else {
        return $url;
    }
}

/**
 * Get related content type.
 *
 * @param $post_type
 *
 * @return string
 */
function get_related_content_type($post_type)
{
    $default_content_types = [
        'news'         => 'news_type',
        'resources'    => 'resource_type',
        'post'         => 'category',
        'tribe_events' => 'tribe_events_cat',
        'product'      => 'product_cat',
    ];

    $content_types = apply_filters('wicket_related_content_types', $default_content_types);

    return $content_types[$post_type] ?? '';
}

/**
 * Get related content type term.
 *
 * @param $post_id
 *
 * @return string
 */
function get_related_content_type_term($post_id)
{
    $related_content_type = get_related_content_type(get_post_type($post_id));
    $content_type = !is_wp_error(get_the_terms($post_id, $related_content_type)) ? get_the_terms($post_id, $related_content_type) : [];

    if ($content_type) {
        return $content_type[0]->name;
    } else {
        return get_post_type_object(get_post_type($post_id))->labels->singular_name;
    }
}

/**
 * Get related topic type.
 *
 * @param $post_type
 *
 * @return string
 */
function get_related_topic_type($post_type)
{
    $default_topic_types = [
        'news'         => 'topics',
        'resources'    => 'topics',
        'post'         => 'post_tag',
        'tribe_events' => 'post_tag',
    ];

    $topic_types = apply_filters('wicket_related_topic_types', $default_topic_types);

    return $topic_types[$post_type] ?? '';
}

/**
 * Get login url.
 *
 * @return string
 */
function get_login_url()
{
    $login_url = get_option('wp_cassify_base_url') . 'login?service=' . urlencode(wicket_get_current_url());

    return $login_url;
}

/**
 * Get meta field from block.
 *
 * @param $post_id
 * @param $block_name
 * @param $field_name
 *
 * @return mixed
 */
function get_field_from_block($post_id, $block_name, $field_name)
{
    $content = get_post_field('post_content', $post_id);
    $blocks = parse_blocks($content);
    foreach ($blocks as $block) {
        if ($block['blockName'] === $block_name) {
            $field = $block['attrs']['data'][$field_name];

            return $field;
        }
    }
}

/**
 * Check if a string is empty.
 *
 * @param $str
 *
 * @return bool
 */
function empty_content($str)
{
    return trim(str_replace('&nbsp;', '', strip_tags($str))) == '';
}
