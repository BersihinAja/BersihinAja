<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BersihinAja') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        .ease-premium { transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen">
        {{-- Left: Decorative Panel --}}
        <div class="hidden lg:flex lg:w-1/2 bg-charcoal relative items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-charcoal via-charcoal to-mint/20"></div>
            <div class="relative z-10 px-16 text-center">
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-3 text-3xl font-black tracking-tighter text-cream">
                    <img src="{{ asset('images/logo.svg') }}" alt="BersihinAja" class="h-10 w-10">
                    BERSIHINAJA
                </a>
                <p class="mt-6 max-w-sm mx-auto text-lg font-medium leading-relaxed text-cream/60">
                    Rumah Bersih, Hidup Nyaman. Platform layanan kebersihan rumah terpercaya di Indonesia.
                </p>
                <div class="mt-12 flex items-center justify-center gap-8 text-cream/30">
                    <div class="text-center">
                        <p class="text-3xl font-black text-mint">3</p>
                        <p class="mt-1 text-[10px] font-black tracking-[0.2em]">PAKET</p>
                    </div>
                    <div class="h-8 w-px bg-cream/10"></div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-mint">24/7</p>
                        <p class="mt-1 text-[10px] font-black tracking-[0.2em]">LAYANAN</p>
                    </div>
                    <div class="h-8 w-px bg-cream/10"></div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-mint">100%</p>
                        <p class="mt-1 text-[10px] font-black tracking-[0.2em]">AMAN</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Auth Form --}}
        <div class="flex w-full flex-col justify-center px-6 py-12 bg-cream lg:w-1/2 lg:px-16">
            <div class="mx-auto w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="mb-10 lg:hidden">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-black tracking-tighter text-charcoal">
                        <img src="{{ asset('images/logo.svg') }}" alt="BersihinAja" class="h-7 w-7">
                        BERSIHINAJA
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
