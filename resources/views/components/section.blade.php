@if ($getCustomCss())
	<style>
		{!! $getCustomCss() !!}
	</style>
@endif

<section
	{{ $attributes->class([
	    'page-section relative grid md:flex group/layout',
	    $customClasses, // Add custom classes if provided
	    'is-dark' => $hasDarkBackground(),
	
	    // Padding logic
	    'pt-0' => $paddingTop === 'none',
	    'pt-4 md:pt-8' => $paddingTop === 'small',
	    'pt-8 md:pt-16' => $paddingTop === null || $paddingTop === 'medium',
	    'pt-16 md:pt-24' => $paddingTop === 'large',
	    'pb-0' => $paddingBottom === 'none',
	    'pb-4 md:pb-8' => $paddingBottom === 'small',
	    'pb-8 md:pb-16' => $paddingBottom === null || $paddingBottom === 'medium',
	    'pb-16 md:pb-24' => $paddingBottom === 'large',
	
	    // Margin logic
	    'mt-0' => $marginTop === 'none' || $marginTop === null,
	    'mt-8' => $marginTop === 'small',
	    'mt-16' => $marginTop === 'medium',
	    'mt-24' => $marginTop === 'large',
	    'mb-0' => $marginBottom === 'none' || $marginBottom === null,
	    'mb-8' => $marginBottom === 'small',
	    'mb-16' => $marginBottom === 'medium',
	    'mb-24' => $marginBottom === 'large',
	
	    // Height logic
	    'h-auto' => $height === 'default' || $height === null,
	    'aspect-square md:aspect-video 2xl:aspect-auto 2xl:h-screen 2xl:max-h-[75svh]' => $height === 'hero',
	    'h-[calc(100svh-7rem)]' => $height === 'full', // Screen height minus h-28
	
	    // Background
	    $getBackgroundColourClass() => $backgroundColour && !$boxedLayout,
	
	    // Background gradient if there is an image and is not a boxed layout
	    $getBackgroundGradientClass(),
	
	    'max-md:pt-0!' => $backgroundImage && !$keepBgBehindContentOnMobile,
	]) }}
	id="{{ $layoutId }}">

	<div @class([
		'page-section-inner relative w-full z-20 mx-auto flex',
	
		// Content width logic
		'max-w-[90vw] xl:max-w-6xl' =>
			$contentWidth === 'default' ||
			$contentWidth === null ||
			$contentWidth === 'thin' ||
			$contentWidth === 'narrow',
		'max-w-none' => $contentWidth === 'full',
	
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
	
		// Order
		'order-1 md:order-none' => !$keepBgBehindContentOnMobile, // Ensure content is above background on mobile when a mobile-specific background image is set
	])>

		<div @class([
			'page-section-container w-full no-child-margin relative',
			'prose max-w-none' => $useProse,
			'prose-invert' => $useProse && $hasDarkBackground(),
		
			// Content width logic
			'max-w-[90vw] md:max-w-xl text-balance' => $contentWidth === 'narrow',
			'max-w-[90vw] lg:max-w-4xl text-balance' => $contentWidth === 'thin',
			'max-w-none' =>
				$contentWidth === 'full' ||
				$contentWidth === 'default' ||
				$contentWidth === null,
		
			// Boxed layout overrides
			'boxed-layout relative p-12! rounded-2xl' => $boxedLayout, // Override padding for boxed layout
		
			// Background
			$getBackgroundColourClass() => $backgroundColour && $boxedLayout, // Background class for boxed layout
		
			// Text alignment
			'text-center! md:text-left' =>
				($contentPosition === 'left' ||
					$contentPosition === 'top_left' ||
					$contentPosition === 'bottom_left') &&
				!$boxedLayout,
			'text-center!' =>
				($contentPosition === 'centre' ||
					$contentPosition === 'top' ||
					$contentPosition === 'bottom' ||
					$contentPosition === null) &&
				!$boxedLayout &&
				($contentWidth === 'narrow' || $contentWidth === 'thin'),
			'text-center! md:text-right!' =>
				($contentPosition === 'right' ||
					$contentPosition === 'top_right' ||
					$contentPosition === 'bottom_right') &&
				!$boxedLayout &&
				($contentWidth === 'narrow' || $contentWidth === 'thin'),
		
			'text-center' => $boxedLayout, // Center text for boxed layout regardless of content position
		])>
			{{ $slot }}
		</div>

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
		<div @class([
			'aspect-square',
			'relative inset-0 md:hidden' => !$keepBgBehindContentOnMobile,
			'absolute inset-0 md:hidden' => $keepBgBehindContentOnMobile,
		])>
			{!! wp_get_attachment_image($backgroundImageMobile, 'full', false, [
			    'class' => 'w-full h-full object-cover',
			    'loading' => 'lazy',
			]) !!}
		</div>
	@endif

</section>
