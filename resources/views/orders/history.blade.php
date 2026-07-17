<x-guest-public-layout>
    <x-slot:title>Riwayat Pesanan - BersihinAja</x-slot:title>

    <section class="px-6 pb-16 pt-28 lg:px-12">
        <div class="mx-auto max-w-[1100px]">
            {{-- Header --}}
            <div class="reveal">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// RIWAYAT</p>
                <h1 class="mt-3 text-5xl font-black tracking-tighter sm:text-6xl">Pesanan Anda</h1>
            </div>

            @if(session('success'))
                <div class="mt-6 flex items-center gap-3 rounded-2xl bg-mint/10 px-6 py-4 reveal">
                    <iconify-icon icon="lucide:check-circle" class="text-xl text-mint"></iconify-icon>
                    <span class="text-sm font-bold text-charcoal">{{ session('success') }}</span>
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="mt-12 rounded-3xl bg-cream-alt p-16 text-center reveal">
                    <iconify-icon icon="lucide:clipboard-list" class="text-6xl text-charcoal/20"></iconify-icon>
                    <h2 class="mt-6 text-2xl font-black tracking-tighter text-charcoal/50">Belum Ada Pesanan</h2>
                    <p class="mt-2 text-sm font-medium text-charcoal/40">Anda belum pernah memesan layanan. Yuk, mulai pesan sekarang!</p>
                    <a href="{{ route('services.index') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-mint px-8 py-4 text-sm font-black uppercase tracking-wide text-charcoal ease-premium hover:bg-purple hover:text-white">
                        Lihat Layanan <iconify-icon icon="lucide:arrow-right" class="text-lg"></iconify-icon>
                    </a>
                </div>
            @else
                <div class="mt-10 space-y-4">
                    @foreach($orders as $order)
                        <div class="rounded-2xl border border-charcoal/5 bg-cream-alt p-6 ease-premium hover:border-mint/30 hover:shadow-sm reveal">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-3 mb-2">
                                        <p class="font-mono text-sm font-black text-charcoal">{{ $order->order_number }}</p>
                                        @php
                                            $statusStyles = match($order->order_status) {
                                                'pending' => 'bg-[#FBBD23]/10 text-[#FBBD23]',
                                                'in_progress' => 'bg-mint/10 text-mint',
                                                'completed' => 'bg-[#36D399]/10 text-[#36D399]',
                                                'cancelled' => 'bg-[#F87272]/10 text-[#F87272]',
                                                default => 'bg-charcoal/5 text-charcoal/50',
                                            };
                                            $paymentStyles = match($order->payment_status) {
                                                'unpaid' => 'border-[#FBBD23]/30 text-[#FBBD23]',
                                                'pending' => 'border-mint/30 text-mint',
                                                'paid' => 'border-[#36D399]/30 text-[#36D399]',
                                                'expired' => 'border-[#F87272]/30 text-[#F87272]',
                                                'cancelled' => 'border-[#F87272]/30 text-[#F87272]',
                                                default => 'border-charcoal/10 text-charcoal/50',
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black tracking-wide {{ $statusStyles }}">{{ strtoupper(str_replace('_', ' ', $order->order_status)) }}</span>
                                        <span class="inline-flex rounded-full border px-3 py-1 text-[10px] font-black tracking-wide {{ $paymentStyles }}">{{ strtoupper($order->payment_status) }}</span>
                                    </div>
                                    <p class="text-sm font-bold text-charcoal/70">{{ $order->service->name }}</p>
                                    <p class="mt-1 text-xs font-medium text-charcoal/40">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="text-right">
                                        <p class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">TOTAL</p>
                                        <div class="flex items-start">
                                            <span class="mt-1 text-[10px] font-black tracking-[0.1em]">Rp</span>
                                            <span class="text-2xl font-black tracking-tighter">{{ number_format($order->total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('orders.receipt', $order->id) }}" class="inline-flex items-center border-b-2 border-charcoal pb-1 text-xs font-black uppercase tracking-widest ease-premium hover:border-mint">
                                        Detail <iconify-icon icon="lucide:arrow-up-right" class="ml-1 text-base"></iconify-icon>
                                    </a>
                                </div>
                            </div>

                            @if($order->review)
                                <div class="mt-4 flex items-center gap-3 border-t border-charcoal/5 pt-4">
                                    <span class="text-[10px] font-black tracking-[0.15em] text-charcoal/40">ULASAN</span>
                                    <div class="flex items-center gap-0.5 text-[#FBBD23]">
                                        @for($i = 1; $i <= 5; $i++)
                                            <iconify-icon icon="lucide:star" class="text-sm {{ $i <= $order->review->rating ? 'fill-current' : 'text-charcoal/10' }}"></iconify-icon>
                                        @endfor
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
</x-guest-public-layout>
