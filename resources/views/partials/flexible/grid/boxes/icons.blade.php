<div
	class="bg-stone-50 border border-stone-200 rounded-2xl p-8 flex flex-col items-center text-center not-prose text-stone-900">
	<div class="w-12 h-12 text-2xl bg-primary-darker rounded-xl flex items-center justify-center mb-4 text-white">
		@if ($box['icon'])
			{!! $box['icon'] !!}
		@endif
	</div>
	<h3 class="text-xl font-bold  my-4!">{!! $box['title'] !!}</h3>
	<div class="text-sm no-child-margin">
		{!! $box['content'] !!}
	</div>
</div>
