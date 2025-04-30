<?php

// On cloudways, they default to imagemagick, which struggles with large pngs, etc. GD is what we use locally and performs much better when swapped out
add_filter('wp_image_editors', function($editors) {
  return array( 'WP_Image_Editor_GD' );
});