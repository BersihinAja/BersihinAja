<div class="p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PEKERJA</p>
            <h1 class="mt-2 text-3xl font-black tracking-tighter text-charcoal">Tugas Kebersihan</h1>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="mt-6 flex gap-2 border-b border-charcoal/5 pb-px">
        <button wire:click="$set('tab', 'active')" class="border-b-2 px-4 py-2 text-[10px] font-black tracking-widest uppercase {{ $tab === 'active' ? 'border-mint text-charcoal' : 'border-transparent text-charcoal/40' }}">PESANAN SAYA</button>
        <button wire:click="$set('tab', 'pool')" class="border-b-2 px-4 py-2 text-[10px] font-black tracking-widest uppercase relative {{ $tab === 'pool' ? 'border-mint text-charcoal' : 'border-transparent text-charcoal/40' }}">
            POOL PEKERJAAN
            @php
                $poolCount = \App\Models\Order::where('order_status', 'pending')->where('payment_status', 'paid')->where('regency_name', Auth::user()->regency_name)->count();
            @endphp
            @if ($poolCount > 0)
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-mint text-[8px] font-bold text-charcoal">{{ $poolCount }}</span>
            @endif
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mt-6 rounded-xl bg-mint/10 p-4 text-xs font-bold text-mint">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mt-6 rounded-xl bg-error/10 p-4 text-xs font-bold text-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="mt-6 overflow-x-auto rounded-2xl border border-charcoal/5 bg-cream">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-charcoal/5 text-[9px] font-black tracking-[0.2em] text-charcoal/40 uppercase bg-cream-alt">
                    <th class="p-4">No. Order</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Layanan</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Status Kerja</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-charcoal/5">
                @forelse ($orders as $order)
                    <tr class="hover:bg-cream-alt/40">
                        <td class="p-4 font-mono font-bold text-charcoal">{{ $order->order_number }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-mint/10 text-[9px] font-black text-mint shrink-0">
                                    {{ strtoupper(substr($order->customer->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-charcoal/70 truncate">{{ $order->customer->name ?? '-' }}</p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="text-[9px] text-charcoal/40 truncate max-w-[150px]" title="{{ $order->address }}, {{ $order->regency_name }}">{{ $order->address }}</span>
                                        @php
                                            $mapsUrl = ($order->latitude && $order->longitude)
                                                ? "https://www.google.com/maps/search/?api=1&query={$order->latitude},{$order->longitude}"
                                                : "https://www.google.com/maps/search/?api=1&query=" . urlencode($order->address . ', ' . $order->regency_name);
                                        @endphp
                                        <a href="{{ $mapsUrl }}" target="_blank" class="inline-flex items-center gap-0.5 text-[8px] font-black uppercase text-mint hover:underline shrink-0">
                                            <iconify-icon icon="lucide:navigation" class="text-[10px]"></iconify-icon> Peta
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-charcoal/70">{{ $order->service->name ?? '-' }}</p>
                            @if ($order->packages->isNotEmpty())
                                <span class="text-[8px] font-black uppercase tracking-wider text-charcoal/40">
                                    + {{ $order->packages->pluck('name')->implode(', ') }}
                                </span>
                            @endif
                        </td>
                        <td class="p-4 font-mono font-bold text-charcoal">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @if ($order->order_status === 'pending')
                                <span class="inline-block rounded bg-charcoal/5 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-charcoal/40">Menunggu Pekerja</span>
                            @elseif ($order->order_status === 'assigned')
                                <span class="inline-block rounded bg-info/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-info">Klaim Berhasil</span>
                            @elseif ($order->order_status === 'on_the_way')
                                <span class="inline-block rounded bg-warning/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-warning">Di Perjalanan</span>
                            @elseif ($order->order_status === 'working')
                                <span class="inline-block rounded bg-mint/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-mint">Pembersihan...</span>
                            @elseif ($order->order_status === 'completed')
                                <span class="inline-block rounded bg-success/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-success">Selesai</span>
                            @else
                                <span class="inline-block rounded bg-charcoal/10 px-2 py-0.5 text-[8px] font-black tracking-wider uppercase text-charcoal/60">{{ $order->order_status }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            @if ($tab === 'pool')
                                <button wire:click="claimOrder({{ $order->id }})" class="rounded-full bg-mint px-4 py-2 text-[9px] font-black uppercase tracking-wider text-charcoal ease-premium hover:bg-charcoal hover:text-cream">Klaim</button>
                            @else
                                @if ($order->order_status === 'assigned')
                                    <button wire:click="startTrip({{ $order->id }})" class="rounded-full bg-warning px-4 py-2 text-[9px] font-black uppercase tracking-wider text-charcoal ease-premium hover:bg-charcoal hover:text-cream">Mulai Perjalanan</button>
                                @elseif ($order->order_status === 'on_the_way')
                                    <div x-data="{
                                        loading: false,
                                        start() {
                                            this.loading = true;
                                            navigator.geolocation.getCurrentPosition(
                                                (position) => {
                                                    $wire.startWork({{ $order->id }}, position.coords.latitude, position.coords.longitude).then(() => {
                                                        this.loading = false;
                                                    });
                                                },
                                                (error) => {
                                                    this.loading = false;
                                                    alert('Gagal mengambil GPS. Izinkan lokasi di browser Anda.');
                                                }
                                            );
                                        }
                                    }">
                                        <button @click="start()" :disabled="loading" class="rounded-full bg-mint px-4 py-2 text-[9px] font-black uppercase tracking-wider text-charcoal ease-premium hover:bg-charcoal hover:text-cream disabled:opacity-50">
                                            <span x-show="!loading">Mulai Bekerja</span>
                                            <span x-show="loading">Cek GPS...</span>
                                        </button>
                                    </div>
                                @elseif ($order->order_status === 'working')
                                    <button wire:click="completeOrder({{ $order->id }})" class="rounded-full bg-charcoal px-4 py-2 text-[9px] font-black uppercase tracking-wider text-cream ease-premium hover:bg-mint hover:text-charcoal">Selesai Kerja</button>
                                @else
                                    -
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-xs font-bold text-charcoal/40">Tidak ada tugas ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
