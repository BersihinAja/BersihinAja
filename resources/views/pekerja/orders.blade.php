<x-pekerja-layout>
    <x-slot:title>Pesanan Saya</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Pesanan Saya</h1>
            <p class="mt-1 text-base-content/60">Kelola semua pesanan yang ditugaskan kepada Anda</p>
        </div>

        <!-- Filter Tabs -->
        <div class="tabs tabs-boxed bg-base-100 mb-6 p-1 inline-flex">
            <a href="{{ route('pekerja.orders.index', ['status' => 'all']) }}"
               class="tab {{ $status === 'all' ? 'tab-active' : '' }}">
                Semua
            </a>
            <a href="{{ route('pekerja.orders.index', ['status' => 'in_progress']) }}"
               class="tab {{ $status === 'in_progress' ? 'tab-active' : '' }}">
                Sedang Berjalan
            </a>
            <a href="{{ route('pekerja.orders.index', ['status' => 'completed']) }}"
               class="tab {{ $status === 'completed' ? 'tab-active' : '' }}">
                Selesai
            </a>
            <a href="{{ route('pekerja.orders.index', ['status' => 'cancelled']) }}"
               class="tab {{ $status === 'cancelled' ? 'tab-active' : '' }}">
                Dibatalkan
            </a>
        </div>

        <!-- Orders Table -->
        <div class="bg-base-100 rounded-box shadow">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Paket</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="hover">
                                    <td class="font-mono text-sm">{{ $order->order_number }}</td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                    <span class="text-xs">{{ substr($order->customer->name ?? '?', 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <span>{{ $order->customer->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $order->service->name ?? '-' }}</td>
                                    <td>
                                        @if($order->packages->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($order->packages as $package)
                                                    <span class="badge badge-outline badge-sm">{{ $package->name }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-base-content/40">—</span>
                                        @endif
                                    </td>
                                    <td class="font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        @switch($order->order_status)
                                            @case('pending')
                                                <span class="badge badge-info">Menunggu</span>
                                                @break
                                            @case('in_progress')
                                                <span class="badge badge-warning">Berjalan</span>
                                                @break
                                            @case('completed')
                                                <span class="badge badge-success">Selesai</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge badge-error">Dibatalkan</span>
                                                @break
                                            @default
                                                <span class="badge badge-neutral">{{ $order->order_status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($order->order_status === 'in_progress')
                                            <form method="POST" action="{{ route('pekerja.orders.complete', $order) }}"
                                                  onsubmit="return confirm('Yakin ingin menyelesaikan pesanan ini?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Selesaikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-base-content/30">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-base-300">
                    {{ $orders->appends(['status' => $status])->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-base-content/40 text-lg">Tidak ada pesanan</p>
                    <p class="text-base-content/30 text-sm mt-1">
                        @if($status !== 'all')
                            Tidak ada pesanan dengan status "{{ $status }}"
                        @else
                            Belum ada pesanan yang ditugaskan kepada Anda
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-pekerja-layout>
