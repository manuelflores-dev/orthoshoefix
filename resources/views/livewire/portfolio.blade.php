<div class="bg-white">
    {{-- Header --}}
    <header class="bg-white border-b border-zinc-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-950 text-white font-extrabold">O</span>
                <span class="text-2xl font-bold text-blue-950 font-['Playfair_Display']">OrthoshoeFix</span>
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-slate-600 font-medium hover:text-blue-950 hidden sm:block">
                    Back to home
                </a>
                <a href="{{ auth()->check() ? route('orders.create') : route('register') }}"
                   class="inline-flex bg-blue-950 hover:bg-blue-900 text-white font-semibold px-6 py-2 rounded-lg transition-colors">
                    Start Your Order
                </a>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="bg-slate-100 py-16 border-b border-zinc-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <div class="text-amber-500 font-bold tracking-widest uppercase text-sm mb-3">Our Work</div>
            <h1 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">Full Portfolio</h1>
            <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Every case below is real work from our Michigan studio: medical modifications integrated
                without compromising the original shoe.
            </p>
        </div>
    </section>

    {{-- Cases --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            @if ($this->items->isEmpty())
                <div class="text-center py-16">
                    <h2 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Coming soon</h2>
                    <p class="text-slate-600 mb-8">
                        We are putting our latest cases together. In the meantime, tell us what your shoes need.
                    </p>
                    <a href="{{ route('home') }}#contact"
                       class="inline-block bg-amber-500 hover:bg-amber-400 text-white font-bold px-8 py-3 rounded-lg shadow-md transition-colors">
                        Get in touch
                    </a>
                </div>
            @else
                @foreach ($this->wideItems as $item)
                    <x-portfolio.process-card :item="$item" />
                @endforeach

                @if ($this->gridItems->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($this->gridItems as $item)
                            <x-portfolio.before-after-card :item="$item" />
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-blue-950 py-16">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white font-['Playfair_Display'] mb-4">
                Want the same for your shoes?
            </h2>
            <p class="text-blue-100 mb-8 text-lg">
                Send us your case and we will confirm the price and the pickup date.
            </p>
            <a href="{{ auth()->check() ? route('orders.create') : route('register') }}"
               class="inline-block bg-amber-500 hover:bg-amber-400 text-white font-bold text-lg px-10 py-4 rounded-lg shadow-lg transition-colors">
                Start Your Order
            </a>
        </div>
    </section>
</div>
