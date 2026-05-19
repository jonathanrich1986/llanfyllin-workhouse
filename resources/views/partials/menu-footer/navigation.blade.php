<ul class="space-y-2 text-sm my-0! not-prose">
	@foreach ($footerMenu as $item)
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
