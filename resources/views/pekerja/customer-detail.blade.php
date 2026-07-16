<x-pekerja-layout>
    <x-slot:title>Detail Pelanggan — {{ $user->name }}</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <div class="text-sm breadcrumbs mb-6">
            <ul>
                <li><a href="{{ route('pekerja.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('pekerja.customers.index') }}">Pelanggan</a></li>
                <li class="text-base-content/60">{{ $user->name }}</li>
            </ul>
        </div>

        <!-- Customer Info Card -->
        <div class="bg-base-100 rounded-box shadow p-6 mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-16">
                        <span class="text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-base-content">{{ $user->name }}</h1>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-3">
                        <div class="flex items-center gap-2 text-base-content/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $user->email }}</span>
                        </div>
                        @if($user->phone)
                            <div class="flex items-center gap-2 text-base-content/60">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>{{ $user->phone }}</span>
                            </div>
                        @endif
                        @if($user->address)
                            <div class="flex items-center gap-2 text-base-content/60 sm:col-span-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $user->address }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="stat bg-base-200 rounded-box p-4">
                    <div class="stat-title text-sm">Total Pesanan Bersama</div>
                    <div class="stat-value text-primary text-2xl">{{ $orders->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Orders History -->
        <div class="bg-base-100 rounded-box shadow">
            <div class="p-6 border-b border-base-300">
                <h2 class="text-xl font-semibold text-base-content">Riwayat Pesanan</h2>
            </div>

            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="hover">
                                    <td class="font-mono text-sm">{{ $order->order_number }}</td>
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
                                    <td>
                                        @if($order->review)
                                            <div class="flex items-center gap-1">
                                                <div class="rating rating-sm">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <input type="radio" class="mask mask-star-2 bg-warning"
                                                               {{ $i == $order->review->rating ? 'checked' : '' }} disabled />
                                                    @endfor
                                                </div>
                                                @if($order->review->comment)
                                                    <div class="tooltip" data-tip="{{ $order->review->comment }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-base-content/30 text-sm">Belum ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-base-content/40">Belum ada riwayat pesanan dengan pelanggan ini</p>
                </div>
            @endif
        </div>
    </div>
</x-pekerja-layout>
