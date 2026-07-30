<div>
    <!-- ===================== FLOATING CTA (Mobile only) ===================== -->
    <div id="floating-cta" class="fixed bottom-6 right-6 z-[100] md:hidden transition-all duration-300">
        <a href="#contact"
           class="flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white font-bold px-5 py-3.5 rounded-full shadow-2xl shadow-amber-500/40 transition-all duration-300 text-sm"
           style="animation: floatPulse 2.5s ease-in-out infinite;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Book Now
        </a>
    </div>

    <!-- ===================== HEADER ===================== -->
    <header id="main-header" class="bg-white border-b border-zinc-200 sticky top-0 z-50 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-950 text-white flex items-center justify-center rounded-sm font-bold text-xl">O</div>
                <span class="text-2xl font-extrabold text-blue-950 font-['Playfair_Display'] tracking-tight">OrthoshoeFix</span>
            </div>

            <nav class="hidden md:flex items-center gap-8 font-medium text-slate-600">
                <a href="#services" class="hover:text-blue-950 transition-colors">Services</a>
                @if (config('features.sole_lab'))
                    <a href="#soles" class="hover:text-blue-950 transition-colors">Soles</a>
                @endif
                @if ($this->portfolioItems->isNotEmpty())
                    <a href="#portfolio" class="hover:text-blue-950 transition-colors">Before & After</a>
                @endif
                <a href="#faq" class="hover:text-blue-950 transition-colors">FAQ</a>
                <a href="#testimonials" class="hover:text-blue-950 transition-colors">Testimonials</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-slate-600 font-medium hover:text-blue-950 hidden sm:block">Login</a>
                <a href="{{ route('register') }}" class="hidden md:inline-flex bg-blue-950 hover:bg-blue-900 text-white font-semibold border-transparent px-6 py-2 rounded-lg transition-colors">
                    Register
                </a>
                <!-- Mobile hamburger -->
                <button id="mobile-menu-btn" class="md:hidden flex flex-col gap-1.5 p-2 rounded-md hover:bg-slate-100 transition-colors" aria-label="Open menu">
                    <span class="hamburger-line block w-6 h-0.5 bg-slate-700 transition-all duration-300 origin-center"></span>
                    <span class="hamburger-line block w-6 h-0.5 bg-slate-700 transition-all duration-300"></span>
                    <span class="hamburger-line block w-6 h-0.5 bg-slate-700 transition-all duration-300 origin-center"></span>
                </button>
            </div>
        </div>

        <!-- Mobile dropdown menu -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-zinc-100 bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-1">
                <a href="#services" class="mobile-menu-link px-4 py-3 rounded-lg text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-950 transition-colors">Services</a>
                @if (config('features.sole_lab'))
                    <a href="#soles" class="mobile-menu-link px-4 py-3 rounded-lg text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-950 transition-colors">Soles</a>
                @endif
                @if ($this->portfolioItems->isNotEmpty())
                    <a href="#portfolio" class="mobile-menu-link px-4 py-3 rounded-lg text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-950 transition-colors">Before & After</a>
                @endif
                <a href="#faq" class="mobile-menu-link px-4 py-3 rounded-lg text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-950 transition-colors">FAQ</a>
                <a href="#testimonials" class="mobile-menu-link px-4 py-3 rounded-lg text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-950 transition-colors">Testimonials</a>
                <div class="border-t border-zinc-100 mt-2 pt-3 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="px-4 py-3 rounded-lg text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-950 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-3 rounded-lg bg-blue-950 text-white font-semibold text-center hover:bg-blue-900 transition-colors">Register</a>
                </div>
            </div>
        </div>
    </header>

    <!-- ===================== HERO SECTION ===================== -->
    <section class="relative text-white overflow-hidden py-28 lg:py-40" style="min-height: 85vh; display: flex; align-items: center;">
        <!-- Parallax Background Image -->
        <div class="absolute inset-0 z-0"
             style="background-image: url('/images/shoes/shoe-diadora.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
        </div>
        <!-- Dark overlay gradient -->
        <div class="absolute inset-0 z-1" style="background: linear-gradient(135deg, rgba(15,23,42,0.96) 0%, rgba(15,23,42,0.85) 50%, rgba(30,41,59,0.75) 100%);"></div>
        <!-- Dot pattern texture -->
        <div class="absolute inset-0 z-2 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8 text-center flex flex-col items-center">
            <div class="reveal inline-block px-4 py-1.5 rounded-full border border-blue-800 bg-blue-900/50 text-blue-200 text-sm font-semibold tracking-wide uppercase mb-8 shadow-sm">
                Certified Orthopedic Modifications
            </div>
            <h1 class="reveal reveal-delay-1 text-5xl md:text-7xl font-extrabold tracking-tight mb-6 font-['Playfair_Display'] text-white drop-shadow-md leading-tight">
                Master Craftsmanship for<br>
                <span class="hero-gradient-text">Medical Precision</span>
            </h1>
            <p class="reveal reveal-delay-2 mt-4 text-xl md:text-2xl text-blue-100 max-w-3xl mb-10 font-light leading-relaxed">
                Michigan's trusted studio for prescription shoe modifications.
                Expert sole lifts, custom orthotics, and premium shoe restoration.
            </p>
            <div class="reveal reveal-delay-3 flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ auth()->check() ? route('orders.create') : route('register') }}" class="w-full sm:w-auto font-bold text-lg px-8 py-3 bg-amber-500 hover:bg-amber-400 text-white rounded-lg shadow-lg hover:shadow-amber-500/30 transition-all hover:-translate-y-0.5 text-center">
                    Schedule Consultation
                </a>
                <a href="#portfolio" class="w-full sm:w-auto font-bold text-lg px-8 py-3 text-white border-2 border-blue-400/60 hover:border-white hover:bg-white/10 rounded-lg transition-all text-center">
                    See Our Work
                </a>
            </div>

            <!-- Scroll indicator -->
            <div class="reveal reveal-delay-4 mt-16 flex flex-col items-center gap-2 text-blue-300/70">
                <span class="text-xs font-medium tracking-widest uppercase">Scroll to explore</span>
                <div class="w-px h-10 bg-gradient-to-b from-blue-400/50 to-transparent animate-bounce"></div>
            </div>
        </div>
    </section>

    <!-- ===================== TRUST BAR / STATS ===================== -->
    <section class="bg-white border-b border-zinc-200 py-10 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-zinc-200">
                <div class="py-4 md:py-0 reveal">
                    <div class="text-4xl font-extrabold text-blue-950 mb-2">
                        <span class="counter" data-target="10000" data-suffix="+">0</span>
                    </div>
                    <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Prescriptions Met</div>
                </div>
                <div class="py-4 md:py-0 reveal reveal-delay-1">
                    <div class="text-4xl font-extrabold text-blue-950 mb-2">
                        Est. <span class="counter" data-target="1998" data-format="year">1998</span>
                    </div>
                    <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Michigan Based</div>
                </div>
                <div class="py-4 md:py-0 flex flex-col items-center justify-center reveal reveal-delay-2">
                    <div class="flex justify-center items-center gap-1 mb-2">
                        @for($i=0; $i<5; $i++)
                            <svg class="w-8 h-8 text-amber-500 drop-shadow-sm" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">5-Star Reviews</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== SPECIALIZED SERVICES ===================== -->
    <section id="services" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <div class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3">What We Do</div>
                <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">Specialized Services</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">Premium craftsmanship tailored exactly to your medical needs and personal comfort.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="reveal reveal-delay-1">
                    <flux:card class="flex flex-col h-full border-none shadow-md hover:shadow-xl transition-all duration-300 bg-white overflow-hidden group hover:-translate-y-1">
                        <div class="h-56 w-full relative overflow-hidden">
                            <img src="/images/shoes/shoe-nb-side.jpg" alt="Shoe with orthopedic modification" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-950/60 to-transparent"></div>
                            <span class="absolute bottom-3 left-4 text-white text-xs font-bold uppercase tracking-widest bg-blue-950/80 px-3 py-1 rounded">Shoe Lift</span>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="w-12 h-1 bg-amber-500 mb-4 group-hover:w-20 transition-all duration-300"></div>
                            <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Orthopedic Shoe Lifts</h3>
                            <p class="text-slate-600 mb-8 flex-1 leading-relaxed">
                                Precision sole additions prescribed by medical professionals to correct leg length discrepancies and improve posture.
                            </p>
                            <a href="#contact" x-data x-on:click="$dispatch('contact-prefill', 'Sole lifts and leg length correction')" class="w-full text-blue-900 font-bold bg-blue-50 hover:bg-blue-100 py-3 rounded-lg transition-colors text-center block">Learn More</a>
                        </div>
                    </flux:card>
                </div>

                <!-- Service 2 -->
                <div class="reveal reveal-delay-2">
                    <flux:card class="flex flex-col h-full border-none shadow-md hover:shadow-xl transition-all duration-300 bg-white overflow-hidden group hover:-translate-y-1">
                        <div class="h-56 w-full relative overflow-hidden">
                            <img src="/images/shoes/clog-smooth.jpg" alt="Medical clog with custom insole" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-950/60 to-transparent"></div>
                            <span class="absolute bottom-3 left-4 text-white text-xs font-bold uppercase tracking-widest bg-blue-950/80 px-3 py-1 rounded">Custom Insoles</span>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="w-12 h-1 bg-amber-500 mb-4 group-hover:w-20 transition-all duration-300"></div>
                            <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Custom Stitched Insoles</h3>
                            <p class="text-slate-600 mb-8 flex-1 leading-relaxed">
                                Hand-stitched, bespoke insoles designed specifically for your unique foot anatomy to provide unparalleled comfort.
                            </p>
                            <a href="#contact" x-data x-on:click="$dispatch('contact-prefill', 'Custom orthotics and insoles')" class="w-full text-blue-900 font-bold bg-blue-50 hover:bg-blue-100 py-3 rounded-lg transition-colors text-center block">Learn More</a>
                        </div>
                    </flux:card>
                </div>

                <!-- Service 3 -->
                <div class="reveal reveal-delay-3">
                    <flux:card class="flex flex-col h-full border-none shadow-md hover:shadow-xl transition-all duration-300 bg-white overflow-hidden group hover:-translate-y-1">
                        <div class="h-56 w-full relative overflow-hidden">
                            <img src="/images/shoes/shoe-diadora.jpg" alt="Sport shoe restored" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-950/60 to-transparent"></div>
                            <span class="absolute bottom-3 left-4 text-white text-xs font-bold uppercase tracking-widest bg-blue-950/80 px-3 py-1 rounded">Shoe Repair</span>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="w-12 h-1 bg-amber-500 mb-4 group-hover:w-20 transition-all duration-300"></div>
                            <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Master Shoe Repair</h3>
                            <p class="text-slate-600 mb-8 flex-1 leading-relaxed">
                                Traditional restoration services for premium footwear, seamlessly blending medical needs with original aesthetics.
                            </p>
                            <a href="#contact" x-data x-on:click="$dispatch('contact-prefill', 'Premium shoe restoration')" class="w-full text-blue-900 font-bold bg-blue-50 hover:bg-blue-100 py-3 rounded-lg transition-colors text-center block">Learn More</a>
                        </div>
                    </flux:card>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== SOLE & COLOR OPTIONS ===================== -->
    {{-- Built and tested, hidden until the shop decides to offer it: FEATURE_SOLE_LAB --}}
    @if (config('features.sole_lab'))
        <x-sole-lab />
    @endif

    <!-- ===================== WHY CHOOSE US ===================== -->
    <section class="py-24 relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);">
        <!-- Background texture -->
        <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <div class="text-amber-500 font-bold tracking-widest uppercase text-sm mb-3">Our Advantage</div>
                <h2 class="text-4xl md:text-5xl font-bold text-white font-['Playfair_Display']">Why Choose OrthoshoeFix</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
                <p class="text-lg text-blue-200 max-w-2xl mx-auto">Michigan's most trusted orthopedic shoe studio — where medical precision meets master craftsmanship.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="reveal reveal-delay-1 group bg-white/5 hover:bg-white/10 border border-white/10 hover:border-amber-500/50 rounded-2xl p-8 text-center transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/30 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-amber-500/20 transition-colors">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-['Playfair_Display']">Doctor-Prescribed Only</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">Every modification is performed according to official medical prescriptions for guaranteed safety and compliance.</p>
                </div>

                <!-- Card 2 -->
                <div class="reveal reveal-delay-2 group bg-white/5 hover:bg-white/10 border border-white/10 hover:border-amber-500/50 rounded-2xl p-8 text-center transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/30 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-amber-500/20 transition-colors">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-['Playfair_Display']">25+ Years Experience</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">Established in 1998, we have built trust across Michigan with over two decades of orthopedic shoe expertise.</p>
                </div>

                <!-- Card 3 -->
                <div class="reveal reveal-delay-3 group bg-white/5 hover:bg-white/10 border border-white/10 hover:border-amber-500/50 rounded-2xl p-8 text-center transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/30 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-amber-500/20 transition-colors">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-['Playfair_Display']">Precision Craftsmanship</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">Our master cobblers work to ±1mm tolerances on sole lift modifications, ensuring medical accuracy every time.</p>
                </div>

                <!-- Card 4 -->
                <div class="reveal reveal-delay-4 group bg-white/5 hover:bg-white/10 border border-white/10 hover:border-amber-500/50 rounded-2xl p-8 text-center transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/30 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-amber-500/20 transition-colors">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-['Playfair_Display']">Nationwide Shipping</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">We ship to all 50 states with full insurance and tracking. Your shoes are safe every step of the way.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== PRODUCT SHOWCASE / FOOTWEAR GALLERY ===================== -->
    <section class="py-24 bg-white border-t border-zinc-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <div class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3">Our Catalog</div>
                <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">Footwear We Work With</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">From athletic shoes to professional clogs — we modify any style to meet your exact medical prescription.</p>
            </div>

            <!-- Big Feature + Side Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Left: Large Feature Card -->
                <div class="reveal group relative rounded-2xl overflow-hidden shadow-lg h-96 lg:h-auto">
                    <img src="/images/shoes/shoe-diadora.jpg" alt="Diadora athletic shoe with orthopedic sole" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-950/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8">
                        <span class="inline-block bg-amber-500 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded mb-3">Featured</span>
                        <h3 class="text-2xl font-bold text-white font-['Playfair_Display'] mb-2">Athletic & Sport Shoes</h3>
                        <p class="text-blue-200 text-sm">We work with all major athletic brands — adding lifts, custom insoles, and rocker soles without losing the original look.</p>
                    </div>
                </div>

                <!-- Right: 2-row grid -->
                <div class="grid grid-rows-2 gap-6">
                    <!-- Top right -->
                    <div class="reveal reveal-delay-1 group relative rounded-2xl overflow-hidden shadow-lg">
                        <img src="/images/shoes/clog-perforated.jpg" alt="Perforated professional black clog" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700" style="max-height:220px;">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-950/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="inline-block bg-blue-900/80 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded mb-2">Professional Clogs</span>
                            <h3 class="text-xl font-bold text-white font-['Playfair_Display']">Perforated Medical Clogs</h3>
                            <p class="text-blue-200 text-sm">Ideal for healthcare workers. We add custom orthotics and arch support for all-day comfort on hard floors.</p>
                        </div>
                    </div>
                    <!-- Bottom right -->
                    <div class="reveal reveal-delay-2 group relative rounded-2xl overflow-hidden shadow-lg">
                        <img src="/images/shoes/clog-smooth.jpg" alt="Smooth non-slip professional clog" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700" style="max-height:220px;">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-950/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="inline-block bg-blue-900/80 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded mb-2">Slip-Resistant</span>
                            <h3 class="text-xl font-bold text-white font-['Playfair_Display']">Smooth Professional Clogs</h3>
                            <p class="text-blue-200 text-sm">Non-slip, waterproof clogs modified for plantar support and pressure-relief insoles.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom 2-col row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="reveal group relative rounded-2xl overflow-hidden shadow-lg h-64">
                    <img src="/images/shoes/shoe-nb-side.jpg" alt="New Balance side view with sole lift" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-950/10 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <span class="inline-block bg-blue-900/80 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded mb-2">Orthopedic Lift</span>
                        <h3 class="text-xl font-bold text-white font-['Playfair_Display']">New Balance — Sole Lift Build-Up</h3>
                        <p class="text-blue-200 text-sm">Invisible lift of up to 2" integrated into the midsole. Prescribed lift corrections with full stability.</p>
                    </div>
                </div>
                <div class="reveal reveal-delay-1 group relative rounded-2xl overflow-hidden shadow-lg h-64">
                    <img src="/images/shoes/shoe-nb-back.jpg" alt="New Balance back view heel reinforcement" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-950/10 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <span class="inline-block bg-amber-500 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded mb-2">360° View</span>
                        <h3 class="text-xl font-bold text-white font-['Playfair_Display']">Heel Counter Reinforcement</h3>
                        <p class="text-blue-200 text-sm">Structural heel support added to prevent overpronation and improve ankle stability per doctor's orders.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== BEFORE & AFTER PORTFOLIO ===================== -->
    {{-- Cases come from the portfolio manager. With none published the section is skipped
         entirely, which reads better than an empty placeholder on a live page. --}}
    @if ($this->portfolioItems->isNotEmpty())
    <section id="portfolio" class="py-24 bg-slate-50 border-t border-zinc-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 reveal">
                <div class="max-w-2xl">
                    <div class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3">Our Craftsmanship</div>
                    <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">Before & After</h2>
                    <p class="mt-4 text-lg text-slate-600">See how we flawlessly integrate medical modifications without compromising the shoe's original beauty.</p>
                </div>
                <a href="{{ route('portfolio') }}" wire:navigate class="hidden md:flex text-blue-950 border border-zinc-300 bg-white hover:bg-zinc-50 font-bold px-6 py-2.5 rounded-lg transition-colors">View Full Portfolio</a>
            </div>

            <!-- Before/After Comparison Cards -->

            @foreach ($this->portfolioWideItems as $item)
                <x-portfolio.process-card :item="$item" />
            @endforeach

            @if ($this->portfolioGridItems->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($this->portfolioGridItems as $index => $item)
                        <x-portfolio.before-after-card :item="$item" :delay="$index === 1 ? 'reveal-delay-1' : null" />
                    @endforeach
                </div>
            @endif

            <a href="{{ route('portfolio') }}" wire:navigate class="block w-full mt-8 md:hidden text-blue-950 border border-zinc-300 bg-white hover:bg-zinc-50 font-bold py-3 rounded-lg transition-colors text-center">View Full Portfolio</a>
        </div>
    </section>
    @endif

    <!-- ===================== TESTIMONIALS ===================== -->
    <section id="testimonials" class="py-24 bg-blue-950 text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <div class="text-amber-500 font-bold tracking-widest uppercase text-sm mb-3">Testimonials</div>
                <h2 class="text-4xl md:text-5xl font-bold text-white font-['Playfair_Display']">What Our Clients Say</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="reveal reveal-delay-1">
                    <flux:card class="bg-white text-slate-900 border-none shadow-xl p-8 rounded-2xl relative h-full">
                        <!-- Quote icon -->
                        <div class="absolute top-6 right-6 text-blue-100">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                        </div>
                        <div class="flex gap-1 text-amber-500 mb-6">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 italic mb-8 text-lg leading-relaxed">"OrthoshoeFix completely transformed my walking experience. The 2-inch lift they added to my dress shoes is virtually invisible. My back pain is gone and nobody can tell I'm wearing an orthotic."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                                 style="background: linear-gradient(135deg, #1e3a5f 0%, #1d4ed8 100%);">
                                S
                                <span class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                    <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </span>
                            </div>
                            <div>
                                <div class="font-bold text-blue-950">Sarah M.</div>
                                <div class="text-sm text-slate-500">Grand Rapids, MI</div>
                            </div>
                        </div>
                    </flux:card>
                </div>

                <!-- Testimonial 2 -->
                <div class="reveal reveal-delay-2">
                    <flux:card class="bg-white text-slate-900 border-none shadow-xl p-8 rounded-2xl relative h-full">
                        <div class="absolute top-6 right-6 text-blue-100">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                        </div>
                        <div class="flex gap-1 text-amber-500 mb-6">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 italic mb-8 text-lg leading-relaxed">"Professional service and amazing craftsmanship. My doctor recommended them for a complicated rocker sole modification. They handled it perfectly and the shoes look fantastic."</p>
                        <div class="flex items-center gap-4">
                            <div class="relative w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                                 style="background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);">
                                J
                                <span class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                    <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </span>
                            </div>
                            <div>
                                <div class="font-bold text-blue-950">John D.</div>
                                <div class="text-sm text-slate-500">Lansing, MI</div>
                            </div>
                        </div>
                    </flux:card>
                </div>

                <!-- Testimonial 3 -->
                <div class="reveal reveal-delay-3">
                    <flux:card class="bg-white text-slate-900 border-none shadow-xl p-8 rounded-2xl relative h-full">
                        <div class="absolute top-6 right-6 text-blue-100">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                        </div>
                        <div class="flex gap-1 text-amber-500 mb-6">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 italic mb-8 text-lg leading-relaxed">"They repaired my favorite leather boots and built in the necessary arch support my podiatrist prescribed. You can't even tell they were modified. The quality is unmatched."</p>
                        <div class="flex items-center gap-4">
                            <div class="relative w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                                 style="background: linear-gradient(135deg, #b45309 0%, #d97706 100%);">
                                M
                                <span class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                    <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </span>
                            </div>
                            <div>
                                <div class="font-bold text-blue-950">Maria G.</div>
                                <div class="text-sm text-slate-500">Detroit, MI</div>
                            </div>
                        </div>
                    </flux:card>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== HOW IT WORKS ===================== -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <div class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3">The Process</div>
                <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">How It Works</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">A seamless, professional process from medical prescription to perfect fit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <!-- Decorative connecting line (desktop only) -->
                <div class="hidden md:block absolute top-16 left-[calc(1/6*100%+2rem)] right-[calc(1/6*100%+2rem)] h-0.5 bg-gradient-to-r from-blue-200 via-amber-300 to-amber-500 z-0 step-connector"></div>

                <!-- Step 1 -->
                <div class="reveal reveal-delay-1 relative z-10 flex flex-col items-center text-center group">
                    <div class="w-32 h-32 bg-white border-4 border-blue-200 group-hover:border-blue-950 rounded-2xl flex flex-col items-center justify-center mb-6 shadow-md transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-1">
                        <svg class="w-10 h-10 text-blue-950 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-xs font-bold text-blue-400 uppercase tracking-wider">Step 1</span>
                    </div>
                    <div class="w-8 h-8 bg-blue-950 text-white rounded-full flex items-center justify-center text-sm font-extrabold mb-4 -mt-2">1</div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Get Prescription</h3>
                    <p class="text-slate-600 leading-relaxed">Consult your doctor or podiatrist to receive your specific orthopedic requirements and official prescription.</p>
                </div>

                <!-- Step 2 -->
                <div class="reveal reveal-delay-2 relative z-10 flex flex-col items-center text-center group">
                    <div class="w-32 h-32 bg-white border-4 border-blue-200 group-hover:border-blue-950 rounded-2xl flex flex-col items-center justify-center mb-6 shadow-md transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-1">
                        <svg class="w-10 h-10 text-blue-950 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="text-xs font-bold text-blue-400 uppercase tracking-wider">Step 2</span>
                    </div>
                    <div class="w-8 h-8 bg-blue-950 text-white rounded-full flex items-center justify-center text-sm font-extrabold mb-4 -mt-2">2</div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Send Your Shoes</h3>
                    <p class="text-slate-600 leading-relaxed">Ship to us or visit our Michigan studio with your footwear and prescription. Free return shipping included.</p>
                </div>

                <!-- Step 3 -->
                <div class="reveal reveal-delay-3 relative z-10 flex flex-col items-center text-center group">
                    <div class="w-32 h-32 bg-amber-500 border-4 border-amber-400 group-hover:border-amber-600 rounded-2xl flex flex-col items-center justify-center mb-6 shadow-lg shadow-amber-500/30 transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-1">
                        <svg class="w-10 h-10 text-white mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-xs font-bold text-amber-100 uppercase tracking-wider">Step 3</span>
                    </div>
                    <div class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-extrabold mb-4 -mt-2">3</div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Expert Crafting</h3>
                    <p class="text-slate-600 leading-relaxed">Our master cobblers meticulously modify your shoes to exact medical specifications. Ready in 5–10 business days.</p>
                </div>
            </div>

            <div class="mt-20 text-center reveal">
                <a href="{{ auth()->check() ? route('orders.create') : route('register') }}" class="inline-block bg-blue-950 hover:bg-blue-900 text-white font-bold text-lg px-10 py-4 rounded-lg shadow-lg hover:-translate-y-0.5 transition-transform text-center">
                    Start Your Order
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== FAQ SECTION ===================== -->
    <section id="faq" class="py-24 bg-white border-t border-zinc-100">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <div class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3">Questions & Answers</div>
                <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">Frequently Asked Questions</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">Everything you need to know about our orthopedic shoe modification services.</p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <details class="reveal faq-item group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-semibold text-blue-950 text-lg hover:text-amber-600 transition-colors">
                        <span>Do I need a medical prescription?</span>
                        <div class="faq-icon w-8 h-8 rounded-full bg-blue-50 group-open:bg-amber-500 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                            <svg class="w-4 h-4 text-blue-950 group-open:text-white group-open:rotate-45 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </summary>
                    <div class="px-6 pb-6 border-l-4 border-amber-500 ml-6">
                        <p class="text-slate-600 leading-relaxed">Yes, for orthopedic modifications such as sole lifts and custom insoles, we require a valid prescription from a licensed physician, podiatrist, or orthotist. For general shoe repairs or aesthetic restoration, no prescription is needed.</p>
                    </div>
                </details>

                <!-- FAQ 2 -->
                <details class="reveal reveal-delay-1 faq-item group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-semibold text-blue-950 text-lg hover:text-amber-600 transition-colors">
                        <span>How long does a modification take?</span>
                        <div class="faq-icon w-8 h-8 rounded-full bg-blue-50 group-open:bg-amber-500 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                            <svg class="w-4 h-4 text-blue-950 group-open:text-white group-open:rotate-45 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </summary>
                    <div class="px-6 pb-6 border-l-4 border-amber-500 ml-6">
                        <p class="text-slate-600 leading-relaxed">Most standard modifications (sole lifts, custom insoles) are completed within <strong>5–10 business days</strong> of receiving your shoes and prescription. Complex multi-modification cases may take up to 2 weeks. We'll provide a precise timeline when you submit your order.</p>
                    </div>
                </details>

                <!-- FAQ 3 -->
                <details class="reveal reveal-delay-2 faq-item group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-semibold text-blue-950 text-lg hover:text-amber-600 transition-colors">
                        <span>Do you ship nationwide?</span>
                        <div class="faq-icon w-8 h-8 rounded-full bg-blue-50 group-open:bg-amber-500 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                            <svg class="w-4 h-4 text-blue-950 group-open:text-white group-open:rotate-45 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </summary>
                    <div class="px-6 pb-6 border-l-4 border-amber-500 ml-6">
                        <p class="text-slate-600 leading-relaxed">Absolutely! We serve clients across all 50 states. Simply ship your shoes to our Michigan studio along with a copy of your prescription. Return shipping is fully insured and tracked. We also offer expedited service for time-sensitive cases.</p>
                    </div>
                </details>

                <!-- FAQ 4 -->
                <details class="reveal reveal-delay-3 faq-item group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-semibold text-blue-950 text-lg hover:text-amber-600 transition-colors">
                        <span>How much does a sole lift cost?</span>
                        <div class="faq-icon w-8 h-8 rounded-full bg-blue-50 group-open:bg-amber-500 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                            <svg class="w-4 h-4 text-blue-950 group-open:text-white group-open:rotate-45 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </summary>
                    <div class="px-6 pb-6 border-l-4 border-amber-500 ml-6">
                        <p class="text-slate-600 leading-relaxed">Pricing varies based on the type of shoe, lift height, and materials required. Basic sole lifts typically start at <strong>$85–$150</strong>, while complex multi-layer builds or premium materials may cost more. Contact us for a free, no-obligation quote.</p>
                    </div>
                </details>

                <!-- FAQ 5 -->
                <details class="reveal reveal-delay-4 faq-item group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-semibold text-blue-950 text-lg hover:text-amber-600 transition-colors">
                        <span>Can you work with any shoe brand?</span>
                        <div class="faq-icon w-8 h-8 rounded-full bg-blue-50 group-open:bg-amber-500 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                            <svg class="w-4 h-4 text-blue-950 group-open:text-white group-open:rotate-45 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </summary>
                    <div class="px-6 pb-6 border-l-4 border-amber-500 ml-6">
                        <p class="text-slate-600 leading-relaxed">Yes! We work with virtually any footwear brand — from athletic shoes (New Balance, Nike, Adidas) to dress shoes, boots, medical clogs, and specialty orthopedic footwear. If you have an unusual style, contact us first and we'll assess feasibility at no charge.</p>
                    </div>
                </details>

                <!-- FAQ 6 -->
                <details class="reveal faq-item group bg-white border border-zinc-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-semibold text-blue-950 text-lg hover:text-amber-600 transition-colors">
                        <span>Does health insurance cover orthopedic shoe modifications?</span>
                        <div class="faq-icon w-8 h-8 rounded-full bg-blue-50 group-open:bg-amber-500 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                            <svg class="w-4 h-4 text-blue-950 group-open:text-white group-open:rotate-45 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </summary>
                    <div class="px-6 pb-6 border-l-4 border-amber-500 ml-6">
                        <p class="text-slate-600 leading-relaxed">Many health insurance plans, including Medicare and Medicaid, cover prescription orthopedic shoe modifications when medically necessary. We provide detailed itemized invoices and documentation to support your insurance claim. We recommend checking with your provider beforehand.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <!-- ===================== CONTACT US ===================== -->
    <section id="contact" class="py-24 bg-slate-100 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="reveal bg-blue-950 rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
                <!-- Contact Info (Left) -->
                <div class="p-10 md:p-16 text-white md:w-5/12 flex flex-col justify-center relative overflow-hidden">
                    <!-- Decorative background elements -->
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-900 rounded-full opacity-50"></div>
                    <div class="absolute -top-12 -right-12 w-40 h-40 bg-blue-800/30 rounded-full"></div>

                    <div class="relative z-10">
                        <div class="text-amber-500 font-bold tracking-widest uppercase text-sm mb-3">Contact Us</div>
                        <h2 class="text-4xl md:text-5xl font-bold font-['Playfair_Display'] mb-6">Get In Touch</h2>
                        <p class="text-blue-100 mb-10 text-lg">
                            Ready to transform your footwear? Contact us today for a consultation or to ask about our medical modifications.
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0 text-amber-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-lg mb-1">Location</div>
                                    <div class="text-blue-200">115 Pearl St<br>Ypsilanti, MI 48197</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0 text-amber-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-lg mb-1">Phone</div>
                                    <div class="text-blue-200">(800) 555-0199</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0 text-amber-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-lg mb-1">Hours</div>
                                    <div class="text-blue-200">Mon–Fri: 9AM – 6PM<br>Sat: 10AM – 4PM</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form (Right) -->
                <div class="bg-white p-10 md:p-16 md:w-7/12">
                    <livewire:contact-form />
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== FOOTER ===================== -->
    <footer id="footer-bottom" class="bg-slate-950 text-slate-300 py-16 border-t-[6px] border-amber-500">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-6">
                        <div class="w-10 h-10 bg-white text-slate-950 flex items-center justify-center rounded-sm font-bold text-2xl">O</div>
                        <span class="text-3xl font-extrabold text-white font-['Playfair_Display'] tracking-tight">OrthoshoeFix</span>
                    </div>
                    <p class="text-slate-400 mb-6 max-w-sm mx-auto md:mx-0">
                        Michigan's trusted orthopedic shoe repair and customization studio. Combining medical precision with master craftsmanship since 1998.
                    </p>
                    <div class="flex gap-4 justify-center md:justify-start">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="text-center md:text-left">
                    <h4 class="text-white font-bold text-lg mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#services" class="text-slate-400 hover:text-amber-500 transition-colors">Our Services</a></li>
                        <li><a href="#portfolio" class="text-slate-400 hover:text-amber-500 transition-colors">Before & After</a></li>
                        <li><a href="#testimonials" class="text-slate-400 hover:text-amber-500 transition-colors">Testimonials</a></li>
                        <li><a href="#faq" class="text-slate-400 hover:text-amber-500 transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-amber-500 transition-colors">Shipping Info</a></li>
                    </ul>
                </div>

                <div class="text-center md:text-left">
                    <h4 class="text-white font-bold text-lg mb-6">Contact Us</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 justify-center md:justify-start">
                            <svg class="w-5 h-5 text-amber-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-slate-400">115 Pearl St,<br>Ypsilanti, MI 48197</span>
                        </li>
                        <li class="flex items-center gap-3 justify-center md:justify-start">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-slate-400">(800) 555-0199</span>
                        </li>
                        <li class="flex items-center gap-3 justify-center md:justify-start">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="text-slate-400">info@orthoshoefix.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
                <div class="mb-4 md:mb-0">
                    &copy; 2026 OrthoshoeFix. All rights reserved.
                </div>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===================== STYLES ===================== -->
    <style>
        /* ---- Hero gradient text animation ---- */
        .hero-gradient-text {
            background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 30%, #f97316 60%, #f59e0b 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease-in-out infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% center; }
            50% { background-position: 100% center; }
            100% { background-position: 0% center; }
        }

        /* ---- Floating CTA pulse animation ---- */
        @keyframes floatPulse {
            0%, 100% { transform: translateY(0px); box-shadow: 0 10px 30px rgba(245,158,11,0.4); }
            50% { transform: translateY(-4px); box-shadow: 0 18px 40px rgba(245,158,11,0.6); }
        }

        /* ---- Scroll Reveal ---- */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* ---- Navbar glass effect ---- */
        #main-header.scrolled {
            background-color: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }

        /* ---- Mobile menu slide animation ---- */
        #mobile-menu {
            animation: slideDown 0.2s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ---- Hamburger to X animation ---- */
        #mobile-menu-btn.open .hamburger-line:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }
        #mobile-menu-btn.open .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        #mobile-menu-btn.open .hamburger-line:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        /* ---- FAQ details marker hide ---- */
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }

        /* ---- Step connector animate ---- */
        .step-connector {
            transform-origin: left;
            transform: scaleX(0);
            transition: transform 1s ease 0.5s;
        }
        .step-connector.revealed {
            transform: scaleX(1);
        }
    </style>

    <!-- ===================== SCRIPTS ===================== -->
    <script>
    (function() {
        // ---- 1. Navbar glassmorphism on scroll ----
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 40);
        }, { passive: true });

        // ---- 2. Mobile hamburger menu ----
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden', isOpen);
            menuBtn.classList.toggle('open', !isOpen);
        });
        // Close when a link is clicked
        document.querySelectorAll('.mobile-menu-link').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                menuBtn.classList.remove('open');
            });
        });

        // ---- 3. Scroll reveal (IntersectionObserver) ----
        const revealEls = document.querySelectorAll('.reveal, .step-connector');
        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            revealEls.forEach(el => revealObserver.observe(el));
        } else {
            // Fallback: show all elements
            revealEls.forEach(el => el.classList.add('revealed'));
        }

        // ---- 4. Animated Counters ----
        const counters = document.querySelectorAll('.counter');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.dataset.target, 10);
                    const suffix = el.dataset.suffix || '';
                    const format = el.dataset.format;
                    const duration = 1800;
                    const start = Date.now();

                    // For year format, start from a lower year
                    const startValue = (format === 'year') ? target - 30 : 0;

                    const update = () => {
                        const elapsed = Date.now() - start;
                        const progress = Math.min(elapsed / duration, 1);
                        // Ease-out cubic
                        const ease = 1 - Math.pow(1 - progress, 3);
                        const current = Math.floor(startValue + (target - startValue) * ease);

                        if (format === 'year') {
                            el.textContent = current;
                        } else {
                            el.textContent = current.toLocaleString() + (progress >= 1 ? suffix : '');
                        }

                        if (progress < 1) requestAnimationFrame(update);
                    };
                    requestAnimationFrame(update);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => counterObserver.observe(c));

        // ---- 5. Floating CTA: hide near footer ----
        const floatingCta = document.getElementById('floating-cta');
        const footer = document.getElementById('footer-bottom');
        if (floatingCta && footer) {
            const footerObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    floatingCta.style.opacity = entry.isIntersecting ? '0' : '1';
                    floatingCta.style.pointerEvents = entry.isIntersecting ? 'none' : 'auto';
                });
            }, { threshold: 0.1 });
            footerObserver.observe(footer);
        }
    })();
    </script>
</div>
