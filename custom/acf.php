<?php
/**
 * ACF Customizations
 **/

 function wicket_acf_init() {
  // Check function exists.
  if ( function_exists( 'acf_add_options_page' ) ) {
      $parent = acf_add_options_page( array(
          'page_title' => __( 'Options', 'wicket' ),
          'redirect'   => true,
          'position'   => '75',
      ) );

      acf_add_options_page( array(
          'page_title'  => __( 'Global Settings', 'wicket' ),
          'menu_title'  => __( 'Global', 'wicket' ),
          'parent_slug' => $parent['menu_slug'],
      ) );
      acf_add_options_page( array(
        'page_title'  => __( 'Header Settings', 'wicket' ),
        'menu_title'  => __( 'Header', 'wicket' ),
        'parent_slug' => $parent['menu_slug'],
      ) );
      acf_add_options_page( array(
        'page_title'  => __( 'Footer Settings', 'wicket' ),
        'menu_title'  => __( 'Footer', 'wicket' ),
        'parent_slug' => $parent['menu_slug'],
      ) );
  }
}
add_action( 'acf/init', 'wicket_acf_init' );

// Disable CPT and taxonomy UI functionality
add_filter( 'acf/settings/enable_post_types', '__return_false' );

// Disable Options Page UI functionality
add_filter( 'acf/settings/enable_options_pages_ui', '__return_false' );

// Don't output empty message on blocks
add_filter( 'acf/blocks/no_fields_assigned_message', '__return_empty_string' );

// Resets row index starting number to 0
add_filter( 'acf/settings/row_index_offset', '__return_zero' );

function wicket_acf_prepare_copyright_field( $field ) {
  $field['prepend']       = '© ' . date('Y');
  if ( $field['value'] === '' ) {
    $field['value'] = get_bloginfo( 'name' );
  }
  return $field;
}
add_filter( 'acf/prepare_field/key=field_651ad74e60f09', 'wicket_acf_prepare_copyright_field' );

function wicket_acf_load_footer_menu_field_choices( $field ) {
  $field['choices'] = array();
  $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
  
  if( is_array($menus) ) {
    $field['choices'][0] = __( '-- Select Menu --', 'wicket' );
    foreach( $menus as $menu ) {
      $field['choices'][$menu->term_id] = $menu->name;
    }
  }
  return $field;
}
add_filter( 'acf/load_field/key=field_65203a1fff220', 'wicket_acf_load_footer_menu_field_choices' );