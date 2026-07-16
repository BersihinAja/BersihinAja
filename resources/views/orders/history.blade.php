<x-app-layout>
    <div class="py-12 px-4 bg-base-200 min-h-screen">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-3xl font-bold text-base-content mb-8">Riwayat Pesanan</h1>

            @if(session('success'))
                <div class="alert alert-success mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center py-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        <h2 class="text-xl font-bold text-base-content/50">Belum Ada Pesanan</h2>
                        <p class="text-base-content/40 mt-2">Anda belum pernah memesan layanan. Yuk, mulai pesan sekarang!</p>
                        <a href="{{ route('services.index') }}" class="btn btn-primary mt-6">Lihat Layanan</a>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow">
                            <div class="card-body">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <p class="font-mono font-bold text-base-content">{{ $order->order_number }}</p>
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
                                            <span class="badge {{ $statusColor }} badge-sm">{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
                                            <span class="badge {{ $paymentColor }} badge-sm badge-outline">{{ ucfirst($order->payment_status) }}</span>
                                        </div>
                                        <p class="text-base-content/70">{{ $order->service->name }}</p>
                                        <p class="text-sm text-base-content/40">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="text-right">
                                            <span class="text-sm text-base-content/50">Total</span>
                                            <p class="text-lg font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                        </div>
                                        <a href="{{ route('orders.receipt', $order->id) }}" class="btn btn-primary btn-sm btn-outline">
                                            Detail
                                        </a>
                                    </div>
                                </div>

                                @if($order->review)
                                    <div class="mt-2 pt-2 border-t border-base-200">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-base-content/40">Ulasan Anda:</span>
                                            <div class="rating rating-xs">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <input type="radio" class="mask mask-star-2 bg-warning" {{ $i === $order->review->rating ? 'checked' : '' }} disabled />
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
