@extends('layouts.app')

@section('content')
	@include('partials.page-header')

	@if (!have_posts())
		<x-alert type="warning">
			{!! __('Sorry, no results were found.', 'sage') !!}
		</x-alert>

		{!! get_search_form(false) !!}
	@endif
	<script async src="https://js.stripe.com/v3/pricing-table.js"></script>
	<stripe-pricing-table pricing-table-id="prctbl_1TCkWwI23MJn7dA2xMsmEt1J"
		publishable-key="pk_live_rlBpiAEkT5ZTkxXPm2guGuox">
	</stripe-pricing-table>
	@while (have_posts())
		@php(the_post())
		@includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
	@endwhile

	{!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
	@include('sections.sidebar')
@endsection
