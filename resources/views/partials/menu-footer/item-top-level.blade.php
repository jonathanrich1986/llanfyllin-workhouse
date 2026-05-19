<li class="{{ $item->classes }} {{ $item->active ? 'active' : '' }}">
	<a href="{{ $item->url }}" class="hover:text-primary transition-colors">
		{{ $item->label }}
	</a>

	@if ($item->children)
		{{-- Recursion happens here --}}
		@include('partials.menu-footer.submenu', [
			'navigation' => $item->children,
			'depth' => $depth + 1,
		])
	@endif
</li>
