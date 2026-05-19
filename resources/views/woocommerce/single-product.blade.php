{{--
The Template for displaying all single products

This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see         https://docs.woocommerce.com/document/template-structure/
@package     WooCommerce\Templates
@version     1.6.4
--}}

@extends('layouts.app')

@section('content')
	{{-- 1. WooCommerce Wrapper Start --}}
	@php do_action('woocommerce_before_main_content') @endphp

	<x-section>
		@while (have_posts())
			@php
				the_post();
				wc_get_template_part('content', 'single-product');
			@endphp
		@endwhile
	</x-section>

	{{-- 2. Flexible Content --}}
	@if (have_rows('page_layouts'))
		@while (have_rows('page_layouts'))
			@php the_row() @endphp
			@include('partials.flexible.' . get_row_layout())
		@endwhile
	@endif

	{{-- 3. WooCommerce Wrapper End --}}
	@php do_action('woocommerce_after_main_content') @endphp
@endsection
