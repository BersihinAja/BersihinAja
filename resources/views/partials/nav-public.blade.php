<header class="fixed inset-x-0 top-0 z-50 h-20 border-b border-charcoal/5 bg-[rgba(250,252,251,0.85)] backdrop-blur-xl">
    <nav class="mx-auto flex h-full max-w-[1440px] items-center justify-between px-6 lg:px-12" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-black tracking-tighter">
            <iconify-icon icon="lucide:sparkles" class="text-xl text-mint"></iconify-icon> BERSIHINAJA
        </a>
        <div class="hidden items-center gap-8 text-[10px] font-black tracking-[0.2em] lg:flex">
            <a href="{{ route('home') }}" class="ease-premium hover:text-mint">BERANDA</a>
            <a href="{{ route('services.index') }}" class="ease-premium hover:text-mint">LAYANAN</a>
            <a href="#cara-kerja" class="ease-premium hover:text-mint">CARA KERJA</a>
            <a href="#kontak" class="ease-premium hover:text-mint">KONTAK</a>
        </div>
        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="hidden text-[10px] font-bold tracking-wide ease-premium hover:text-mint lg:inline-block">MASUK</a>
                <a href="{{ route('services.index') }}" class="rounded-full bg-mint px-5 py-3 text-[10px] font-bold tracking-wide text-charcoal ease-premium hover:bg-purple hover:text-white lg:px-8">PESAN SEKARANG</a>
            @else
                <a href="{{ route('orders.history') }}" class="hidden text-[10px] font-bold tracking-wide ease-premium hover:text-mint lg:inline-block">PESANAN</a>
                <a href="{{ route('services.index') }}" class="rounded-full bg-mint px-5 py-3 text-[10px] font-bold tracking-wide text-charcoal ease-premium hover:bg-purple hover:text-white lg:px-8">PESAN SEKARANG</a>
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
        <a href="{{ route('home') }}" x-on:click="open = false">Beranda</a>
        <a href="{{ route('services.index') }}" x-on:click="open = false">Layanan</a>
        <a href="#cara-kerja" x-on:click="open = false">Cara Kerja</a>
        <a href="#kontak" x-on:click="open = false">Kontak</a>
        <hr class="border-charcoal/10">
        @guest
            <a href="{{ route('login') }}" x-on:click="open = false">Masuk</a>
            <a href="{{ route('register') }}" x-on:click="open = false">Daftar</a>
        @else
            <a href="{{ route('orders.history') }}" x-on:click="open = false">Riwayat Pesanan</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-left">Keluar</button>
            </form>
        @endguest
    </div>
</div>
