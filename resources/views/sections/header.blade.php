<header class="bg-white sticky top-0 z-50 shadow-lg h-16 lg:h-28 flex lg:block items-center justify-between"
	role="banner">
	<div class="bg-white px-4 lg:px-8 h-full flex lg:block items-center justify-between z-50 w-full relative">
		<div class="absolute hidden sm:flex top-5 right-16 lg:top-6 lg:right-8 items-center gap-4">
			<a href="{!! get_permalink(wc_get_page_id('myaccount')) !!}" class="inline-flex align-center gap-1">
				{!! wr_icon('user', ['style' => 'solid'], ['class' => 'text-secondary top-1 relative']) !!} <span class="hidden sm:block">Login</span>
			</a>
			<a href="{!! get_permalink(wc_get_page_id('cart')) !!}" class="inline-flex align-center gap-1">
				{!! wr_icon('shopping-cart', ['style' => 'solid'], ['class' => 'text-secondary top-1 relative']) !!} <span class="hidden sm:block">Basket</span>
			</a>
		</div>
		<div class="text-center items-center flex py-3 gap-2 justify-center-safe" href="{{ home_url('/') }}">
			<a href="{{ home_url('/') }}" class="flex items-center gap-2">
				<x-logo type="icon" class="h-auto max-h-12 w-auto" />
				<div class="">
					<p class="text-xl lg:text-3xl font-bold font-title text-secondary">{!! $siteName !!}</p>
					@if (!empty($tagline))
						<p class="tagline text-primary hidden lg:block font-title uppercase font-bold text-xs">{!! $tagline !!}</p>
					@endif
				</div>
			</a>

		</div>

		<nav class="nav-primary hidden lg:block">
			@include('partials.menu.navigation')
		</nav>

		<div class="nav-mobile flex items-center lg:hidden h-full">
			<button class="mobile-menu-button relative w-8 h-8 flex items-center justify-center cursor-pointer">
				{!! wr_icon('bars', ['style' => 'solid'], ['class' => 'text-secondary']) !!}
			</button>
		</div>
	</div>


	<nav
		class="nav-primary-mobile fixed top-16 left-0 w-full max-h-[calc(100vh-4rem)] bg-secondary z-40 overflow-y-auto transition-transform duration-750 -translate-y-[calc(100%+4rem)] lg:hidden">
		@include('partials.menu-mobile.navigation')
	</nav>

</header>
