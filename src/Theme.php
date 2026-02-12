<?php

declare(strict_types=1);

namespace WicketTheme;

/**
 * Theme utility class
 */
class Theme
{
    public static function version(): string
    {
        return '2.1.21';
    }

    public static function isActive(): bool
    {
        return function_exists('wp_get_theme') && 'wicket-wp-theme' === wp_get_theme()->get_stylesheet();
    }
}
