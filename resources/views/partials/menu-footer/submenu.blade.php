<ul
	class="submenu nav-depth-{{ $depth ?? 0 }} absolute top-full left-0 transition-all transition-discrete opacity-0 hidden group-hover:opacity-100 group-hover:block bg-secondary-darker shadow-xl min-w-45 py-1 z-50">
	@foreach ($navigation as $item)
		@php
			$currentDepth = $depth ?? 0;
			$template = 'partials.menu-footer.item-default';

			if ($currentDepth === 0) {
			    $template = 'partials.menu-footer.item-top-level';
			}
			if ($currentDepth > 0) {
			    $template = 'partials.menu-footer.item-submenu';
			}
			if ($item->children) {
			    $template = 'partials.menu-footer.item-dropdown';
			}
		@endphp

		@include($template, ['item' => $item, 'depth' => $currentDepth])
	@endforeach
</ul>
