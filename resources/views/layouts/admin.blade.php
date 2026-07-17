<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} — Admin | {{ config('app.name', 'BersihinAja') }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        .ease-premium { transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal { opacity: 0; transform: translateY(20px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="bg-cream font-sans text-charcoal antialiased">
    <div class="flex min-h-screen" x-data="{ mobileOpen: false }">
        <!-- Sidebar - Desktop (Fixed) -->
        <aside class="hidden w-72 flex-col bg-charcoal text-cream lg:flex fixed inset-y-0 left-0 z-40 border-r border-cream/5">
            <!-- Brand -->
            <div class="flex h-20 items-center px-8 border-b border-cream/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-lg font-black tracking-tighter">
                    <img src="{{ asset('images/logo.svg') }}" alt="BersihinAja" class="h-7 w-7"> BERSIHINAJA
                </a>
            </div>

            <!-- Profile Info -->
            <div class="p-6 border-b border-cream/5 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-mint text-charcoal font-black">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-sm truncate text-cream">{{ Auth::user()->name }}</p>
                    <span class="inline-flex rounded-full bg-mint/10 px-2.5 py-0.5 text-[10px] font-black tracking-wider text-mint mt-1">ADMIN</span>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 p-6 space-y-2 text-[10px] font-black tracking-[0.2em]">
                <a href="{{ route('admin.dashboard') }}" wire:navigate 
                   class="flex items-center gap-4 rounded-xl px-4 py-3.5 ease-premium {{ request()->routeIs('admin.dashboard') ? 'bg-mint text-charcoal' : 'text-cream/50 hover:bg-cream/5 hover:text-cream' }}">
                    <iconify-icon icon="lucide:layout-dashboard" class="text-base"></iconify-icon> DASHBOARD
                </a>
                <a href="{{ route('admin.services.index') }}" wire:navigate 
                   class="flex items-center gap-4 rounded-xl px-4 py-3.5 ease-premium {{ request()->routeIs('admin.services.*') ? 'bg-mint text-charcoal' : 'text-cream/50 hover:bg-cream/5 hover:text-cream' }}">
                    <iconify-icon icon="lucide:sparkles" class="text-base"></iconify-icon> LAYANAN
                </a>
                <a href="{{ route('admin.users.index') }}" wire:navigate 
                   class="flex items-center gap-4 rounded-xl px-4 py-3.5 ease-premium {{ request()->routeIs('admin.users.*') ? 'bg-mint text-charcoal' : 'text-cream/50 hover:bg-cream/5 hover:text-cream' }}">
                    <iconify-icon icon="lucide:users" class="text-base"></iconify-icon> PENGGUNA
                </a>
                <a href="{{ route('admin.orders.index') }}" wire:navigate 
                   class="flex items-center gap-4 rounded-xl px-4 py-3.5 ease-premium {{ request()->routeIs('admin.orders.*') ? 'bg-mint text-charcoal' : 'text-cream/50 hover:bg-cream/5 hover:text-cream' }}">
                    <iconify-icon icon="lucide:clipboard-list" class="text-base"></iconify-icon> PESANAN
                </a>
            </nav>

            <!-- Footer / Logout -->
            <div class="p-6 border-t border-cream/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-4 rounded-xl px-4 py-3.5 text-[10px] font-black tracking-[0.2em] text-[#F87272] ease-premium hover:bg-[#F87272]/5">
                        <iconify-icon icon="lucide:log-out" class="text-base"></iconify-icon> KELUAR
                    </button>
                </form>
            </div>
        </aside>

        <!-- Sidebar - Mobile (Slide-over) -->
        <div x-show="mobileOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
            <div x-show="mobileOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-charcoal/80"></div>
            <div class="fixed inset-0 flex">
                <div x-show="mobileOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex w-full max-w-xs flex-1 flex-col bg-charcoal text-cream" @click.outside="mobileOpen = false">
                    <!-- Close button -->
                    <div class="absolute right-4 top-4">
                        <button @click="mobileOpen = false" class="text-cream/50 hover:text-cream">
                            <iconify-icon icon="lucide:x" class="text-2xl"></iconify-icon>
                        </button>
                    </div>

                    <!-- Brand -->
                    <div class="flex h-20 items-center px-8 border-b border-cream/5">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-lg font-black tracking-tighter">
                            <img src="{{ asset('images/logo.svg') }}" alt="BersihinAja" class="h-7 w-7"> BERSIHINAJA
                        </a>
                    </div>

                    <!-- Profile Info -->
                    <div class="p-6 border-b border-cream/5 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-mint text-charcoal font-black">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-sm truncate text-cream">{{ Auth::user()->name }}</p>
                            <span class="inline-flex rounded-full bg-mint/10 px-2.5 py-0.5 text-[10px] font-black tracking-wider text-mint mt-1">ADMIN</span>
                        </div>
                    </div>

                    <!-- Nav Links -->
                    <nav class="flex-1 p-6 space-y-2 text-[10px] font-black tracking-[0.2em]">
                        <a href="{{ route('admin.dashboard') }}" wire:navigate @click="mobileOpen = false"
                           class="flex items-center gap-4 rounded-xl px-4 py-3.5 ease-premium {{ request()->routeIs('admin.dashboard') ? 'bg-mint text-charcoal' : 'text-cream/50 hover:bg-cream/5 hover:text-cream' }}">
                            <iconify-icon icon="lucide:layout-dashboard" class="text-base"></iconify-icon> DASHBOARD
                        </a>
                        <a href="{{ route('admin.services.index') }}" wire:navigate @click="mobileOpen = false"
                           class="flex items-center gap-4 rounded-xl px-4 py-3.5 ease-premium {{ request()->routeIs('admin.services.*') ? 'bg-mint text-charcoal' : 'text-cream/50 hover:bg-cream/5 hover:text-cream' }}">
                            <iconify-icon icon="lucide:sparkles" class="text-base"></iconify-icon> LAYANAN
                        </a>
                        <a href="{{ route('admin.users.index') }}" wire:navigate @click="mobileOpen = false"
                           class="flex items-center gap-4 rounded-xl px-4 py-3.5 ease-premium {{ request()->routeIs('admin.users.*') ? 'bg-mint text-charcoal' : 'text-cream/50 hover:bg-cream/5 hover:text-cream' }}">
                            <iconify-icon icon="lucide:users" class="text-base"></iconify-icon> PENGGUNA
                        </a>
                        <a href="{{ route('admin.orders.index') }}" wire:navigate @click="mobileOpen = false"
                           class="flex items-center gap-4 rounded-xl px-4 py-3.5 ease-premium {{ request()->routeIs('admin.orders.*') ? 'bg-mint text-charcoal' : 'text-cream/50 hover:bg-cream/5 hover:text-cream' }}">
                            <iconify-icon icon="lucide:clipboard-list" class="text-base"></iconify-icon> PESANAN
                        </a>
                    </nav>

                    <!-- Footer / Logout -->
                    <div class="p-6 border-t border-cream/5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-4 rounded-xl px-4 py-3.5 text-[10px] font-black tracking-[0.2em] text-[#F87272] ease-premium hover:bg-[#F87272]/5">
                                <iconify-icon icon="lucide:log-out" class="text-base"></iconify-icon> KELUAR
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col lg:pl-72 min-h-screen">
            <!-- Mobile Header Top Bar -->
            <header class="flex h-20 items-center justify-between border-b border-charcoal/5 bg-cream px-6 lg:hidden sticky top-0 z-30">
                <button @click="mobileOpen = true" class="text-charcoal hover:text-mint ease-premium">
                    <iconify-icon icon="lucide:menu" class="text-2xl"></iconify-icon>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-lg font-black tracking-tighter">
                    <img src="{{ asset('images/logo.svg') }}" alt="BersihinAja" class="h-7 w-7"> BERSIHINAJA
                </a>
                <span class="inline-flex rounded-full bg-mint/10 px-2.5 py-0.5 text-[10px] font-black tracking-wider text-mint">ADMIN</span>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-6 lg:p-12">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-2xl bg-mint/10 px-6 py-4 reveal active">
                        <iconify-icon icon="lucide:check-circle" class="text-xl text-mint"></iconify-icon>
                        <span class="text-sm font-bold text-charcoal">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 flex items-center gap-3 rounded-2xl bg-[#F87272]/10 px-6 py-4 reveal active">
                        <iconify-icon icon="lucide:alert-circle" class="text-xl text-[#F87272]"></iconify-icon>
                        <span class="text-sm font-bold text-[#F87272]">{{ session('error') }}</span>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
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
