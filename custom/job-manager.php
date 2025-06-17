<?php

/**
 * Job Manager > Dashboard actions won't work because plugin checks if the shortcode is present in the content of a 'page'.
 * However, Wicket AC plugin uses 'posts' instead of 'pages', so we need to make a quick fix here.
 */
add_filter('job_manager_should_run_shortcode_action_handler', function ($should_run) {
    global $post;

    return has_shortcode($post->post_content, 'job_dashboard');
}, 10, 1);

/**
 * Job Manager > Add banner to the single job listing page.
 */
add_action('single_job_listing_start', function () {
  $job_page_id = get_option('job_manager_jobs_page_id');
  $job_board_url = get_permalink($job_page_id);
?>
  <div class="wicket-job-listing-head">
    <?php get_component('link', [
      'classes' => ['back-link'],
      'text'    => __('Back', 'wicket'),
      'url'     => $job_board_url,
      'icon_start' => [
        'icon' => 'fa-solid fa-arrow-left-long',
      ],
    ]) ?>

    <h3 class="text-heading-sm"><?php _e('Job opportunity', 'wicket') ?></h3>
    <hr>

    <h1 class="text-heading-2xl"><?php the_title() ?></h1>
  </div>

<?php
});