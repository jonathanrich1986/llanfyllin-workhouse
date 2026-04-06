@props([
    'class' => '',
    'inner_class' => '',
    'style' => '',
    'section_settings' => [],
    'use_prose' => false,
])

@if ($section_settings['custom_css'] ?? false)
	<style>
		{!! $section_settings['custom_css'] !!}
	</style>
@endif

<section class="page-section relative {{ $class }} {{ $section_settings['class'] ?? '' }}"
	style="{{ $style }} {{ $section_settings['style'] ?? '' }}" id="{{ $section_settings['id'] ?? '' }}">

	<div
		class="page-section-inner w-full mx-auto no-child-margin py-20 relative z-10 {{ $use_prose ? 'prose' : '' }} {{ $inner_class }} {{ $section_settings['inner_class'] ?? '' }}">
		{{ $slot }}
	</div>

	@if ($section_settings['background_image'] ?? false)
		<div class="absolute inset-0 hidden md:block">
			{!! $section_settings['background_image'] !!}
		</div>
	@endif

	@if ($section_settings['background_image_mobile'] ?? false)
		<div class="absolute inset-0 md:hidden">
			{!! $section_settings['background_image_mobile'] !!}
		</div>
	@endif

</section>
