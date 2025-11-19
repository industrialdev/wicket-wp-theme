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
  theme: {
    extend: {
      boxShadow: boxShadow,
      width: layout,
      lineHeight: lineHeight,
      aspectRatio: {
        '3/2': '3 / 2',
      },
      fontSize: fontSize
    },
    container: {
      center: true,
    },
    fontFamily: fontFamily,
    letterSpacing: letterSpacing,
  },
}
