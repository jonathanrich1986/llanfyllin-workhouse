<ul class="hidden lg:flex w-full items-stretch text-sm text-white divide-x divide-white bg-secondary">
	@foreach ($navigation as $item)
		@php
			$currentDepth = $depth ?? 0;
			$template = 'partials.menu.item-default';

			if ($currentDepth === 0) {
			    $template = 'partials.menu.item-top-level';
			}
			if ($currentDepth > 0) {
			    $template = 'partials.menu.item-submenu';
			}
			if ($item->children) {
			    $template = 'partials.menu.item-dropdown';
			}
		@endphp

		@include($template, ['item' => $item, 'depth' => $currentDepth])
	@endforeach
</ul>
