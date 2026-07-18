<div>
    @if ($user->status === 'pending_verification' || $user->status === 'rejected')
        {{-- State 1: KYC Submission Form --}}
        <div class="mx-auto max-w-2xl reveal active">
            <div>
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// VERIFIKASI PROFIL</p>
                <h1 class="mt-2 text-3xl font-black tracking-tighter text-charcoal">Lengkapi Dokumen Anda</h1>
                <p class="mt-2 text-xs font-medium text-charcoal/50">Lengkapi data diri dan upload foto KTP sebelum Anda bisa mengambil tugas pembersihan.</p>
            </div>

            @if ($user->status === 'rejected')
                <div class="mt-6 rounded-xl bg-[#F87272]/10 p-4 border border-[#F87272]/20">
                    <p class="text-[10px] font-black tracking-widest text-[#F87272] uppercase">⚠️ PENDAFTARAN DITOLAK</p>
                    <p class="mt-1 text-xs font-bold text-charcoal/80">Alasan: <span class="italic text-[#F87272]">{{ $user->rejection_reason }}</span></p>
                    <p class="mt-1 text-[10px] text-charcoal/50">Mohon perbaiki data dan ajukan kembali berkas foto Anda yang benar.</p>
                </div>
            @endif

            <form wire:submit="submitKyc" class="mt-8 space-y-6">
                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">NOMOR TELEPON / WA</label>
                    <input id="phone" type="text" wire:model="phone" required
                        class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                {{-- KTP Number --}}
                <div>
                    <label for="ktp_number" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">NOMOR KTP</label>
                    <input id="ktp_number" type="text" wire:model="ktp_number" required
                        class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                    <x-input-error :messages="$errors->get('ktp_number')" class="mt-2" />
                </div>

                {{-- Region Selectors --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="province" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PROVINSI DOMISILI</label>
                        <select id="province" wire:model.live="selectedProvince" required
                            class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('selectedProvince')" class="mt-2" />
                    </div>

                    <div>
                        <label for="regency" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">KABUPATEN / KOTA WILAYAH KERJA</label>
                        <select id="regency" wire:model="selectedRegency" required {{ empty($selectedProvince) ? 'disabled' : '' }}
                            class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20 disabled:opacity-50">
                            <option value="">Pilih Kabupaten/Kota</option>
                            @foreach ($regencies as $reg)
                                <option value="{{ $reg['id'] }}">{{ $reg['name'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('selectedRegency')" class="mt-2" />
                    </div>
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">ALAMAT LENGKAP</label>
                    <textarea id="address" wire:model="address" required rows="3"
                        class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20"></textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                {{-- File Uploads (Selfie & KTP) --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    {{-- Selfie --}}
                    <div class="rounded-2xl border border-dashed border-charcoal/10 bg-cream-alt p-5 text-center">
                        <label class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">FOTO DIRI (PAS FOTO)</label>
                        <div class="mt-3 flex flex-col items-center justify-center">
                            @if ($avatar_file)
                                <img src="{{ $avatar_file->temporaryUrl() }}" class="h-24 w-24 rounded-full object-cover border-2 border-mint">
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-cream text-charcoal/30">
                                    <iconify-icon icon="lucide:user" class="text-3xl"></iconify-icon>
                                </div>
                            @endif
                            <input type="file" wire:model="avatar_file" required class="mt-4 text-xs font-bold text-charcoal/60">
                            <x-input-error :messages="$errors->get('avatar_file')" class="mt-2" />
                        </div>
                    </div>

                    {{-- KTP Image --}}
                    <div class="rounded-2xl border border-dashed border-charcoal/10 bg-cream-alt p-5 text-center">
                        <label class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">FOTO KARTU KTP</label>
                        <div class="mt-3 flex flex-col items-center justify-center">
                            @if ($ktp_file)
                                <img src="{{ $ktp_file->temporaryUrl() }}" class="h-20 w-32 rounded-lg object-cover border border-mint">
                            @else
                                <div class="flex h-20 w-32 items-center justify-center rounded-lg bg-cream text-charcoal/30">
                                    <iconify-icon icon="lucide:credit-card" class="text-3xl"></iconify-icon>
                                </div>
                            @endif
                            <input type="file" wire:model="ktp_file" required class="mt-6 text-xs font-bold text-charcoal/60">
                            <x-input-error :messages="$errors->get('ktp_file')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full rounded-full bg-charcoal px-8 py-4 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal">
                    <span wire:loading.remove wire:target="submitKyc">Ajukan Verifikasi</span>
                    <span wire:loading wire:target="submitKyc" class="flex items-center justify-center gap-2">
                        <iconify-icon icon="lucide:loader" class="animate-spin text-base"></iconify-icon> Memproses...
                    </span>
                </button>
            </form>
        </div>
    @elseif ($user->status === 'under_review')
        {{-- State 2: Under Review Alert --}}
        <div class="mx-auto max-w-md py-12 text-center reveal active">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-[#FBBD23]/10 text-[#FBBD23]">
                <iconify-icon icon="lucide:clock" class="text-3xl"></iconify-icon>
            </div>
            <h1 class="mt-6 text-2xl font-black tracking-tighter text-charcoal">Dokumen Sedang Ditinjau</h1>
            <p class="mt-3 text-xs font-semibold leading-relaxed text-charcoal/50">Terima kasih telah melengkapi profil Anda. Dokumen verifikasi Anda sedang dalam proses peninjauan oleh Admin. Biasanya proses ini memakan waktu maksimal 1x24 jam.</p>
            <div class="mt-8 rounded-2xl bg-cream-alt p-4 text-left border border-charcoal/5">
                <p class="text-[9px] font-black tracking-wider text-charcoal/40 uppercase">WILAYAH DAFTAR</p>
                <p class="mt-1 text-xs font-bold text-charcoal">{{ $user->regency_name }}, {{ $user->province_name }}</p>
                <p class="mt-2 text-[9px] font-black tracking-wider text-charcoal/40 uppercase">ALAMAT</p>
                <p class="mt-1 text-xs font-bold text-charcoal">{{ $user->address }}</p>
            </div>
        </div>
    @else
        {{-- State 3: Regular Verified Dashboard --}}
        <!-- Page Header -->
        <div class="mb-10 flex flex-wrap items-center justify-between gap-4 reveal active">
            <div>
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PEKERJA</p>
                <h1 class="mt-3 text-4xl font-black tracking-tighter">Dashboard</h1>
                <p class="mt-1 text-sm font-medium text-charcoal/50">Selamat datang kembali, <span class="text-charcoal font-bold">{{ $user->name }}</span>!</p>
            </div>
            <!-- Status Switcher -->
            <div class="flex items-center gap-3 bg-cream-alt p-3 rounded-2xl border border-charcoal/5">
                <span class="text-[10px] font-black tracking-wider text-charcoal/40">STATUS KERJA:</span>
                <select wire:model.live="status" 
                    class="rounded-xl border border-charcoal/10 bg-cream px-3 py-1.5 text-xs font-black text-charcoal outline-none ease-premium focus:border-mint">
                    <option value="available">TERSEDIA (AVAILABLE)</option>
                    <option value="busy">SIBUK (BUSY)</option>
                </select>
            </div>
        </div>

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 reveal active">
            <!-- Pesanan Aktif -->
            <div class="rounded-3xl bg-cream-alt p-6 border border-charcoal/5 flex flex-col justify-between min-h-[140px] ease-premium hover:border-mint/30">
                <div class="flex items-center justify-between text-charcoal/40">
                    <span class="text-[10px] font-black tracking-[0.2em]">PESANAN AKTIF</span>
                    <iconify-icon icon="lucide:loader" class="text-xl text-[#FBBD23]"></iconify-icon>
                </div>
                <div class="mt-4">
                    <p class="text-4xl font-black tracking-tighter text-[#FBBD23]">{{ $stats['active_jobs'] }}</p>
                    <p class="text-[10px] font-bold text-charcoal/30 mt-1">Sedang dalam pengerjaan</p>
                </div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="rounded-3xl bg-cream-alt p-6 border border-charcoal/5 flex flex-col justify-between min-h-[140px] ease-premium hover:border-mint/30">
                <div class="flex items-center justify-between text-charcoal/40">
                    <span class="text-[10px] font-black tracking-[0.2em]">PESANAN SELESAI</span>
                    <iconify-icon icon="lucide:check-circle" class="text-xl text-[#36D399]"></iconify-icon>
                </div>
                <div class="mt-4">
                    <p class="text-4xl font-black tracking-tighter text-[#36D399]">{{ $stats['completed_jobs'] }}</p>
                    <p class="text-[10px] font-bold text-charcoal/30 mt-1">Total tugas selesai</p>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="rounded-3xl bg-cream-alt p-6 border border-charcoal/5 flex flex-col justify-between min-h-[140px] ease-premium hover:border-mint/30">
                <div class="flex items-center justify-between text-charcoal/40">
                    <span class="text-[10px] font-black tracking-[0.2em]">PENDAPATAN</span>
                    <iconify-icon icon="lucide:wallet" class="text-xl text-mint"></iconify-icon>
                </div>
                <div class="mt-4">
                    <div class="flex items-start">
                        <span class="mt-1 text-[10px] font-black tracking-[0.1em]">Rp</span>
                        <span class="text-3xl font-black tracking-tighter text-mint">{{ number_format($stats['total_earnings'], 0, ',', '.') }}</span>
                    </div>
                    <p class="text-[10px] font-bold text-charcoal/30 mt-1">Dari pesanan selesai</p>
                </div>
            </div>

            <!-- Status Card -->
            <div class="rounded-3xl bg-cream-alt p-6 border border-charcoal/5 flex flex-col justify-between min-h-[140px] ease-premium hover:border-mint/30">
                <div class="flex items-center justify-between text-charcoal/40">
                    <span class="text-[10px] font-black tracking-[0.2em]">STATUS SAYA</span>
                    <div class="h-2 w-2 rounded-full {{ $status === 'available' ? 'bg-[#36D399]' : 'bg-[#FBBD23]' }} animate-pulse"></div>
                </div>
                <div class="mt-4">
                    @if($status === 'available')
                        <span class="inline-flex rounded-full bg-[#36D399]/10 px-4 py-1.5 text-xs font-black tracking-wide text-[#36D399]">TERSEDIA</span>
                    @else
                        <span class="inline-flex rounded-full bg-[#FBBD23]/10 px-4 py-1.5 text-xs font-black tracking-wide text-[#FBBD23]">SIBUK</span>
                    @endif
                    <p class="text-[10px] font-bold text-charcoal/30 mt-2">Dapat menerima order baru</p>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 reveal active">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-black tracking-tighter text-charcoal">Pesanan Terbaru</h2>
                <a href="{{ route('pekerja.orders.index') }}" wire:navigate class="inline-flex items-center border-b border-charcoal pb-0.5 text-xs font-black uppercase tracking-widest ease-premium hover:border-mint">
                    Lihat Semua <iconify-icon icon="lucide:arrow-right" class="ml-1.5 text-base"></iconify-icon>
                </a>
            </div>

            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-charcoal/10 text-[10px] font-black tracking-[0.2em] text-charcoal/40">
                                <th class="pb-4">NO. PESANAN</th>
                                <th class="pb-4">PELANGGAN</th>
                                <th class="pb-4">LAYANAN</th>
                                <th class="pb-4">STATUS</th>
                                <th class="pb-4 text-right">TANGGAL</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-charcoal/5 text-sm">
                            @foreach($recentOrders as $order)
                                <tr wire:key="order-{{ $order->id }}" class="hover:bg-cream/40 ease-premium">
                                    <td class="py-4 font-mono font-bold text-charcoal">{{ $order->order_number }}</td>
                                    <td class="py-4 font-bold text-charcoal/70">{{ $order->customer->name ?? '-' }}</td>
                                    <td class="py-4 font-bold text-charcoal/70">{{ $order->service->name ?? '-' }}</td>
                                    <td class="py-4">
                                        @php
                                            $statusStyles = match($order->order_status) {
                                                'pending' => 'bg-[#FBBD23]/10 text-[#FBBD23]',
                                                'assigned' => 'bg-info/10 text-info',
                                                'on_the_way' => 'bg-warning/10 text-warning',
                                                'working' => 'bg-mint/10 text-mint',
                                                'completed' => 'bg-[#36D399]/10 text-[#36D399]',
                                                'cancelled' => 'bg-[#F87272]/10 text-[#F87272]',
                                                default => 'bg-charcoal/5 text-charcoal/50',
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-3 py-1 text-[9px] font-black tracking-wide {{ $statusStyles }}">{{ strtoupper(str_replace('_', ' ', $order->order_status)) }}</span>
                                    </td>
                                    <td class="py-4 text-right font-medium text-charcoal/40">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <iconify-icon icon="lucide:clipboard-list" class="text-4xl text-charcoal/20"></iconify-icon>
                    <p class="mt-4 text-sm font-medium text-charcoal/40">Belum ada pesanan ditugaskan</p>
                </div>
            @endif
        </div>
    @endif
</div>
