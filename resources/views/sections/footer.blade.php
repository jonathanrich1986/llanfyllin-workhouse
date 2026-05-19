<footer class="">
	<x-section contentWidth="default" :useProse="true" backgroundColour="tertiary" class="pb-0" padding="small">
		<div class="grid sm:grid-cols-3 gap-8 mb-8">
			<div class="no-child-margin grid gap-4 justify-center">
				<x-logo class="mb-4" type="white" class="w-24 h-auto m-auto sm:m-0" />
				<x-address format="list" />
			</div>
			<div class="no-child-margin flex flex-col gap-4 justify-start items-center sm:items-start text-center sm:text-left">
				<h4 class="text-white font-bold mb-3 text-center sm:text-left flex-0">Quick Links</h4>
				<nav class="nav-primary">
					@include('partials.menu-footer.navigation')
				</nav>
			</div>
			<div class="no-child-margin flex flex-col gap-4 items-center md:items-start text-center sm:text-left">
				<h4 class="text-white font-bold mb-3 ">Support the Workhouse</h4>
				<p class="text-sm leading-relaxed mb-4">
					The workhouse relies on admission fees, donations, and the time of dedicated volunteers.
					If you would like to support our work, please get in touch.
				</p>
			</div>
		</div>
		<div
			class="text-stone-400 border-t border-slate-800 pt-6 flex flex-col sm:flex-row justify-between items-center sm:gap-4 text-sm">
			<p class="text-center sm:text-left">© {{ date('Y') }} Llanfyllin Workhouse Heritage Centre. All rights reserved.
			</p>
			<p class="text-xs text-center sm:text-right">
				Website by <a href="https://www.lonelytree.co.uk"
					class="font-bold transition-colors bg-linear-to-br from-secondary to-primary bg-clip-text text-transparent"
					target="_blank">Lonely Tree Media</a>
			</p>
		</div>
	</x-section>

</footer>
