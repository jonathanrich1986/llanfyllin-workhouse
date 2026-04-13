@if ($getCustomCss())
	<style>
		{!! $getCustomCss() !!}
	</style>
@endif

<section @class([
	'page-section relative flex group/layout',
	$customClasses, // Add custom classes if provided
	'is-dark' => $hasDarkBackground(),

	// Padding logic
	'pt-0' => $paddingTop === 'none',
	'pt-8' => $paddingTop === 'small',
	'pt-16' => $paddingTop === null || $paddingTop === 'medium',
	'pt-24' => $paddingTop === 'large',
	'pb-0' => $paddingBottom === 'none',
	'pb-8' => $paddingBottom === 'small',
	'pb-16' => $paddingBottom === null || $paddingBottom === 'medium',
	'pb-24' => $paddingBottom === 'large',

	// Margin logic
	'mt-0' => $marginTop === 'none' || $marginTop === null,
	'mt-8' => $marginTop === 'small',
	'mt-16' => $marginTop === 'medium',
	'mt-24' => $marginTop === 'large',
	'mb-0' => $marginBottom === 'none' || $marginBottom === null,
	'mb-8' => $marginBottom === 'small',
	'mb-16' => $marginBottom === 'medium',
	'mb-24' => $marginBottom === 'large',

	// Content position logic
	'items-start justify-center' => $contentPosition === 'top',
	'items-center justify-center' =>
		$contentPosition === 'centre' || $contentPosition === null,
	'items-end justify-center' => $contentPosition === 'bottom',
	'items-center justify-start' => $contentPosition === 'left',
	'items-center justify-end' => $contentPosition === 'right',
	'items-start justify-start' => $contentPosition === 'top_left',
	'items-start justify-end' => $contentPosition === 'top_right',
	'items-end justify-start' => $contentPosition === 'bottom_left',
	'items-end justify-end' => $contentPosition === 'bottom_right',

	// Height logic
	'h-auto' => $height === 'default' || $height === null,
	'aspect-video 2xl:aspect-auto 2xl:h-screen 2xl:max-h-[75svh]' =>
		$height === 'hero',
	'h-[calc(100svh-7rem)]' => $height === 'full', // Screen height minus h-28

	// Boxed layout overrides
	'p-20' => $boxedLayout, // Override padding for boxed layout

	// Background
	$getBackgroundColourClass() => $backgroundColour && !$boxedLayout,

	// Background gradient if there is an image and is not a boxed layout
	$getBackgroundGradientClass(),
]) id="{{ $layoutId }}">

	<div @class([
		'page-section-inner w-full no-child-margin relative z-20',
		'prose' => $useProse,
		'prose-invert' => $useProse && $hasDarkBackground(),
	
		// Content width logic
		'max-w-[90vw] xl:max-w-2xl' => $contentWidth === 'narrow',
		'max-w-[90vw] xl:max-w-4xl' => $contentWidth === 'thin',
		'max-w-[90vw] xl:max-w-6xl' =>
			$contentWidth === 'default' || $contentWidth === null,
		'max-w-none' => $contentWidth === 'full',
	
		// Boxed layout overrides
		'boxed-layout relative p-12! rounded-2xl' => $boxedLayout, // Override padding for boxed layout
	
		// Background
		$getBackgroundColourClass() => $backgroundColour && $boxedLayout, // Background class for boxed layout
	])>
		{{ $slot }}
	</div>

	@if ($backgroundImage)
		<div class="absolute inset-0 hidden md:block">
			{!! wp_get_attachment_image($backgroundImage, 'full', false, [
			    'class' => 'w-full h-full object-cover',
			    'loading' => 'lazy',
			]) !!}
		</div>
	@endif

	@if ($backgroundImageMobile)
		<div class="absolute inset-0 md:hidden">
			{!! wp_get_attachment_image($backgroundImageMobile, 'full', false, [
			    'class' => 'w-full h-full object-cover',
			    'loading' => 'lazy',
			]) !!}
		</div>
	@endif

</section>
