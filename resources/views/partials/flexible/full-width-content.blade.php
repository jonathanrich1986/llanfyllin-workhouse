<x-section :useProse="true">
	@if ($subtitle)
		<p class="uppercase tracking-widest text-sm font-bold mb-3 font-title text-primary group-[.is-dark]/layout:text-white">
			{{ $subtitle }}</p>
	@endif
	<x-title class="mt-0" size="{{ $titleSize ?? 'medium' }}">{{ $title }}</x-title>
	@if ($content)
		<div class="[&>p]:first:text-xl [&>p]:first:text-leading-relaxed no-child-margin">
			{!! $content !!}
		</div>
	@endif
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
