<x-section :section_settings="$section_settings" :use_prose="true" class="text-center">
	@if ($subtitle)
		<p
			class="uppercase tracking-widest text-sm font-bold mb-3 font-title text-primary group-[.is-dark]/layout:text-white text-center">
			{{ $subtitle }}</p>
	@endif
	<x-title class="text-center mt-0">{{ $title }}</x-title>
	{!! $content !!}
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
		@foreach ($events['events'] as $event)
			@if (!$event['is_featured'])
				@continue
			@endif
			@include("partials.flexible.events.card-{$card_template}", ['event' => $event])
		@endforeach
	</div>
	<x-button :tag="'a'" colour="primary" style="solid" size="md" :url="$archive_url" class="mt-12">
		View all events
	</x-button>
</x-section>
