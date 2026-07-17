<div class="px-6 pb-16 pt-28 lg:px-12">
    <div class="mx-auto max-w-[800px]">
        {{-- Header --}}
        <div class="reveal active">
            <p class="text-[10px] font-black tracking-[0.4em] text-mint">// PEMBAYARAN</p>
            <h1 class="mt-3 text-5xl font-black tracking-tighter sm:text-6xl">Konfirmasi Pesanan</h1>
        </div>

        <div class="mt-10 space-y-6">
            {{-- Receipt details --}}
            <div class="rounded-3xl bg-cream-alt p-8 reveal active">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-charcoal/5 pb-6">
                    <div>
                        <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">NOMOR PESANAN</span>
                        <p class="font-mono font-black text-charcoal mt-1">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <span class="inline-flex rounded-full bg-[#FBBD23]/10 px-4 py-1.5 text-[10px] font-black tracking-wider text-[#FBBD23]">
                            MENUNGGU PEMBAYARAN
                        </span>
                    </div>
                </div>

                <div class="space-y-6 mt-6">
                    {{-- Service --}}
                    <div>
                        <h3 class="text-xs font-black tracking-[0.15em] text-charcoal/40 mb-2">LAYANAN</h3>
                        <div class="flex justify-between items-center rounded-2xl bg-cream p-4">
                            <span class="font-bold text-charcoal">{{ $order->service->name }}</span>
                            <span class="font-black text-mint">Rp {{ number_format($order->service->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Workers --}}
                    <div>
                        <h3 class="text-xs font-black tracking-[0.15em] text-charcoal/40 mb-2">PEKERJA DITUGASKAN</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($order->workers as $worker)
                                <div class="inline-flex items-center gap-2 rounded-full border border-charcoal/10 bg-cream px-4 py-2 text-xs font-bold text-charcoal">
                                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-mint text-[9px] font-black text-charcoal overflow-hidden">
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
                    @if($order->packages->count() > 0)
                        <div>
                            <h3 class="text-xs font-black tracking-[0.15em] text-charcoal/40 mb-2">PAKET TAMBAHAN</h3>
                            <div class="space-y-2">
                                @foreach($order->packages as $package)
                                    <div class="flex justify-between items-center rounded-2xl bg-cream p-4">
                                        <span class="font-bold text-charcoal">{{ $package->name }}</span>
                                        <span class="font-black text-mint">+ Rp {{ number_format($package->pivot->price, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Address --}}
                    <div>
                        <h3 class="text-xs font-black tracking-[0.15em] text-charcoal/40 mb-2">ALAMAT PENGIRIMAN</h3>
                        <p class="rounded-2xl bg-cream p-4 text-sm font-medium leading-relaxed text-charcoal/70">{{ $order->address }}, {{ $order->regency_name }}</p>
                    </div>

                    {{-- Expiry --}}
                    @if($order->expires_at)
                        <div class="rounded-2xl bg-[#FBBD23]/10 p-5 flex items-start gap-3">
                            <iconify-icon icon="lucide:alert-circle" class="text-xl text-[#FBBD23] mt-0.5"></iconify-icon>
                            <span class="text-xs font-medium text-charcoal/70 leading-relaxed">
                                Pesanan akan kedaluwarsa pada <strong class="font-black">{{ $order->expires_at->format('d M Y, H:i') }}</strong>. Segera lakukan pembayaran untuk mengonfirmasi pesanan Anda.
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Total --}}
                <div class="flex justify-between items-center border-t border-charcoal/5 mt-8 pt-6">
                    <span class="text-xs font-black tracking-[0.15em] text-charcoal/40">TOTAL PEMBAYARAN</span>
                    <div class="flex items-start">
                        <span class="mt-1.5 text-xs font-black tracking-[0.1em]">Rp</span>
                        <span class="text-3xl font-black tracking-tighter text-mint">{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Pay Button --}}
                <div class="flex justify-center mt-8">
                    <button wire:click="initiatePayment" class="rounded-full bg-charcoal px-10 py-4 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal flex items-center gap-2">
                        <span wire:loading.remove wire:target="initiatePayment">Bayar Sekarang</span>
                        <span wire:loading wire:target="initiatePayment" class="flex items-center gap-2">
                            <iconify-icon icon="lucide:loader" class="animate-spin"></iconify-icon> Membuka Pembayaran...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap --}}
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('pay-order', (event) => {
                const snapToken = event.snapToken;
                window.snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route('orders.receipt', $order->id) }}';
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route('orders.receipt', $order->id) }}';
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</div>
