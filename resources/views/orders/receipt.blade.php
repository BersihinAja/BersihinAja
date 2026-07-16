<x-app-layout>
    <div class="py-12 px-4 bg-base-200 min-h-screen">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-base-content mb-8">Detail Pesanan</h1>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    {{-- Header --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <span class="text-sm text-base-content/50">Nomor Pesanan</span>
                            <p class="text-lg font-mono font-bold">{{ $order->order_number }}</p>
                        </div>
                        <div class="flex gap-2">
                            @php
                                $statusColor = match($order->order_status) {
                                    'pending' => 'badge-warning',
                                    'in_progress' => 'badge-info',
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-error',
                                    default => 'badge-ghost',
                                };
                                $paymentColor = match($order->payment_status) {
                                    'unpaid' => 'badge-warning',
                                    'pending' => 'badge-info',
                                    'paid' => 'badge-success',
                                    'expired' => 'badge-error',
                                    'cancelled' => 'badge-error',
                                    default => 'badge-ghost',
                                };
                            @endphp
                            <span class="badge {{ $statusColor }} badge-lg">{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
                            <span class="badge {{ $paymentColor }} badge-lg badge-outline">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                    </div>

                    <div class="divider"></div>

                    {{-- Service Info --}}
                    <div class="mb-4">
                        <h3 class="font-semibold text-base-content mb-2">Layanan</h3>
                        <div class="bg-base-200 rounded-lg p-4">
                            <p class="font-bold text-lg">{{ $order->service->name }}</p>
                            <p class="text-sm text-base-content/60">Harga: Rp {{ number_format($order->service->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Workers --}}
                    <div class="mb-4">
                        <h3 class="font-semibold text-base-content mb-2">Pekerja</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($order->workers as $worker)
                                <div class="flex items-center gap-2 bg-base-200 rounded-lg px-4 py-2">
                                    <div class="avatar">
                                        <div class="w-8 rounded-full">
                                            <img src="{{ $worker->avatar ? asset('storage/' . $worker->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($worker->name) . '&size=32&background=570df8&color=fff' }}" alt="" />
                                        </div>
                                    </div>
                                    <span class="font-medium">{{ $worker->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Packages --}}
                    @if($order->packages->count() > 0)
                        <div class="mb-4">
                            <h3 class="font-semibold text-base-content mb-2">Paket Tambahan</h3>
                            @foreach($order->packages as $package)
                                <div class="flex justify-between bg-base-200 rounded-lg p-3 mb-2">
                                    <span>{{ $package->name }}</span>
                                    <span class="font-semibold">+ Rp {{ number_format($package->pivot->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Address --}}
                    <div class="mb-4">
                        <h3 class="font-semibold text-base-content mb-2">Alamat</h3>
                        <p class="bg-base-200 rounded-lg p-3 text-base-content/70">{{ $order->address }}, {{ $order->regency_name }}</p>
                    </div>

                    {{-- Payment Info --}}
                    @if($order->paid_at)
                        <div class="mb-4">
                            <h3 class="font-semibold text-base-content mb-2">Dibayar pada</h3>
                            <p class="text-success font-medium">{{ $order->paid_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    @endif

                    <div class="divider"></div>

                    {{-- Total --}}
                    <div class="flex justify-between items-center text-xl font-bold">
                        <span>Total</span>
                        <span class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Review Section --}}
            @if($order->order_status === 'completed' && !$order->review)
                <div class="card bg-base-100 shadow-xl mt-8">
                    <div class="card-body">
                        <h2 class="card-title text-base-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                            Beri Ulasan
                        </h2>
                        <form action="{{ route('reviews.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            <div class="form-control mb-4">
                                <label class="label"><span class="label-text">Rating</span></label>
                                <div class="rating rating-lg">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" class="mask mask-star-2 bg-warning" {{ $i === 5 ? 'checked' : '' }} />
                                    @endfor
                                </div>
                            </div>

                            <div class="form-control mb-4">
                                <label class="label"><span class="label-text">Komentar (opsional)</span></label>
                                <textarea name="comment" class="textarea textarea-bordered" rows="3" placeholder="Bagikan pengalaman Anda..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                Kirim Ulasan
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($order->review)
                <div class="card bg-base-100 shadow-xl mt-8">
                    <div class="card-body">
                        <h2 class="card-title text-base-content">Ulasan Anda</h2>
                        <div class="rating rating-sm mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" class="mask mask-star-2 bg-warning" {{ $i === $order->review->rating ? 'checked' : '' }} disabled />
                            @endfor
                        </div>
                        @if($order->review->comment)
                            <p class="text-base-content/70 mt-2">"{{ $order->review->comment }}"</p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="text-center mt-8">
                <a href="{{ route('orders.history') }}" class="btn btn-ghost">← Kembali ke Riwayat Pesanan</a>
            </div>
        </div>
    </div>
</x-app-layout>
