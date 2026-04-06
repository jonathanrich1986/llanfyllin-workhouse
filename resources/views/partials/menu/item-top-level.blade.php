<li
	class="top-level-item flex-1 transition-colors hover:bg-secondary-darker [&.highlight]:text-white [&.highlight]:font-bold [&.highlight]:bg-primary [&.highlight]:hover:bg-primary-lighter {{ $item->classes }} {{ $item->active ? 'active' : '' }}">
	<a href="{{ $item->url }}"
		class="flex items-center justify-center h-full py-2 px-4  transition-colors whitespace-nowrap">
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
