<div>
    <!-- Page Header -->
    <div class="mb-10 flex flex-wrap items-center justify-between gap-4 reveal active">
        <div>
            <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PEKERJA</p>
            <h1 class="mt-3 text-4xl font-black tracking-tighter">Dashboard</h1>
            <p class="mt-1 text-sm font-medium text-charcoal/50">Selamat datang kembali, <span class="text-charcoal font-bold">{{ Auth::user()->name }}</span>!</p>
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
                <p class="text-4xl font-black tracking-tighter text-[#FBBD23]">{{ $this->stats['active_orders'] }}</p>
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
                <p class="text-4xl font-black tracking-tighter text-[#36D399]">{{ $this->stats['completed_orders'] }}</p>
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
                    <span class="text-3xl font-black tracking-tighter text-mint">{{ number_format($this->stats['total_earnings'], 0, ',', '.') }}</span>
                </div>
                <p class="text-[10px] font-bold text-charcoal/30 mt-1">Dari pesanan dibayar</p>
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

        @if($this->recentOrders->count() > 0)
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
                        @foreach($this->recentOrders as $order)
                            <tr wire:key="order-{{ $order->id }}" class="hover:bg-cream/40 ease-premium">
                                <td class="py-4 font-mono font-bold text-charcoal">{{ $order->order_number }}</td>
                                <td class="py-4 font-bold text-charcoal/70">{{ $order->customer->name ?? '-' }}</td>
                                <td class="py-4 font-bold text-charcoal/70">{{ $order->service->name ?? '-' }}</td>
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
</div>
