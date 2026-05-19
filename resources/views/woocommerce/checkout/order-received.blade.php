<section class="membership-thankyou">
	<p class="membership-thankyou-message">
		{!! __(
		    'Thank you for becoming a member of the Llanfyllin Workhouse! We are delighted to have you as part of our community. Your support plays a vital role in our work, and we\'re excited to share your new benefits with you:',
		    'llanfyllin-workhouse',
		) !!}
	</p>

	<ul class="membership-thankyou-benefits">
		<li><strong>10% off</strong> delicious treats at <a href="{!! get_permalink(114) !!}">The Meadows Café</a></li>
		<li><strong>10% off</strong> <a href="{!! home_url('/events') !!}">Events</a> hosted by The Workhouse</li>
		<li><strong>10% off</strong> bookings at our on-site <a href="{!! get_permalink(116) !!}">Escape Room</a></li>
		<li>{!! __('...plus more exciting perks coming soon!', 'llanfyllin-workhouse') !!}</li>
	</ul>

	<p>
		<strong>{!! __('How to use your discount:', 'llanfyllin-workhouse') !!}</strong>
		{!! __('Simply show a copy of this email to our team when you visit.', 'llanfyllin-workhouse') !!}
	</p>

	<p>
		<strong>{!! __('Membership Details:', 'llanfyllin-workhouse') !!}</strong><br />
		{!! __(
		    'For your convenience, your membership renews automatically each year. We\'ll always keep you in the loop by sending a reminder email 15 days before your renewal date.',
		    'llanfyllin-workhouse',
		) !!}
	</p>

	<p>
		{!! sprintf(
		    __(
		        'You can view your membership status or make changes at any time by %slogging into your account%s. If you need a hand with anything, just drop us an email at %smembers@llanfyllinworkhouse.org.uk%s.',
		        'llanfyllin-workhouse',
		    ),
		    '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '">',
		    '</a>',
		    '<a href="mailto:members@llanfyllinworkhouse.org.uk">',
		    '</a>',
		) !!}
	</p>
</section>
