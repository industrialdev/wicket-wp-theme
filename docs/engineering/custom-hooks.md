---
title: "Custom Hooks"
audience: [developer, agent]
php_class: wicket_setup
source_files: ["custom/config.php", "custom/styling-scripts.php", "custom/helpers.php"]
---

# Custom Hooks

Theme-specific hooks and filters added by wicket-wp-theme. These extend WordPress and WooCommerce behaviour.

## Actions

### `wicket/remote_media_proxy_url`

Filter to set the remote media proxy URL for local development.

```php
add_filter('wicket/remote_media_proxy_url', fn () => 'https://your-staging-site.com/');
```

When set (non-empty), remote media requests are proxied through the local environment instead of hitting the remote server directly.

---

### `acf/options_page/save`

Fires when an ACF options page is saved. Used by:
- `wicket_styling_acf_save_post` → regenerates CSS variables file and clears CSS transient
- `wicket_check_acf_option_fields_and_clear_breeze_cache` → clears Breeze cache for header/footer options

---

### `wp_enqueue_scripts`

`wicket_add_theme_assets` — enqueues Font Awesome, Material Icons, theme CSS/JS, and the generated CSS variables file. Inline CSS is used instead of the file in development/local environments.

`wicket_admin_styles` — enqueues admin CSS and block editor scripts with appropriate dependencies.

---

### `admin_enqueue_scripts`

`wicket_admin_styles` — enqueues admin styles with environment-aware CSS variable handling.

---

### `after_setup_theme`

`wicket_setup` — registers editor styles, post thumbnails, image sizes, post formats, custom logo support, and selective refresh for widgets.

`wicket_add_theme_classes` — adds `wicket-theme-v2` to body class.

---

## Filters

### `send_password_change_email`

Returns `false` — prevents WordPress from sending password change emails on manual user creation.

### `send_email_change_email`

Returns `false` — prevents WordPress from sending email change emails.

### `excerpt_length`

Returns `40` — changes the default WordPress excerpt length to 40 words.

### `body_class`

Adds `wicket-theme-v2` to the body class array.

### `option_date_format`

Applies WPML translation to the date format via `icl_translate`.

### `send_password_change_email`

Prevents password change notification emails on manual user creation in the current thread.

---

## Environment Detection

The theme uses `wp_get_environment_type()` to switch behaviour:

| Environment | CSS variables |
|---|---|
| `production`, `staging` | Pre-generated file in `wp-content/uploads/css/` |
| `development`, `local` | Inline via `wp_add_inline_style` |

---

## ACF Options Pages

The theme creates ACF options pages that trigger cache clearing on save:

| Options page slug | On save action |
|---|---|
| `acf-options-theme-styling` | Regenerates CSS variables, clears transient |
| `acf-options-header` | Clears Breeze cache |
| `acf-options-footer` | Clears Breeze cache |

---

## Documentation Links

- [Theme Styling](../product/theme-styling.md) — ACF options page and CSS variable generation
- [Customize Colors and Fonts](../guides/customize-colors-fonts.md) — Step-by-step guide