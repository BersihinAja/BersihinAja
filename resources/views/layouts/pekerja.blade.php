<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="bersihinaja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Dashboard' }} — Pekerja | {{ config('app.name', 'BersihinAja') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-base-200 min-h-screen">
        <div class="drawer lg:drawer-open">
            <input id="pekerja-drawer" type="checkbox" class="drawer-toggle" />

            <!-- Main Content -->
            <div class="drawer-content flex flex-col">
                <!-- Top bar (mobile) -->
                <div class="navbar bg-base-100 shadow-sm lg:hidden">
                    <div class="flex-none">
                        <label for="pekerja-drawer" class="btn btn-square btn-ghost drawer-button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </label>
                    </div>
                    <div class="flex-1">
                        <span class="text-lg font-bold">BersihinAja</span>
                    </div>
                    <div class="flex-none">
                        <div class="badge badge-sm {{ Auth::user()->status === 'available' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst(Auth::user()->status ?? 'available') }}
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="flex-1 p-4 lg:p-8">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success mb-6 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error mb-6 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>

            <!-- Sidebar -->
            <div class="drawer-side z-40">
                <label for="pekerja-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                <aside class="bg-base-100 w-72 min-h-full flex flex-col border-r border-base-300">
                    <!-- Sidebar Header -->
                    <div class="p-6 border-b border-base-300">
                        <a href="{{ route('pekerja.dashboard') }}" class="flex items-center gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-10">
                                    <span class="text-lg font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-base-content truncate">{{ Auth::user()->name }}</p>
                                <div class="badge badge-sm mt-1 {{ Auth::user()->status === 'available' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst(Auth::user()->status ?? 'available') }}
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 p-4">
                        <ul class="menu gap-1">
                            <li>
                                <a href="{{ route('pekerja.dashboard') }}"
                                   class="{{ request()->routeIs('pekerja.dashboard') ? 'active' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pekerja.orders.index') }}"
                                   class="{{ request()->routeIs('pekerja.orders.*') ? 'active' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    Pesanan Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pekerja.customers.index') }}"
                                   class="{{ request()->routeIs('pekerja.customers.*') ? 'active' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Pelanggan
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Sidebar Footer -->
                    <div class="p-4 border-t border-base-300">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-block justify-start gap-3 text-error">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
