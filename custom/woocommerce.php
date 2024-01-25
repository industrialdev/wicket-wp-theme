<?php

// Remove Product Permalink on Order Table after checkout
add_filter( 'woocommerce_order_item_permalink', '__return_false' );

// Remove product link in cart item list
add_filter('woocommerce_cart_item_permalink','__return_false');

// when redirected to a checkout disable the "X added to cart, continue shopping?" message
add_filter( 'wc_add_to_cart_message_html', '__return_false' );

/**
 * Remove built-in react since it's messing with the wicket widgets
 */
function wp_remove_scripts() {
  global $wp_scripts;
  wp_deregister_script( 'react' );
  wp_deregister_script( 'react-dom' );
}
add_action( 'wp_enqueue_scripts', 'wp_remove_scripts', 99 );

/**
 * Fires after a team has been created.
 * This action hook is similar to `wc_memberships_for_teams_team_saved`
 * but doesn't fire when teams are manually created from admin.  
 * found in wp-content\plugins\woocommerce-memberships-for-teams\src\Teams_Handler.php:274
 * 
 * @param Team $team_post_data
 * @return void
 */
function alter_teams_data($team_post_data)
{
  // we can't update the field value before the post exists, so we do it right after 
  $order = $team_post_data->get_order();
  if($order){
    $user_id = $order->get_user_id();
    $chosen_organization = get_user_meta($user_id, 'org_id', true);
  }

  if ($chosen_organization) {
    update_field('wicket_organization', $chosen_organization, $team_post_data->get_id());
  }

  $name = $team_post_data->get_name();
  // don't make changes if the team already has a name!
  if ($name == 'Team') {
    $company = get_user_meta($user_id, 'org_name', true);

    // use the company name if possible, and fallback to team ID if not
    $team_name = $company ?: sprintf(__('Team %s', 'woocommerce-memberships-for-teams'), $company);
    wp_update_post(array(
      'ID'         => $team_post_data->get_id(),
      'post_title' => $team_name
    ));

    // make sure correct meta is in the order line items so "renew now" button works in the account center and other things
    if ($order) {
      foreach ($order->get_items() as $item) {
        wc_update_order_item_meta( $item->get_id() , '_wc_memberships_for_teams_team_id', $team_post_data->get_id() );
        wc_update_order_item_meta( $item->get_id(), 'team_name', $team_name );
      }
      // update the subscription item meta as well
      $subscriptions = wcs_get_subscriptions_for_order($order->get_id());
      foreach ($subscriptions as $subscription) {
        $subscription = wcs_get_subscription($subscription->get_id());
        foreach ($subscription->get_items() as $item) {
          // used this method for orders, seems to work for subscriptions as well since the 2 are so similar
          wc_update_order_item_meta( $item->get_id() , '_wc_memberships_for_teams_team_id', $team_post_data->get_id() );
          wc_update_order_item_meta( $item->get_id(), 'team_name', $team_name );
        }
      }
    }
  }
}
add_action('wc_memberships_for_teams_team_created', 'alter_teams_data');