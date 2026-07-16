<x-pekerja-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Dashboard</h1>
            <p class="mt-1 text-base-content/60">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Pesanan Aktif -->
            <div class="stat bg-base-100 rounded-box shadow">
                <div class="stat-figure text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Pesanan Aktif</div>
                <div class="stat-value text-warning">{{ $stats['active_orders'] }}</div>
                <div class="stat-desc">Sedang berjalan</div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="stat bg-base-100 rounded-box shadow">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Pesanan Selesai</div>
                <div class="stat-value text-success">{{ $stats['completed_orders'] }}</div>
                <div class="stat-desc">Total diselesaikan</div>
            </div>

            <!-- Total Pendapatan -->
            <div class="stat bg-base-100 rounded-box shadow">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Pendapatan</div>
                <div class="stat-value text-primary text-2xl">Rp {{ number_format($stats['total_earnings'], 0, ',', '.') }}</div>
                <div class="stat-desc">Dari pesanan selesai</div>
            </div>

            <!-- Status -->
            <div class="stat bg-base-100 rounded-box shadow">
                <div class="stat-figure">
                    <div class="avatar placeholder online">
                        <div class="bg-neutral text-neutral-content rounded-full w-12">
                            <span class="text-xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>
                <div class="stat-title">Status</div>
                <div class="stat-value text-lg">
                    @if($stats['status'] === 'available')
                        <span class="badge badge-success badge-lg">Tersedia</span>
                    @elseif($stats['status'] === 'busy')
                        <span class="badge badge-warning badge-lg">Sibuk</span>
                    @else
                        <span class="badge badge-neutral badge-lg">{{ ucfirst($stats['status'] ?? 'Tidak Diketahui') }}</span>
                    @endif
                </div>
                <div class="stat-desc">Status saat ini</div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-base-100 rounded-box shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-base-content">Pesanan Terbaru</h2>
                <a href="{{ route('pekerja.orders.index') }}" class="btn btn-ghost btn-sm">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td class="font-mono text-sm">{{ $order->order_number }}</td>
                                    <td>{{ $order->customer->name ?? '-' }}</td>
                                    <td>{{ $order->service->name ?? '-' }}</td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-base-content/40">Belum ada pesanan</p>
                </div>
            @endif
        </div>
    </div>
</x-pekerja-layout>
