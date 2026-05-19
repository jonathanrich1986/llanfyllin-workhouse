@if (!empty($products))
	<div class="membership-form max-w-2xl mx-auto">
		<p class="mb-6 text-gray-700"><strong>What type of membership would you like?</strong> (select an option below)</p>

		<form method="post" action="{{ esc_url(wc_get_cart_url()) }}" class="space-y-6">
			@php wp_nonce_field('woocommerce-add-to-cart'); @endphp

			<div class="grid gap-4">
				@foreach ($products as $product)
					@php
						$is_first = $loop->first;
						$product_id = $product->get_id();
					@endphp

					<label
						class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm hover:border-primary/80 transition">
						<input type="radio" name="add-to-cart" value="{{ $product_id }}" class="sr-only peer"
							data-min-price="{{ $product->get_price() }}" {{ $is_first ? 'checked' : '' }}>

						<div class="flex flex-1 items-center justify-between">
							<div>
								<span class="block text-sm font-bold text-gray-900">{{ $product->get_name() }}</span>
								<span class="mt-1 block text-xs text-gray-500 italic">
									{!! strip_tags($product->get_short_description()) !!}
								</span>
							</div>
							<div class="text-sm font-bold text-primary">
								{!! $product->get_price_html() !!}
							</div>
						</div>

						{{-- Border for selected state --}}
						<div
							class="pointer-events-none absolute -inset-px rounded-lg border-4 border-transparent peer-checked:border-primary"
							aria-hidden="true"></div>
					</label>
				@endforeach
			</div>

			{{-- Quantity Selector Section --}}
			<div class="border-t pt-6">
				<label for="quantity" class="block text-sm font-medium text-gray-700 mb-3 text-center">How many memberships are you
					purchasing?</label>

				<div class="flex items-center justify-center space-x-3" x-data="{ qty: 1 }">
					<button type="button" @click="if(qty > 1) qty--"
						class="cursor-pointer w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100 font-bold text-xl">-</button>

					<input type="number" name="quantity" x-model="qty" min="1" step="1"
						class="w-16 text-center border-gray-300 rounded-md shadow-sm focus:border-primary/50 focus:ring-primary/80 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />

					<button type="button" @click="qty++"
						class="cursor-pointer w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100 font-bold text-xl">+</button>
				</div>
			</div>

			<div class="max-w-sm mx-auto">
				<label for="custom_amount" class="block text-sm font-medium text-gray-700 mb-3 text-center">How much would you like
					to pay for each membership?</label>
				<span class="block text-xs text-gray-500 italic mb-2 text-center text-balance">The minimum amount is £<span
						class="min-price">15</span>, but you can choose to
					pay more if you'd like to support us further!</span>
				<div class="flex items-center justify-center gap-2 max-w-28 mx-auto">
					£<input type="number" name="custom_amount" id="custom_amount" min="15" step="1" value="15"
						required
						class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary/50 focus:ring-primary/80 px-4 py-2" />
				</div>
			</div>

			<div class="mt-4">
				<button type="submit"
					class="w-full cursor-pointer bg-primary text-white py-4 px-6 rounded-lg font-bold hover:bg-primary/80 transition shadow-lg uppercase tracking-wide">
					Join Now
				</button>
			</div>

			<input type="hidden" name="checkout-after-add" value="1">
		</form>
	</div>
@else
	<div class="p-6 bg-gray-50 border border-dashed border-gray-300 rounded-lg text-center">
		<p class="text-gray-600">No membership products available at this time.</p>
	</div>
@endif
