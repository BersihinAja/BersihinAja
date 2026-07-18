<div class="p-6">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-black tracking-[0.4em] text-mint">// ADMIN</p>
            <h1 class="mt-2 text-3xl font-black tracking-tighter text-charcoal">Kelola Pengguna</h1>
        </div>
        <div class="w-full lg:w-72">
            <input type="text" wire:model.live="search" placeholder="Cari nama atau email..."
                class="w-full rounded-xl border border-charcoal/10 bg-cream px-4 py-3.5 text-xs font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
        </div>
    </div>

    {{-- Tabs --}}
    <div class="mt-6 flex gap-2 border-b border-charcoal/5 pb-px">
        <button wire:click="$set('tab', 'all')" class="border-b-2 px-4 py-2 text-[10px] font-black tracking-widest uppercase {{ $tab === 'all' ? 'border-mint text-charcoal' : 'border-transparent text-charcoal/40' }}">SEMUA</button>
        <button wire:click="$set('tab', 'under_review')" class="border-b-2 px-4 py-2 text-[10px] font-black tracking-widest uppercase relative {{ $tab === 'under_review' ? 'border-mint text-charcoal' : 'border-transparent text-charcoal/40' }}">
            MENUNGGU REVIEW
            @php
                $reviewCount = \App\Models\User::role('pekerja')->where('status', 'under_review')->count();
            @endphp
            @if ($reviewCount > 0)
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-error text-[8px] font-bold text-white">{{ $reviewCount }}</span>
            @endif
        </button>
        <button wire:click="$set('tab', 'pending_workers')" class="border-b-2 px-4 py-2 text-[10px] font-black tracking-widest uppercase {{ $tab === 'pending_workers' ? 'border-mint text-charcoal' : 'border-transparent text-charcoal/40' }}">BELUM KYC</button>
        <button wire:click="$set('tab', 'verified_workers')" class="border-b-2 px-4 py-2 text-[10px] font-black tracking-widest uppercase {{ $tab === 'verified_workers' ? 'border-mint text-charcoal' : 'border-transparent text-charcoal/40' }}">PEKERJA AKTIF</button>
    </div>

    @if (session()->has('success'))
        <div class="mt-6 rounded-xl bg-mint/10 p-4 text-xs font-bold text-mint">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="mt-6 overflow-x-auto rounded-2xl border border-charcoal/5 bg-cream">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-charcoal/5 text-[9px] font-black tracking-[0.2em] text-charcoal/40 uppercase bg-cream-alt">
                    <th class="p-4">Pengguna</th>
                    <th class="p-4">Peran & Wilayah</th>
                    <th class="p-4">KTP & Telepon</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-charcoal/5">
                @forelse ($users as $user)
                    <tr class="hover:bg-cream-alt/40" x-data="{ openDetail: false }">
                        <td class="p-4">
                            <p class="font-bold text-charcoal cursor-pointer hover:underline" @click="openDetail = true">{{ $user->name }}</p>
                            <p class="text-[10px] text-charcoal/50">{{ $user->email }}</p>
                        </td>
                        <td class="p-4">
                            <span class="inline-block rounded bg-charcoal/5 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-charcoal/60">
                                {{ $user->roles->pluck('name')->implode(', ') }}
                            </span>
                            @if ($user->regency_name)
                                <p class="text-[10px] text-charcoal/70 mt-1 font-medium">{{ $user->regency_name }}, {{ $user->province_name }}</p>
                            @endif
                        </td>
                        <td class="p-4 text-[10px] font-medium text-charcoal/80">
                            @if ($user->hasRole('pekerja'))
                                <p>KTP: <span class="font-mono font-bold">{{ $user->ktp_number ?? '-' }}</span></p>
                                <p class="mt-0.5">WA: <span class="font-bold">{{ $user->phone ?? '-' }}</span></p>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($user->status === 'available')
                                <span class="inline-block rounded bg-mint/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-mint">Aktif / Available</span>
                            @elseif ($user->status === 'under_review')
                                <span class="inline-block rounded bg-warning/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-warning">Menunggu Review</span>
                            @elseif ($user->status === 'pending_verification')
                                <span class="inline-block rounded bg-charcoal/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-charcoal/40">Belum Submit KYC</span>
                            @elseif ($user->status === 'rejected')
                                <span class="inline-block rounded bg-error/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-error">Ditolak</span>
                            @else
                                <span class="inline-block rounded bg-charcoal/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-charcoal/60">{{ $user->status }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            @if ($user->status === 'under_review')
                                <div class="flex justify-end gap-2">
                                    <button wire:click="verifyWorker({{ $user->id }})" class="rounded-full bg-mint px-4 py-2 text-[9px] font-black uppercase tracking-wider text-charcoal ease-premium hover:bg-charcoal hover:text-cream">Setuju</button>
                                    <button wire:click="openRejectionModal({{ $user->id }})" class="rounded-full bg-error/10 px-4 py-2 text-[9px] font-black uppercase tracking-wider text-error ease-premium hover:bg-error hover:text-white">Tolak</button>
                                </div>
                            @else
                                <button @click="openDetail = true" class="rounded-full bg-cream-alt border border-charcoal/5 px-4 py-2 text-[9px] font-black uppercase tracking-wider text-charcoal/60 ease-premium hover:border-mint hover:text-mint">Detail</button>
                            @endif
                        </td>

                        {{-- Detail Slide-Over Drawer --}}
                        <div x-show="openDetail" class="fixed inset-0 z-50 overflow-hidden" x-cloak>
                            <div class="absolute inset-0 bg-charcoal/40 backdrop-blur-sm" @click="openDetail = false"></div>
                            <div class="absolute inset-y-0 right-0 max-w-full pl-10 flex">
                                <div class="w-screen max-w-md bg-cream p-6 shadow-2xl border-l border-charcoal/5 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between border-b border-charcoal/5 pb-4">
                                            <div>
                                                <p class="text-[8px] font-black tracking-[0.2em] text-mint uppercase">// DETAIL PENGGUNA</p>
                                                <h3 class="text-lg font-black text-charcoal tracking-tight">{{ $user->name }}</h3>
                                            </div>
                                            <button @click="openDetail = false" class="text-charcoal/40 hover:text-charcoal">
                                                <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                                            </button>
                                        </div>

                                        <div class="mt-6 space-y-5">
                                            <div>
                                                <span class="text-[8px] font-black tracking-wider text-charcoal/40 uppercase">EMAIL</span>
                                                <p class="text-xs font-bold text-charcoal mt-1">{{ $user->email }}</p>
                                            </div>
                                            <div>
                                                <span class="text-[8px] font-black tracking-wider text-charcoal/40 uppercase">STATUS DOKUMEN</span>
                                                <p class="text-xs font-bold text-charcoal mt-1">{{ strtoupper($user->status) }}</p>
                                            </div>
                                            @if ($user->phone)
                                                <div>
                                                    <span class="text-[8px] font-black tracking-wider text-charcoal/40 uppercase">NOMOR TELEPON / WA</span>
                                                    <p class="text-xs font-bold text-charcoal mt-1">{{ $user->phone }}</p>
                                                </div>
                                            @endif
                                            @if ($user->address)
                                                <div>
                                                    <span class="text-[8px] font-black tracking-wider text-charcoal/40 uppercase">ALAMAT DOMISILI</span>
                                                    <p class="text-xs font-bold text-charcoal mt-1">{{ $user->address }} ({{ $user->regency_name }}, {{ $user->province_name }})</p>
                                                </div>
                                            @endif

                                            @if ($user->avatar && $user->hasRole('pekerja'))
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <span class="text-[8px] font-black tracking-wider text-charcoal/40 uppercase block mb-1">FOTO DIRI</span>
                                                        <a href="{{ asset('storage/' . $user->avatar) }}" target="_blank">
                                                            <img src="{{ asset('storage/' . $user->avatar) }}" class="h-32 w-full object-cover rounded-xl border border-charcoal/10 hover:border-mint">
                                                        </a>
                                                    </div>
                                                    @if ($user->ktp_image)
                                                        <div>
                                                            <span class="text-[8px] font-black tracking-wider text-charcoal/40 uppercase block mb-1">FOTO KTP</span>
                                                            <a href="{{ asset('storage/' . $user->ktp_image) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $user->ktp_image) }}" class="h-32 w-full object-cover rounded-xl border border-charcoal/10 hover:border-mint">
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-xs font-bold text-charcoal/40">Tidak ada pengguna ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>

    {{-- Rejection Feedback Modal --}}
    @if ($showRejectionModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-charcoal/40 backdrop-blur-sm" wire:click="$set('showRejectionModal', false)"></div>
            <div class="relative w-full max-w-md rounded-3xl bg-cream p-6 shadow-2xl border border-charcoal/5">
                <h3 class="text-lg font-black text-charcoal tracking-tight">Tolak Berkas Pekerja</h3>
                <p class="mt-1 text-xs font-medium text-charcoal/50">Berikan feedback alasan penolakan agar pekerja dapat memperbaikinya.</p>
                
                <form wire:submit.prevent="submitRejection" class="mt-4 space-y-4">
                    <div>
                        <label for="rejectionReason" class="block text-[8px] font-black tracking-wider text-charcoal/40 uppercase">ALASAN PENOLAKAN</label>
                        <textarea id="rejectionReason" wire:model="rejectionReason" required rows="3" placeholder="Contoh: Berkas foto KTP kurang jelas/buram..."
                            class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-4 py-3 text-xs font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20"></textarea>
                        <x-input-error :messages="$errors->get('rejectionReason')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showRejectionModal', false)" class="rounded-full bg-cream-alt border border-charcoal/5 px-5 py-2.5 text-[10px] font-black uppercase tracking-wider text-charcoal/60">Batal</button>
                        <button type="submit" class="rounded-full bg-error px-5 py-2.5 text-[10px] font-black uppercase tracking-wider text-white ease-premium hover:bg-charcoal hover:text-cream">Kirim & Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
