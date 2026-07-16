<x-app-layout>
    <div class="py-12 px-4 bg-base-200 min-h-screen">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-base-content mb-8">Konfirmasi & Pembayaran</h1>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    {{-- Order Number --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-sm text-base-content/50">Nomor Pesanan</span>
                            <p class="text-lg font-mono font-bold text-base-content">{{ $order->order_number }}</p>
                        </div>
                        <div class="badge badge-warning badge-lg">Menunggu Pembayaran</div>
                    </div>

                    <div class="divider"></div>

                    {{-- Service --}}
                    <div class="mb-4">
                        <h3 class="font-semibold text-base-content mb-2">Layanan</h3>
                        <div class="flex justify-between items-center bg-base-200 rounded-lg p-3">
                            <span>{{ $order->service->name }}</span>
                            <span class="font-semibold">Rp {{ number_format($order->service->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Workers --}}
                    <div class="mb-4">
                        <h3 class="font-semibold text-base-content mb-2">Pekerja Ditugaskan</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($order->workers as $worker)
                                <div class="badge badge-primary badge-outline gap-2 p-3">
                                    <div class="avatar">
                                        <div class="w-5 rounded-full">
                                            <img src="{{ $worker->avatar ? asset('storage/' . $worker->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($worker->name) . '&size=20&background=570df8&color=fff' }}" alt="" />
                                        </div>
                                    </div>
                                    {{ $worker->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Packages --}}
                    @if($order->packages->count() > 0)
                        <div class="mb-4">
                            <h3 class="font-semibold text-base-content mb-2">Paket Tambahan</h3>
                            @foreach($order->packages as $package)
                                <div class="flex justify-between items-center bg-base-200 rounded-lg p-3 mb-2">
                                    <span>{{ $package->name }}</span>
                                    <span class="font-semibold">+ Rp {{ number_format($package->pivot->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Address --}}
                    <div class="mb-4">
                        <h3 class="font-semibold text-base-content mb-2">Alamat</h3>
                        <p class="text-base-content/70 bg-base-200 rounded-lg p-3">{{ $order->address }}, {{ $order->regency_name }}</p>
                    </div>

                    <div class="divider"></div>

                    {{-- Total --}}
                    <div class="flex justify-between items-center text-xl font-bold">
                        <span>Total Pembayaran</span>
                        <span class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    {{-- Pay Button --}}
                    <div class="card-actions justify-center mt-8">
                        <button id="pay-button" class="btn btn-primary btn-lg btn-wide gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                            Bayar Sekarang
                        </button>
                    </div>

                    {{-- Expiry warning --}}
                    @if($order->expires_at)
                        <div class="alert alert-warning mt-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <span>Pesanan akan kedaluwarsa pada <strong>{{ $order->expires_at->format('d M Y, H:i') }}</strong>. Segera lakukan pembayaran.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap --}}
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', async function () {
            this.classList.add('loading');
            this.disabled = true;

            try {
                const response = await fetch('{{ route('payment.snap-token', $order->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route('orders.receipt', $order->id) }}';
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route('orders.receipt', $order->id) }}';
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        location.reload();
                    },
                    onClose: function() {
                        document.getElementById('pay-button').classList.remove('loading');
                        document.getElementById('pay-button').disabled = false;
                    }
                });
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                this.classList.remove('loading');
                this.disabled = false;
            }
        });
    </script>
</x-app-layout>
