<?php

// No direct access
defined('ABSPATH') || exit;

/*
 * When saving ACF option page for Theme Styling, trigger a custom function
 * to generate a single CSS file with all the customizations.
 */
function wicket_styling_acf_save_post($post_id, $menu_slug)
{
    if ($menu_slug !== 'acf-options-theme-styling') {
        return;
    }

    // Generate the CSS file, for IDE auto-completion
    // And maybe enqueue it? Not sure if that mess with the live preview of styles
    wicket_styling_theme_variables();

    // Clear the cache
    delete_transient(WICKET_THEME_PREFIX . 'css_customizations');
}
add_action('acf/options_page/save', 'wicket_styling_acf_save_post', 10, 2);

/**
 * Generate (or return) the CSS file from ACF options.
 *
 * @param string $mode Whether to write the CSS file, or return its contents for enqueuing. Default is 'write'. Can be set to 'return'.
 *
 * @return string|void
 */
function wicket_styling_theme_variables($mode = 'write')
{
    global $wp_filesystem;

    $wicket_css_variables = wicket_get_customizations_inline_css();

    if (empty($wicket_css_variables)) {
        return;
    }

    // Format CSS variables for better readability
    $wicket_css_variables = preg_replace('/;/', ";\n", $wicket_css_variables); // Add newline after ;
    $wicket_css_variables = preg_replace('/:root\s*{/', "$0\n", $wicket_css_variables); // Add newline after :root {
    $wicket_css_variables = preg_replace('/^--/m', '  --', $wicket_css_variables); // Add proper indentation only to CSS variables (lines starting with --)

    // Get WP CSS variables
    $wp_css_variables = wp_get_global_stylesheet(['variables']);

    // Format and append the variables to the CSS
    if (!empty($wp_css_variables)) {
        $wp_css_variables = preg_replace('/;/', ";\n", $wp_css_variables);
        $wp_css_variables = preg_replace('/:root\s*{/', "$0\n", $wp_css_variables);
        $wp_css_variables = preg_replace('/^--/m', '  --', $wp_css_variables);

        $wicket_css_variables = $wicket_css_variables . PHP_EOL . PHP_EOL . $wp_css_variables;
    }

    $sizesPXtoREM = wicket_sizesPXtoREM();

    // Format and append the variables to the CSS
    if (!empty($sizesPXtoREM)) {
        //$sizesPXtoREM = preg_replace('/;/', ";\n", $sizesPXtoREM);
        //$sizesPXtoREM = preg_replace('/:root\s*{/', "$0\n", $sizesPXtoREM);
        //$sizesPXtoREM = preg_replace('/^--/m', '  --', $sizesPXtoREM);

        $wicket_css_variables = $wicket_css_variables . PHP_EOL . PHP_EOL . $sizesPXtoREM;
    }

    if ($mode == 'return') {
        // Minify our CSS for inline render
        $wicket_css_variables = str_replace(["\r\n", "\r", "\n", "\t"], '', $wicket_css_variables);

        // Remove extra spaces
        $wicket_css_variables = preg_replace('/\s+/', ' ', $wicket_css_variables);

        return $wicket_css_variables;
    }

    // Use WP_Filesystem API to write the file to our theme folder
    require_once ABSPATH . '/wp-admin/includes/file.php';
    WP_Filesystem();

    // Create the folder if it doesn't exist
    if (!file_exists(WICKET_UPLOADS_PATH . 'css/')) {
        wp_mkdir_p(WICKET_UPLOADS_PATH . 'css/');
    }

    $wp_filesystem->put_contents(
        WICKET_UPLOADS_PATH . 'css/theme-variables.css',
        $wicket_css_variables
    );
}

/**
 * Generate CSS variables for sizes in PX to REM.
 *
 * @return string
 */
function wicket_sizesPXtoREM()
{
    $css = ":root {\n";

    // Generate from 1px to 100px
    for ($px = 1; $px <= 100; $px++) {
        $rem = number_format($px / 16, 4);
        $css .= "  --size-{$px}px: {$rem}rem;\n";
    }

    $css .= '}';

    return $css;
}

/**
 * Get customizations inline css.
 * Uses transient caching for 12 hours to improve performance.
 *
 * @return string
 */
function wicket_get_customizations_inline_css()
{
    // Try to get the cached CSS
    $css = get_transient(WICKET_THEME_PREFIX . 'css_customizations');

    // If cache doesn't exist or is expired, regenerate it
    if ($css === false) {
        $customized_fields = acf_get_fields('group_66f2d49c4ce0d');
        $css = ':root {';

        if (!empty($customized_fields)) {
            foreach ($customized_fields as $field) {
                if (isset($field['sub_fields'])) {
                    $group = get_field($field['name'], 'option') ?: [];

                    if (!empty($group)) {
                        foreach ($field['sub_fields'] as $sub_field) {
                            $sub_field_name = $sub_field['name'];

                            // Skip acf fields that are not meant to be used as CSS variables
                            if (in_array($sub_field_name, ['head-font-html-code'])) {
                                continue;
                            }

                            if (isset($group[$sub_field_name])) {
                                $sub_field_value = is_numeric($group[$sub_field_name]) ? $group[$sub_field_name] . 'px' : $group[$sub_field_name];
                                $css .= '--' . $sub_field_name . ': ' . $sub_field_value . ';';
                            }
                        }
                    }
                }
            }
        }

        $css .= '}';

        // Cache the CSS for 12 hours
        set_transient(WICKET_THEME_PREFIX . 'css_customizations', $css, 12 * HOUR_IN_SECONDS);
    }

    return $css;
}

/**
 * Enqueue theme assets.
 *
 * @return void
 */
function wicket_add_theme_assets()
{
    if (!wp_style_is('font-awesome', 'enqueued')) {
        wicket_enqueue_style('font-awesome', '/font-awesome/css/fontawesome.css');
        wicket_enqueue_style('font-awesome-brands', '/font-awesome/css/brands.css');
        wicket_enqueue_style('font-awesome-solid', '/font-awesome/css/solid.css');
        wicket_enqueue_style('font-awesome-regular', '/font-awesome/css/regular.css');
    }

    if (!wp_style_is('material-icons', 'enqueued')) {
        wp_enqueue_style('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons');
    }

    // Only if WP ENVIRONMENT is production
    if (in_array(wp_get_environment_type(), ['production'])) {
        // Check if the CSS file exists
        if (!file_exists(WICKET_UPLOADS_PATH . 'css/theme-variables.css')) {
            // Can we create the file?
            if (is_writable(WICKET_UPLOADS_PATH . 'css/')) {
                // Generate the CSS file
                wicket_styling_theme_variables();
            }

            // In this page load, we don't have the theme variables file yet, so we need to enqueue the inline CSS
            wp_add_inline_style('wicket-theme', wicket_get_customizations_inline_css());
        } else {
            // Enqueue our cached CSS in the uploads folder
            wp_enqueue_style('wicket-theme-variables', WICKET_UPLOADS_URL . 'css/theme-variables.css', [], filemtime(WICKET_UPLOADS_PATH . 'css/theme-variables.css'));
        }
    }

    wicket_enqueue_style('wicket-theme', '/assets/styles/min/wicket.min.css');

    // Only if WP ENVIRONMENT is development or local
    if (in_array(wp_get_environment_type(), ['development', 'local', 'staging'])) {
        wp_add_inline_style('wicket-theme', wicket_styling_theme_variables('return'));
    }

    wicket_enqueue_script('wicket', '/assets/scripts/min/wicket.min.js', false, ['jquery'], false, true);

}
add_action('wp_enqueue_scripts', 'wicket_add_theme_assets');

/**
 * Enqueue admin assets.
 *
 * @return void
 */
function wicket_admin_styles()
{
    wp_enqueue_style('admin-styles', get_template_directory_uri() . '/assets/styles/min/admin.min.css');

    // Only enqueue admin script with dependencies on block editor screens
    $screen = get_current_screen();
    if ($screen && (in_array($screen->base, ['post', 'widgets', 'site-editor']) || $screen->is_block_editor)) {
        $dependencies = ['wp-blocks', 'wp-dom-ready'];

        // Add specific dependencies based on the screen
        switch ($screen->base) {
            case 'post':
                $dependencies[] = 'wp-edit-post';
                break;
            case 'widgets':
                $dependencies[] = 'wp-edit-widgets';
                break;
            case 'site-editor':
                $dependencies[] = 'wp-edit-site';
                break;
        }

        wp_enqueue_script(
            'wicket-admin-script',
            get_template_directory_uri() . '/assets/scripts/min/wicket-wp-admin.min.js',
            $dependencies,
            filemtime(get_template_directory() . '/assets/scripts/min/wicket-wp-admin.min.js'),
            true
        );
    }

    // Only if WP ENVIRONMENT is development or local
    if (in_array(wp_get_environment_type(), ['development', 'local', 'staging'])) {
        wp_add_inline_style('admin-styles', wicket_get_customizations_inline_css());
    }

    // Only if WP ENVIRONMENT is not development or local
    if (!in_array(wp_get_environment_type(), ['development', 'local', 'staging'])) {
        // Enqueue our cached CSS in the uploads folder
        wp_enqueue_style('wicket-theme-variables', WICKET_UPLOADS_URL . 'css/theme-variables.css');
    }
}
add_action('admin_enqueue_scripts', 'wicket_admin_styles');

/**
 * Add editor styles.
 *
 * @return void
 */
function wicket_add_editor_styles()
{
    add_editor_style('editor-style.css');
}
add_action('admin_init', 'wicket_add_editor_styles');

/**
 * Enqueue Gutenberg scripts and styles.
 *
 * @return void
 */
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
