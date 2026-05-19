@extends('layouts.app')

@section('content')
	@include('partials.page-header')

	<x-section :useProse="true">
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
			@foreach ($events['events'] as $event)
				@include('partials.content-event', ['event' => $event])
			@endforeach
		</div>
	</x-section>

	{!! get_the_posts_navigation() !!}
@endsection
