---
title: "Customize Colors and Fonts"
audience: end-user
---

# Customize Colors and Fonts

Adjust the visual appearance of your site — colors, typography, and spacing — from the WordPress admin without touching code.

## Before You Start

- Advanced Custom Fields (ACF) Pro must be active
- The Wicket theme must be installed and active
- You need `manage_options` capability

## Open Theme Styling

1. In the WordPress admin, go to **ACF → Options → Theme Styling**.
2. You will see fields for custom colors and other theme variables.

## Set Custom Colors

1. In the **Custom Colours** section, click **Add Colour**.
2. Choose a color using the picker.
3. Add more colors as needed — each becomes available as a CSS variable.

To use a custom color in your CSS or blocks: `var(--custom-colour-0)` for the first color, `var(--custom-colour-1)` for the second, and so on.

## Configure Theme Variables

Other fields in Theme Styling (such as spacing and typography) are converted directly to CSS custom properties. Fill in the values you want to override — leave blank any you do not want to change.

## Save and Preview

1. Click **Save Changes**.
2. Visit the frontend to see the updated styles.
3. In `development` or `local` environments, changes appear immediately. In `production` or `staging`, a CSS file is regenerated in `wp-content/uploads/css/theme-variables.css`.

## Clear the Cache

If your changes do not appear after saving:

1. Go to **Settings → Breeze** (if the Breeze cache plugin is active).
2. Click **Clear All Cache**.
3. Reload the frontend.

## Environment Note

| Environment | How to update |
|---|---|
| `development` / `local` | Changes appear immediately on save |
| `production` / `staging` | A CSS file is regenerated — allow a moment for the file to build |