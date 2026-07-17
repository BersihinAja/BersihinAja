<header class="fixed inset-x-0 top-0 z-50 h-20 border-b border-charcoal/5 bg-[rgba(250,252,251,0.85)] backdrop-blur-xl">
    <nav class="mx-auto flex h-full max-w-[1440px] items-center justify-between px-6 lg:px-12" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 text-lg font-black tracking-tighter">
            <img src="{{ asset('images/logo.svg') }}" alt="BersihinAja" class="h-7 w-7"> BERSIHINAJA
        </a>
        <div class="hidden items-center gap-8 text-[10px] font-black tracking-[0.2em] lg:flex">
            <a href="{{ route('home') }}" wire:navigate class="ease-premium hover:text-mint">BERANDA</a>
            <a href="{{ route('services.index') }}" wire:navigate class="ease-premium hover:text-mint">LAYANAN</a>
            <a href="{{ route('home') }}#cara-kerja" class="ease-premium hover:text-mint">CARA KERJA</a>
            <a href="{{ route('home') }}#kontak" class="ease-premium hover:text-mint">KONTAK</a>
        </div>
        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" wire:navigate class="hidden text-[10px] font-bold tracking-wide ease-premium hover:text-mint lg:inline-block">MASUK</a>
                <a href="{{ route('services.index') }}" wire:navigate class="rounded-full bg-mint px-5 py-3 text-[10px] font-bold tracking-wide text-charcoal ease-premium hover:bg-purple hover:text-white lg:px-8">PESAN SEKARANG</a>
            @else
                {{-- User Dropdown --}}
                <div class="relative hidden lg:block" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 rounded-full border border-charcoal/10 px-4 py-2.5 ease-premium hover:border-mint">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-mint text-xs font-black text-charcoal">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="text-[10px] font-black tracking-wide">{{ Str::upper(Str::limit(Auth::user()->name, 12)) }}</span>
                        <iconify-icon icon="lucide:chevron-down" class="text-sm text-charcoal/40 ease-premium" :class="open && 'rotate-180'"></iconify-icon>
                    </button>

                    <div x-show="open" x-transition:enter="ease-premium" x-transition:enter-start="translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute right-0 mt-3 w-56 rounded-2xl border border-charcoal/5 bg-cream p-2 shadow-xl">
                        <a href="{{ route('profile.edit') }}" wire:navigate class="flex items-center gap-3 rounded-xl px-4 py-3 text-xs font-bold text-charcoal ease-premium hover:bg-cream-alt">
                            <iconify-icon icon="lucide:user" class="text-base text-mint"></iconify-icon> Profil Saya
                        </a>
                        <a href="{{ route('orders.history') }}" wire:navigate class="flex items-center gap-3 rounded-xl px-4 py-3 text-xs font-bold text-charcoal ease-premium hover:bg-cream-alt">
                            <iconify-icon icon="lucide:clipboard-list" class="text-base text-mint"></iconify-icon> Riwayat Pesanan
                        </a>
                        <a href="{{ route('services.index') }}" wire:navigate class="flex items-center gap-3 rounded-xl px-4 py-3 text-xs font-bold text-charcoal ease-premium hover:bg-cream-alt">
                            <iconify-icon icon="lucide:plus-circle" class="text-base text-mint"></iconify-icon> Pesan Sekarang
                        </a>
                        <div class="my-1 border-t border-charcoal/5"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-xs font-bold text-[#F87272] ease-premium hover:bg-[#F87272]/5">
                                <iconify-icon icon="lucide:log-out" class="text-base"></iconify-icon> Keluar
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mobile: keep CTA visible --}}
                <a href="{{ route('services.index') }}" wire:navigate class="rounded-full bg-mint px-5 py-3 text-[10px] font-bold tracking-wide text-charcoal ease-premium hover:bg-purple hover:text-white lg:hidden lg:px-8">PESAN SEKARANG</a>
            @endguest
        </div>
        <!-- Mobile Menu Button -->
        <button x-data x-on:click="$dispatch('toggle-mobile-menu')" class="lg:hidden">
            <iconify-icon icon="lucide:menu" class="text-2xl"></iconify-icon>
        </button>
    </nav>
</header>

<!-- Mobile Menu -->
<div x-data="{ open: false }" x-on:toggle-mobile-menu.window="open = !open" x-show="open" x-transition class="fixed inset-0 z-[60] bg-cream p-6 pt-24 lg:hidden">
    <button x-on:click="open = false" class="absolute right-6 top-6">
        <iconify-icon icon="lucide:x" class="text-2xl"></iconify-icon>
    </button>
    <div class="flex flex-col gap-6 text-lg font-black">
        <a href="{{ route('home') }}" wire:navigate x-on:click="open = false">Beranda</a>
        <a href="{{ route('services.index') }}" wire:navigate x-on:click="open = false">Layanan</a>
        <a href="{{ route('home') }}#cara-kerja" x-on:click="open = false">Cara Kerja</a>
        <a href="{{ route('home') }}#kontak" x-on:click="open = false">Kontak</a>
        <hr class="border-charcoal/10">
        @guest
            <a href="{{ route('login') }}" wire:navigate x-on:click="open = false">Masuk</a>
            <a href="{{ route('register') }}" wire:navigate x-on:click="open = false">Daftar</a>
        @else
            <a href="{{ route('profile.edit') }}" wire:navigate x-on:click="open = false" class="flex items-center gap-3">
                <iconify-icon icon="lucide:user" class="text-mint"></iconify-icon> Profil Saya
            </a>
            <a href="{{ route('orders.history') }}" wire:navigate x-on:click="open = false" class="flex items-center gap-3">
                <iconify-icon icon="lucide:clipboard-list" class="text-mint"></iconify-icon> Riwayat Pesanan
            </a>
            <hr class="border-charcoal/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-[#F87272]">
                    <iconify-icon icon="lucide:log-out"></iconify-icon> Keluar
                </button>
            </form>
        @endguest
    </div>
</div>
