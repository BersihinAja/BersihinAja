<x-admin-layout>
    <x-slot:title>Detail Pengguna</x-slot:title>

    <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-base-content/60 mb-2">
                <a href="{{ route('admin.users.index') }}" class="hover:text-base-content">Pengguna</a>
                <span>/</span>
                <span>Detail</span>
            </div>
            <h1 class="text-3xl font-bold text-base-content">Detail Pengguna</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="bg-base-100 rounded-box shadow p-6">
                <div class="text-center mb-6">
                    <div class="avatar placeholder mb-4">
                        <div class="bg-primary text-primary-content rounded-full w-20">
                            <span class="text-3xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-base-content">{{ $user->name }}</h2>
                    <p class="text-base-content/60 text-sm">{{ $user->email }}</p>
                    <div class="flex justify-center gap-2 mt-3">
                        @foreach($user->roles as $userRole)
                            @switch($userRole->name)
                                @case('admin')
                                    <span class="badge badge-primary">Admin</span>
                                    @break
                                @case('pekerja')
                                    <span class="badge badge-warning">Pekerja</span>
                                    @break
                                @case('customer')
                                    <span class="badge badge-info">Customer</span>
                                    @break
                                @default
                                    <span class="badge badge-ghost">{{ $userRole->name }}</span>
                            @endswitch
                        @endforeach
                    </div>
                </div>

                <div class="divider"></div>

                <div class="space-y-3 text-sm">
                    @if($user->phone)
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Telepon</span>
                            <span class="font-medium">{{ $user->phone }}</span>
                        </div>
                    @endif
                    @if($user->address)
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Alamat</span>
                            <span class="font-medium text-right max-w-[60%]">{{ $user->address }}</span>
                        </div>
                    @endif
                    @if($user->regency_name)
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Kota</span>
                            <span class="font-medium">{{ $user->regency_name }}</span>
                        </div>
                    @endif
                    @if($user->province_name)
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Provinsi</span>
                            <span class="font-medium">{{ $user->province_name }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Bergabung</span>
                        <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    @if($user->status)
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Status</span>
                            <span class="badge badge-sm {{ $user->status === 'available' ? 'badge-success' : ($user->status === 'working' ? 'badge-warning' : 'badge-neutral') }}">{{ ucfirst($user->status) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Stats -->
                <div class="divider"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary">{{ $user->orders->count() }}</div>
                        <div class="text-xs text-base-content/60">Total Pesanan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-success">Rp {{ number_format($user->orders->sum('total'), 0, ',', '.') }}</div>
                        <div class="text-xs text-base-content/60">Total Belanja</div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="lg:col-span-2 bg-base-100 rounded-box shadow p-6">
                <h3 class="text-lg font-semibold text-base-content mb-4">Pesanan Terbaru</h3>

                @if($user->orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Layanan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-sm link link-primary">{{ $order->order_number }}</a>
                                        </td>
                                        <td>{{ $order->service->name ?? '-' }}</td>
                                        <td class="font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-base-content/20 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-base-content/40">Belum ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
