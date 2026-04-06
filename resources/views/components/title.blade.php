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
	        $class = 'text-3xl md:text-6xl';
	        break;
	    case 'medium':
	    default:
	        $class = 'text-2xl md:text-4xl';
	        break;
	}
@endphp

<{{ $tag ?? 'h2' }} {{ $attributes->merge(['class' => "{$class} font-bold font-title mb-6 capitalize"]) }}>
	{!! $message ?? $slot !!}
	</{{ $tag ?? 'h2' }}>
