<li
	class="top-level-item flex-1 transition-colors  [&.highlight]:text-white [&.highlight]:font-bold [&.highlight]:bg-primary [&.highlight]:hover:bg-primary-lighter {{ $item->classes }} {{ $item->active ? 'active' : '' }}">

	@if (!$item->children)
		<a href="{{ $item->url }}"
			class="flex items-center justify-center h-full py-2 px-4  transition-colors whitespace-nowrap">
			{{ $item->label }}
		</a>
	@endif

	@if ($item->children)
		<details class="flex items-center justify-center h-full py-2 px-4  transition-colors whitespace-nowrap">
			{{ $item->label }}

			<summary>

				{{-- Recursion happens here --}}
				@include('partials.menu-mobile.submenu', [
					'navigation' => $item->children,
					'depth' => $depth + 1,
				])

			</summary>

		</details>
	@endif
</li>
