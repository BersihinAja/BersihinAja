<x-app-layout>
    <div class="py-12 px-4 bg-base-200 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="text-sm breadcrumbs mb-6">
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a></li>
                    <li class="text-base-content/60">Buat Pesanan</li>
                </ul>
            </div>

            <h1 class="text-3xl font-bold text-base-content mb-8">Buat Pesanan</h1>

            <form action="{{ route('orders.store') }}" method="POST" x-data="orderForm()">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="regency_name" value="{{ $regencyName }}">

                {{-- Service Summary --}}
                <div class="card bg-base-100 shadow-lg mb-6">
                    <div class="card-body">
                        <h2 class="card-title text-base-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Ringkasan Layanan
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            <div>
                                <span class="text-xs text-base-content/50">Layanan</span>
                                <p class="font-semibold">{{ $service->name }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-base-content/50">Harga Dasar</span>
                                <p class="font-semibold text-primary">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-base-content/50">Lokasi</span>
                                <p class="font-semibold">{{ $regencyName }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-base-content/50">Estimasi</span>
                                <p class="font-semibold">{{ $service->estimation }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Worker Selection --}}
                <div class="card bg-base-100 shadow-lg mb-6">
                    <div class="card-body">
                        <h2 class="card-title text-base-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Pilih Pekerja
                        </h2>
                        <p class="text-sm text-base-content/60 mb-4">Pilih minimal {{ $service->cleaners_required }} pekerja untuk layanan ini</p>

                        @if($workers->isEmpty())
                            <div class="alert alert-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                <span>Tidak ada pekerja tersedia di wilayah ini saat ini. Silakan coba lagi nanti.</span>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($workers as $worker)
                                    <label class="card card-compact bg-base-200 cursor-pointer hover:bg-base-300 transition-colors border-2" :class="selectedWorkers.includes('{{ $worker->id }}') ? 'border-primary' : 'border-transparent'">
                                        <div class="card-body flex-row items-center gap-4">
                                            <input type="checkbox" name="worker_ids[]" value="{{ $worker->id }}" class="checkbox checkbox-primary" @change="toggleWorker('{{ $worker->id }}')">
                                            <div class="avatar">
                                                <div class="w-12 rounded-full">
                                                    <img src="{{ $worker->avatar ? asset('storage/' . $worker->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($worker->name) . '&background=570df8&color=fff' }}" alt="{{ $worker->name }}" />
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-base-content">{{ $worker->name }}</p>
                                                <p class="text-xs text-base-content/50">{{ $worker->regency_name ?? 'Wilayah tidak diketahui' }}</p>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        @error('worker_ids')
                            <p class="text-error text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Package Selection --}}
                @if($service->packages->count() > 0)
                    <div class="card bg-base-100 shadow-lg mb-6">
                        <div class="card-body">
                            <h2 class="card-title text-base-content">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                Paket Tambahan (Opsional)
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                                @foreach($service->packages as $package)
                                    <label class="card card-compact bg-base-200 cursor-pointer hover:bg-base-300 transition-colors border-2" :class="selectedPackages.includes('{{ $package->id }}') ? 'border-accent' : 'border-transparent'">
                                        <div class="card-body">
                                            <div class="flex items-start gap-3">
                                                <input type="checkbox" name="package_ids[]" value="{{ $package->id }}" class="checkbox checkbox-accent mt-1" @change="togglePackage('{{ $package->id }}', {{ $package->price }})">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-base-content">{{ $package->name }}</p>
                                                    <p class="text-xs text-base-content/60">{{ $package->description }}</p>
                                                    <p class="text-accent font-bold mt-1">+ Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Address --}}
                <div class="card bg-base-100 shadow-lg mb-6">
                    <div class="card-body">
                        <h2 class="card-title text-base-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Alamat Lengkap
                        </h2>
                        <textarea name="address" class="textarea textarea-bordered w-full mt-2" rows="3" placeholder="Masukkan alamat lengkap Anda (minimal 10 karakter)..." required minlength="10">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Total & Submit --}}
                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-base-content/60 text-sm">Total Perkiraan</span>
                                <p class="text-3xl font-bold text-primary" x-text="'Rp ' + totalFormatted"></p>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg" :disabled="selectedWorkers.length < {{ $service->cleaners_required }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function orderForm() {
            return {
                basePrice: {{ $service->price }},
                selectedWorkers: [],
                selectedPackages: [],
                packagePrices: {},
                get total() {
                    let packageTotal = Object.values(this.packagePrices).reduce((sum, p) => sum + p, 0);
                    return this.basePrice + packageTotal;
                },
                get totalFormatted() {
                    return new Intl.NumberFormat('id-ID').format(this.total);
                },
                toggleWorker(id) {
                    const index = this.selectedWorkers.indexOf(id);
                    if (index > -1) this.selectedWorkers.splice(index, 1);
                    else this.selectedWorkers.push(id);
                },
                togglePackage(id, price) {
                    const index = this.selectedPackages.indexOf(id);
                    if (index > -1) {
                        this.selectedPackages.splice(index, 1);
                        delete this.packagePrices[id];
                    } else {
                        this.selectedPackages.push(id);
                        this.packagePrices[id] = price;
                    }
                }
            }
        }
    </script>
</x-app-layout>
