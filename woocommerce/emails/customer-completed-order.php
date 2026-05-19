<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.4.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php echo $email_improvements_enabled ? '<div class="email-introduction">' : ''; ?>
<p>
<?php
if ( ! empty( $order->get_billing_first_name() ) ) {
	/* translators: %s: Customer first name */
	printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) );
} else {
	printf( esc_html__( 'Hi,', 'woocommerce' ) );
}
?>
</p>

<?php if (order_contains_membership_product($order)) : ?>

	<p><?php esc_html_e( 'Welcome to the community! We are delighted to have you as a member of The Llanfyllin Workhouse. Your support plays a vital role in our work, and we\'re excited to share your new benefits with you:', 'woocommerce' ); ?></p>
	<ul>
		<li><strong>10% off</strong> delicious treats at <a href="<?php echo get_permalink(114); ?>">The Meadows Café</a></li>
		<li><strong>10% off</strong> <a href="<?php echo get_home_url(); ?>/events">Events</a> hosted by The Workhouse</li>
		<li><strong>10% off</strong> bookings at our on-site <a href="<?php echo get_permalink(116); ?>">Escape Room</a></li>
		<li>...plus more exciting perks coming soon!</li>
	</ul>
	<p><strong>How to use your discount:</strong> Simply show a copy of this email to our team when you visit.</p>
	<p><strong>Membership Details:</strong><br />
	For your convenience, your membership renews automatically each year. We'll always keep you in the loop by sending a reminder email 15 days before your renewal date. Should there be any issues with your payment — such as an expired card — we'll reach out to help you update your details.</p>

	<p>You can view your membership status or make changes at any time by <a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>">logging into your account</a>. If you need a hand with anything, just drop us an email at <a href="mailto:members@llanfyllinworkhouse.org.uk">members@llanfyllinworkhouse.org.uk</a>.</p>
		

<?php else : ?>
	<p><?php esc_html_e( 'We have finished processing your order', 'woocommerce' ); ?></p>
	<?php if ( $email_improvements_enabled ) : ?>
		<p><?php esc_html_e( 'Here’s a reminder of what you’ve ordered:', 'woocommerce' ); ?></p>
	<?php endif; ?>
	
<?php endif; ?>

<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
