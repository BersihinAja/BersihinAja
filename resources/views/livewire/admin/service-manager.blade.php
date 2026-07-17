<div>
    <!-- Page Header -->
    <div class="mb-10 flex flex-wrap items-center justify-between gap-4 reveal active">
        <div>
            <p class="text-[10px] font-black tracking-[0.4em] text-mint">// KELOLA</p>
            <h1 class="mt-3 text-4xl font-black tracking-tighter">Layanan Pembersihan</h1>
            <p class="mt-1 text-sm font-medium text-charcoal/50">Tambah, ubah, atau hapus paket layanan BersihinAja</p>
        </div>
        <button wire:click="openCreateModal" class="rounded-full bg-charcoal px-8 py-3 text-xs font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal flex items-center gap-2">
            <iconify-icon icon="lucide:plus" class="text-base"></iconify-icon> Tambah Layanan
        </button>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 reveal active">
        @forelse($services as $service)
            <div wire:key="service-{{ $service->id }}" class="rounded-3xl bg-cream-alt border border-charcoal/5 overflow-hidden flex flex-col justify-between ease-premium hover:border-mint/30">
                <!-- Image Header -->
                <div class="relative aspect-[16/10] bg-cream border-b border-charcoal/5 overflow-hidden group">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="h-full w-full object-cover grayscale ease-premium group-hover:scale-105 group-hover:grayscale-0">
                    @else
                        <div class="flex h-full w-full items-center justify-center">
                            <iconify-icon icon="lucide:sparkles" class="text-5xl text-mint/30"></iconify-icon>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 rounded-full bg-charcoal/80 backdrop-blur-md px-3 py-1 text-[9px] font-black tracking-wider text-cream flex items-center gap-1">
                        <iconify-icon icon="lucide:clipboard-list" class="text-mint"></iconify-icon> {{ $service->orders_count }} PESANAN
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-black uppercase tracking-tighter text-charcoal">{{ $service->name }}</h2>
                        <p class="text-xs font-medium text-charcoal/50 mt-2 leading-relaxed line-clamp-3">{{ $service->description ?: 'Tidak ada deskripsi.' }}</p>

                        <div class="grid grid-cols-2 gap-y-3 gap-x-2 mt-4 text-[10px] font-black tracking-wider text-charcoal/60">
                            <div class="flex items-center gap-1.5">
                                <iconify-icon icon="lucide:home" class="text-mint text-sm"></iconify-icon> {{ $service->room_size }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <iconify-icon icon="lucide:clock" class="text-mint text-sm"></iconify-icon> {{ $service->estimation }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <iconify-icon icon="lucide:users" class="text-mint text-sm"></iconify-icon> {{ $service->cleaners_required }} Pekerja
                            </div>
                            <div class="flex items-center gap-1.5">
                                <iconify-icon icon="lucide:hourglass" class="text-mint text-sm"></iconify-icon> Maks {{ $service->max_hours }} Jam
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-charcoal/5 pt-4 flex items-center justify-between">
                        <div>
                            <span class="text-[9px] font-black tracking-wider text-charcoal/30">HARGA</span>
                            <div class="flex items-start">
                                <span class="text-[9px] font-black mt-1">Rp</span>
                                <span class="text-2xl font-black tracking-tighter text-mint">{{ number_format($service->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button wire:click="openEditModal({{ $service->id }})" class="flex h-8 w-8 items-center justify-center rounded-full bg-charcoal/5 text-charcoal ease-premium hover:bg-mint hover:text-charcoal" title="Edit">
                                <iconify-icon icon="lucide:edit-2" class="text-sm"></iconify-icon>
                            </button>
                            <button wire:confirm="Yakin ingin menghapus layanan ini?" wire:click="delete({{ $service->id }})" class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F87272]/10 text-[#F87272] ease-premium hover:bg-[#F87272] hover:text-white" title="Hapus">
                                <iconify-icon icon="lucide:trash-2" class="text-sm"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @forelse
            <div class="col-span-full rounded-3xl bg-cream-alt p-12 text-center border border-charcoal/5">
                <iconify-icon icon="lucide:sparkles" class="text-5xl text-charcoal/20"></iconify-icon>
                <p class="mt-4 text-sm font-medium text-charcoal/40">Belum ada layanan pembersihan yang ditambahkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Form (Create/Edit) -->
    <div x-data="{ open: @entangle('showModal') }" x-show="open" class="relative z-50" role="dialog" aria-modal="true" style="display: none;">
        <!-- Backdrop -->
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-charcoal/80"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div x-show="open" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="scale-100 opacity-100" x-transition:leave-end="scale-95 opacity-0" 
                 class="relative w-full max-w-2xl bg-cream-alt rounded-3xl border border-charcoal/5 shadow-2xl p-8 max-h-[90vh] overflow-y-auto" @click.outside="open = false">
                
                <!-- Close Button -->
                <button @click="open = false" class="absolute right-6 top-6 text-charcoal/40 hover:text-charcoal ease-premium">
                    <iconify-icon icon="lucide:x" class="text-2xl"></iconify-icon>
                </button>

                <h2 class="text-3xl font-black tracking-tighter text-charcoal">{{ $isEditing ? 'Ubah Layanan' : 'Tambah Layanan Baru' }}</h2>
                <p class="text-xs font-medium text-charcoal/50 mt-1 mb-6">Lengkapi detail paket pembersihan di bawah ini</p>

                <form wire:submit="save" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-[9px] font-black tracking-wider text-charcoal/50">NAMA LAYANAN</label>
                            <input type="text" wire:model="name" required class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-4 py-3 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                        
                        <!-- Price -->
                        <div>
                            <label class="block text-[9px] font-black tracking-wider text-charcoal/50">HARGA (RP)</label>
                            <input type="number" wire:model="price" required class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-4 py-3 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('price')" class="mt-1" />
                        </div>

                        <!-- Room Size -->
                        <div>
                            <label class="block text-[9px] font-black tracking-wider text-charcoal/50">UKURAN RUANGAN</label>
                            <input type="text" wire:model="room_size" placeholder="Contoh: 5 x 5" required class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-4 py-3 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('room_size')" class="mt-1" />
                        </div>

                        <!-- Max Hours -->
                        <div>
                            <label class="block text-[9px] font-black tracking-wider text-charcoal/50">MAKSIMAL DURASI (JAM)</label>
                            <input type="number" wire:model="max_hours" required class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-4 py-3 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('max_hours')" class="mt-1" />
                        </div>

                        <!-- Estimation -->
                        <div>
                            <label class="block text-[9px] font-black tracking-wider text-charcoal/50">ESTIMASI LAMA WAKTU</label>
                            <input type="text" wire:model="estimation" placeholder="Contoh: ~2 jam" required class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-4 py-3 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('estimation')" class="mt-1" />
                        </div>

                        <!-- Cleaners Required -->
                        <div>
                            <label class="block text-[9px] font-black tracking-wider text-charcoal/50">JUMLAH PEKERJA</label>
                            <input type="number" wire:model="cleaners_required" required class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-4 py-3 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('cleaners_required')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-[9px] font-black tracking-wider text-charcoal/50">DESKRIPSI</label>
                        <textarea wire:model="description" rows="3" class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-4 py-3 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-[9px] font-black tracking-wider text-charcoal/50">GAMBAR LAYANAN</label>
                        <input type="file" wire:model="image" class="mt-2 text-sm">
                        <x-input-error :messages="$errors->get('image')" class="mt-1" />
                        
                        <div class="mt-3 flex items-center gap-3">
                            @if ($image)
                                <div class="relative h-16 w-24 rounded-lg overflow-hidden border border-charcoal/10">
                                    <img src="{{ $image->temporaryUrl() }}" class="h-full w-full object-cover">
                                </div>
                            @elseif ($existingImage)
                                <div class="relative h-16 w-24 rounded-lg overflow-hidden border border-charcoal/10">
                                    <img src="{{ asset('storage/' . $existingImage) }}" class="h-full w-full object-cover">
                                </div>
                            @endif
                            <div wire:loading wire:target="image" class="text-xs font-bold text-mint">
                                <iconify-icon icon="lucide:loader" class="animate-spin mr-1.5"></iconify-icon>Mengupload gambar...
                            </div>
                        </div>
                    </div>

                    <!-- Packages checkboxes -->
                    @if(count($packages) > 0)
                        <div>
                            <label class="block text-[9px] font-black tracking-wider text-charcoal/50 mb-3">PAKET TAMBAHAN YANG DIDUKUNG</label>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($packages as $package)
                                    <label wire:key="modal-package-{{ $package->id }}" class="flex items-center gap-2.5 rounded-xl border border-charcoal/5 bg-cream p-3 cursor-pointer hover:border-mint/30 ease-premium">
                                        <input type="checkbox" wire:click="togglePackage({{ $package->id }})" @checked(in_array($package->id, $selectedPackages)) class="checkbox checkbox-mint checkbox-sm">
                                        <span class="text-xs font-bold text-charcoal/70">{{ $package->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Submit -->
                    <div class="mt-8 flex justify-end gap-3 border-t border-charcoal/5 pt-6">
                        <button type="button" @click="open = false" class="rounded-full border border-charcoal/10 px-6 py-3 text-xs font-bold text-charcoal ease-premium hover:bg-cream">Batal</button>
                        <button type="submit" class="rounded-full bg-charcoal px-8 py-3 text-xs font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal flex items-center gap-2">
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <iconify-icon icon="lucide:loader" class="animate-spin"></iconify-icon> Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
