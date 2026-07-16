<x-guest-public-layout>
    <x-slot:title>Semua Layanan — BersihinAja</x-slot:title>

    {{-- Hero Banner --}}
    <section class="px-6 pb-16 pt-32 lg:px-12">
        <div class="mx-auto max-w-[1344px]">
            <div class="reveal">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// LAYANAN KAMI</p>
                <h1 class="mt-5 text-5xl font-black leading-[0.85] tracking-tighter sm:text-7xl lg:text-8xl">Semua<br>Layanan</h1>
                <p class="mt-6 max-w-lg text-lg font-medium text-charcoal/60">Temukan layanan kebersihan yang sesuai dengan kebutuhan Anda</p>
            </div>
        </div>
    </section>

    {{-- Services Grid --}}
    <section class="bg-cream-alt px-6 py-24 lg:px-12 lg:py-32">
        <div class="mx-auto max-w-[1344px]">
            @if($services->count() > 0)
                <div class="grid border border-charcoal/10 md:grid-cols-3 reveal">
                    @php
                        $icons = ['lucide:spray-can', 'lucide:brush-cleaning', 'lucide:paintbrush'];
                    @endphp
                    @foreach ($services as $index => $service)
                    <article class="group flex min-h-[480px] flex-col {{ !$loop->last ? 'border-b border-charcoal/10 md:border-b-0 md:border-r' : '' }} bg-cream p-8 ease-premium hover:bg-mint lg:p-10">
                        <iconify-icon icon="{{ $icons[$index] ?? 'lucide:sparkles' }}" class="text-5xl text-mint ease-premium group-hover:text-charcoal"></iconify-icon>
                        <h3 class="mt-10 text-3xl font-black uppercase tracking-tighter">{{ $service->name }}</h3>
                        <p class="mt-4 text-sm font-medium leading-relaxed text-charcoal/70">{{ $service->description }}</p>
                        
                        <div class="mt-6 flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-1 text-[10px] font-black tracking-[0.15em] text-charcoal/50">
                                <iconify-icon icon="lucide:home" class="text-sm text-mint ease-premium group-hover:text-charcoal"></iconify-icon>
                                {{ $service->room_size }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[10px] font-black tracking-[0.15em] text-charcoal/50">
                                <iconify-icon icon="lucide:clock" class="text-sm text-mint ease-premium group-hover:text-charcoal"></iconify-icon>
                                {{ $service->estimation }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[10px] font-black tracking-[0.15em] text-charcoal/50">
                                <iconify-icon icon="lucide:users" class="text-sm text-mint ease-premium group-hover:text-charcoal"></iconify-icon>
                                {{ $service->cleaners_required }} pekerja
                            </span>
                        </div>

                        @if($service->packages->count() > 0)
                            <p class="mt-3 text-[10px] font-bold text-charcoal/40">{{ $service->packages->count() }} paket tambahan tersedia</p>
                        @endif

                        <div class="mt-auto pt-8">
                            <div class="flex items-start">
                                <span class="mt-2 text-[10px] font-black tracking-[0.2em]">Rp</span>
                                <span class="text-5xl font-black tracking-tighter">{{ number_format($service->price, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('services.show', $service->slug) }}" class="mt-5 inline-flex items-center border-b-2 border-charcoal pb-1 text-xs font-black uppercase tracking-widest ease-premium group-hover:border-charcoal">
                                Lihat Detail <iconify-icon icon="lucide:arrow-up-right" class="ml-2 text-base"></iconify-icon>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-charcoal/10 bg-cream p-12 text-center reveal">
                    <iconify-icon icon="lucide:info" class="text-4xl text-mint"></iconify-icon>
                    <p class="mt-4 text-lg font-medium text-charcoal/60">Belum ada layanan tersedia saat ini.</p>
                </div>
            @endif
        </div>
    </section>
</x-guest-public-layout>
