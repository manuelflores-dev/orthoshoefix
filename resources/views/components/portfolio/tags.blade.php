@props(['tags' => []])

@if (filled($tags))
    <div class="flex flex-wrap gap-2">
        @foreach ($tags as $index => $tag)
            @php
                // Literal classes so Tailwind keeps them in the build.
                $tone = match ($index % 4) {
                    0 => 'bg-blue-50 text-blue-800',
                    1 => 'bg-amber-50 text-amber-700',
                    2 => 'bg-green-50 text-green-700',
                    default => 'bg-slate-100 text-slate-600',
                };
            @endphp

            <span class="text-xs {{ $tone }} font-semibold px-3 py-1 rounded-full">{{ $tag }}</span>
        @endforeach
    </div>
@endif
