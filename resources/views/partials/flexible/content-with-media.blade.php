<x-section :useProse="true">
	@if ($subtitle)
		<p class="uppercase tracking-widest text-sm font-bold mb-3 font-title text-primary group-[.is-dark]/layout:text-white">
			{{ $subtitle }}</p>
	@endif
	<x-title size="{{ $titleSize ?? 'medium' }}" class="mt-0">{{ $title }}</x-title>
	<div class="grid grid-cols-2 gap-gutter">
		<div class="{{ $layout === 'text-left' ? 'order-1' : 'order-2' }}">
			{!! $content !!}
			@if ($buttons)
				<div class="flex flex-wrap gap-4 mt-8">
					@foreach ($buttons as $button)
						<x-button :tag="'a'" :colour="$button['colour']" :style="$button['style']" :size="$button['size']" :url="$button['url']">
							{{ $button['content'] }}
						</x-button>
					@endforeach
				</div>
			@endif
		</div>
		<div class="{{ $layout === 'text_left' ? 'order-2' : 'order-1' }}">
			@if ($image)
				{!! wp_get_attachment_image($image['id'], 'full', false, [
				    'class' => 'w-full h-auto object-cover rounded',
				    'loading' => 'lazy',
				]) !!}
			@endif
		</div>
	</div>


</x-section>
