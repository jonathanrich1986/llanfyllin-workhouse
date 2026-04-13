@if ($address)
	<div class="address">
		@if ($format === 'list')
			<ul class="not-prose">
				@if ($addressLines)
					<li class="flex">
						@php echo wr_icon('location-dot', ['style' => 'solid'], ['class' => 'text-primary mt-[0.35rem] mr-2 flex-shrink-0']) @endphp
						<ul>
							@foreach ($addressLines as $line)
								<li>{{ $line }}</li>
							@endforeach
						</ul>
					</li>
				@endif

				@if ($phone)
					<li class="flex mt-2">
						@php echo wr_icon('phone', ['style' => 'solid'], ['class' => 'text-primary mt-[0.35rem] mr-2 flex-shrink-0']) @endphp
						<a href="tel:{{ preg_replace('/\D+/', '', $phone) }}">{{ $phone }}</a>
					</li>
				@endif

				@if ($email)
					<li class="flex mt-2">
						@php echo wr_icon('envelope', ['style' => 'solid'], ['class' => 'text-primary mt-[0.35rem] mr-2 flex-shrink-0']) @endphp
						<a href="mailto:{{ $email }}">{{ $email }}</a>
					</li>
				@endif
			</ul>
		@else
			{!! nl2br(e(implode("\n", $addressLines))) !!}
		@endif
	</div>
@endif
