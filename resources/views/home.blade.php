<x-app-layout>
    <!-- Hero Section -->
    <div class="hero min-h-[70vh]" style="background: linear-gradient(135deg, oklch(var(--p)) 0%, oklch(var(--s)) 100%);">
        <div class="hero-overlay bg-opacity-40"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-2xl">
                <h1 class="mb-5 text-5xl font-bold tracking-tight">BersihinAja</h1>
                <p class="mb-8 text-xl opacity-90">Layanan kebersihan profesional untuk rumah dan kantor Anda. Pesan dengan mudah, bayar aman, rumah bersih tanpa ribet.</p>
                <a href="{{ route('services.index') }}" class="btn btn-accent btn-lg gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Lihat Layanan
                </a>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <section class="py-20 px-4 bg-base-200">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-4xl font-bold text-base-content">Layanan Kami</h2>
                <p class="mt-3 text-lg text-base-content/60">Pilih layanan kebersihan sesuai kebutuhan Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($services as $service)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                        @if($service->image)
                            <figure class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
                            </figure>
                        @else
                            <figure class="h-48 bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" /></svg>
                            </figure>
                        @endif
                        <div class="card-body">
                            <h3 class="card-title text-base-content">{{ $service->name }}</h3>
                            <div class="flex flex-wrap gap-2 my-2">
                                <span class="badge badge-primary badge-outline">{{ $service->room_size }}</span>
                                <span class="badge badge-accent badge-outline">{{ $service->estimation }}</span>
                            </div>
                            <p class="text-2xl font-bold text-primary">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            <div class="card-actions justify-end mt-4">
                                <a href="{{ route('services.show', $service->slug) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-base-content/50 text-lg">Belum ada layanan tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 px-4 bg-base-100">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-base-content mb-14">Kenapa Memilih BersihinAja?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Pekerja Terverifikasi</h3>
                    <p class="text-base-content/60">Semua pekerja kami telah melalui proses seleksi dan verifikasi identitas yang ketat.</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-success/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Pembayaran Aman</h3>
                    <p class="text-base-content/60">Transaksi aman melalui Midtrans dengan berbagai metode pembayaran yang tersedia.</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Proses Cepat</h3>
                    <p class="text-base-content/60">Pesan layanan dalam hitungan menit, pekerja langsung ditugaskan ke lokasi Anda.</p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
