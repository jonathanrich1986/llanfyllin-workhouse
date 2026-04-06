@if (!empty($title) && !$page_settings['hide_header'])
	<header
		class="page-header relative pb-gutter mt-12 md:mt-0 text-white before:absolute before:inset-0 before:hidden lg:flex lg:min-h-[40svh] lg:items-center lg:justify-center lg:py-12 lg:before:z-10 lg:before:block before:bg-linear-to-r {!! $page_settings['header_text_position'] === 'left'
		    ? 'before:from-black/80 before:to-black/20 before:from-20% before:to-80%'
		    : 'before:from-black/20 before:to-black/80 before:from-20% before:to-80%' !!}">
		@if ($page_settings['header_image'] || $page_settings['header_image_mobile'])
			<div class="{!! $page_settings['header_image_classes'] !!}
		relative">
				@if ($page_settings['header_image'])
					{!! wp_get_attachment_image($page_settings['header_image']['id'], 'full', false, [
					    'class' => 'absolute w-full h-full object-cover object-center hidden lg:block',
					    'loading' => 'lazy',
					]) !!}
				@endif
				@if ($page_settings['header_image_mobile'])
					{!! wp_get_attachment_image($page_settings['header_image_mobile']['id'], 'full', false, [
					    'class' => 'absolute w-full h-full object-cover object-center lg:hidden',
					    'loading' => 'lazy',
					]) !!}
				@endif
			</div>
			<div
				class="lg:max-w-6xl relative z-20 block flex-1 grid-cols-2 bg-slate-800 text-white lg:grid lg:bg-transparent lg:py-0">
				<div class="relative z-10 {!! $page_settings['header_text_position'] === 'left' ? 'col-[1/2] text-left' : 'col-[2/3] text-right' !!}">
					<x-title tag="h1" size="large" class="text-shadow-lg/30">{{ $title }}</x-title>
					@if ($page_settings['header_text'])
						<div class="no-child-margin prose-lg max-w-none text-pretty text-lg text-shadow-lg/30">
							{!! $page_settings['header_text'] !!}
						</div>
					@endif
				</div>
			</div>
		@else
			<x-title tag="h1" size="large" class="mb-0 text-center">{{ $title }}</x-title>
		@endif
	</header>
@endif
