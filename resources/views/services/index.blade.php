<x-app-layout>
    <div class="py-12 px-4 bg-base-200 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-base-content">Semua Layanan</h1>
                <p class="mt-2 text-base-content/60">Temukan layanan kebersihan yang sesuai dengan kebutuhan Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($services as $service)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                        @if($service->image)
                            <figure class="h-52 overflow-hidden">
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover" />
                            </figure>
                        @else
                            <figure class="h-52 bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-primary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </figure>
                        @endif
                        <div class="card-body">
                            <h2 class="card-title text-base-content">{{ $service->name }}</h2>
                            <p class="text-base-content/60 text-sm line-clamp-2">{{ $service->description }}</p>

                            <div class="flex flex-wrap gap-2 my-3">
                                <div class="badge badge-primary badge-outline gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" /></svg>
                                    {{ $service->room_size }}
                                </div>
                                <div class="badge badge-accent badge-outline gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $service->estimation }}
                                </div>
                                <div class="badge badge-neutral gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $service->cleaners_required }} pekerja
                                </div>
                            </div>

                            @if($service->packages->count() > 0)
                                <div class="text-xs text-base-content/40">
                                    {{ $service->packages->count() }} paket tambahan tersedia
                                </div>
                            @endif

                            <div class="divider my-1"></div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-base-content/40">Mulai dari</span>
                                    <p class="text-xl font-bold text-primary">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('services.show', $service->slug) }}" class="btn btn-primary btn-sm">Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Belum ada layanan tersedia saat ini.</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
