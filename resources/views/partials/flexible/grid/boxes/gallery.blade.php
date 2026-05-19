<a class="self-center aspect-video block" href="{!! wp_get_attachment_url($box['image']) !!}" data-fancybox="gallery"
	data-caption="{{ $box['caption'] ?? '' }}">
	@if ($box['image'])
		{!! wp_get_attachment_image($box['image'], 'full', false, [
		    'class' => 'w-full h-auto object-contain m-0 aspect-video',
		    'loading' => 'lazy',
		]) !!}
	@endif
</a>
