@props([
    'color',
    'name',
])

{{--
    Bottom view of a sole. The tread pattern shown depends on the shoe family
    picked in the section, so one swatch carries all three and Alpine toggles them.
--}}
<button
    type="button"
    x-on:click="color = '{{ $color }}'; colorName = '{{ $name }}'"
    class="group flex flex-col items-center gap-3 rounded-xl p-2 transition-all hover:-translate-y-1 focus:outline-none"
    :class="color === '{{ $color }}' ? 'bg-white shadow-lg ring-2 ring-amber-500' : 'hover:bg-white/60'"
    :aria-pressed="color === '{{ $color }}'"
    aria-label="{{ $name }}"
>
    <svg viewBox="0 0 110 280" class="h-40 w-auto drop-shadow-md" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <clipPath id="sole-clip-{{ Str::slug($name) }}">
                <path d="M55 6 C82 6 101 26 101 58 C101 88 90 106 86 128 C82 150 88 166 90 188 C92 218 82 246 68 268 C60 281 47 285 37 279 C24 271 17 250 15 226 C13 200 20 182 22 162 C24 140 15 124 11 102 C5 76 9 40 25 20 C33 10 43 6 55 6 Z" />
            </clipPath>
        </defs>

        {{-- Sole body --}}
        <path
            d="M55 6 C82 6 101 26 101 58 C101 88 90 106 86 128 C82 150 88 166 90 188 C92 218 82 246 68 268 C60 281 47 285 37 279 C24 271 17 250 15 226 C13 200 20 182 22 162 C24 140 15 124 11 102 C5 76 9 40 25 20 C33 10 43 6 55 6 Z"
            fill="{{ $color }}"
        />

        <g clip-path="url(#sole-clip-{{ Str::slug($name) }})" opacity="0.28">
            {{-- Fine ribs: dress shoes --}}
            <g x-show="family === 'dress'" fill="#000">
                @for ($i = 0; $i < 26; $i++)
                    <rect x="0" y="{{ 12 + $i * 10 }}" width="110" height="3" rx="1.5" />
                @endfor
            </g>

            {{-- Lugs: sneakers and trainers --}}
            <g x-show="family === 'sneaker'" fill="#000">
                @for ($row = 0; $row < 13; $row++)
                    @for ($col = 0; $col < 5; $col++)
                        <rect
                            x="{{ 6 + $col * 21 + ($row % 2 === 0 ? 0 : 8) }}"
                            y="{{ 12 + $row * 20 }}"
                            width="14"
                            height="11"
                            rx="3"
                        />
                    @endfor
                @endfor
            </g>

            {{-- Ripple bars: sandals and slides --}}
            <g x-show="family === 'sandal'" fill="#000">
                @for ($i = 0; $i < 17; $i++)
                    <rect x="0" y="{{ 10 + $i * 16 }}" width="110" height="8" rx="4" />
                @endfor
            </g>
        </g>

        {{-- Brand-free maker's dot, like the stamp on a finished sole --}}
        <ellipse cx="53" cy="150" rx="9" ry="5" fill="#f59e0b" opacity="0.85" />
    </svg>

    <span
        class="text-xs font-semibold tracking-wide text-slate-600"
        :class="color === '{{ $color }}' && 'text-blue-950'"
    >{{ $name }}</span>
</button>
