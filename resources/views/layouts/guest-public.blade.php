<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BersihinAja — Rumah Bersih, Hidup Nyaman' }}</title>
    <meta name="description" content="{{ $description ?? 'Layanan pembersihan profesional untuk rumah Anda. Pesan dalam hitungan menit.' }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        .ease-premium { transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal { opacity: 0; transform: translateY(40px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        @keyframes bounce-slow { 0%,100% { transform: translateY(-5%); } 50% { transform: translateY(5%); } }
        .bounce-slow { animation: bounce-slow 4s ease-in-out infinite; }
    </style>
</head>
<body class="bg-cream text-charcoal">
    <div class="min-h-screen overflow-x-hidden">
        @include('partials.nav-public')

        <main>
            {{ $slot }}
        </main>

        @include('partials.footer-public')
    </div>

    <script>
        document.addEventListener('livewire:navigated', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
        });
    </script>
    @stack('scripts')
</body>
</html>
