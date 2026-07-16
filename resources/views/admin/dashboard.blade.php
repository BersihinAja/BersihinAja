<x-admin-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Dashboard Admin</h1>
            <p class="mt-1 text-base-content/60">Ringkasan data BersihinAja</p>
        </div>

        <!-- Main Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Pesanan -->
            <div class="stat bg-base-100 rounded-box shadow">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="stat-title">Total Pesanan</div>
                <div class="stat-value text-primary">{{ $stats['total_orders'] }}</div>
                <div class="stat-desc">Semua pesanan</div>
            </div>

            <!-- Total Pendapatan -->
            <div class="stat bg-base-100 rounded-box shadow">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Pendapatan</div>
                <div class="stat-value text-success text-2xl">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="stat-desc">Dari pembayaran lunas</div>
            </div>

            <!-- Total Pengguna -->
            <div class="stat bg-base-100 rounded-box shadow">
                <div class="stat-figure text-info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Pengguna</div>
                <div class="stat-value text-info">{{ $stats['total_users'] }}</div>
                <div class="stat-desc">Terdaftar di sistem</div>
            </div>

            <!-- Pekerja Aktif -->
            <div class="stat bg-base-100 rounded-box shadow">
                <div class="stat-figure text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Pekerja Aktif</div>
                <div class="stat-value text-warning">{{ $stats['active_workers'] }}</div>
                <div class="stat-desc">Sedang bekerja</div>
            </div>
        </div>

        <!-- Secondary Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="stat bg-base-100 rounded-box shadow py-4">
                <div class="stat-title text-xs">Pelanggan</div>
                <div class="stat-value text-lg">{{ $stats['total_customers'] }}</div>
            </div>
            <div class="stat bg-base-100 rounded-box shadow py-4">
                <div class="stat-title text-xs">Pekerja</div>
                <div class="stat-value text-lg">{{ $stats['total_workers'] }}</div>
            </div>
            <div class="stat bg-base-100 rounded-box shadow py-4">
                <div class="stat-title text-xs">Pesanan Pending</div>
                <div class="stat-value text-lg text-info">{{ $stats['pending_orders'] }}</div>
            </div>
            <div class="stat bg-base-100 rounded-box shadow py-4">
                <div class="stat-title text-xs">Pesanan Berjalan</div>
                <div class="stat-value text-lg text-warning">{{ $stats['in_progress_orders'] }}</div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-base-100 rounded-box shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-base-content">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">
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
                                <th>Total</th>
                                <th>Pembayaran</th>
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
</x-admin-layout>
