<div>
    <!-- Page Header -->
    <div class="mb-10 reveal active">
        <p class="text-[10px] font-black tracking-[0.4em] text-mint">// ADMINISTRATOR</p>
        <h1 class="mt-3 text-4xl font-black tracking-tighter">Dashboard</h1>
        <p class="mt-1 text-sm font-medium text-charcoal/50">Ringkasan operasional BersihinAja</p>
    </div>

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 reveal active">
        <!-- Total Pesanan -->
        <div class="rounded-3xl bg-cream-alt p-6 border border-charcoal/5 flex flex-col justify-between min-h-[140px] ease-premium hover:border-mint/30">
            <div class="flex items-center justify-between text-charcoal/40">
                <span class="text-[10px] font-black tracking-[0.2em]">TOTAL PESANAN</span>
                <iconify-icon icon="lucide:clipboard-list" class="text-xl text-mint"></iconify-icon>
            </div>
            <div class="mt-4">
                <p class="text-4xl font-black tracking-tighter text-charcoal">{{ $this->stats['total_orders'] }}</p>
                <p class="text-[10px] font-bold text-charcoal/30 mt-1">Semua pesanan terdaftar</p>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="rounded-3xl bg-cream-alt p-6 border border-charcoal/5 flex flex-col justify-between min-h-[140px] ease-premium hover:border-mint/30">
            <div class="flex items-center justify-between text-charcoal/40">
                <span class="text-[10px] font-black tracking-[0.2em]">TOTAL PENDAPATAN</span>
                <iconify-icon icon="lucide:wallet" class="text-xl text-mint"></iconify-icon>
            </div>
            <div class="mt-4">
                <div class="flex items-start">
                    <span class="mt-1 text-[10px] font-black tracking-[0.1em]">Rp</span>
                    <span class="text-3xl font-black tracking-tighter text-mint">{{ number_format($this->stats['total_revenue'], 0, ',', '.') }}</span>
                </div>
                <p class="text-[10px] font-bold text-charcoal/30 mt-1">Dari pembayaran lunas</p>
            </div>
        </div>

        <!-- Total Pengguna -->
        <div class="rounded-3xl bg-cream-alt p-6 border border-charcoal/5 flex flex-col justify-between min-h-[140px] ease-premium hover:border-mint/30">
            <div class="flex items-center justify-between text-charcoal/40">
                <span class="text-[10px] font-black tracking-[0.2em]">TOTAL PENGGUNA</span>
                <iconify-icon icon="lucide:users" class="text-xl text-mint"></iconify-icon>
            </div>
            <div class="mt-4">
                <p class="text-4xl font-black tracking-tighter text-charcoal">{{ $this->stats['total_users'] }}</p>
                <p class="text-[10px] font-bold text-charcoal/30 mt-1">Akun dalam sistem</p>
            </div>
        </div>

        <!-- Pekerja Aktif -->
        <div class="rounded-3xl bg-cream-alt p-6 border border-charcoal/5 flex flex-col justify-between min-h-[140px] ease-premium hover:border-mint/30">
            <div class="flex items-center justify-between text-charcoal/40">
                <span class="text-[10px] font-black tracking-[0.2em]">PEKERJA AKTIF</span>
                <iconify-icon icon="lucide:activity" class="text-xl text-mint"></iconify-icon>
            </div>
            <div class="mt-4">
                <p class="text-4xl font-black tracking-tighter text-charcoal">{{ $this->stats['active_workers'] }}</p>
                <p class="text-[10px] font-bold text-charcoal/30 mt-1">Sedang bertugas lapangan</p>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10 reveal active">
        <div class="rounded-2xl border border-charcoal/5 bg-cream p-5">
            <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">PELANGGAN</span>
            <p class="text-2xl font-black mt-2">{{ $this->stats['total_customers'] }}</p>
        </div>
        <div class="rounded-2xl border border-charcoal/5 bg-cream p-5">
            <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">TOTAL PEKERJA</span>
            <p class="text-2xl font-black mt-2">{{ $this->stats['total_workers'] }}</p>
        </div>
        <div class="rounded-2xl border border-charcoal/5 bg-cream p-5">
            <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">PESANAN PENDING</span>
            <p class="text-2xl font-black mt-2 text-[#FBBD23]">{{ $this->stats['pending_orders'] }}</p>
        </div>
        <div class="rounded-2xl border border-charcoal/5 bg-cream p-5">
            <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">PESANAN BERJALAN</span>
            <p class="text-2xl font-black mt-2 text-mint">{{ $this->stats['in_progress_orders'] }}</p>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 reveal active">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-black tracking-tighter text-charcoal">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" wire:navigate class="inline-flex items-center border-b border-charcoal pb-0.5 text-xs font-black uppercase tracking-widest ease-premium hover:border-mint">
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
                            <th class="pb-4">TOTAL</th>
                            <th class="pb-4">PEMBAYARAN</th>
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
                                <td class="py-4 font-black">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-4">
                                    @if($order->payment_status === 'paid')
                                        <span class="inline-flex rounded-full bg-[#36D399]/10 px-3 py-1 text-[10px] font-black tracking-wide text-[#36D399]">LUNAS</span>
                                    @elseif($order->payment_status === 'unpaid')
                                        <span class="inline-flex rounded-full bg-[#FBBD23]/10 px-3 py-1 text-[10px] font-black tracking-wide text-[#FBBD23]">BELUM BAYAR</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-charcoal/5 px-3 py-1 text-[10px] font-black tracking-wide text-charcoal/50">{{ strtoupper($order->payment_status) }}</span>
                                    @endif
                                </td>
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
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black tracking-wide {{ $statusStyles }}">{{ strtoupper(str_replace('_', ' ', $order->order_status)) }}</span>
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
                <p class="mt-4 text-sm font-medium text-charcoal/40">Belum ada pesanan</p>
            </div>
        @endif
    </div>
</div>
