<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ filled($title ?? null) ? $title.' - OrthoshoeFix' : 'OrthoshoeFix — Premium Orthopedic Shoe Repair, Michigan' }}</title>
        <meta name="description" content="{{ $description ?? 'OrthoshoeFix is Michigan\'s trusted orthopedic shoe repair and customization studio — sole lifts, custom stitched insoles, and prescription-based orthopedic adjustments.' }}" />

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        {{-- Google Fonts: Inter + Playfair Display --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-white antialiased">
        {{ $slot }}

        @fluxScripts
        @livewireScripts
    </body>
</html>
