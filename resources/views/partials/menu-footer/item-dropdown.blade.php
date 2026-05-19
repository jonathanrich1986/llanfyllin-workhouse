<li
	class="dropdown-item relative flex-1 group hover:bg-secondary-darker transition-all {{ $item->classes }} {{ $item->active ? 'active' : '' }}">
	<a href="{{ $item->url }}"
		class="flex items-center justify-center h-full py-2 px-4 transition-colors whitespace-nowrap">
		{{ $item->label }}
		<svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
		</svg>
	</a>

	@if ($item->children)
		{{-- Recursion happens here --}}
		@include('partials.menu-footer.submenu', [
			'navigation' => $item->children,
			'depth' => $depth + 1,
		])
	@endif
</li>
