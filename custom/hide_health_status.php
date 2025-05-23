<?php

// remove dashboard widget 
add_action( 'wp_dashboard_setup', 'remove_site_health_widget' );
function remove_site_health_widget() {
  global $wp_meta_boxes;
  unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] );
}

// remove menu item from under "Tools" section 
add_action( 'admin_menu', 'remove_site_health_submenu', 999 );
function remove_site_health_submenu() {
  remove_submenu_page( 'tools.php', 'site-health.php' );
}