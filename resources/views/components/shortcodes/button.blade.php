@props([
    'url' => '#',
    'colour' => 'primary',
    'style' => 'filled',
    'size' => 'medium',
    'with_arrow' => false,
    'slot' => '',
])

<a href="{{ $url }}"
	class="btn btn-{{ $colour }} btn-{{ $style }} btn-{{ $size }} {{ $with_arrow ? 'has-arrow' : '' }}">
	{!! $slot !!}
</a>
