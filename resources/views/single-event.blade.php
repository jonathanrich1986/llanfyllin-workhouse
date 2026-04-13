@extends('layouts.app')

@section('content')
	@include('partials.page-header')

	@if (!have_posts())
		<x-alert type="warning">
			{!! __('Sorry, no results were found.', 'sage') !!}
		</x-alert>

		{!! get_search_form(false) !!}
	@endif

	@while (have_posts())
		@php(the_post())
		{{-- Flexible Content --}}
		@if (have_rows('page_layouts'))
			@while (have_rows('page_layouts'))
				@php(the_row())
				@include('partials.flexible.' . get_row_layout())
			@endwhile
		@endif
	@endwhile

@endsection
