<?php

function cm_get_api_data() {
  return [
    'api_key' => 'frkzhN21SUWcnLNiDRP7+00Rof6UxfSAK+U0QCD1idXyoU8lJQ6flpFEzbl0Px2tKzw4LKgfKlVHONxAMQ6+GzF09bhtK3B93FlyY2tylSWm2Y4VmXOTpbth2BrJtlcQ/qq+LgVYuDvH0F7mgnhCvA==',
    'newsletter_list_id' => '68ffec371d59efdf0332994e4743a9eb',
    'member_list_id' => '02ab7fdcd166c6db39cc7ec550da7836',
  ];
}

add_action('wpcf7_before_send_mail', 'sync_cf7_to_campaign_monitor', 10, 3);

function sync_cf7_to_campaign_monitor($contact_form, &$abort, $submission) {
    $data = $submission->get_posted_data();

    // Mapping fields
    $email = $data['your-email'] ?? '';
    $name  = $data['your-name'] ?? '';
    $newsletter = $data['newsletter'] ?? [];

    if (empty($email)) return;

    // Maybe signup to newsletter
    if ( is_array($newsletter) && count($newsletter) > 0 ) {
        // Use the namespaced class from the Composer package
        $api_data = cm_get_api_data();
        $auth = array('api_key' => $api_data['api_key']);
        $wrap = new CS_REST_Subscribers($api_data['newsletter_list_id'], $auth);

        $result = $wrap->add(array(
            'EmailAddress' => $email,
            'Name' => $name,
            'ConsentToTrack' => 'yes',
            'Resubscribe' => true
        ));
    }

}

/**
 * Sync YITH Subscription status to Campaign Monitor
 */
add_action('ywsbs_subscription_status_changed', 'sync_yith_subscription_to_cm', 10, 3);

function sync_yith_subscription_to_cm($subscription_id, $old_status, $new_status) {
    $subscription = ywsbs_get_subscription($subscription_id);
    if (!$subscription) return;

    $api_data = cm_get_api_data();
    $auth = array('api_key' => $api_data['api_key']);
    $user_id = $subscription->get_user_id();
    $wrap = new CS_REST_Subscribers($api_data['member_list_id'], $auth);
    $customer = new WC_Customer($user_id);

    $result = $wrap->add(array(
        'EmailAddress' => $customer->get_billing_email(),
        'Name'         => $customer->get_first_name() . ' ' . $customer->get_last_name(),
        'CustomFields' => array(
            array(
                'Key'   => 'Status', // Ensure this matches your CM Custom Field Name
                'Value' => ucfirst($new_status)      // e.g., "Active", "Cancelled"
            ),
            array(
                'Key'   => 'SubscriptionID',
                'Value' => $subscription_id
            ),
        ),
        'ConsentToTrack' => 'yes',
        'Resubscribe'    => true
    ));

    $test = 1;
}