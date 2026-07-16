<x-admin-layout>
    <x-slot:title>Detail Pesanan</x-slot:title>

    <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-base-content/60 mb-2">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-base-content">Pesanan</a>
                <span>/</span>
                <span>{{ $order->order_number }}</span>
            </div>
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-base-content">Detail Pesanan</h1>
                <div class="flex gap-2">
                    @switch($order->order_status)
                        @case('pending')
                            <span class="badge badge-info badge-lg">Menunggu</span>
                            @break
                        @case('in_progress')
                            <span class="badge badge-warning badge-lg">Berjalan</span>
                            @break
                        @case('completed')
                            <span class="badge badge-success badge-lg">Selesai</span>
                            @break
                        @case('cancelled')
                            <span class="badge badge-error badge-lg">Dibatalkan</span>
                            @break
                        @default
                            <span class="badge badge-neutral badge-lg">{{ $order->order_status }}</span>
                    @endswitch
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Info -->
                <div class="bg-base-100 rounded-box shadow p-6">
                    <h3 class="text-lg font-semibold text-base-content mb-4">Informasi Pesanan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-base-content/60">No. Pesanan</span>
                            <p class="font-mono font-semibold">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <span class="text-base-content/60">Layanan</span>
                            <p class="font-semibold">{{ $order->service->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-base-content/60">Alamat</span>
                            <p class="font-medium">{{ $order->address ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-base-content/60">Kota</span>
                            <p class="font-medium">{{ $order->regency_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-base-content/60">Tanggal Pesanan</span>
                            <p class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Workers -->
                @if($order->workers->count() > 0)
                    <div class="bg-base-100 rounded-box shadow p-6">
                        <h3 class="text-lg font-semibold text-base-content mb-4">Pekerja Ditugaskan</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($order->workers as $worker)
                                <div class="flex items-center gap-3 bg-base-200 rounded-lg px-4 py-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-warning text-warning-content rounded-full w-10">
                                            <span>{{ substr($worker->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm">{{ $worker->name }}</p>
                                        <p class="text-xs text-base-content/50">{{ $worker->phone ?? $worker->email }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Packages -->
                @if($order->packages->count() > 0)
                    <div class="bg-base-100 rounded-box shadow p-6">
                        <h3 class="text-lg font-semibold text-base-content mb-4">Paket Tambahan</h3>
                        <div class="space-y-3">
                            @foreach($order->packages as $package)
                                <div class="flex items-center justify-between bg-base-200 rounded-lg px-4 py-3">
                                    <span class="font-medium text-sm">{{ $package->name }}</span>
                                    <span class="font-semibold text-sm">Rp {{ number_format($package->pivot->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Review -->
                @if($order->review)
                    <div class="bg-base-100 rounded-box shadow p-6">
                        <h3 class="text-lg font-semibold text-base-content mb-4">Ulasan</h3>
                        <div class="flex items-start gap-4">
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= $order->review->rating ? 'text-warning fill-warning' : 'text-base-content/20' }}" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endfor
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-base-content/80">{{ $order->review->comment ?? 'Tidak ada komentar' }}</p>
                                <p class="text-xs text-base-content/40 mt-2">{{ $order->review->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Status Timeline -->
                <div class="bg-base-100 rounded-box shadow p-6">
                    <h3 class="text-lg font-semibold text-base-content mb-4">Timeline Status</h3>
                    <ul class="steps steps-vertical">
                        <li class="step {{ in_array($order->order_status, ['pending', 'in_progress', 'completed']) ? 'step-primary' : '' }}">
                            <div class="text-left">
                                <p class="font-medium text-sm">Pesanan Dibuat</p>
                                <p class="text-xs text-base-content/50">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </li>
                        <li class="step {{ $order->payment_status === 'paid' ? 'step-primary' : '' }}">
                            <div class="text-left">
                                <p class="font-medium text-sm">Pembayaran</p>
                                <p class="text-xs text-base-content/50">{{ $order->paid_at ? $order->paid_at->format('d M Y, H:i') : 'Belum dibayar' }}</p>
                            </div>
                        </li>
                        <li class="step {{ in_array($order->order_status, ['in_progress', 'completed']) ? 'step-primary' : '' }}">
                            <div class="text-left">
                                <p class="font-medium text-sm">Sedang Dikerjakan</p>
                                <p class="text-xs text-base-content/50">{{ $order->order_status === 'in_progress' ? 'Sedang berjalan' : ($order->order_status === 'completed' ? 'Selesai' : 'Menunggu') }}</p>
                            </div>
                        </li>
                        <li class="step {{ $order->order_status === 'completed' ? 'step-primary' : '' }}">
                            <div class="text-left">
                                <p class="font-medium text-sm">Selesai</p>
                                <p class="text-xs text-base-content/50">{{ $order->order_status === 'completed' ? 'Pesanan selesai' : 'Belum selesai' }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Info -->
                <div class="bg-base-100 rounded-box shadow p-6">
                    <h3 class="text-lg font-semibold text-base-content mb-4">Pelanggan</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-12">
                                <span class="text-lg">{{ substr($order->customer->name ?? '?', 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $order->customer->name ?? '-' }}</p>
                            <p class="text-sm text-base-content/60">{{ $order->customer->email ?? '-' }}</p>
                        </div>
                    </div>
                    @if($order->customer)
                        <a href="{{ route('admin.users.show', $order->customer) }}" class="btn btn-ghost btn-sm btn-block">Lihat Profil</a>
                    @endif
                </div>

                <!-- Pricing -->
                <div class="bg-base-100 rounded-box shadow p-6">
                    <h3 class="text-lg font-semibold text-base-content mb-4">Rincian Harga</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Layanan</span>
                            <span class="font-medium">{{ $order->service->name ?? '-' }}</span>
                        </div>
                        @if($order->packages->count() > 0)
                            @foreach($order->packages as $package)
                                <div class="flex justify-between">
                                    <span class="text-base-content/60">+ {{ $package->name }}</span>
                                    <span class="font-medium">Rp {{ number_format($package->pivot->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @endif
                        <div class="divider my-2"></div>
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-base-100 rounded-box shadow p-6">
                    <h3 class="text-lg font-semibold text-base-content mb-4">Pembayaran</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Status</span>
                            @if($order->payment_status === 'paid')
                                <span class="badge badge-success">Lunas</span>
                            @elseif($order->payment_status === 'unpaid')
                                <span class="badge badge-warning">Belum Bayar</span>
                            @else
                                <span class="badge badge-neutral">{{ $order->payment_status }}</span>
                            @endif
                        </div>
                        @if($order->midtrans_order_id)
                            <div class="flex justify-between">
                                <span class="text-base-content/60">Midtrans ID</span>
                                <span class="font-mono text-xs">{{ $order->midtrans_order_id }}</span>
                            </div>
                        @endif
                        @if($order->paid_at)
                            <div class="flex justify-between">
                                <span class="text-base-content/60">Dibayar</span>
                                <span class="font-medium">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                        @if($order->expires_at)
                            <div class="flex justify-between">
                                <span class="text-base-content/60">Kadaluarsa</span>
                                <span class="font-medium {{ $order->expires_at->isPast() ? 'text-error' : '' }}">{{ $order->expires_at->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
