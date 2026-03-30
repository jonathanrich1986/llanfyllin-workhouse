@extends('layouts.app')

@section('content')
	@while (have_posts())
		@php(the_post())
		@include('partials.page-header')
		@includeFirst(['partials.content-page', 'partials.content'])
		@if (have_rows('page_layouts'))
			@while (have_rows('page_layouts'))
				@php(the_row())
				@include('partials.flexible.' . get_row_layout())
			@endwhile
		@endif
	@endwhile
@endsection
