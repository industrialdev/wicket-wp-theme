const // Package Variables
  //dotenv = require('dotenv').config({ path: '.env' }),
  gulp = require('gulp'),
  sass = require('gulp-dart-sass'),
  sourcemaps = require('gulp-sourcemaps'),
  uglify = require('gulp-uglify'),
  autoprefixer = require('gulp-autoprefixer'),
  concat = require('gulp-concat'),
  rename = require('gulp-rename'),
  plumber = require('gulp-plumber'),
  notify = require('gulp-notify'),
  imagemin = require('gulp-imagemin'),
  insert = require('gulp-insert'),
  gulpIgnore = require('gulp-ignore'),
  postcss = require('gulp-postcss'),
  tailwindcss = require('tailwindcss'),
  livereload = require('gulp-livereload'),
  browserSync = require('browser-sync'),
  webpack = require('webpack-stream'),
  // Former Environment Variables
  srcPath = '.',
  assetPath = '/assets',
  themePath = '.',
  basePluginPath = '../../plugins/wicket-wp-base-plugin',
  baseStyleName = 'wicket',
  scriptName = 'wicket'
server = livereload()

// BrowserSync configuration"
// see: https://browsersync.io/docs/options
browserSync({
  proxy: 'https://localhost',
  reloadDebounce: 2000,
})

// Compiles both unminified and minified CSS files
function sassTask() {
  return gulp
    .src([
      srcPath + assetPath + '/styles/' + baseStyleName + '.scss',
      srcPath + assetPath + '/styles/' + 'admin.scss',
    ])
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        outputStyle: 'expanded',
        includePaths: ['node_modules'],
      })
    )
    .on('error', onError)
    .pipe(postcss([tailwindcss]))
    .pipe(
      autoprefixer({
        browsers: ['last 100 versions'],
        cascade: false,
      })
    )
    .on('error', function (err) {
      console.log(err.message)
    })
    .pipe(sourcemaps.write('../../maps'))
    .pipe(gulp.dest(srcPath + assetPath + '/styles/'))
}

// Note: Updated this to minify the .css files that were just compiled from scss. Notify Coulter if this was targetting
// the original .scss files for any reason
function minSass() {
  return gulp
    .src([
      srcPath + assetPath + '/styles/' + baseStyleName + '.css',
      srcPath + assetPath + '/styles/' + 'admin.css',
    ])
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        outputStyle: 'compressed',
      })
    )
    .on('error', onError)
    .pipe(
      autoprefixer({
        browsers: ['last 100 versions'],
        cascade: false,
      })
    )
    .on('error', function (err) {
      console.log(err.message)
    })
    .pipe(rename({suffix: '.min'}))
    .pipe(sourcemaps.write('../../maps'))
    .pipe(gulp.dest(srcPath + assetPath + '/styles/min'))
}
// Original minSass:
// function minSass() {
//   return gulp.src([
//     srcPath + assetPath + '/styles/' + baseStyleName + '.scss',
//     srcPath + assetPath + '/styles/' + 'admin.scss',
//   ])
//     .pipe(plumber())
//     .pipe(sourcemaps.init())
//     .pipe(sass({
//       outputStyle: 'compressed',
//       includePaths: ['node_modules'],
//     }))
//     .on('error', onError)
//     //.pipe(postcss([tailwindcss]))
//     .pipe(autoprefixer({
//       browsers: ['last 100 versions'],
//       cascade: false,
//     }))
//     .on('error', function (err) {
//       console.log(err.message);
//     })
//     .pipe(rename({ suffix: '.min' }))
//     .pipe(sourcemaps.write('../../maps'))
//     .pipe(gulp.dest(srcPath + assetPath + '/styles/min'));
// }

var adminScripts = srcPath + assetPath + '/scripts/wp-admin/' + '*.js'

// Compiles both unminified and minified JS files
function scriptsTask() {
  return gulp
    .src(srcPath + assetPath + '/scripts/' + '*.js')
    .pipe(gulpIgnore.exclude(adminScripts))
    .pipe(plumber())
    .pipe(webpack({}))
    .pipe(concat(scriptName + '.js'))
    .pipe(insert.wrap('(function($){\n\n', '\n\n})(jQuery);'))
    .on('error', onError)
    .pipe(gulp.dest(srcPath + assetPath + '/scripts/mingul'))
}

// Targets the newly compiled script and minifies it
function minScripts() {
  return (
    gulp
      .src(srcPath + assetPath + `/scripts/mingul/${scriptName}.js`)
      //.pipe(gulpIgnore.exclude(adminScripts))
      .pipe(plumber())
      .pipe(concat(scriptName + '.js'))
      //.pipe(insert.wrap('(function($){\n\n', '\n\n})(jQuery);'))
      .on('error', onError)
      .pipe(rename(scriptName + '.min.js'))
      .pipe(uglify())
      .pipe(gulp.dest(srcPath + assetPath + '/scripts/min'))
  )
}

// WP-Admin Scripts: Compiles both unminified and minified JS files
function scriptsTaskAdmin() {
  return gulp
    .src(adminScripts)
    .pipe(plumber())
    .pipe(concat(scriptName + '-wp-admin.js'))
    .pipe(insert.wrap('(function($){\n\n', '\n\n})(jQuery);'))
    .on('error', onError)
    .pipe(gulp.dest(srcPath + assetPath + '/scripts/mingul'))
}

// WP-Admin Scripts: Minifies admin scripts
function minScriptsAdmin() {
  return gulp
    .src(adminScripts)
    .pipe(plumber())
    .pipe(concat(scriptName + '-wp-admin.js'))
    .pipe(insert.wrap('(function($){\n\n', '\n\n})(jQuery);'))
    .on('error', onError)
    .pipe(rename(scriptName + '-wp-admin.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(srcPath + assetPath + '/scripts/min'))
}

// Minifies images to optimize load times
function imagesTask() {
  return gulp.src(srcPath + assetPath + '/images/' + '*').pipe(imagemin())
}

function iconsTask() {
  return gulp.src(srcPath + assetPath + '/icons/' + '*').pipe(imagemin())
}

// Duplicates fonts into destination folder
function fontsTask() {
  return gulp.src(srcPath + assetPath + '/fonts/' + '**/*')
}

// Watches files for changes and compiles on the fly
function watchTask() {
  const scssTailwindLocations = [
    srcPath + assetPath + '/styles/' + '**/*.scss',
    srcPath + '/**/*.php',
    basePluginPath + '/**/*.php',
    srcPath + '/**/*.js',
  ]

  const jsLocations = [
    srcPath + assetPath + '/scripts/' + '*.js',
    srcPath + assetPath + '/scripts/components/' + '*.js',
  ]

  gulp
    .watch(
      jsLocations,
      gulp.series(scriptsTask, minScripts, scriptsTaskAdmin, minScriptsAdmin)
    )
    .on('change', () => {
      browserSync.reload()
    })
  gulp
    .watch(scssTailwindLocations, gulp.series(sassTask, minSass))
    .on('change', () => {
      browserSync.reload()
    })
}

// error notifications
var onError = function (err) {
  notify({
    title: 'Gulp Task Error',
    message: 'Error: <%= error.message %>',
  }).write(err)

  this.emit('end')
}

module.exports = {
  sass: gulp.series(sassTask, minSass),
  scripts: gulp.series(
    scriptsTask,
    minScripts,
    scriptsTaskAdmin,
    minScriptsAdmin
  ),
  images: gulp.series(imagesTask, iconsTask),
  watch: gulp.series(watchTask),
  default: gulp.series(
    sassTask,
    minSass,
    scriptsTask,
    minScripts,
    scriptsTaskAdmin,
    minScriptsAdmin,
    fontsTask,
    watchTask
  ),
  serve: gulp.parallel(watchTask),
  build: gulp.series(
    sassTask,
    minSass,
    scriptsTask,
    minScripts,
    scriptsTaskAdmin,
    minScriptsAdmin,
    imagesTask,
    iconsTask,
    fontsTask
  ),
}
