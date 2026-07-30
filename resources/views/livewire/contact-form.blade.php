<div x-data x-on:contact-prefill.window="$wire.selectService($event.detail); $el.scrollIntoView({ behavior: 'smooth', block: 'center' })">
    <h3 class="text-2xl font-bold text-blue-950 mb-8 font-['Playfair_Display']">Send us a Message</h3>

    @if ($sent)
        <div class="rounded-2xl border border-green-200 bg-green-50 p-8 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-green-100">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="text-xl font-bold text-blue-950 mb-2">Message sent</div>
            <p class="text-slate-600 mb-6">
                Thanks for reaching out. We usually reply within one business day. If it is urgent,
                call us at (800) 555-0199.
            </p>
            <button type="button" wire:click="sendAnother"
                    class="text-blue-900 font-bold bg-blue-50 hover:bg-blue-100 px-6 py-2.5 rounded-lg transition-colors">
                Send another message
            </button>
        </div>
    @else
        <form wire:submit="send" class="space-y-6">
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="contact-name" class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                    <input id="contact-name" wire:model="name" type="text" placeholder="Your full name"
                           class="w-full border border-slate-300 bg-slate-50 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact-email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="contact-email" wire:model="email" type="email" placeholder="your@email.com"
                           class="w-full border border-slate-300 bg-slate-50 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="contact-phone" class="block text-sm font-medium text-slate-700 mb-1">
                            Phone <span class="text-slate-400 font-normal">(optional)</span>
                        </label>
                        <input id="contact-phone" wire:model="phone" type="tel" placeholder="(313) 555-0123"
                               class="w-full border border-slate-300 bg-slate-50 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500" />
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact-service" class="block text-sm font-medium text-slate-700 mb-1">
                            I'm interested in
                        </label>
                        <select id="contact-service" wire:model="service"
                                class="w-full border border-slate-300 bg-slate-50 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Choose a service…</option>
                            @foreach ($this->services() as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('service')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="contact-message" class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                    <textarea id="contact-message" wire:model="message" placeholder="How can we help you?" rows="4"
                              class="w-full border border-slate-300 bg-slate-50 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"></textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" wire:loading.attr="disabled" wire:target="send"
                        class="w-full bg-amber-500 hover:bg-amber-400 disabled:opacity-60 text-white font-bold text-lg py-3 rounded-lg shadow-md hover:-translate-y-0.5 transition-transform">
                    <span wire:loading.remove wire:target="send">Send Message</span>
                    <span wire:loading wire:target="send">Sending…</span>
                </button>
            </div>
        </form>
    @endif
</div>
