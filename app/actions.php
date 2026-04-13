<?php

/**
 * Theme filters.
 */

namespace App;

// Remove global styles to prevent conflicts with Tailwind CSS.
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('global-styles');
}, 100);

/**
 * Clear cart before adding a new membership product.
 */
add_filter('woocommerce_add_to_cart_handler', function ($handler, $product) {
    if (has_term('membership', 'product_tag', $product->get_id())) {
        wc_empty_cart();
    }
    return $handler;
}, 10, 2);

/**
 * Redirect to checkout immediately after adding to cart.
 */
add_filter('woocommerce_add_to_cart_redirect', function ($url) {
    return wc_get_checkout_url();
});

/**
 * Remove the "Added to Cart" message.
 */
add_filter('wc_add_to_cart_message_html', '__return_false');