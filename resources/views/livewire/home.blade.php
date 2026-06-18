<div>
    <!-- HEADER -->
    <header class="bg-white border-b border-zinc-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-950 text-white flex items-center justify-center rounded-sm font-bold text-xl">O</div>
                <span class="text-2xl font-extrabold text-blue-950 font-['Playfair_Display'] tracking-tight">OrthoshoeFix</span>
            </div>
            
            <nav class="hidden md:flex items-center gap-8 font-medium text-slate-600">
                <a href="#services" class="hover:text-blue-950 transition-colors">Services</a>
                <a href="#portfolio" class="hover:text-blue-950 transition-colors">Before & After</a>
                <a href="#testimonials" class="hover:text-blue-950 transition-colors">Testimonials</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="/login" class="text-slate-600 font-medium hover:text-blue-950 hidden sm:block">Login</a>
                <flux:button variant="filled" class="bg-blue-950 hover:bg-blue-900 text-white font-semibold border-transparent px-6">
                    Register
                </flux:button>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative bg-blue-950 text-white overflow-hidden py-24 lg:py-32">
        <!-- Subtle Pattern Overlay -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center flex flex-col items-center">
            <div class="inline-block px-4 py-1.5 rounded-full border border-blue-800 bg-blue-900/50 text-blue-200 text-sm font-semibold tracking-wide uppercase mb-8 shadow-sm">
                Certified Orthopedic Modifications
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 font-['Playfair_Display'] text-white drop-shadow-md">
                Master Craftsmanship for<br><span class="text-amber-500">Medical Precision</span>
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-blue-100 max-w-3xl mb-10 font-light leading-relaxed">
                Michigan's trusted studio for prescription shoe modifications. 
                Expert sole lifts, custom orthotics, and premium shoe restoration.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <flux:button variant="filled" class="w-full sm:w-auto font-bold text-lg px-8 py-3 bg-amber-600 hover:bg-amber-500 text-white border-transparent shadow-lg hover:shadow-amber-500/20 transition-all">
                    Schedule Consultation
                </flux:button>
                <flux:button variant="outline" class="w-full sm:w-auto font-bold text-lg px-8 py-3 text-white border-blue-400 hover:bg-blue-900 hover:border-white transition-all">
                    See Our Work
                </flux:button>
            </div>
        </div>
    </section>

    <!-- TRUST BAR / STATS -->
    <section class="bg-white border-b border-zinc-200 py-10 shadow-sm relative z-20 -mt-2">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-zinc-200">
                <div class="py-4 md:py-0">
                    <div class="text-4xl font-extrabold text-blue-950 mb-2">10,000+</div>
                    <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Prescriptions Met</div>
                </div>
                <div class="py-4 md:py-0">
                    <div class="text-4xl font-extrabold text-blue-950 mb-2">Est. 1998</div>
                    <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Michigan Based</div>
                </div>
                <div class="py-4 md:py-0 flex flex-col items-center justify-center">
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

    <!-- SPECIALIZED SERVICES -->
    <section id="services" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3">What We Do</div>
                <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">Specialized Services</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">Premium craftsmanship tailored exactly to your medical needs and personal comfort.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <flux:card class="flex flex-col h-full border-none shadow-md hover:shadow-xl transition-all duration-300 bg-white overflow-hidden group">
                    <div class="bg-blue-50 h-56 w-full flex items-center justify-center border-b border-blue-100 relative overflow-hidden">
                        <div class="absolute inset-0 bg-blue-900/5 group-hover:bg-blue-900/0 transition-colors"></div>
                        <span class="text-blue-300 font-medium flex flex-col items-center gap-2">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Shoe Lift Image
                        </span>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Orthopedic Shoe Lifts</h3>
                        <p class="text-slate-600 mb-8 flex-1 leading-relaxed">
                            Precision sole additions prescribed by medical professionals to correct leg length discrepancies and improve posture.
                        </p>
                        <flux:button variant="subtle" class="w-full text-blue-900 font-bold bg-blue-50 hover:bg-blue-100">Learn More</flux:button>
                    </div>
                </flux:card>

                <!-- Service 2 -->
                <flux:card class="flex flex-col h-full border-none shadow-md hover:shadow-xl transition-all duration-300 bg-white overflow-hidden group">
                    <div class="bg-blue-50 h-56 w-full flex items-center justify-center border-b border-blue-100 relative overflow-hidden">
                        <div class="absolute inset-0 bg-blue-900/5 group-hover:bg-blue-900/0 transition-colors"></div>
                        <span class="text-blue-300 font-medium flex flex-col items-center gap-2">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            Custom Insole Image
                        </span>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Custom Stitched Insoles</h3>
                        <p class="text-slate-600 mb-8 flex-1 leading-relaxed">
                            Hand-stitched, bespoke insoles designed specifically for your unique foot anatomy to provide unparalleled comfort.
                        </p>
                        <flux:button variant="subtle" class="w-full text-blue-900 font-bold bg-blue-50 hover:bg-blue-100">Learn More</flux:button>
                    </div>
                </flux:card>

                <!-- Service 3 -->
                <flux:card class="flex flex-col h-full border-none shadow-md hover:shadow-xl transition-all duration-300 bg-white overflow-hidden group">
                    <div class="bg-blue-50 h-56 w-full flex items-center justify-center border-b border-blue-100 relative overflow-hidden">
                        <div class="absolute inset-0 bg-blue-900/5 group-hover:bg-blue-900/0 transition-colors"></div>
                        <span class="text-blue-300 font-medium flex flex-col items-center gap-2">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                            Restoration Image
                        </span>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Master Shoe Repair</h3>
                        <p class="text-slate-600 mb-8 flex-1 leading-relaxed">
                            Traditional restoration services for premium footwear, seamlessly blending medical needs with original aesthetics.
                        </p>
                        <flux:button variant="subtle" class="w-full text-blue-900 font-bold bg-blue-50 hover:bg-blue-100">Learn More</flux:button>
                    </div>
                </flux:card>
            </div>
        </div>
    </section>

    <!-- BEFORE & AFTER PORTFOLIO (NEW) -->
    <section id="portfolio" class="py-24 bg-white border-t border-zinc-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div class="max-w-2xl">
                    <div class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3">Our Craftsmanship</div>
                    <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">Before & After</h2>
                    <p class="mt-4 text-lg text-slate-600">See how we flawlessly integrate medical modifications without compromising the shoe's original beauty.</p>
                </div>
                <flux:button variant="outline" class="hidden md:flex text-blue-950 border-zinc-300 font-bold">View Full Portfolio</flux:button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Portfolio Item 1 -->
                <div class="group relative rounded-2xl overflow-hidden shadow-lg border border-zinc-100">
                    <div class="flex h-64 md:h-80 w-full">
                        <div class="w-1/2 bg-slate-200 flex flex-col items-center justify-center border-r border-white relative">
                            <span class="absolute top-4 left-4 bg-white/90 text-xs font-bold px-3 py-1 rounded shadow-sm">BEFORE</span>
                            <span class="text-slate-500 font-medium">Original Shoe</span>
                        </div>
                        <div class="w-1/2 bg-slate-100 flex flex-col items-center justify-center relative">
                            <span class="absolute top-4 right-4 bg-blue-950 text-white text-xs font-bold px-3 py-1 rounded shadow-sm">AFTER</span>
                            <span class="text-slate-500 font-medium">1.5" Lift Added</span>
                        </div>
                    </div>
                    <div class="p-6 bg-white absolute bottom-0 inset-x-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <h4 class="text-xl font-bold text-blue-950 mb-1">Allen Edmonds Oxford</h4>
                        <p class="text-slate-600 text-sm">Invisible 1.5" sole lift built directly into the welt stack.</p>
                    </div>
                </div>

                <!-- Portfolio Item 2 -->
                <div class="group relative rounded-2xl overflow-hidden shadow-lg border border-zinc-100">
                    <div class="flex h-64 md:h-80 w-full">
                        <div class="w-1/2 bg-slate-200 flex flex-col items-center justify-center border-r border-white relative">
                            <span class="absolute top-4 left-4 bg-white/90 text-xs font-bold px-3 py-1 rounded shadow-sm">BEFORE</span>
                            <span class="text-slate-500 font-medium">Original Boot</span>
                        </div>
                        <div class="w-1/2 bg-slate-100 flex flex-col items-center justify-center relative">
                            <span class="absolute top-4 right-4 bg-blue-950 text-white text-xs font-bold px-3 py-1 rounded shadow-sm">AFTER</span>
                            <span class="text-slate-500 font-medium">Custom Rocker Sole</span>
                        </div>
                    </div>
                    <div class="p-6 bg-white absolute bottom-0 inset-x-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <h4 class="text-xl font-bold text-blue-950 mb-1">Red Wing Heritage</h4>
                        <p class="text-slate-600 text-sm">Full custom rocker bottom sole to alleviate forefoot pain.</p>
                    </div>
                </div>
            </div>
            
            <flux:button variant="outline" class="w-full mt-8 md:hidden text-blue-950 border-zinc-300 font-bold">View Full Portfolio</flux:button>
        </div>
    </section>

    <!-- TESTIMONIALS (NEW) -->
    <section id="testimonials" class="py-24 bg-blue-950 text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="text-amber-500 font-bold tracking-widest uppercase text-sm mb-3">Testimonials</div>
                <h2 class="text-4xl md:text-5xl font-bold text-white font-['Playfair_Display']">What Our Clients Say</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <flux:card class="bg-white text-slate-900 border-none shadow-xl p-8 rounded-2xl relative">
                    <div class="flex gap-1 text-amber-500 mb-6">
                        @for($i=0; $i<5; $i++)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 italic mb-8 text-lg">"OrthoshoeFix completely transformed my walking experience. The 2-inch lift they added to my dress shoes is virtually invisible. My back pain is gone and nobody can tell I'm wearing an orthotic."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-950 font-bold text-xl">S</div>
                        <div>
                            <div class="font-bold text-blue-950">Sarah M.</div>
                            <div class="text-sm text-slate-500">Grand Rapids, MI</div>
                        </div>
                    </div>
                </flux:card>

                <!-- Testimonial 2 -->
                <flux:card class="bg-white text-slate-900 border-none shadow-xl p-8 rounded-2xl relative">
                    <div class="flex gap-1 text-amber-500 mb-6">
                        @for($i=0; $i<5; $i++)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 italic mb-8 text-lg">"Professional service and amazing craftsmanship. My doctor recommended them for a complicated rocker sole modification. They handled it perfectly and the shoes look fantastic."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-950 font-bold text-xl">J</div>
                        <div>
                            <div class="font-bold text-blue-950">John D.</div>
                            <div class="text-sm text-slate-500">Lansing, MI</div>
                        </div>
                    </div>
                </flux:card>

                <!-- Testimonial 3 -->
                <flux:card class="bg-white text-slate-900 border-none shadow-xl p-8 rounded-2xl relative">
                    <div class="flex gap-1 text-amber-500 mb-6">
                        @for($i=0; $i<5; $i++)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 italic mb-8 text-lg">"They repaired my favorite leather boots and built in the necessary arch support my podiatrist prescribed. You can't even tell they were modified. The quality is unmatched."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-950 font-bold text-xl">M</div>
                        <div>
                            <div class="font-bold text-blue-950">Maria G.</div>
                            <div class="text-sm text-slate-500">Detroit, MI</div>
                        </div>
                    </div>
                </flux:card>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3">The Process</div>
                <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">How It Works</h2>
                <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">A seamless, professional process from medical prescription to perfect fit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <!-- Decorative Line -->
                <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-0.5 bg-blue-200 z-0"></div>

                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white border-4 border-blue-950 rounded-full flex items-center justify-center text-3xl font-extrabold text-blue-950 mb-6 shadow-md">
                        1
                    </div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Get Prescription</h3>
                    <p class="text-slate-600">Consult your doctor or podiatrist to receive your specific orthopedic requirements.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white border-4 border-blue-950 rounded-full flex items-center justify-center text-3xl font-extrabold text-blue-950 mb-6 shadow-md">
                        2
                    </div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Bring Your Shoes</h3>
                    <p class="text-slate-600">Ship to us or visit our Michigan studio with your footwear and prescription.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white border-4 border-amber-500 rounded-full flex items-center justify-center text-3xl font-extrabold text-amber-600 mb-6 shadow-lg transform scale-110">
                        3
                    </div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 font-['Playfair_Display']">Expert Crafting</h3>
                    <p class="text-slate-600">Our master cobblers meticulously modify your shoes to exact medical specifications.</p>
                </div>
            </div>
            
            <div class="mt-20 text-center">
                <flux:button variant="filled" class="bg-blue-950 hover:bg-blue-900 text-white font-bold text-lg px-10 py-4 shadow-lg">
                    Start Your Order
                </flux:button>
            </div>
        </div>
    </section>

    <!-- CONTACT US (NEW) -->
    <section class="py-24 bg-slate-100 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-blue-950 rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
                <!-- Contact Info (Left) -->
                <div class="p-10 md:p-16 text-white md:w-5/12 flex flex-col justify-center relative overflow-hidden">
                    <!-- Decorative background element -->
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-900 rounded-full opacity-50"></div>
                    
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
                                    <div class="text-blue-200">123 Craftsmanship Way<br>Grand Rapids, MI 49503</div>
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
                                    <div class="text-blue-200">Mon-Fri: 9AM - 6PM<br>Sat: 10AM - 4PM</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form (Right) -->
                <div class="bg-white p-10 md:p-16 md:w-7/12">
                    <h3 class="text-2xl font-bold text-blue-950 mb-8 font-['Playfair_Display']">Send us a Message</h3>
                    
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 gap-6">
                            <flux:input label="Name" placeholder="Your name" />
                            <flux:input label="Email" type="email" placeholder="your@email.com" />
                            <flux:textarea label="Message" placeholder="How can we help you?" rows="4" />
                        </div>
                        
                        <div class="pt-4">
                            <flux:button variant="filled" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-bold text-lg py-3 border-transparent shadow-md">
                                Send Message
                            </flux:button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="contact" class="bg-slate-950 text-slate-300 py-16 border-t-[6px] border-amber-500">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-6">
                        <div class="w-10 h-10 bg-white text-slate-950 flex items-center justify-center rounded-sm font-bold text-2xl">O</div>
                        <span class="text-3xl font-extrabold text-white font-['Playfair_Display'] tracking-tight">OrthoshoeFix</span>
                    </div>
                    <p class="text-slate-400 mb-6 max-w-sm mx-auto md:mx-0">
                        Michigan's trusted orthopedic shoe repair and customization studio. Combining medical precision with master craftsmanship.
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
                        <li><a href="#" class="text-slate-400 hover:text-amber-500 transition-colors">Shipping Info</a></li>
                    </ul>
                </div>
                
                <div class="text-center md:text-left">
                    <h4 class="text-white font-bold text-lg mb-6">Contact Us</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 justify-center md:justify-start">
                            <svg class="w-5 h-5 text-amber-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-slate-400">123 Craftsmanship Way,<br>Grand Rapids, MI 49503</span>
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
</div>
