<nav x-data="{ open: false }" class="bg-base-100 border-b border-base-300 sticky top-0 z-50 backdrop-blur-lg bg-base-100/90">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-xl font-bold text-primary">BersihinAja</span>
                </a>

                {{-- Desktop Navigation Links --}}
                <div class="hidden sm:flex sm:items-center sm:ml-10 space-x-1">
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm {{ request()->routeIs('home') ? 'btn-active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('services.index') }}" class="btn btn-ghost btn-sm {{ request()->routeIs('services.*') ? 'btn-active' : '' }}">
                        Layanan
                    </a>
                    @auth
                        <a href="{{ route('orders.history') }}" class="btn btn-ghost btn-sm {{ request()->routeIs('orders.*') ? 'btn-active' : '' }}">
                            Riwayat Pesanan
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Right side --}}
            <div class="flex items-center">
                @auth
                    {{-- User Dropdown --}}
                    <div class="hidden sm:flex sm:items-center">
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-sm gap-2">
                                <div class="avatar">
                                    <div class="w-7 rounded-full">
                                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=28&background=570df8&color=fff' }}" alt="" />
                                    </div>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                            <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                                <li><a href="{{ route('profile.edit') }}" class="gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Profil
                                </a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="gap-2 w-full text-left">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex sm:items-center space-x-2">
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                    </div>
                @endauth

                {{-- Mobile Hamburger --}}
                <div class="sm:hidden">
                    <button @click="open = !open" class="btn btn-ghost btn-sm">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-base-300">
        <div class="p-4 space-y-2">
            <a href="{{ route('home') }}" class="btn btn-ghost btn-block justify-start {{ request()->routeIs('home') ? 'btn-active' : '' }}">Beranda</a>
            <a href="{{ route('services.index') }}" class="btn btn-ghost btn-block justify-start {{ request()->routeIs('services.*') ? 'btn-active' : '' }}">Layanan</a>
            @auth
                <a href="{{ route('orders.history') }}" class="btn btn-ghost btn-block justify-start {{ request()->routeIs('orders.*') ? 'btn-active' : '' }}">Riwayat Pesanan</a>
            @endauth
        </div>

        @auth
            <div class="border-t border-base-300 p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=40&background=570df8&color=fff' }}" alt="" />
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-base-content">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-base-content/50">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="btn btn-ghost btn-block justify-start btn-sm">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-block justify-start btn-sm text-error">Keluar</button>
                </form>
            </div>
        @else
            <div class="border-t border-base-300 p-4 space-y-2">
                <a href="{{ route('login') }}" class="btn btn-ghost btn-block">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-block">Daftar</a>
            </div>
        @endauth
    </div>
</nav>
