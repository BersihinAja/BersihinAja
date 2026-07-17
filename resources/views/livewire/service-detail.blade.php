<div>
    {{-- Breadcrumb + Hero --}}
    <section class="px-6 pb-12 pt-28 lg:px-12">
        <div class="mx-auto max-w-[1100px]">
            {{-- Breadcrumb --}}
            <nav class="mb-10 flex items-center gap-2 text-[10px] font-bold tracking-[0.15em] text-charcoal/40 reveal active">
                <a href="{{ route('home') }}" wire:navigate class="ease-premium hover:text-mint">BERANDA</a>
                <iconify-icon icon="lucide:chevron-right" class="text-sm"></iconify-icon>
                <a href="{{ route('services.index') }}" wire:navigate class="ease-premium hover:text-mint">LAYANAN</a>
                <iconify-icon icon="lucide:chevron-right" class="text-sm"></iconify-icon>
                <span class="text-charcoal">{{ strtoupper($service->name) }}</span>
            </nav>

            {{-- Service Header --}}
            <div class="grid gap-10 lg:grid-cols-12 reveal active">
                {{-- Image --}}
                <div class="lg:col-span-5">
                    <div class="group relative aspect-[4/5] overflow-hidden rounded-3xl bg-cream-alt">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="h-full w-full object-cover grayscale ease-premium group-hover:scale-[1.08] group-hover:grayscale-0">
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <iconify-icon icon="lucide:sparkles" class="text-8xl text-mint/30"></iconify-icon>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Info --}}
                <div class="lg:col-span-7">
                    <p class="text-[10px] font-black tracking-[0.4em] text-mint">// DETAIL LAYANAN</p>
                    <h1 class="mt-4 text-5xl font-black tracking-tighter sm:text-6xl">{{ $service->name }}</h1>
                    <p class="mt-6 text-lg font-medium leading-relaxed text-charcoal/70">{{ $service->description }}</p>

                    {{-- Stats Grid --}}
                    <div class="mt-10 grid grid-cols-2 gap-4 md:grid-cols-4">
                        <div class="rounded-2xl bg-cream-alt p-5">
                            <p class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">HARGA</p>
                            <div class="mt-2 flex items-start">
                                <span class="mt-1 text-[10px] font-black tracking-[0.1em]">Rp</span>
                                <span class="text-2xl font-black tracking-tighter text-mint">{{ number_format($service->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="rounded-2xl bg-cream-alt p-5">
                            <p class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">RUANGAN</p>
                            <p class="mt-2 text-2xl font-black tracking-tighter">{{ $service->room_size }}</p>
                        </div>
                        <div class="rounded-2xl bg-cream-alt p-5">
                            <p class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">ESTIMASI</p>
                            <p class="mt-2 text-2xl font-black tracking-tighter">{{ $service->estimation }}</p>
                        </div>
                        <div class="rounded-2xl bg-cream-alt p-5">
                            <p class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">MAKS. JAM</p>
                            <p class="mt-2 text-2xl font-black tracking-tighter">{{ $service->max_hours }} jam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Packages --}}
    @if($service->packages->count() > 0)
    <section class="bg-cream-alt px-6 py-16 lg:px-12">
        <div class="mx-auto max-w-[1100px]">
            <div class="reveal active">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PAKET TAMBAHAN</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter sm:text-4xl">Tingkatkan Layanan</h2>
            </div>
            <div class="mt-10 grid gap-5 sm:grid-cols-2 reveal active">
                @php
                    $pkgIcons = ['lucide:armchair', 'lucide:heater', 'lucide:trees', 'lucide:leaf'];
                @endphp
                @foreach($service->packages as $i => $package)
                <article wire:key="package-{{ $package->id }}" class="flex items-start gap-5 border-l-4 border-transparent bg-cream p-6 shadow-sm ease-premium hover:-translate-y-1 hover:border-mint">
                    <iconify-icon icon="{{ $pkgIcons[$i] ?? 'lucide:package' }}" class="mt-1 text-2xl text-mint"></iconify-icon>
                    <div>
                        <h3 class="text-lg font-black">{{ $package->name }}</h3>
                        <p class="mt-1 text-sm text-charcoal/60">{{ $package->description }}</p>
                        <p class="mt-3 text-lg font-black text-mint">+ Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Region Selection & Order CTA --}}
    <section class="px-6 py-16 lg:px-12">
        <div class="mx-auto max-w-[1100px]">
            <div class="reveal active">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PESAN SEKARANG</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter sm:text-4xl">Pilih Lokasi Anda</h2>
            </div>
            <div class="mt-10 rounded-3xl bg-cream-alt p-8 lg:p-12 reveal active">
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PROVINSI</label>
                        <select wire:model.live="selectedProvince" class="w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                            @endforeach
                        </select>
                        <div wire:loading wire:target="selectedProvince" class="mt-2 flex items-center gap-1.5 text-xs font-bold text-mint">
                            <iconify-icon icon="lucide:loader" class="animate-spin"></iconify-icon> Memuat kabupaten/kota...
                        </div>
                    </div>
                    <div>
                        <label class="mb-2 block text-[10px] font-black tracking-[0.2em] text-charcoal/50">KABUPATEN / KOTA</label>
                        <select wire:model.live="selectedRegency" class="w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20" @disabled(empty($regencies))>
                            <option value="">Pilih Kabupaten/Kota</option>
                            @foreach($regencies as $regency)
                                <option value="{{ $regency['id'] }}">{{ $regency['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-10 flex justify-end">
                    @auth
                        <button wire:click="order" class="inline-flex items-center gap-2 rounded-full bg-mint px-10 py-4 text-sm font-black uppercase tracking-wide text-charcoal ease-premium hover:bg-purple hover:text-white disabled:pointer-events-none disabled:opacity-40" @disabled(empty($selectedRegency))>
                            Pesan Sekarang <iconify-icon icon="lucide:arrow-right" class="text-lg"></iconify-icon>
                        </button>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 rounded-full bg-mint px-10 py-4 text-sm font-black uppercase tracking-wide text-charcoal ease-premium hover:bg-purple hover:text-white">
                            Login untuk Memesan <iconify-icon icon="lucide:log-in" class="text-lg"></iconify-icon>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
</div>
