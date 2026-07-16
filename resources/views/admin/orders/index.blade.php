<x-admin-layout>
    <x-slot:title>Kelola Pesanan</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Kelola Pesanan</h1>
            <p class="mt-1 text-base-content/60">Semua pesanan yang masuk</p>
        </div>

        <!-- Filter Tabs -->
        <div class="tabs tabs-boxed bg-base-100 mb-6 p-1 w-fit">
            <a href="{{ route('admin.orders.index', ['status' => 'all']) }}"
               class="tab {{ $status === 'all' ? 'tab-active' : '' }}">Semua</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
               class="tab {{ $status === 'pending' ? 'tab-active' : '' }}">Pending</a>
            <a href="{{ route('admin.orders.index', ['status' => 'in_progress']) }}"
               class="tab {{ $status === 'in_progress' ? 'tab-active' : '' }}">Berjalan</a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
               class="tab {{ $status === 'completed' ? 'tab-active' : '' }}">Selesai</a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}"
               class="tab {{ $status === 'cancelled' ? 'tab-active' : '' }}">Dibatalkan</a>
        </div>

        <!-- Orders Table -->
        <div class="bg-base-100 rounded-box shadow overflow-hidden">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Total</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="font-mono text-sm">{{ $order->order_number }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                    <span class="text-xs">{{ substr($order->customer->name ?? '?', 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <span class="text-sm">{{ $order->customer->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-sm">{{ $order->service->name ?? '-' }}</td>
                                    <td class="font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->payment_status === 'paid')
                                            <span class="badge badge-success badge-sm">Lunas</span>
                                        @elseif($order->payment_status === 'unpaid')
                                            <span class="badge badge-warning badge-sm">Belum Bayar</span>
                                        @else
                                            <span class="badge badge-neutral badge-sm">{{ $order->payment_status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($order->order_status)
                                            @case('pending')
                                                <span class="badge badge-info badge-sm">Menunggu</span>
                                                @break
                                            @case('in_progress')
                                                <span class="badge badge-warning badge-sm">Berjalan</span>
                                                @break
                                            @case('completed')
                                                <span class="badge badge-success badge-sm">Selesai</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge badge-error badge-sm">Dibatalkan</span>
                                                @break
                                            @default
                                                <span class="badge badge-neutral badge-sm">{{ $order->order_status }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-sm text-base-content/60">{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-sm btn-square" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-base-300">
                    {{ $orders->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-base-content/40">Tidak ada pesanan ditemukan</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
