<div
	class="bg-white rounded-xl p-6 shadow-sm border border-stone-200 inline-block max-w-lg text-left {{ $isLeft ? 'md:text-right' : 'md:text-left' }}">
	<span
		class="inline-block {{ $isLeft ? 'bg-primary' : 'bg-stone-700' }} text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
		{{ $item['date'] }}
	</span>
	<h3 class="text-xl font-bold text-stone-900 mb-2 mt-0 font-title capitalize">
		{{ $item['title'] }}
	</h3>
	<div class="text-sm text-stone-700">
		{!! $item['content'] !!}
	</div>
</div>
