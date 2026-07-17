<div>
    <!-- Page Header -->
    <div class="mb-10 reveal active">
        <p class="text-[10px] font-black tracking-[0.4em] text-mint">// ADMINISTRASI</p>
        <h1 class="mt-3 text-4xl font-black tracking-tighter">Kelola Pesanan</h1>
        <p class="mt-1 text-sm font-medium text-charcoal/50">Daftar semua pesanan jasa kebersihan BersihinAja</p>
    </div>

    <!-- Filters & Search -->
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4 reveal active">
        <!-- Status Tabs -->
        <div class="flex items-center gap-1 bg-cream-alt p-1 rounded-2xl border border-charcoal/5">
            @foreach(['all' => 'Semua', 'pending' => 'Pending', 'in_progress' => 'Berjalan', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $key => $label)
                <button wire:click="$set('status', '{{ $key }}')" 
                        class="rounded-xl px-4 py-2 text-[10px] font-black tracking-wider uppercase ease-premium {{ $status === $key ? 'bg-mint text-charcoal' : 'text-charcoal/50 hover:text-charcoal hover:bg-cream' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <!-- Search Bar -->
        <div class="relative w-full max-w-xs">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari No. Pesanan, pelanggan, layanan..." 
                class="w-full rounded-xl border border-charcoal/10 bg-cream-alt px-4 py-2.5 pl-10 text-xs font-bold text-charcoal outline-none ease-premium focus:border-mint">
            <iconify-icon icon="lucide:search" class="absolute left-3.5 top-3.5 text-sm text-charcoal/40"></iconify-icon>
        </div>
    </div>

    <!-- Main Grid (Order Table / Detail Panel) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start reveal active">
        <!-- Table Area -->
        <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 {{ $selectedOrder ? 'lg:col-span-8' : 'lg:col-span-12' }}">
            @if($orders->count() > 0)
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
                                <th class="pb-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-charcoal/5 text-sm">
                            @foreach($orders as $o)
                                <tr wire:key="order-row-{{ $o->id }}" class="hover:bg-cream/40 ease-premium {{ $selectedOrderId === $o->id ? 'bg-cream' : '' }}">
                                    <td class="py-4 font-mono font-bold text-charcoal">{{ $o->order_number }}</td>
                                    <td class="py-4 font-bold text-charcoal/70">{{ $o->customer->name ?? '-' }}</td>
                                    <td class="py-4 font-bold text-charcoal/70">{{ $o->service->name ?? '-' }}</td>
                                    <td class="py-4 font-black">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                                    <td class="py-4">
                                        @if($o->payment_status === 'paid')
                                            <span class="inline-flex rounded-full bg-[#36D399]/10 px-3 py-1 text-[9px] font-black tracking-wide text-[#36D399]">LUNAS</span>
                                        @elseif($o->payment_status === 'unpaid')
                                            <span class="inline-flex rounded-full bg-[#FBBD23]/10 px-3 py-1 text-[9px] font-black tracking-wide text-[#FBBD23]">BELUM BAYAR</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-charcoal/5 px-3 py-1 text-[9px] font-black tracking-wide text-charcoal/50">{{ strtoupper($o->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        @php
                                            $statusStyles = match($o->order_status) {
                                                'pending' => 'bg-[#FBBD23]/10 text-[#FBBD23]',
                                                'in_progress' => 'bg-mint/10 text-mint',
                                                'completed' => 'bg-[#36D399]/10 text-[#36D399]',
                                                'cancelled' => 'bg-[#F87272]/10 text-[#F87272]',
                                                default => 'bg-charcoal/5 text-charcoal/50',
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-3 py-1 text-[9px] font-black tracking-wide {{ $statusStyles }}">{{ strtoupper(str_replace('_', ' ', $o->order_status)) }}</span>
                                    </td>
                                    <td class="py-4 text-right font-medium text-charcoal/40">{{ $o->created_at->format('d M Y') }}</td>
                                    <td class="py-4 text-right">
                                        <button wire:click="selectOrder({{ $o->id }})" class="inline-flex items-center border-b border-charcoal pb-0.5 text-xs font-black uppercase tracking-widest ease-premium hover:border-mint">
                                            Rincian
                                        </button>
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

        <!-- Detail Panel -->
        @if($selectedOrder)
            <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 lg:col-span-4 relative">
                <!-- Close Button -->
                <button wire:click="selectOrder(null)" class="absolute right-6 top-6 text-charcoal/40 hover:text-charcoal ease-premium">
                    <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                </button>

                <h2 class="text-2xl font-black tracking-tighter text-charcoal mb-1">Detail Pesanan</h2>
                <span class="font-mono text-xs font-bold text-charcoal/40">{{ $selectedOrder->order_number }}</span>

                <div class="border-t border-charcoal/5 py-4 space-y-4 text-xs mt-4">
                    {{-- Customer Info --}}
                    <div>
                        <span class="font-black text-charcoal/40 uppercase tracking-wider block mb-1">PELANGGAN</span>
                        <p class="font-bold text-charcoal">{{ $selectedOrder->customer->name ?? '-' }}</p>
                        <p class="text-[10px] text-charcoal/50 mt-0.5">{{ $selectedOrder->customer->email ?? '-' }}</p>
                    </div>

                    {{-- Service Info --}}
                    <div>
                        <span class="font-black text-charcoal/40 uppercase tracking-wider block mb-1">LAYANAN</span>
                        <p class="font-bold text-charcoal">{{ $selectedOrder->service->name ?? '-' }}</p>
                        <p class="text-[10px] text-mint mt-0.5">Rp {{ number_format($selectedOrder->service->price, 0, ',', '.') }}</p>
                    </div>

                    {{-- Assigned Workers --}}
                    <div>
                        <span class="font-black text-charcoal/40 uppercase tracking-wider block mb-2">PEKERJA DITUGASKAN</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($selectedOrder->workers as $worker)
                                <div class="inline-flex items-center gap-1.5 rounded-full border border-charcoal/10 bg-cream px-3 py-1 text-[10px] font-bold text-charcoal">
                                    <div class="flex h-4 w-4 items-center justify-center rounded-full bg-mint text-[8px] font-black text-charcoal overflow-hidden">
                                        @if($worker->avatar)
                                            <img src="{{ asset('storage/' . $worker->avatar) }}" alt="" class="h-full w-full object-cover">
                                        @else
                                            {{ strtoupper(substr($worker->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    {{ $worker->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Packages --}}
                    @if($selectedOrder->packages->count() > 0)
                        <div>
                            <span class="font-black text-charcoal/40 uppercase tracking-wider block mb-1.5">PAKET TAMBAHAN</span>
                            <div class="space-y-1.5">
                                @foreach($selectedOrder->packages as $package)
                                    <div class="flex justify-between items-center bg-cream px-3 py-2 rounded-xl border border-charcoal/5">
                                        <span class="font-bold text-charcoal">{{ $package->name }}</span>
                                        <span class="font-black text-mint">+ Rp {{ number_format($package->pivot->price, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Address --}}
                    <div class="flex flex-col gap-1">
                        <span class="font-black text-charcoal/40 uppercase tracking-wider">ALAMAT</span>
                        <span class="font-medium text-charcoal/70 bg-cream p-3 rounded-xl leading-relaxed">{{ $selectedOrder->address }}, {{ $selectedOrder->regency_name }}</span>
                    </div>

                    {{-- Date & Payment status --}}
                    <div class="flex justify-between border-t border-charcoal/5 pt-4">
                        <span class="font-black text-charcoal/40 uppercase tracking-wider">TANGGAL PESAN</span>
                        <span class="font-bold text-charcoal">{{ $selectedOrder->created_at->format('d M Y, H:i') }}</span>
                    </div>

                    @if($selectedOrder->paid_at)
                        <div class="flex justify-between">
                            <span class="font-black text-charcoal/40 uppercase tracking-wider">DIBAYAR PADA</span>
                            <span class="font-bold text-[#36D399]">{{ $selectedOrder->paid_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>

                {{-- Total --}}
                <div class="border-t border-charcoal/5 pt-6 flex justify-between items-center">
                    <span class="text-[10px] font-black tracking-wider text-charcoal/30 uppercase">TOTAL</span>
                    <div class="flex items-start">
                        <span class="text-[9px] font-black mt-1">Rp</span>
                        <span class="text-2xl font-black tracking-tighter text-mint">{{ number_format($selectedOrder->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- User Review --}}
                @if($selectedOrder->review)
                    <div class="border-t border-charcoal/5 mt-6 pt-6 bg-cream p-5 rounded-2xl border border-charcoal/5">
                        <h3 class="text-xs font-black text-charcoal flex items-center gap-1.5">
                            <iconify-icon icon="lucide:star" class="text-[#FBBD23] fill-current"></iconify-icon> Ulasan Pelanggan
                        </h3>
                        <div class="flex items-center gap-0.5 text-[#FBBD23] mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <iconify-icon icon="lucide:star" class="text-xs {{ $i <= $selectedOrder->review->rating ? 'fill-current' : 'text-charcoal/10' }}"></iconify-icon>
                            @endfor
                        </div>
                        @if($selectedOrder->review->comment)
                            <p class="mt-2 text-xs font-medium italic text-charcoal/60 leading-relaxed">"{{ $selectedOrder->review->comment }}"</p>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
