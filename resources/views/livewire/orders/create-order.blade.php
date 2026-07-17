<div class="px-6 pb-16 pt-28 lg:px-12">
    <div class="mx-auto max-w-[900px]">
        {{-- Breadcrumbs --}}
        <nav class="mb-10 flex items-center gap-2 text-[10px] font-bold tracking-[0.15em] text-charcoal/40 reveal active">
            <a href="{{ route('home') }}" wire:navigate class="ease-premium hover:text-mint">BERANDA</a>
            <iconify-icon icon="lucide:chevron-right" class="text-sm"></iconify-icon>
            <a href="{{ route('services.show', $service->slug) }}" wire:navigate class="ease-premium hover:text-mint">{{ strtoupper($service->name) }}</a>
            <iconify-icon icon="lucide:chevron-right" class="text-sm"></iconify-icon>
            <span class="text-charcoal">BUAT PESANAN</span>
        </nav>

        {{-- Title --}}
        <div class="reveal active">
            <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PEMESANAN</p>
            <h1 class="mt-3 text-5xl font-black tracking-tighter sm:text-6xl">Konfirmasi Pesanan</h1>
        </div>

        <form wire:submit="store" class="mt-10 space-y-6">
            {{-- Summary Card --}}
            <div class="rounded-3xl bg-cream-alt p-8 reveal active">
                <h2 class="text-xl font-black tracking-tighter text-charcoal flex items-center gap-2">
                    <iconify-icon icon="lucide:info" class="text-mint"></iconify-icon> Ringkasan Layanan
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6">
                    <div>
                        <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">LAYANAN</span>
                        <p class="font-bold text-charcoal mt-1">{{ $service->name }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">HARGA DASAR</span>
                        <p class="font-bold text-mint mt-1">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">LOKASI</span>
                        <p class="font-bold text-charcoal mt-1">{{ $regencyName }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">ESTIMASI</span>
                        <p class="font-bold text-charcoal mt-1">{{ $service->estimation }}</p>
                    </div>
                </div>
            </div>

            {{-- Worker Selection --}}
            <div class="rounded-3xl bg-cream-alt p-8 reveal active">
                <h2 class="text-xl font-black tracking-tighter text-charcoal flex items-center gap-2">
                    <iconify-icon icon="lucide:users" class="text-mint"></iconify-icon> Pilih Pekerja
                </h2>
                <p class="text-sm font-medium text-charcoal/50 mt-1">Pilih minimal <span class="font-black text-mint">{{ $service->cleaners_required }}</span> pekerja untuk daerah {{ $regencyName }}</p>

                @if(empty($workers))
                    <div class="mt-6 rounded-2xl bg-[#FBBD23]/10 px-6 py-4 flex items-center gap-3">
                        <iconify-icon icon="lucide:alert-circle" class="text-xl text-[#FBBD23]"></iconify-icon>
                        <span class="text-sm font-bold text-charcoal">Tidak ada pekerja tersedia di wilayah ini saat ini. Silakan coba lagi nanti.</span>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        @foreach($workers as $worker)
                            <label wire:key="worker-{{ $worker->id }}" 
                                   class="relative flex items-center gap-4 rounded-2xl border-2 p-5 cursor-pointer ease-premium {{ in_array($worker->id, $form->worker_ids) ? 'border-mint bg-cream' : 'border-charcoal/5 bg-cream hover:border-mint/30' }}">
                                <input type="checkbox" wire:click="toggleWorker('{{ $worker->id }}')" class="sr-only">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-mint/10 text-mint overflow-hidden">
                                    @if($worker->avatar)
                                        <img src="{{ asset('storage/' . $worker->avatar) }}" alt="{{ $worker->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="font-black text-sm text-mint">{{ strtoupper(substr($worker->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-charcoal truncate">{{ $worker->name }}</p>
                                    <p class="text-xs font-medium text-charcoal/40 mt-0.5">{{ $worker->regency_name ?? 'Wilayah tidak diketahui' }}</p>
                                </div>
                                @if(in_array($worker->id, $form->worker_ids))
                                    <iconify-icon icon="lucide:check-circle" class="text-xl text-mint"></iconify-icon>
                                @endif
                            </label>
                        @endforeach
                    </div>
                @endif
                <x-input-error :messages="$errors->get('form.worker_ids')" class="mt-3" />
            </div>

            {{-- Package Selection --}}
            @if($packages->count() > 0)
                <div class="rounded-3xl bg-cream-alt p-8 reveal active">
                    <h2 class="text-xl font-black tracking-tighter text-charcoal flex items-center gap-2">
                        <iconify-icon icon="lucide:package-open" class="text-mint"></iconify-icon> Paket Tambahan (Opsional)
                    </h2>
                    <p class="text-sm font-medium text-charcoal/50 mt-1">Tingkatkan kebersihan dengan add-on premium</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        @foreach($packages as $package)
                            <label wire:key="package-{{ $package->id }}" 
                                   class="relative flex items-start gap-4 rounded-2xl border-2 p-5 cursor-pointer ease-premium {{ in_array($package->id, $form->package_ids) ? 'border-mint bg-cream' : 'border-charcoal/5 bg-cream hover:border-mint/30' }}">
                                <input type="checkbox" wire:click="togglePackage('{{ $package->id }}')" class="sr-only">
                                <div class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded border border-charcoal/20 ease-premium {{ in_array($package->id, $form->package_ids) ? 'bg-mint border-mint text-charcoal' : '' }}">
                                    @if(in_array($package->id, $form->package_ids))
                                        <iconify-icon icon="lucide:check" class="text-xs"></iconify-icon>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-charcoal truncate">{{ $package->name }}</p>
                                    <p class="text-xs font-medium text-charcoal/50 mt-0.5">{{ $package->description }}</p>
                                    <p class="text-sm font-black text-mint mt-2">+ Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Address --}}
            <div class="rounded-3xl bg-cream-alt p-8 reveal active" x-data="{
                loading: false,
                successMessage: '',
                errorMessage: '',
                getCoordinates() {
                    this.loading = true;
                    this.errorMessage = '';
                    this.successMessage = '';
                    if (!navigator.geolocation) {
                        this.errorMessage = 'Geolocation tidak didukung oleh browser Anda.';
                        this.loading = false;
                        return;
                    }
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            @this.set('form.latitude', position.coords.latitude);
                            @this.set('form.longitude', position.coords.longitude);
                            this.successMessage = 'Lokasi GPS berhasil didapatkan! (' + position.coords.latitude.toFixed(6) + ', ' + position.coords.longitude.toFixed(6) + ')';
                            this.loading = false;
                        },
                        (error) => {
                            this.errorMessage = 'Gagal mendapatkan lokasi. Pastikan izin lokasi aktif.';
                            this.loading = false;
                        },
                        { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                    );
                }
            }">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-xl font-black tracking-tighter text-charcoal flex items-center gap-2">
                        <iconify-icon icon="lucide:map-pin" class="text-mint"></iconify-icon> Alamat Lengkap
                    </h2>
                    <button type="button" @click="getCoordinates()" class="inline-flex items-center gap-1.5 rounded-full border border-charcoal/10 bg-cream px-4 py-2 text-[10px] font-black uppercase tracking-wider text-charcoal ease-premium hover:border-mint hover:bg-cream-alt">
                        <template x-if="!loading">
                            <iconify-icon icon="lucide:navigation" class="text-xs text-mint"></iconify-icon>
                        </template>
                        <template x-if="loading">
                            <iconify-icon icon="lucide:loader" class="animate-spin text-xs text-mint"></iconify-icon>
                        </template>
                        <span x-text="loading ? 'Mencari...' : 'Gunakan Koordinat GPS'"></span>
                    </button>
                </div>
                <textarea wire:model="form.address" class="mt-4 w-full rounded-2xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20" rows="3" placeholder="Masukkan alamat lengkap Anda (minimal 10 karakter)..." required minlength="10"></textarea>
                <x-input-error :messages="$errors->get('form.address')" class="mt-2" />
                
                {{-- Success / Error message indicator --}}
                <div x-show="successMessage" class="mt-3 text-[10px] font-bold text-mint flex items-center gap-1.5" x-cloak style="display: none;">
                    <iconify-icon icon="lucide:check-circle"></iconify-icon> <span x-text="successMessage"></span>
                </div>
                <div x-show="errorMessage" class="mt-3 text-[10px] font-bold text-[#F87272] flex items-center gap-1.5" x-cloak style="display: none;">
                    <iconify-icon icon="lucide:alert-circle"></iconify-icon> <span x-text="errorMessage"></span>
                </div>
                
                {{-- Hidden fields for coordinate values --}}
                <input type="hidden" wire:model="form.latitude">
                <input type="hidden" wire:model="form.longitude">
            </div>

            {{-- Total & Submit --}}
            <div class="rounded-3xl bg-cream-alt p-8 reveal active">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">TOTAL PERKIRAAN</span>
                        <div class="flex items-start mt-1">
                            <span class="mt-1.5 text-xs font-black tracking-[0.1em]">Rp</span>
                            <span class="text-4xl font-black tracking-tighter text-mint">{{ number_format($this->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <button type="submit" class="rounded-full bg-charcoal px-10 py-4 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal disabled:pointer-events-none disabled:opacity-40" @disabled(count($form->worker_ids) < $service->cleaners_required || empty($form->address))>
                        <span wire:loading.remove wire:target="store">Buat Pesanan</span>
                        <span wire:loading wire:target="store" class="flex items-center gap-2">
                            <iconify-icon icon="lucide:loader" class="animate-spin"></iconify-icon> Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
