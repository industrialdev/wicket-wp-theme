<?php

// Register Sidebars
function wicket_widgets_init() {
  register_sidebar( array(
    'id'          => 'header-widgets',
    'name'        => 'Header Widgets',
    'description' => __( 'Header widget area.', 'text_domain' ),
  ));
  
  register_sidebar( array(
    'id'          => 'footer-widgets',
    'name'        => 'Footer Widgets',
    'description' => __( 'Footer widget area.', 'text_domain' ),
  ));
}
add_action( 'widgets_init', 'wicket_widgets_init' );