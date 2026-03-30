@props([
    'class' => '',
    'inner_class' => '',
    'style' => '',
    'section_settings' => [],
    'use_prose' => false,
])

<section class="page-section py-20 {{ $class }} {{ $section_settings['class'] }}"
	style="{{ $style }} {{ $section_settings['style'] }}" id="{{ $section_settings['id'] }}">

	<div
		class="page-section-inner max-w-6xl mx-auto px-4 no-child-margin {{ $use_prose ? 'prose max-w-none' : '' }} {{ $inner_class }} {{ $section_settings['inner_class'] }}">
		{{ $slot }}
	</div>

</section>
