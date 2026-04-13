<footer class="">
	<x-section contentWidth="default" :useProse="true" backgroundColour="tertiary" class="pb-0" padding="small">
		<div class="grid md:grid-cols-3 gap-8 mb-8">
			<div class="no-child-margin">
				<x-logo class="mb-4" type="white" class="w-24 h-auto" />
				<x-address format="list" />
			</div>
			<div class=" no-child-margin">
				<h4 class="text-white font-bold mb-3">Quick Links</h4>
				<ul class="space-y-2 text-sm">
					<li><a href="#home" class="hover:text-primary-300 transition-colors">Home</a></li>
					<li><a href="#newsletter" class="hover:text-primary-300 transition-colors">Newsletter</a></li>
					<li><a href="#history-centre" class="hover:text-primary-300 transition-colors">History Centre</a></li>
					<li><a href="#bunkhouse" class="hover:text-primary-300 transition-colors">Bunkhouse</a></li>
					<li><a href="#events" class="hover:text-primary-300 transition-colors">Events</a></li>
					<li><a href="#contact" class="hover:text-primary-300 transition-colors">Contact Us</a></li>
					<li><a href="#membership" class="hover:text-primary-300 transition-colors">Membership / Donate</a></li>
				</ul>
			</div>
			<div class="no-child-margin">
				<h4 class="text-white font-bold mb-3">Support the Workhouse</h4>
				<p class="text-sm leading-relaxed mb-4">
					The workhouse relies on admission fees, donations, and the time of dedicated volunteers.
					If you would like to support our work, please get in touch.
				</p>
				<a href="#contact"
					class="inline-block bg-primary-500 hover:bg-primary-400 text-stone-900 font-bold text-sm px-5 py-2 rounded transition-colors">
					Get Involved
				</a>
			</div>
		</div>
		<div
			class="text-stone-400 border-t border-slate-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm">
			<p>© {{ date('Y') }} Llanfyllin Workhouse Heritage Centre. All rights reserved.</p>
			<p class="text-xs">
				Website by <a href="https://www.lonelytree.co.uk"
					class="font-bold transition-colors bg-linear-to-br from-secondary to-primary bg-clip-text text-transparent"
					target="_blank">Lonely Tree Media</a>
			</p>
		</div>
	</x-section>

</footer>
