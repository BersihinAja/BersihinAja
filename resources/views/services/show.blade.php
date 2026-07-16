<x-app-layout>
    <div class="py-12 px-4 bg-base-200 min-h-screen">
        <div class="max-w-5xl mx-auto">
            {{-- Breadcrumb --}}
            <div class="text-sm breadcrumbs mb-6">
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('services.index') }}">Layanan</a></li>
                    <li class="text-base-content/60">{{ $service->name }}</li>
                </ul>
            </div>

            {{-- Service Detail Card --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex flex-col lg:flex-row gap-8">
                        {{-- Image --}}
                        <div class="lg:w-1/3">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="rounded-xl w-full h-64 object-cover" />
                            @else
                                <div class="rounded-xl w-full h-64 bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-primary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" /></svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="lg:w-2/3">
                            <h1 class="text-3xl font-bold text-base-content mb-4">{{ $service->name }}</h1>
                            <p class="text-base-content/70 mb-6">{{ $service->description }}</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="stat bg-base-200 rounded-lg p-4">
                                    <div class="stat-title text-xs">Harga</div>
                                    <div class="stat-value text-lg text-primary">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="stat bg-base-200 rounded-lg p-4">
                                    <div class="stat-title text-xs">Ukuran Ruangan</div>
                                    <div class="stat-value text-lg">{{ $service->room_size }}</div>
                                </div>
                                <div class="stat bg-base-200 rounded-lg p-4">
                                    <div class="stat-title text-xs">Estimasi</div>
                                    <div class="stat-value text-lg">{{ $service->estimation }}</div>
                                </div>
                                <div class="stat bg-base-200 rounded-lg p-4">
                                    <div class="stat-title text-xs">Maks. Jam</div>
                                    <div class="stat-value text-lg">{{ $service->max_hours }} jam</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Packages --}}
                    @if($service->packages->count() > 0)
                        <div class="divider">Paket Tambahan</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($service->packages as $package)
                                <div class="card card-compact bg-base-200">
                                    <div class="card-body">
                                        <h3 class="card-title text-sm">{{ $package->name }}</h3>
                                        <p class="text-xs text-base-content/60">{{ $package->description }}</p>
                                        <div class="text-primary font-bold">+ Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Region Selection & Order CTA --}}
                    <div class="divider">Pilih Lokasi Anda</div>
                    <div x-data="regionSelector()">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Provinsi</span></label>
                                <select class="select select-bordered" x-model="selectedProvince" @change="fetchRegencies()">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Kabupaten / Kota</span></label>
                                <select class="select select-bordered" x-model="selectedRegency" :disabled="regencies.length === 0">
                                    <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                                    <template x-for="regency in regencies" :key="regency.id">
                                        <option :value="regency.id" x-text="regency.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="card-actions justify-end mt-6">
                            @auth
                                <a x-bind:href="orderUrl" class="btn btn-primary btn-lg" :class="{ 'btn-disabled': !selectedRegency }">
                                    Pesan Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login untuk Memesan</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function regionSelector() {
            return {
                selectedProvince: '',
                selectedRegency: '',
                regencies: [],
                get selectedRegencyName() {
                    const r = this.regencies.find(r => r.id == this.selectedRegency);
                    return r ? r.name : '';
                },
                get orderUrl() {
                    if (!this.selectedRegency) return '#';
                    return `{{ route('orders.create', $service->slug) }}?regency_id=${this.selectedRegency}&regency_name=${encodeURIComponent(this.selectedRegencyName)}`;
                },
                async fetchRegencies() {
                    this.selectedRegency = '';
                    this.regencies = [];
                    if (!this.selectedProvince) return;
                    try {
                        const res = await fetch(`/api/regions/regencies/${this.selectedProvince}`);
                        this.regencies = await res.json();
                    } catch (e) {
                        console.error('Failed to fetch regencies:', e);
                    }
                }
            }
        }
    </script>
</x-app-layout>
