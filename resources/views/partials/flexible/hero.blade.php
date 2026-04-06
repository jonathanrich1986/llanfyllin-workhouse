<x-section :section_settings="$section_settings" :use_prose="true" class="h-[75vh]"
	inner_class="text-center flex flex-col justify-center items-center">
	@if ($subtitle)
		<p
			class="uppercase tracking-widest text-base font-bold mb-3 font-title text-primary group-[.is-dark]/layout:text-white">
			{{ $subtitle }}</p>
	@endif
	<x-title :size="$title_size" class="mt-0">{{ $title }}</x-title>
	{!! $content !!}
	@if ($buttons)
		<div class="flex flex-wrap justify-center gap-4 mt-8">
			@foreach ($buttons as $button)
				<x-button :tag="'a'" :colour="$button['colour']" :style="$button['style']" :size="$button['size']" :url="$button['url']">
					{{ $button['content'] }}
				</x-button>
			@endforeach
		</div>
	@endif
</x-section>
