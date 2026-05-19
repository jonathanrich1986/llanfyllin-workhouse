<ul
	class="submenu nav-depth-{{ $depth ?? 0 }} relative transition-all bg-secondary-darker min-w-45 py-1 z-50 text-center mt-2">
	@foreach ($navigation as $item)
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
