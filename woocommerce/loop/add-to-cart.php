<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if (! defined('ABSPATH')) {
    exit;
}

global $product;
$login_link = '';

if (! is_user_logged_in()) {
    ob_start();
    get_component('link', [
        'text'     => __('Login to Purchase', 'woocommerce'),
        'default_link_style' => true,
        'target'   => '_blank',
        'url'      => get_login_url(),
        'icon_end' => [
            'icon' => 'fa-solid fa-arrow-up-right-from-square',
        ],
    ]);
    $login_link = ob_get_clean();
}

echo apply_filters(
    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
    sprintf(
        '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>%s',
        esc_url($product->add_to_cart_url()),
        esc_attr($args['quantity'] ?? 1),
        esc_attr($args['class'] ?? 'button'),
        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
        '<span class="add_to_cart_button__text">' . esc_html($product->add_to_cart_text()) . '</span>' . '<span class="add_to_cart_button__text-added">' . __('Added to cart') . ' <i class="fa-solid fa-check"></i></span>',
        $login_link
    ),
    $product,
    $args
);
