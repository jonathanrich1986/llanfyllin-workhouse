{{-- content-event.blade.php --}}
<article @php(post_class('h-entry bg-light-grey p-6 rounded-lg shadow-md'))>
	<header>
		@if ($event['date_text'])
			<p class="text-xl text-primary font-bold m-0! font-title">
				{!! $event['date_text'] !!}
			</p>
		@endif
		<x-title class="entry-title p-name mt-0">
			{!! $event['title'] !!}
		</x-title>

		@if ($event['featured_image'])
			<a class="relative w-full aspect-square overflow-hidden rounded-lg mb-4 block" href="{{ $event['url'] }}">
				{!! wp_get_attachment_image($event['featured_image']['id'], 'portrait', false, [
				    'class' => 'w-full h-full object-cover m-0!',
				]) !!}
			</a>
		@endif


	</header>

	<div class="e-content no-child-margin text-sm">
		@php(the_excerpt())
	</div>
	<a href="{{ $event['url'] }}" class="mt-4 inline-block text-primary font-bold">
		Read more
	</a>
</article>
