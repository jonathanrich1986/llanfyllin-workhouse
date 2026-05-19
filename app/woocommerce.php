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

// Send an email in WooCommerce style
function send_woocommerce_email($to, $subject, $title, $message) {
  // 1. Get the WC_Emails instance
  $mailer = WC()->mailer();

  // 3. Wrap content in the WooCommerce Template
  // This adds the header, footer, and your site's custom colors
  $wrapped_message = $mailer->wrap_message( $title, $message );

  $headers = [
      'Content-Type: text/html; charset=UTF-8',
      'From: ' . get_bloginfo('name') . ' <members@llanfyllinworkhouse.org.uk>',
  ];

  // BCC to the admin email for testing
  $admin_email = get_option( 'admin_email' );
  if ( $admin_email ) {
      $headers[] = 'BCC: ' . $admin_email;
  }

  // 4. Send the email 
  // We omit the manual "Content-Type" as the mailer handles this via the wrapped template
  $sent = $mailer->send(
      $to,
      $subject,
      $wrapped_message,
      $headers
  );

  // 5. Optional: Log or handle failure
  if ( ! $sent ) {
      error_log( 'WC Custom Email failed to send to: ' . $to );
  }
}

// Schedule a daily event to send the email
if ( ! wp_next_scheduled( 'lt_send_membership_expiry_email' ) ) {
  wp_schedule_event( time(), 'daily', 'lt_send_membership_expiry_email' );
}

// Hook into the scheduled event
add_action( 'lt_send_membership_expiry_email', function() {

  // Today in the format Ymd
  $today = date('Ymd');
  
  // Get all users where the meta key 'membership_expires' is equal to or less than today
  $users = get_users( array(
      'meta_key' => 'membership_expires',
      'meta_value' => $today,
      'meta_compare' => '<='
  ) );

  // Loop through the users and send an email
  foreach ( $users as $user ) {
      $customer = new WC_Customer( $user->ID );

      $orders = wc_get_orders( array(
          'customer_id' => $user->ID,
          'limit' => 1,
          'orderby' => 'date',
          'order' => 'DESC',
      ) );

      foreach($orders as $order) {
          if ( ywsbs_is_an_order_with_subscription( $order) ) {
            delete_user_meta( $user->ID, 'membership_expires' );
            continue 2;
          }
      }

      $to = $customer->get_email();
      $subject = 'Your Llanfyllin Workhouse Membership Expires Today';
      $title = 'Your Llanfyllin Workhouse Membership Expires Today';
      // Get my account page
      $link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
      $message = '<p>Hi ' . $customer->get_first_name() . "</p>";
      $message .= "<p>Your Llanfyllin Workhouse membership expires today. We’ve recently upgraded to a new subscription system, and as a result, your current membership cannot renew automatically.";
      $message .= "<p>To stay with us and continue supporting the growth of The Workhouse, please <a href=\"" . $link . "\">re-activate your subscription</a>.";
      $message .= "<p><strong>How to renew:</strong></p>";
      $message .= "<ul>";
      $message .= "<li><strong>Login:</strong> Use your existing email and password.</li>";
      $message .= "<li><strong>Reset Password:</strong> If you need to reset your password, please use the 'Lost your password' link on the login page.</li>";
      $message .= "<li><strong>Renew Membership:</strong> Once logged in, you can click on the banner at the top of your account page to renew your membership.</li>";
      $message .= "<li><strong>Manage Your Membership:</strong> After renewing, you can manage your subscription by using the \"Login\" button at the top of the website.</li>";
      $message .= "</ul>";
      $message .= "<p><a href=\"" . $link . "\" class=\"wr-button\">Login to your account</a></p>";
      $message .= "<p>As a thank you for your support, you’ll continue to enjoy 10% off at the <a href=\"" . get_permalink(114) . "\">Meadows Café</a>, all Trust-organised <a href=\"" . get_home_url() . "/events\">events</a>, and <a href=\"" . get_permalink(116) . "\">Roomination Escape Rooms</a>.</p>";
      $message .= "<p>We truly value your contribution to everything we do here. If you have any questions, just hit reply!</p>";
      $message .= "<p>Best regards,<br>Llanfyllin Workhouse</p>";
      send_woocommerce_email( $to, $subject, $title, $message );

      // Remove the meta key to prevent duplicate emails
      delete_user_meta( $user->ID, 'membership_expires' );
  }

});

// Email styles
add_filter('woocommerce_email_styles', function($css) {
    $css .= "
        .wr-button {
            background-color: #8eae16 !important;
            border-radius: 5px !important;
            padding: 15px 30px !important;
            font-family: 'Helvetica', sans-serif;
            text-transform: uppercase;
            font-weight: bold;
            color: #fff !important;
            text-decoration: none !important;
            display: inline-block;
            margin-top: 20px;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
        }
    ";
    return $css;
});

// Add a banner to the top of the my account pages
add_action( 'woocommerce_before_account_navigation', function() {

  // Get YITH membership details
  $user_id = get_current_user_id();
  $orders = wc_get_orders( array(
      'customer_id' => $user_id,
      'limit' => 1,
      'orderby' => 'date',
      'order' => 'DESC',
  ) );

  $has_subscription = false;

  foreach($orders as $order) {
      if ( ywsbs_is_an_order_with_subscription( $order) ) {
          $has_subscription = true;
          break;
      }
  }

  if ( $has_subscription ) {
    return;
  }

  echo '<div class="my-account-banner bg-primary/40 p-4 mb-4 rounded-lg text-balance text-center">
          <h2 class="my-0! text-balance">Become a Llanfyllin Workhouse Member Today!</h2>
          <p class="text-balance mb-0">Support the work of the Llanfyllin Workhouse and enjoy great benefits by becoming a member. <a href="' . get_permalink(get_membership_page()) . '" class="font-bold">Click here</a> to view our membership options and sign up today.</p>
        </div>';
} );

// Add banner to top of login form
add_action( 'woocommerce_before_customer_login_form', function() {
  echo '<div class="login-banner bg-secondary/10 p-8 mb-4 rounded-lg no-child-margin prose max-w-none">
          <h2 class="text-balance text-center">Welcome to the Llanfyllin Workhouse Members Area</h2>
          <p class="text-center text-pretty">This is the place to manage your membership details and subscription.</p>
          <p class="text-center text-pretty">We now have a new subscription system in place to help manage all memberships. As a result, if you have previously signed up via the website, your subscription will not renew automatically. To continue being a member and supporting The Workhouse, please follow the instructions below:</p>
          <ul>
            <li class="">If you have signed up via the website in the past, please log in below to create or manage your subscription. If you have forgotten your password, please use the "Lost your password?" link below to reset it.</li>
            <li class="">If you are looking to become a member but have never signed up through the website before, <a href="' . get_permalink(get_membership_page()) . '" class="font-bold">click here</a> to view our membership options.</li>
          </ul>
        </div>';
} );


// Send automated email when contact form 7 is submitted
add_action('wpcf7_mail_sent', 'custom_cf7_email_trigger');

function custom_cf7_email_trigger($contact_form) {
    // Get the current submission instance
    $submission = WPCF7_Submission::get_instance();
    $contact_form_id = $contact_form->id();

    if ($submission) {

        // Get the posted data (user inputs)
        $posted_data = $submission->get_posted_data();

        switch( $contact_form_id ) {

            // Newsletter signup form ID
            case 642:

                // Example: Extract specific fields
                $name = $posted_data['your-name'];
                $email = $posted_data['your-email'];
                $message = "<p>Hi $name,</p>";
                $message .= "Thank you for signing up for our newsletter! We're excited to keep you updated on all the latest news and events at the Llanfyllin Workhouse.</p>";
                $message .= "<p>Best regards,<br>Llanfyllin Workhouse Team</p>";

                // Send the email using our custom WooCommerce email function
                send_woocommerce_email($email, 'Welcome to the Llanfyllin Workhouse Newsletter', 'Welcome to the Llanfyllin Workhouse Newsletter', $message);

                break;

            // Bunkhouse
            case 725:

                // Example: Extract specific fields
                $name = $posted_data['your-name'];
                $email = $posted_data['your-email'];
                $message = "<p>Hi $name,</p>";
                $message .= "Thank you for your interest in our bunkhouse! We will get back to you as soon as possible with more information.</p>";
                $message .= "<p>Best regards,<br>Llanfyllin Workhouse Team</p>";
                $message .= "<p>P.S. Did you know we have an escape room at the Workhouse? Use the code <strong>BUNKHOUSE</strong> to get a special discount! For more information, visit the <a href=\"https://www.roomination.co.uk\">website</a>!</p>";

                // Send the email using our custom WooCommerce email function
                send_woocommerce_email($email, 'Thank you for contacting us about the bunkhouse', 'Thank you for contacting us about the bunkhouse', $message);

                break;

            // Default
            default:

                // Example: Extract specific fields
                $name = $posted_data['your-name'] ?? 'there';
                $email = $posted_data['your-email'] ?? null;

                if ( ! $email ) {
                    break;
                }
                $message = "<p>Hi $name,</p>";
                $message .= "Thank you for getting in touch with us! We will get back to you as soon as possible.</p>";
                $message .= "<p>Best regards,<br>Llanfyllin Workhouse Team</p>";

                // Send the email using our custom WooCommerce email function
                send_woocommerce_email($email, 'Thank you for contacting us', 'Thank you for contacting us', $message);
                break;
        }
    }

}

add_filter('woocommerce_order_item_needs_processing', function($needs_processing, $product) {

    if ( $product && $product->is_virtual() ) {
        return false; // This product does not require processing
    }
    return $needs_processing; // Default behavior for other products
}, 10, 2);

/**
 * Get the membership product IDs
 *
 * @return array
 */
function get_membership_product_ids(): array {
    return [776]; // Replace with your actual membership product IDs
}

function get_membership_page(): int {
    return 776; // Replace with your actual membership page ID
}

/**
 * Does this order contain a membership
 *
 * @param mixed $order
 * @return boolean
 */
function order_contains_membership_product($order): bool {

    $order = wc_get_order($order);
    
    if (!$order instanceof \WC_Order) {
        return false;
    }

    foreach($order->get_items() as $item) {

        if (!$item instanceof \WC_Order_Item_Product) {
            continue;

        }
        $product = $item->get_product();
        $product_id = $product->get_id();

        if ($product->is_type('variation')) {
            $product_id = $product->get_parent_id();
        }

        if ( $product && in_array( $product_id, get_membership_product_ids() ) ) {
            return true;
        }
    }

    return false;
}

// Redirect to membership page when trying to view a membership product
add_action( 'template_redirect', function() {
    
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        wp_redirect( get_permalink(get_membership_page()) ); // Redirect to the membership page
        exit;
    }
} );

// Hide woocommerce breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// Hide product meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Hide product tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// Change order received title
add_filter( 'the_title', function( $title ) {
    if ( is_wc_endpoint_url( 'order-received' ) ) {
        return 'You\'re now a member!';
    }
    return $title;
} );