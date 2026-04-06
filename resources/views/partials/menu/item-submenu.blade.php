<li class="submenu-item {{ $item->classes }} {{ $item->active ? 'active' : '' }}">
	<a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-secondary transition-colors">
		{{ $item->label }}
	</a>

	@if ($item->children)
		{{-- Recursion happens here --}}
		@include('partials.menu.submenu', [
			'navigation' => $item->children,
			'depth' => $depth + 1,
		])
	@endif
</li>
