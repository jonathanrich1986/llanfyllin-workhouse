@props([
    'type' => null,
    'message' => null,
])

@php
	switch ($type) {
	    case 'success':
	        $class = 'text-green-50 bg-green-400';
	        break;
	    case 'caution':
	        $class = 'text-yellow-50 bg-yellow-400';
	        break;
	    case 'warning':
	        $class = 'text-red-50 bg-red-400';
	        break;
	    default:
	        $class = 'text-indigo-50 bg-indigo-400';
	        break;
	}
@endphp

<div {{ $attributes->merge(['class' => "px-2 py-1 {$class}"]) }}>
	{!! $message ?? $slot !!}
</div>
