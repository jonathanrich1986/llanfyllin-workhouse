@props([
    'type' => 'default',
])

@if ($logoId)
	{!! wp_get_attachment_image($logoId, 'full', false, [
	    // We merge the incoming classes with some smart defaults
	    'class' => $attributes->merge([
	            'class' => '',
	        ])->get('class'),
	    'alt' => get_bloginfo('name'),
	]) !!}
@endif
