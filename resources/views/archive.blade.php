@extends('layouts.app')

@section('content')
	@include('partials.page-header')

	<x-section :useProse="true">
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
			@while (have_posts())
				@php(the_post())
				@includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
			@endwhile
		</div>
	</x-section>

	{!! get_the_posts_navigation() !!}
@endsection
