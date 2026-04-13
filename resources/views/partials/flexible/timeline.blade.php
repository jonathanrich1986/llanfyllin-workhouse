<x-section :useProse="true">
	{{-- Header Logic --}}
	@if ($subtitle)
		<p class="uppercase tracking-widest text-sm font-bold mb-3 font-title text-primary text-center">{{ $subtitle }}</p>
	@endif
	<x-title size="{{ $titleSize ?? 'medium' }}" class="text-center mt-0">{{ $title }}</x-title>
	{!! $content !!}

	<div class="relative mt-12">
		{{-- Vertical Line --}}
		<div class="hidden md:block absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-0.5 bg-primary/20"></div>

		{{-- The Grid Container --}}
		<div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] gap-y-12 items-start">
			@foreach ($items as $item)
				@php $isLeft = $loop->odd; @endphp

				{{-- Left Column --}}
				<div class="hidden md:block {{ $isLeft ? 'text-right pr-10' : '' }}">
					@if ($isLeft)
						@include('partials.flexible.timeline.timeline-card', ['item' => $item, 'isLeft' => true])
					@endif
				</div>

				{{-- Center Column (The Dot) --}}
				<div class="relative flex justify-center z-10">
					<div
						class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white font-bold shadow font-title mt-6">
						{{ $loop->iteration }}
					</div>
				</div>

				{{-- Right Column --}}
				<div class="pl-10 md:pl-10 {{ !$isLeft ? 'text-left' : '' }}">
					@if (!$isLeft)
						@include('partials.flexible.timeline.timeline-card', ['item' => $item, 'isLeft' => false])
					@else
						{{-- Mobile fallback: show card on right for all items on small screens --}}
						<div class="md:hidden">
							@include('partials.flexible.timeline.timeline-card', ['item' => $item, 'isLeft' => false])
						</div>
					@endif
				</div>
			@endforeach
		</div>
	</div>
</x-section>
