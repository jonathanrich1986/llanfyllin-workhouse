<x-section :section_settings="$section_settings" :use_prose="true">
	@if ($subtitle)
		<p
			class="uppercase tracking-widest text-sm font-bold mb-3 font-title text-primary group-[.is-dark]/layout:text-white text-center">
			{{ $subtitle }}</p>
	@endif
	<x-title class="text-center mt-0">{{ $title }}</x-title>
	{!! $content !!}
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
		@foreach ($boxes as $box)
			@include("partials.flexible.grid.boxes.{$box_template}", ['box' => $box])
		@endforeach
	</div>
</x-section>
