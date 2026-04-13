@props([
    'size' => null,
    'tag' => null,
])

@php
	switch ($size) {
	    case 'small':
	        $class = 'text-sm';
	        break;
	    case 'large':
	        $class = 'text-2xl md:text-4xl';
	        break;
	    case 'xl':
	        $class = 'text-3xl md:text-6xl';
	        break;
	    case 'medium':
	        $class = 'text-xl md:text-2xl';
	        break;
	    default:
	        $class = 'text-base';
	        break;
	}
@endphp

<{{ $tag ?? 'h2' }} {{ $attributes->merge(['class' => "{$class} font-bold font-title mb-6 capitalize"]) }}>
	{!! $message ?? $slot !!}
	</{{ $tag ?? 'h2' }}>
