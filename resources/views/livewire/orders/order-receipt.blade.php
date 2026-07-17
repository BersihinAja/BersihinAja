<div class="px-6 pb-16 pt-28 lg:px-12">
    <div class="mx-auto max-w-[800px]">
        {{-- Header --}}
        <div class="reveal active">
            <p class="text-[10px] font-black tracking-[0.4em] text-mint">// RINCIAN</p>
            <h1 class="mt-3 text-5xl font-black tracking-tighter sm:text-6xl">Detail Pesanan</h1>
        </div>

        <div class="mt-10 space-y-6">
            {{-- Status Messages --}}
            @if(session('success'))
                <div class="flex items-center gap-3 rounded-2xl bg-mint/10 px-6 py-4 reveal active">
                    <iconify-icon icon="lucide:check-circle" class="text-xl text-mint"></iconify-icon>
                    <span class="text-sm font-bold text-charcoal">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Receipt details --}}
            <div class="rounded-3xl bg-cream-alt p-8 reveal active">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-charcoal/5 pb-6">
                    <div>
                        <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/40">NOMOR PESANAN</span>
                        <p class="font-mono font-black text-charcoal mt-1">{{ $order->order_number }}</p>
                    </div>
                    <div class="flex gap-2">
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
                        <h3 class="text-xs font-black tracking-[0.15em] text-charcoal/40 mb-2">PEKERJA</h3>
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

                    {{-- Paid at --}}
                    @if($order->paid_at)
                        <div>
                            <h3 class="text-xs font-black tracking-[0.15em] text-charcoal/40 mb-2">DIBAYAR PADA</h3>
                            <p class="text-sm font-bold text-[#36D399]">{{ $order->paid_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    @endif
                </div>

                {{-- Total --}}
                <div class="flex justify-between items-center border-t border-charcoal/5 mt-8 pt-6">
                    <span class="text-xs font-black tracking-[0.15em] text-charcoal/40">TOTAL</span>
                    <div class="flex items-start">
                        <span class="mt-1.5 text-xs font-black tracking-[0.1em]">Rp</span>
                        <span class="text-3xl font-black tracking-tighter text-mint">{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Review Section --}}
            @if($order->order_status === 'completed' && !$order->review)
                <div class="rounded-3xl bg-cream-alt p-8 reveal active">
                    <h2 class="text-xl font-black tracking-tighter text-charcoal flex items-center gap-2">
                        <iconify-icon icon="lucide:star" class="text-[#FBBD23]"></iconify-icon> Beri Ulasan
                    </h2>
                    <form wire:submit="submitReview" class="mt-6 space-y-5">
                        {{-- Star Selection --}}
                        <div>
                            <label class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50 mb-3">RATING</label>
                            <div class="flex items-center gap-1.5 text-2xl text-[#FBBD23]">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" wire:click="$set('rating', {{ $i }})" class="ease-premium hover:scale-110 focus:outline-none">
                                        <iconify-icon icon="lucide:star" class="{{ $i <= $rating ? 'fill-current' : 'text-charcoal/10' }}"></iconify-icon>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        {{-- Comment --}}
                        <div>
                            <label for="comment" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">KOMENTAR (OPSIONAL)</label>
                            <textarea id="comment" wire:model="comment" rows="3" placeholder="Bagikan pengalaman Anda..."
                                class="mt-2 w-full rounded-2xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20"></textarea>
                            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                        </div>

                        <button type="submit" class="rounded-full bg-charcoal px-8 py-3 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal flex items-center gap-2">
                            <span wire:loading.remove wire:target="submitReview">Kirim Ulasan</span>
                            <span wire:loading wire:target="submitReview" class="flex items-center gap-2">
                                <iconify-icon icon="lucide:loader" class="animate-spin"></iconify-icon> Mengirim...
                            </span>
                        </button>
                    </form>
                </div>
            @elseif($order->review)
                <div class="rounded-3xl bg-cream-alt p-8 reveal active">
                    <h2 class="text-xl font-black tracking-tighter text-charcoal flex items-center gap-2">Ulasan Anda</h2>
                    <div class="flex items-center gap-1 text-[#FBBD23] mt-4">
                        @for($i = 1; $i <= 5; $i++)
                            <iconify-icon icon="lucide:star" class="{{ $i <= $order->review->rating ? 'fill-current' : 'text-charcoal/10' }}"></iconify-icon>
                        @endfor
                    </div>
                    @if($order->review->comment)
                        <p class="mt-4 text-sm font-medium italic leading-relaxed text-charcoal/70 bg-cream p-5 rounded-2xl">"{{ $order->review->comment }}"</p>
                    @endif
                </div>
            @endif

            {{-- Back Link --}}
            <div class="text-center mt-10">
                <a href="{{ route('orders.history') }}" wire:navigate class="inline-flex items-center gap-2 border-b border-charcoal pb-0.5 text-xs font-black uppercase tracking-widest ease-premium hover:border-mint">
                    <iconify-icon icon="lucide:arrow-left" class="text-base"></iconify-icon> Kembali ke Riwayat Pesanan
                </a>
            </div>
        </div>
    </div>
</div>
