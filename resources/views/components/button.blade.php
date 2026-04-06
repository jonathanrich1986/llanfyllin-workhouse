@props([
    'content' => null,
    'tag' => 'a',
    'colour' => 'primary',
    'style' => 'solid', // solid, outline
    'size' => 'medium', // small, medium, large
    'url' => '#',
])

@php
	$classes = ['font-title', 'font-bold', 'not-prose'];

	// Determine the Color/Style combination
	if ($style === 'outline') {
	    $styleSuffix = 'outline';
	    $classes[] = 'wr-button-outline';
	} else {
	    $styleSuffix = 'solid';
	    $classes[] = 'wr-button-solid';
	}

	// Defaulting to 'primary' if color isn't recognized could be done here
$classes[] = "wr-button-{$colour}-{$styleSuffix}";

// Handle Sizes
if ($size === 'small') {
    $classes[] = 'wr-button-small';
} elseif ($size === 'large') {
    $classes[] = 'wr-button-large';
}

// Merge classes into a single string
$finalClasses = implode(' ', $classes);
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => "{$finalClasses}"]) }} href="{{ $url }}">
	{!! $content ?? $slot !!}
	</{{ $tag }}>
