@if (!empty($title) && !$page_settings['hide_header'])
	<header @class(['page-header relative py-16'])>
		<x-title tag="h1" size="large" class="mb-0! text-center">{!! wp_kses_post($page_settings['custom_page_title'] ?: $title) !!}</x-title>
	</header>
@endif
