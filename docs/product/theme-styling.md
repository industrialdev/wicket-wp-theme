---
title: "Theme Styling"
audience: [implementer, support]
wp_admin_path: "ACF → Options → Theme Styling"
php_class: wicket_styling_acf_save_post
source_files: ["custom/styling-scripts.php"]
---

# Theme Styling

Controls the visual appearance of the theme — custom colors, fonts, and spacing — through an ACF options page at **ACF → Options → Theme Styling**.

## How It Works

Saving the Theme Styling options page triggers `wicket_styling_theme_variables()`, which generates a CSS file containing all CSS custom properties (variables). This file is stored in `wp-content/uploads/css/theme-variables.css` and enqueued as a separate stylesheet on the frontend.

In `development` and `local` environments, the CSS is rendered inline per page load instead of from a file.

## Custom Colours

ARepeating sub-field exposing a colour picker. Each colour is output as `--custom-colour-N: #xxxxxx;` in the generated CSS.

| | |
|---|---|
| ACF field group | `group_66f2d49c4ce0d` |
| Field name | `wicket_custom_colours` |
| Sub-field | `colour` |

Access in CSS: `var(--custom-colour-0)`, `var(--custom-colour-1)`, etc.

## Spacing and Typography

ACF sub-fields from the Theme Styling group are converted to CSS variables with their values. For example, a field named `--some-variable` with value `16` becomes `--some-variable: 16px;`.

Fields listed in `head-font-html-code` are excluded from CSS output (they render as raw HTML in the `<head>` instead).

## Generated CSS Variables

The generated file includes:
- Custom colours from the ACF field
- Typography, spacing, and other configured fields
- WordPress global stylesheet variables (`wp_get_global_stylesheet`)
- A `--size-Npx` scale from 1px to 100px (output as rem)

## Environment Behaviour

| Environment | CSS delivery |
|---|---|
| `production` | Pre-generated file from `wp-content/uploads/css/theme-variables.css` |
| `staging` | Pre-generated file |
| `development` | Inline via `wp_add_inline_style` |
| `local` | Inline via `wp_add_inline_style` |

## Cache

The inline CSS is cached in a transient (`{WICKET_THEME_PREFIX}css_customizations`) for 12 hours. Saving the Theme Styling options page clears this transient.

## Documentation Links

- [Styling & Assets](engineering/styling-assets.md) — How CSS/JS are enqueued and generated
- [Customize Colors and Fonts](../guides/customize-colors-fonts.md) — Step-by-step guide for implementers