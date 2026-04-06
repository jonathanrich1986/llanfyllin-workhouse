<header class="bg-white sticky top-0 z-50 shadow-lg">
	<div class="text-center flex py-3 gap-2 justify-center-safe" href="{{ home_url('/') }}">
		<x-logo type="icon" class="h-auto max-h-12 w-auto" />
		<div class="">
			<p class="text-3xl font-bold font-title text-secondary">{!! $siteName !!}</p>
			@if (!empty($tagline))
				<p class="tagline text-primary block font-title uppercase font-bold text-xs">{!! $tagline !!}</p>
			@endif
		</div>

	</div>

	<nav class="nav-primary">
		@include('partials.menu.navigation')
	</nav>
</header>
