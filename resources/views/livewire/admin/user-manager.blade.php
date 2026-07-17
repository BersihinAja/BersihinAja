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
        <button wire:click="$set('tab', 'pending_workers')" class="border-b-2 px-4 py-2 text-[10px] font-black tracking-widest uppercase relative {{ $tab === 'pending_workers' ? 'border-mint text-charcoal' : 'border-transparent text-charcoal/40' }}">
            MENUNGGU VERIFIKASI
            @php
                $pendingCount = \App\Models\User::role('pekerja')->where('status', 'pending_verification')->count();
            @endphp
            @if ($pendingCount > 0)
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-error text-[8px] font-bold text-white">{{ $pendingCount }}</span>
            @endif
        </button>
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
                    <tr class="hover:bg-cream-alt/40">
                        <td class="p-4">
                            <p class="font-bold text-charcoal">{{ $user->name }}</p>
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
                            @elseif ($user->status === 'pending_verification')
                                <span class="inline-block rounded bg-warning/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-warning">Menunggu Verifikasi</span>
                            @else
                                <span class="inline-block rounded bg-charcoal/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-charcoal/40">{{ $user->status }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            @if ($user->status === 'pending_verification')
                                <div class="flex justify-end gap-2">
                                    <button wire:click="verifyWorker({{ $user->id }})" class="rounded-full bg-mint px-4 py-2 text-[9px] font-black uppercase tracking-wider text-charcoal ease-premium hover:bg-charcoal hover:text-cream">Setujui</button>
                                    <button wire:click="rejectWorker({{ $user->id }})" class="rounded-full bg-error/10 px-4 py-2 text-[9px] font-black uppercase tracking-wider text-error ease-premium hover:bg-error hover:text-white">Tolak</button>
                                </div>
                            @else
                                -
                            @endif
                        </td>
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
</div>
