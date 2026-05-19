<ul class="grid w-full text-sm text-white divide-x divide-white bg-secondary">
	@foreach ($mobileMenu as $item)
		@php
			$currentDepth = $depth ?? 0;
			$template = 'partials.menu-mobile.item-default';

			if ($currentDepth === 0) {
			    $template = 'partials.menu-mobile.item-top-level';
			}
			if ($currentDepth > 0) {
			    $template = 'partials.menu-mobile.item-submenu';
			}
			if ($item->children) {
			    $template = 'partials.menu-mobile.item-dropdown';
			}
		@endphp

		@include($template, ['item' => $item, 'depth' => $currentDepth])
	@endforeach
</ul>
