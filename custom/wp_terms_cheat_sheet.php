<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-load.php');

global $current_user;
$user_roles = $current_user->roles;

if( !in_array( 'administrator', $user_roles ) || empty( $user_roles ) ) {
  die();
}

?><h1>Taxonomies:</h1><?php

wicket_write_log( get_taxonomies(), true );

?><h1>Post Types:</h1><?php

$post_types = get_post_types();
wicket_write_log( $post_types, true );

?><h1>Post IDs and their pages:</h1><?php

$args = [ 
  //'post_type'      => [ 'post', 'page' ],
  'post_type'      => 'any',
  'fields'          => 'all',
  'posts_per_page'  => -1,
  'post_status'     => ['private', 'draft', 'publish'],
  //'paged'          => $paged,
  //'orderby'        => 'date',
  //'order'          => $order,
  //'s'              => $search_term,
  //'post__not_in'   => $excluded_post_ids,
  //'tax_query'      => $tax_query,
];

$query       = new WP_Query( $args );
$posts       = $query->posts;

$cleaned_posts = [];
foreach( $posts as $post ) {
  $cleaned_posts[] = [
    'post-title' => $post->post_title,
    'post-id'    => $post->ID,
    'post-type'  => $post->post_type,
  ];
}

wicket_write_log( $cleaned_posts, true );