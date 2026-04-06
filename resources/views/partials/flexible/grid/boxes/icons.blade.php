<div class="bg-stone-50 border border-stone-200 rounded-2xl p-8">
	<div class="w-12 h-12 text-2xl bg-primary-darker rounded-xl flex items-center justify-center mb-4 text-white">
		@if ($box['icon'])
			{!! $box['icon'] !!}
		@endif
	</div>
	<h3 class="text-xl font-bold text-stone-900 my-4!">{!! $box['title'] !!}</h3>
	<div class="text-sm text-stone-700 no-child-margin">
		{!! $box['content'] !!}
	</div>
</div>
