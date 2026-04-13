@props([
    'type' => 'default',
    'size' => 'full',
])

@if ($logoId)
	{!! wp_get_attachment_image($logoId, $size, false, [
	    // We merge the incoming classes with some smart defaults
	    'class' => $attributes->merge([
	            'class' => '',
	        ])->get('class'),
	    'alt' => get_bloginfo('name'),
	]) !!}
@endif
