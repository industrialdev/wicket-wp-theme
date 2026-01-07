<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add "subscription" product type support for the "Role Based Pricing for WooCommerce" plugin.
 */
if (class_exists('AF_C_S_P_Price')) {
    class AF_C_S_P_Price_Wicket extends AF_C_S_P_Price {
        /**
         * Return a price HTML of product.
         *
         * @param  object $price_html HTML of default price.
         * @param  object $product    Product id or object.
         * @param  object $user       User id or object.
         * @param string $user_role  Role.
         * @return float
         */
        public function get_price_html_of_product($price_html, $product, $user = false, $user_role = 'guest') {

            if ($this->is_product_price_hidden($product, $user, $user_role)) {
                $cps_price_text = get_option('csp_price_text');
                return $cps_price_text;
            }

            $has_price = $this->have_price_of_product($product, $user, $user_role);

            if (!$has_price) {

                return $price_html;
            }

            $replace_original = $this->is_replace_price($product, $user, $user_role);

            switch ($product->get_type()) {

                case 'subscription':
                case 'variable-subscription':
                case 'simple':
                case 'variation':
                    return $this->get_product_price_html($product, $replace_original);

                case 'variable':
                    return $this->get_variable_product_price_html($product, $replace_original);

                case 'grouped':
                    return $this->get_grouped_product_price_html($product, $replace_original);
                default:
                    return $price_html;
            }
        }
    }

    add_filter('woocommerce_get_price_html', function ($price, $product) {

        $af_price = new AF_C_S_P_Price_Wicket();
        $price = $af_price->get_price_html_of_product($price, $product);

        return $price;
    }, 100, 2);
}
