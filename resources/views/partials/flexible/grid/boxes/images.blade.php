<div class="self-center aspect-video">
	@if ($box['image'])
		{!! wp_get_attachment_image($box['image'], 'full', false, [
		    'class' => 'w-full h-auto object-contain m-0 aspect-video',
		    'loading' => 'lazy',
		]) !!}
	@endif
	@if ($box['title'])
		<h3 class="text-xl font-bold text-stone-900 my-4">{{ $box['title'] }}</h3>
	@endif
	@if ($box['content'])
		<div class="text-sm text-stone-700 my-4">
			{!! $box['content'] !!}
		</div>
	@endif
</div>
