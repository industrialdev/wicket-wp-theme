<?php

/**
 * Job Manager > Dashboard actions won't work because plugin checks if the shortcode is present in the content of a 'page'.
 * However, Wicket AC plugin uses 'posts' instead of 'pages', so we need to make a quick fix here.
 */
add_filter('job_manager_should_run_shortcode_action_handler', function ( $should_run ) {
  global $post;

  return has_shortcode( $post->post_content, 'job_dashboard' );
}, 10, 1 );
