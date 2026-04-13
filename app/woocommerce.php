<?php

defined( 'ABSPATH' ) or exit;

add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
 
add_filter( 'woocommerce_add_to_cart_redirect', function ( $url ) {
  return wc_get_checkout_url();
} );

add_filter( 'wc_add_to_cart_message_html', function ( $message ){
  return '';
} );

add_filter( 'woocommerce_product_single_add_to_cart_text', function ( $text, $product ) {

  if ( $product->get_id() === 4760 ) {
    $text = $product->is_purchasable() && $product->is_in_stock() ? 'Sign Up' : 'Read more';
  }

  return $text;
}, 10, 2 );

// Add Gift Aid checkbox to checkout page
add_action('woocommerce_review_order_before_submit', function ($checkout) {

  echo '<div id="gift_aid_field"><h2 class="mb-0">' . __('Gift Aid') . '</h2>';
  woocommerce_form_field('gift_aid', array(
      'type' => 'checkbox',
      'class' => array('form-row-wide'),
      'label' => __('Yes, I am a UK taxpayer and I want to Gift Aid my donation'),
      'required' => false,
  ), WC()->checkout->get_value('gift_aid'));
  echo '</div>';
});

// Save Gift Aid checkbox value
add_action('woocommerce_checkout_create_order', function ($order) {

  if ( isset($_POST['gift_aid']) && $_POST['gift_aid']) {
      $order->update_meta_data('gift_aid', 'yes');
  } else {
      $order->update_meta_data('gift_aid', 'no');
  }
});

// Display Gift Aid value in order details
add_action('woocommerce_order_details_after_order_table', function ($order) {

  $gift_aid = $order->get_meta('gift_aid');

  if ($gift_aid == 'yes') {
      echo '<p><strong>' . __('Gift Aid:') . '</strong> ' . __('Yes') . '</p>';
  } else {
      echo '<p><strong>' . __('Gift Aid:') . '</strong> ' . __('No') . '</p>';
  }

});

// Display Gift Aid value in order details
add_action('woocommerce_admin_order_data_after_billing_address', function ($order) {

  $gift_aid = $order->get_meta('gift_aid');

  if ($gift_aid == 'yes') {
      echo '<p><strong>' . __('Gift Aid:') . '</strong> ' . __('Yes') . '</p>';
  } else {
      echo '<p><strong>' . __('Gift Aid:') . '</strong> ' . __('No') . '</p>';
  }

});