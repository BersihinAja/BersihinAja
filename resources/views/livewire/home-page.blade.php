<div>
    {{-- Hero Section --}}
    <section id="beranda" class="relative flex min-h-screen items-center px-6 pb-14 pt-28 lg:px-12">
        <div class="mx-auto grid w-full max-w-[1344px] items-center gap-12 lg:grid-cols-12">
            <div class="relative z-10 lg:col-span-7">
                <p class="mb-7 text-[10px] font-black tracking-[0.4em] text-mint reveal">// KEBERSIHAN YANG BERARTI</p>
                <h1 class="max-w-4xl text-[17vw] font-black leading-[0.78] tracking-tighter sm:text-7xl lg:text-[9.5vw] reveal">
                    Rumah<br>Bersih,<br>Hidup <em class="font-bold text-mint">nyaman</em>
                </h1>
                <div class="mt-10 max-w-md reveal">
                    <p class="text-xl font-medium leading-snug text-charcoal/70 lg:text-2xl">Layanan pembersihan profesional untuk rumah Anda. Pesan dalam hitungan menit.</p>
                    <a href="{{ route('services.index') }}" wire:navigate class="mt-8 inline-flex items-center gap-3 border-b-2 border-mint pb-2 text-sm font-black uppercase tracking-wide ease-premium hover:gap-5">
                        Lihat Layanan <iconify-icon icon="lucide:arrow-down-right" class="text-xl"></iconify-icon>
                    </a>
                </div>
            </div>
            <div class="relative mt-2 lg:col-span-5 lg:mt-20">
                <div class="group relative aspect-[4/5] overflow-hidden rounded-3xl bg-cream-alt reveal">
                    <img src="https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=1000&q=85" alt="Ruang keluarga modern yang bersih" class="h-full w-full scale-100 object-cover grayscale ease-premium group-hover:scale-[1.08] group-hover:grayscale-0">
                    <div class="absolute inset-0 bg-charcoal/10"></div>
                </div>
                <div class="bounce-slow absolute -bottom-8 -left-8 flex h-32 w-32 flex-col items-center justify-center rounded-full bg-mint text-center shadow-xl sm:h-40 sm:w-40">
                    <span class="text-4xl leading-none">✦</span>
                    <span class="mt-2 text-[10px] font-black tracking-[0.2em]">{{ $this->services->count() }} PAKET<br>BERSIH</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Grid --}}
    <section id="layanan" class="bg-cream-alt px-6 py-24 lg:px-12 lg:py-32">
        <div class="mx-auto max-w-[1344px]">
            <div class="mb-14 reveal">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// LAYANAN KAMI</p>
                <h2 class="mt-5 text-5xl font-black leading-[0.85] tracking-tighter sm:text-7xl lg:text-8xl">Pilih Paket<br>Kebersihan</h2>
            </div>
            <div class="grid border border-charcoal/10 md:grid-cols-3 reveal">
                @php
                    $icons = ['lucide:spray-can', 'lucide:brush-cleaning', 'lucide:paintbrush'];
                @endphp
                @foreach ($this->services as $index => $service)
                <article wire:key="service-{{ $service->id }}" class="group flex min-h-[420px] flex-col {{ !$loop->last ? 'border-b border-charcoal/10 md:border-b-0 md:border-r' : '' }} bg-cream p-8 ease-premium hover:bg-mint lg:p-10">
                    <iconify-icon icon="{{ $icons[$index] ?? 'lucide:sparkles' }}" class="text-5xl text-mint ease-premium group-hover:text-charcoal"></iconify-icon>
                    <h3 class="mt-12 text-3xl font-black uppercase tracking-tighter">{{ $service->name }}</h3>
                    <p class="mt-4 text-sm font-medium leading-relaxed text-charcoal/70">Ruangan {{ $service->room_size }}<br>{{ $service->estimation }} · {{ $service->cleaners_required }} pekerja</p>
                    <div class="mt-auto">
                        <div class="flex items-start">
                            <span class="mt-2 text-[10px] font-black tracking-[0.2em]">Rp</span>
                            <span class="text-5xl font-black tracking-tighter">{{ number_format($service->price, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('services.show', $service->slug) }}" wire:navigate class="mt-5 inline-flex border-b-2 border-charcoal pb-1 text-xs font-black uppercase tracking-widest ease-premium group-hover:border-charcoal">
                            Pesan <iconify-icon icon="lucide:arrow-up-right" class="ml-2 text-base"></iconify-icon>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="cara-kerja" class="px-6 py-24 lg:px-12 lg:py-32">
        <div class="mx-auto max-w-[1344px]">
            <div class="reveal">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// CARA KERJA</p>
                <h2 class="mt-5 text-5xl font-black leading-[0.85] tracking-tighter sm:text-7xl">Semudah 1-2-3</h2>
            </div>
            <div class="relative mt-20 grid gap-10 md:grid-cols-4 reveal">
                <div class="absolute left-10 right-10 top-10 hidden h-px bg-mint/40 md:block"></div>
                @php
                    $steps = [
                        ['num' => '01', 'title' => 'Pilih Layanan', 'desc' => 'Pilih paket yang paling sesuai kebutuhan rumah Anda.'],
                        ['num' => '02', 'title' => 'Tentukan Lokasi', 'desc' => 'Masukkan alamat dan pilih waktu layanan terbaik.'],
                        ['num' => '03', 'title' => 'Bayar Online', 'desc' => 'Transaksi aman dan praktis dengan pembayaran digital.'],
                        ['num' => '04', 'title' => 'Rumah Bersih', 'desc' => 'Tim profesional hadir dan rumah Anda kembali segar.'],
                    ];
                @endphp
                @foreach ($steps as $step)
                <div class="relative" wire:key="step-{{ $step['num'] }}">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full border-2 border-mint bg-cream text-2xl font-black ease-premium hover:bg-mint">{{ $step['num'] }}</div>
                    <h3 class="mt-7 text-sm font-black uppercase tracking-wide">{{ $step['title'] }}</h3>
                    <p class="mt-3 max-w-[180px] text-sm leading-relaxed text-charcoal/60">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Add-on Packages --}}
    <section class="bg-cream-alt px-6 py-24 lg:px-12 lg:py-32">
        <div class="mx-auto max-w-[1344px]">
            <div class="reveal">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PAKET TAMBAHAN</p>
                <h2 class="mt-5 text-5xl font-black leading-[0.85] tracking-tighter sm:text-7xl">Tingkatkan Kebersihan</h2>
            </div>
            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4 reveal">
                @php
                    $packageIcons = ['lucide:armchair', 'lucide:heater', 'lucide:trees', 'lucide:leaf'];
                @endphp
                @foreach ($this->packages as $index => $package)
                <article wire:key="package-{{ $package->id }}" class="border-l-4 border-transparent bg-cream p-7 shadow-sm ease-premium hover:-translate-y-2 hover:border-mint">
                    <iconify-icon icon="{{ $packageIcons[$index] ?? 'lucide:package' }}" class="text-3xl text-mint"></iconify-icon>
                    <h3 class="mt-8 text-xl font-black">{{ $package->name }}</h3>
                    <p class="mt-2 text-sm text-charcoal/60">{{ $package->description }}</p>
                    <p class="mt-7 text-xl font-black">Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Portfolio / Before-After --}}
    <section class="px-6 py-24 lg:px-12 lg:py-32">
        <div class="mx-auto max-w-5xl">
            <div class="reveal">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// SEBELUM &amp; SESUDAH</p>
                <h2 class="mt-5 text-5xl font-black leading-[0.85] tracking-tighter sm:text-7xl">Bukti yang<br>Berbicara</h2>
            </div>
            <div class="mt-16 grid gap-x-8 gap-y-12 md:grid-cols-2">
                <article class="group reveal">
                    <div class="relative aspect-[3/4] overflow-hidden rounded-2xl">
                        <img src="https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=900&q=85" alt="Ruang tamu bersih" class="h-full w-full object-cover grayscale ease-premium group-hover:scale-[1.08] group-hover:grayscale-0">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 ease-premium group-hover:opacity-100">
                            <span class="flex h-24 w-24 items-center justify-center rounded-full bg-mint text-center text-[10px] font-black uppercase tracking-wide text-white">Lihat<br>Detail</span>
                        </div>
                    </div>
                    <p class="mt-5 text-[10px] font-black tracking-[0.3em] text-mint">RUANG TAMU</p>
                    <h3 class="mt-2 text-3xl font-black tracking-tighter">Kembali Bernapas</h3>
                    <p class="mt-2 text-xs text-charcoal/50">Deep clean <span class="mx-2">&bull;</span> Jakarta Selatan</p>
                </article>
                <article class="group mt-0 reveal md:mt-24">
                    <div class="relative aspect-[3/4] overflow-hidden rounded-2xl">
                        <img src="https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=900&q=85" alt="Dapur bersih" class="h-full w-full object-cover grayscale ease-premium group-hover:scale-[1.08] group-hover:grayscale-0">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 ease-premium group-hover:opacity-100">
                            <span class="flex h-24 w-24 items-center justify-center rounded-full bg-mint text-center text-[10px] font-black uppercase tracking-wide text-white">Lihat<br>Detail</span>
                        </div>
                    </div>
                    <p class="mt-5 text-[10px] font-black tracking-[0.3em] text-mint">DAPUR</p>
                    <h3 class="mt-2 text-3xl font-black tracking-tighter">Mengilap Kembali</h3>
                    <p class="mt-2 text-xs text-charcoal/50">Kitchen care <span class="mx-2">&bull;</span> Jakarta Barat</p>
                </article>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="bg-charcoal px-6 py-24 text-cream lg:px-12 lg:py-32">
        <div class="mx-auto grid max-w-[1100px] gap-8 md:grid-cols-12">
            <div class="md:col-span-3 reveal">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// KATA MEREKA</p>
                <div class="mt-10 text-8xl leading-none text-mint">&ldquo;</div>
            </div>
            <div class="md:col-span-9 reveal">
                <blockquote class="text-3xl font-semibold italic leading-tight tracking-tight sm:text-4xl">BersihinAja membuat rumah terasa benar-benar baru. Timnya datang tepat waktu, teliti, dan sangat profesional.</blockquote>
                <div class="mt-10 flex items-center gap-1 text-[#FBBD23]">
                    @for ($i = 0; $i < 5; $i++)
                        <iconify-icon icon="lucide:star" class="fill-current"></iconify-icon>
                    @endfor
                </div>
                <p class="mt-5 text-sm font-black uppercase tracking-wide">Nadia Prameswari <span class="ml-3 font-medium text-cream/50">Pelanggan sejak 2024</span></p>
            </div>
        </div>
    </section>
</div>
