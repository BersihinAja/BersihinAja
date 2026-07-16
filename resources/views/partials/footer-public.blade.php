<footer id="kontak" class="bg-cream-alt px-6 pb-8 pt-20 lg:px-12">
    <div class="mx-auto max-w-[1344px]">
        <div class="grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-black tracking-tighter">
                    <iconify-icon icon="lucide:sparkles" class="text-mint"></iconify-icon>BERSIHINAJA
                </a>
                <p class="mt-5 max-w-xs text-lg font-medium leading-relaxed text-charcoal/60">Platform layanan kebersihan rumah terpercaya di Indonesia.</p>
            </div>
            <div class="grid grid-cols-3 gap-6 lg:col-span-7">
                <div>
                    <h3 class="border-b-2 border-mint pb-2 text-[10px] font-black tracking-[0.2em] text-mint">NAVIGASI</h3>
                    <div class="mt-5 space-y-3 text-xs font-bold">
                        <a href="{{ route('home') }}" class="block">Beranda</a>
                        <a href="{{ route('services.index') }}" class="block">Layanan</a>
                        @auth
                            <a href="{{ route('orders.history') }}" class="block">Riwayat Pesanan</a>
                            <a href="{{ route('profile.edit') }}" class="block">Profil</a>
                        @endauth
                    </div>
                </div>
                <div>
                    <h3 class="border-b-2 border-mint pb-2 text-[10px] font-black tracking-[0.2em] text-mint">LAYANAN</h3>
                    <div class="mt-5 space-y-3 text-xs font-bold">
                        <a href="{{ route('services.index') }}" class="block">Small</a>
                        <a href="{{ route('services.index') }}" class="block">Medium</a>
                        <a href="{{ route('services.index') }}" class="block">Large</a>
                        <a href="{{ route('services.index') }}" class="block">Paket Tambahan</a>
                    </div>
                </div>
                <div>
                    <h3 class="border-b-2 border-mint pb-2 text-[10px] font-black tracking-[0.2em] text-mint">KONTAK</h3>
                    <div class="mt-5 space-y-3 text-xs font-bold">
                        <a href="mailto:halo@bersihinaja.id" class="block">Email</a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="block">WhatsApp</a>
                        <a href="https://instagram.com" target="_blank" class="block">Instagram</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-20 flex flex-col justify-between gap-4 border-t border-charcoal/10 pt-6 text-[9px] font-bold tracking-wide text-charcoal/30 sm:flex-row">
            <p>&copy; {{ date('Y') }} BERSIHINAJA. SEMUA HAK DILINDUNGI.</p>
            <div class="flex gap-5">
                <a href="#">KEBIJAKAN PRIVASI</a>
                <a href="#">SYARAT &amp; KETENTUAN</a>
            </div>
        </div>
    </div>
</footer>
