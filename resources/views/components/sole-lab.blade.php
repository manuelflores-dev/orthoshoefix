@php
    // Original illustrations, drawn for this site. Colour names are generic on purpose.
    $colors = [
        ['name' => 'Black', 'hex' => '#111827'],
        ['name' => 'Brick', 'hex' => '#b91c1c'],
        ['name' => 'Lime', 'hex' => '#84cc16'],
        ['name' => 'Marine', 'hex' => '#1d4ed8'],
        ['name' => 'Teal', 'hex' => '#0f766e'],
        ['name' => 'Mustard', 'hex' => '#d97706'],
        ['name' => 'Sand', 'hex' => '#cbb994'],
        ['name' => 'Cocoa', 'hex' => '#6b4423'],
    ];

    $families = [
        'dress' => ['label' => 'Dress shoe', 'tread' => 'Fine rib tread'],
        'sneaker' => ['label' => 'Sneaker', 'tread' => 'Lug tread'],
        'sandal' => ['label' => 'Sandal', 'tread' => 'Ripple tread'],
    ];
@endphp

<section id="soles" class="py-24 bg-slate-100 border-y border-zinc-200">
    <div
        class="max-w-7xl mx-auto px-6 lg:px-8"
        x-data="{ family: 'dress', color: '#111827', colorName: 'Black' }"
    >
        {{-- Heading --}}
        <div class="text-center mb-14 reveal">
            <div class="text-amber-500 font-bold tracking-widest uppercase text-sm mb-3">Sole Options</div>
            <h2 class="text-4xl md:text-5xl font-bold text-blue-950 font-['Playfair_Display']">Pick Your Sole and Color</h2>
            <div class="w-24 h-1 bg-amber-500 mx-auto mt-6 mb-6"></div>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Every repair and lift is finished with a new sole. Choose the family that matches your
                shoes and the color you want on the ground.
            </p>
        </div>

        {{-- Shoe family tabs --}}
        <div class="reveal flex flex-wrap justify-center gap-2 mb-10">
            @foreach ($families as $key => $family)
                <button
                    type="button"
                    x-on:click="family = '{{ $key }}'"
                    class="px-6 py-2.5 rounded-lg font-bold transition-colors border"
                    :class="family === '{{ $key }}'
                        ? 'bg-blue-950 text-white border-blue-950'
                        : 'bg-white text-blue-950 border-zinc-300 hover:bg-zinc-50'"
                >
                    {{ $family['label'] }}
                </button>
            @endforeach
        </div>

        {{-- Shoe on the selected colour --}}
        <div class="reveal rounded-3xl bg-white shadow-xl border border-zinc-100 overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-3 px-8 pt-7 pb-4 border-b border-zinc-100">
                <div class="flex items-center gap-3">
                    <span class="inline-block bg-amber-500 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded">
                        <span x-text="colorName"></span>
                    </span>
                    <h3 class="text-xl font-bold text-blue-950 font-['Playfair_Display']">
                        <span x-text="{
                            dress: '{{ $families['dress']['label'] }}',
                            sneaker: '{{ $families['sneaker']['label'] }}',
                            sandal: '{{ $families['sandal']['label'] }}',
                        }[family]"></span>
                    </h3>
                </div>

                <div class="text-slate-500 text-sm font-medium">
                    <span x-text="{
                        dress: '{{ $families['dress']['tread'] }}',
                        sneaker: '{{ $families['sneaker']['tread'] }}',
                        sandal: '{{ $families['sandal']['tread'] }}',
                    }[family]"></span>
                </div>
            </div>

            <div class="px-6 py-10 sm:px-12">
                {{-- Dress shoe --}}
                <div x-show="family === 'dress'" x-cloak>
                    <svg viewBox="0 0 440 200" class="w-full max-w-2xl mx-auto h-auto" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Dress shoe illustration">
                        <ellipse cx="232" cy="186" rx="168" ry="8" fill="#0f172a" opacity="0.08" />

                        {{-- Upper: heel counter, ankle opening, throat and vamp down to the toe --}}
                        <path d="M96 150 C92 130 92 100 94 84 C96 70 106 62 122 62 C138 62 148 70 154 82
                                 C160 94 170 100 184 104 C204 108 226 110 248 112 C294 117 330 120 356 124
                                 C374 127 388 136 390 150 Z"
                              fill="#7c4a32" />

                        {{-- Ankle opening --}}
                        <path d="M122 62 C138 62 148 70 154 82 C160 94 170 100 184 104 C166 104 146 96 136 84 C128 74 124 68 122 62 Z"
                              fill="#3f2216" opacity="0.85" />
                        {{-- Heel counter seam --}}
                        <path d="M136 88 C130 108 128 128 130 150" stroke="#4a2a1b" stroke-width="2" fill="none" opacity="0.5" />
                        {{-- Vamp highlight --}}
                        <path d="M206 118 C246 122 292 127 330 132 C292 129 246 124 206 121 Z" fill="#fff" opacity="0.14" />

                        {{-- Lace panel --}}
                        <path d="M154 84 C176 98 214 107 250 112 L247 123 C209 117 172 106 152 95 Z" fill="#6b3d28" />
                        <g stroke="#efe2d6" stroke-width="3" stroke-linecap="round">
                            <path d="M172 95 L181 106" /><path d="M192 101 L201 112" />
                            <path d="M212 106 L221 116" /><path d="M232 110 L241 120" />
                        </g>

                        {{-- Toe cap and brogue detail --}}
                        <path d="M330 121 C338 130 342 140 343 150" stroke="#4a2a1b" stroke-width="2.5" fill="none" />
                        <g fill="#4a2a1b" opacity="0.5">
                            <circle cx="350" cy="127" r="1.8" /><circle cx="360" cy="131" r="1.8" />
                            <circle cx="369" cy="136" r="1.8" /><circle cx="377" cy="142" r="1.8" />
                        </g>

                        {{-- Welt --}}
                        <path d="M92 150 L392 150 C398 150 400 154 394 155 L98 157 C90 157 86 154 92 150 Z" fill="#c98b58" />

                        {{-- Sole, the part the visitor is choosing --}}
                        <path d="M92 155 L394 154 C402 154 404 163 395 165 L104 168 C92 168 86 162 92 155 Z" :fill="color" />
                        {{-- Heel block --}}
                        <path d="M94 166 L146 165 L148 182 C148 185 144 186 138 186 L104 186 C98 186 94 185 94 182 Z" :fill="color" />
                        <path d="M94 166 L146 165 L146 170 L94 171 Z" fill="#000" opacity="0.2" />
                    </svg>
                </div>

                {{-- Sneaker --}}
                <div x-show="family === 'sneaker'" x-cloak>
                    <svg viewBox="0 0 440 200" class="w-full max-w-2xl mx-auto h-auto" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Sneaker illustration">
                        <ellipse cx="232" cy="186" rx="168" ry="8" fill="#0f172a" opacity="0.08" />

                        {{-- Upper --}}
                        <path d="M100 128 C93 108 94 84 104 70 C116 54 138 50 154 60 C166 68 172 82 178 94
                                 C184 106 194 112 210 114 C240 112 270 106 298 102 C332 98 362 108 377 124
                                 C380 127 380 128 376 128 Z"
                              fill="#eef0f2" />

                        {{-- Heel counter --}}
                        <path d="M100 128 C93 108 94 84 104 70 C110 62 120 56 130 54 C118 72 112 98 114 128 Z"
                              fill="#8fa0b3" opacity="0.8" />
                        {{-- Heel pull tab --}}
                        <path d="M104 70 C112 62 124 58 134 58 L132 66 C122 66 112 70 106 76 Z" fill="#64748b" opacity="0.8" />

                        {{-- Ankle opening --}}
                        <path d="M141 57 C158 55 170 72 180 96 C164 90 148 78 141 66 Z" fill="#3f4a5a" />

                        {{-- Lace panel --}}
                        <path d="M180 96 C196 106 216 112 238 113 L236 123 C212 121 190 113 175 103 Z" fill="#c9d2db" />
                        <g stroke="#475569" stroke-width="3.5" stroke-linecap="round">
                            <path d="M186 101 L196 112" /><path d="M202 107 L212 117" /><path d="M218 111 L228 121" />
                        </g>

                        {{-- Quarter panel swoosh-free stripe --}}
                        <path d="M244 114 C266 110 288 105 308 103 C292 114 268 121 246 123 Z"
                              fill="#8fa0b3" opacity="0.55" />
                        {{-- Toe box seam and cap --}}
                        <path d="M330 103 C338 111 342 120 344 128" stroke="#9aa7b5" stroke-width="2" fill="none" />
                        <path d="M336 101 C356 106 370 114 377 124 C380 127 380 128 376 128 L344 128 C343 118 340 109 336 101 Z"
                              fill="#dfe3e8" />

                        {{-- Midsole, the part the visitor is choosing --}}
                        <path d="M88 130 C82 146 92 160 112 161 L364 157 C382 156 394 146 392 134 C390 124 378 121 366 122
                                 L100 127 C92 127 88 128 88 130 Z"
                              :fill="color" />
                        {{-- Outsole shading and lugs --}}
                        <path d="M90 146 C92 156 100 161 112 161 L364 157 C380 156 390 150 392 142 L90 146 Z"
                              fill="#000" opacity="0.22" />
                        <g fill="#000" opacity="0.28">
                            @for ($i = 0; $i < 15; $i++)
                                <rect x="{{ 108 + $i * 18 }}" y="{{ 152 - ($i > 11 ? 2 : 0) }}" width="10" height="7" rx="2" />
                            @endfor
                        </g>
                    </svg>
                </div>

                {{-- Sandal --}}
                <div x-show="family === 'sandal'" x-cloak>
                    <svg viewBox="0 0 440 200" class="w-full max-w-2xl mx-auto h-auto" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Sandal illustration">
                        <ellipse cx="232" cy="186" rx="160" ry="8" fill="#0f172a" opacity="0.08" />

                        {{-- Two buckled bands, each arching from the footbed and back down to it --}}
                        <path d="M164 122 C158 82 232 78 236 120" stroke="#6b452f" stroke-width="15" fill="none" stroke-linecap="round" />
                        <path d="M262 120 C258 84 326 82 330 118" stroke="#6b452f" stroke-width="15" fill="none" stroke-linecap="round" />
                        {{-- Band shading --}}
                        <path d="M170 116 C168 92 214 86 230 96" stroke="#4f3222" stroke-width="3" fill="none" opacity="0.5" />
                        <path d="M268 114 C266 92 310 88 324 98" stroke="#4f3222" stroke-width="3" fill="none" opacity="0.5" />
                        {{-- Buckles --}}
                        <g fill="#a1a1aa">
                            <rect x="222" y="84" width="18" height="14" rx="3" />
                            <rect x="316" y="86" width="18" height="14" rx="3" />
                        </g>
                        <g fill="#6b7280">
                            <rect x="226" y="88" width="10" height="3.5" rx="1.75" />
                            <rect x="320" y="90" width="10" height="3.5" rx="1.75" />
                        </g>

                        {{-- Contoured footbed --}}
                        <path d="M104 130 C96 118 104 108 120 106 L360 104 C378 104 388 116 384 130 Z" fill="#b98a5b" />
                        {{-- Arch and toe ridge --}}
                        <path d="M150 118 C190 108 250 106 300 108" stroke="#8a6340" stroke-width="2.5" fill="none" opacity="0.7" />
                        <path d="M352 106 C360 112 362 120 360 128" stroke="#8a6340" stroke-width="2.5" fill="none" opacity="0.7" />
                        {{-- Footbed edge --}}
                        <path d="M104 130 L384 130 L384 138 C384 142 380 144 374 144 L114 146 C106 146 102 142 102 138 Z" fill="#8a6340" />

                        {{-- Outsole, the part the visitor is choosing --}}
                        <path d="M102 144 L384 140 C392 140 394 149 386 151 L112 157 C102 157 96 149 102 144 Z" :fill="color" />
                        {{-- Ripple teeth --}}
                        <g :fill="color">
                            @for ($i = 0; $i < 19; $i++)
                                <path d="M{{ 110 + $i * 14 }} 154 L{{ 117 + $i * 14 }} 167 L{{ 124 + $i * 14 }} 153 Z" />
                            @endfor
                        </g>
                        <g fill="#000" opacity="0.2">
                            @for ($i = 0; $i < 19; $i++)
                                <path d="M{{ 117 + $i * 14 }} 167 L{{ 124 + $i * 14 }} 153 L{{ 120 + $i * 14 }} 153 Z" />
                            @endfor
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Colour swatches --}}
        <div class="reveal reveal-delay-1 mt-10">
            <div class="grid grid-cols-4 gap-3 md:grid-cols-8">
                @foreach ($colors as $color)
                    <x-sole.swatch :color="$color['hex']" :name="$color['name']" />
                @endforeach
            </div>

            <p class="mt-8 text-center text-sm text-slate-500">
                Illustrations, not photographs. Tread patterns and colors are confirmed at the studio
                before we start, and every sole is fitted to your prescription.
            </p>

            <div class="mt-8 text-center">
                <a href="{{ auth()->check() ? route('orders.create') : route('register') }}"
                   class="inline-block bg-amber-500 hover:bg-amber-400 text-white font-bold text-lg px-10 py-4 rounded-lg shadow-lg hover:-translate-y-0.5 transition-transform">
                    Request This Finish
                </a>
            </div>
        </div>
    </div>
</section>
