/** @type {import('tailwindcss').Config} */

const fs = require('fs')
//const themePath = process.env.SRC_PATH + process.env.THEME_PATH + '/'
const themePath = './'

const themeJson = fs.readFileSync(themePath + 'theme.json')
const theme = JSON.parse(themeJson)

// Reformat font families
const fontFamily = theme.settings.typography.fontFamilies.reduce(
  (accumulator, item) => {
    // Make the main sans and serif fonts easier to reference in Tailwind
    if (item.slug == 'system-sans-serif') {
      accumulator['sans'] = item.fontFamily.split(',')
    } else if (item.slug == 'system-serif') {
      accumulator['serif'] = item.fontFamily.split(',')
    } else {
      accumulator[item.slug] = item.fontFamily.split(',')
    }

    return accumulator
  },
  {}
)

// Reformat font sizes
const fontSize = theme.settings.typography.fontSizes.reduce(
  (accumulator, item) => {
    accumulator[item.slug] = item.size
    return accumulator
  },
  {}
)

const customThemeJsonSettings = theme.settings.custom
const boxShadow = customThemeJsonSettings['box-shadow']
const layout = customThemeJsonSettings.layout
const letterSpacing = customThemeJsonSettings['letter-spacing']
const lineHeight = customThemeJsonSettings['line-height']

/**
 * Theme.json values not (yet) used:
 * - theme.settings.spacing
 * - theme.settings.layout
 * - theme.settings.blocks
 * - theme.settings.styles
 * Reference for mapping theme.json to Tailwind config:
 * https://tailwindcss.com/docs/font-size#customizing-your-theme
 */

module.exports = {
  content: [
    '../wicket-wp-theme/blocks/**/*.{php,js}',
    '../wicket-wp-theme/components/**/*.{php,js}',
    '../wicket-wp-theme/*.php',
    './custom/**/*.php',
    './blocks/**/*.{php,js}',
    './components/**/*.{php,js}',
    './job_manager/**/*.php',
    '../../plugins/wicket-wp-base-plugin/includes/components/**/*.php',
    './page-templates/**/*.php',
    './partials/**/*.php',
    './assets/scripts/**/*.js',
    './*.php',
    './woocommerce/**/*.php',
  ],
  theme: {
    extend: {
      boxShadow: boxShadow,
      width: layout,
      lineHeight: lineHeight,
      aspectRatio: {
        '3/2': '3 / 2',
      },
    },
    container: {
      center: true,
    },
    fontFamily: fontFamily,
    fontSize: fontSize,
    letterSpacing: letterSpacing,
  },
  plugins: [require('@tailwindcss/container-queries')],
  corePlugins: {
    preflight: false,
  },
  safelist: [
    'lg:grid-cols-6',
    'lg:grid-cols-5',
    'lg:grid-cols-4',
    'lg:grid-cols-3',
    'lg:grid-cols-2',
    'aspect-[3/2]',
    'border',
    'rounded',
    {pattern: /(grid-cols|grid-rows)-./},
    {pattern: /(opacity)-./},
    // Adding styles to safelist for usage on Blocks in Editor:
    {pattern: /(rounded)-./},
    {pattern: /(shadow)-./},
    {pattern: /(drop-shadow)-./},
    {pattern: /(gradient)-./},
    {pattern: /(from)-./},
    {pattern: /(via)-./},
    {pattern: /(to)-./},
    {pattern: /(blend)-./},
  ],
}

// Uncomment to see config that gets generated:
console.log(
  'Tailwind is using these settings combined from theme.json and manual overrides:'
)

/**
 * Example of the final generated theme config:
 * {
    extend: {
      colors: {
        primary: 'var(--bs-primary)',
        secondary: 'var(--bs-secondary)',
        success: 'var(--bs-success)',
        info: 'var(--bs-info)',
        warning: 'var(--bs-warning)',
        danger: 'var(--bs-danger)',
        light: 'var(--bs-light)',
        dark: 'var(--bs-dark)'
      },
      width: {
        content: 'var(--bs-container-md)',
        wide: 'var(--bs-container-xl)',
        sidebar: 'var(--bs-container-sm)',
        page: 'var(--bs-container-lg)',
        padding: 'var(--bs-gutter-x)',
        'block-gap': 'var(--bs-gutter-x)',
        'block-gap-large': '40px'
      },
      lineHeight: { tiny: 1.1, small: 1.2, medium: 1.4, normal: 1.6 }
    },
    container: { center: true },
    fontFamily: {
      'sans': [
        '-apple-system',
        'BlinkMacSystemFont',
        '"Segoe UI"',
        'Roboto',
        'Oxygen-Sans',
        'Ubuntu',
        'Cantarell',
        '"Helvetica Neue"',
        'sans-serif'
      ],
      'serif': [
        '-apple-system-ui-serif',
        'ui-serif',
        'Noto Serif',
        'Iowan Old Style',
        'Apple Garamond',
        'Baskerville',
        'Times New Roman',
        'Droid Serif',
        'Times',
        'Source Serif Pro',
        'serif',
        'Apple Color Emoji',
        'Segoe UI Emoji',
        'Segoe UI Symbol'
      ]
    },
    fontSize: {
      gargantuan: 'clamp(2.75rem, 5.2vw, 3.25rem)',
      colossal: 'clamp(2.5rem, 4.8vw, 3rem)',
      gigantic: 'clamp(2.125rem, 4.4vw, 2.75rem)',
      jumbo: 'clamp(2rem, 4vw, 2.5rem)',
      huge: 'clamp(1.875rem, 3.6vw, 2.25rem)',
      big: 'clamp(1.75rem, 3.2vw, 2rem)',
      'x-large': 'clamp(1.5rem, 2.8vw, 1.75rem)',
      large: '1.25rem',
      medium: '1.125rem',
      small: '1rem',
      tiny: '0.875rem',
      min: '0.75rem'
    },
    borderRadius: {
      base: 'var(--bs-border-radius)',
      small: 'var(--bs-border-radius-sm)',
      large: 'var(--bs-border-radius-lg)',
      xl: 'var(--bs-border-radius-xl)',
      xxl: 'var(--bs-border-radius-xxl)',
      pill: 'var(--bs-border-radius-pill)'
    },
    borderWidth: { base: 'var(--bs-border-width)', medium: '2px', large: '3px' },
    letterSpacing: { none: 'normal', tight: '-.01em', loose: '.05em', looser: '.1em' }
  }
 */
