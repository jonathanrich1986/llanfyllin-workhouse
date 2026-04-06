<a href="{{ $event['url'] }}"
	class="not-prose bg-stone-50 border transform-gpu border-stone-200 no-child-margin relative overflow-clip aspect-2/3 flex items-end group/card duration-300 transition-all hover:scale-[1.02] shadow-xs hover:shadow-xl/30">
	@if ($event['featured_image'])
		{!! wp_get_attachment_image($event['featured_image']['id'], 'portrait', false, [
		    'class' => 'absolute inset-0 w-full h-full object-cover',
		]) !!}
	@endif
	<div
		class="relative z-20 overflow-clip text-white text-left p-6 flex flex-col w-full no-child-margin is-dark backdrop-blur-xs">
		<h3 class="text-lg font-bold mb-4 text-white text-shadow-lg/20 font-title">{!! $event['title'] !!}</h3>
		<div class="text-xs  text-shadow-md/10 opacity-90 line-clamp-3 font-bold">
			{!! $event['content'] !!}
		</div>
	</div>
	<div class="bg-linear-to-b from-transparent to-secondary absolute left-0 right-0 bottom-0 h-1/3"></div>
	<div
		class="absolute top-0 left-0 px-6 py-3 text-white text-shadow-lg/20 z-30 text-sm bg-secondary/50 backdrop-blur-sm font-bold uppercase rounded-br-2xl grid place-items-center [&>.date-range]:text-xl [&>.date-range]:capitalize">
		{!! $event['date_text'] !!}
	</div>
</a>
