<div>
    <!-- Page Header -->
    <div class="mb-10 reveal active">
        <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PENUGASAN</p>
        <h1 class="mt-3 text-4xl font-black tracking-tighter">Pesanan Saya</h1>
        <p class="mt-1 text-sm font-medium text-charcoal/50">Kelola dan selesaikan semua tugas kebersihan Anda</p>
    </div>

    <!-- Status Tabs -->
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4 reveal active">
        <div class="flex items-center gap-1 bg-cream-alt p-1 rounded-2xl border border-charcoal/5">
            @foreach(['all' => 'Semua', 'in_progress' => 'Sedang Berjalan', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $key => $label)
                <button wire:click="$set('status', '{{ $key }}')" 
                        class="rounded-xl px-4 py-2 text-[10px] font-black tracking-wider uppercase ease-premium {{ $status === $key ? 'bg-mint text-charcoal' : 'text-charcoal/50 hover:text-charcoal hover:bg-cream' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Orders Card List -->
    <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 reveal active">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-charcoal/10 text-[10px] font-black tracking-[0.2em] text-charcoal/40">
                            <th class="pb-4">NO. PESANAN</th>
                            <th class="pb-4">PELANGGAN</th>
                            <th class="pb-4">LAYANAN</th>
                            <th class="pb-4">PAKET TAMBAHAN</th>
                            <th class="pb-4">TOTAL GAJI</th>
                            <th class="pb-4">STATUS</th>
                            <th class="pb-4 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-charcoal/5 text-sm">
                        @foreach($orders as $order)
                            <tr wire:key="order-row-{{ $order->id }}" class="hover:bg-cream/40 ease-premium">
                                <td class="py-4 font-mono font-bold text-charcoal">{{ $order->order_number }}</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-mint/10 text-[9px] font-black text-mint">
                                            {{ strtoupper(substr($order->customer->name ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="font-bold text-charcoal/70">{{ $order->customer->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 font-bold text-charcoal/70">{{ $order->service->name ?? '-' }}</td>
                                <td class="py-4">
                                    @if($order->packages->count() > 0)
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($order->packages as $package)
                                                <span class="inline-flex rounded-full border border-charcoal/10 px-2.5 py-0.5 text-[8px] font-black tracking-wide text-charcoal/60">{{ strtoupper($package->name) }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs font-bold text-charcoal/20">—</span>
                                    @endif
                                </td>
                                <td class="py-4 font-black">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-4">
                                    @php
                                        $statusStyles = match($order->order_status) {
                                            'pending' => 'bg-[#FBBD23]/10 text-[#FBBD23]',
                                            'in_progress' => 'bg-mint/10 text-mint',
                                            'completed' => 'bg-[#36D399]/10 text-[#36D399]',
                                            'cancelled' => 'bg-[#F87272]/10 text-[#F87272]',
                                            default => 'bg-charcoal/5 text-charcoal/50',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-3 py-1 text-[9px] font-black tracking-wide {{ $statusStyles }}">{{ strtoupper(str_replace('_', ' ', $order->order_status)) }}</span>
                                </td>
                                <td class="py-4 text-right">
                                    @if($order->order_status === 'in_progress')
                                        <button wire:confirm="Yakin ingin menyelesaikan pesanan {{ $order->order_number }}?" 
                                                wire:click="completeOrder({{ $order->id }})" 
                                                class="rounded-full bg-[#36D399] px-4 py-2 text-[10px] font-black uppercase tracking-wide text-white ease-premium hover:bg-[#36D399]/80 flex items-center gap-1.5 ml-auto">
                                            <iconify-icon icon="lucide:check" class="text-sm"></iconify-icon> Selesaikan
                                        </button>
                                    @else
                                        <span class="text-xs font-bold text-charcoal/20">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <iconify-icon icon="lucide:clipboard-list" class="text-4xl text-charcoal/20"></iconify-icon>
                <p class="mt-4 text-sm font-medium text-charcoal/40">Tidak ada pesanan ditemukan</p>
            </div>
        @endif
    </div>
</div>
