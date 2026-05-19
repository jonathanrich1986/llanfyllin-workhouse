@extends('layouts.app')

@section('content')
	@while (have_posts())
		@php(the_post())
		@include('partials.page-header')

		{{-- Main Content --}}
		@if (get_the_content())
			<x-section contentWidth="default" :useProse="true" paddingTop="none">
				@include('partials.content-page')
			</x-section>
		@endif

		{{-- Flexible Content --}}
		@if (have_rows('page_layouts'))
			@while (have_rows('page_layouts'))
				@php(the_row())
				@include('partials.flexible.' . get_row_layout())
			@endwhile
		@endif
	@endwhile
@endsection
