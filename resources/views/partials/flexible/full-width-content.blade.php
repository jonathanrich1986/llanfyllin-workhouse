<x-section :section_settings="$section_settings" :use_prose="true">
	@if ($subtitle)
		<h2 class="uppercase tracking-widest text-sm font-medium mb-3">{{ $subtitle }}</h2>
	@endif
	<h1 class="text-4xl md:text-5xl font-bold mb-6">{{ $title }}</h1>
	{!! $content !!}
</x-section>
