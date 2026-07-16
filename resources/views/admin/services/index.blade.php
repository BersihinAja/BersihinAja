<x-admin-layout>
    <x-slot:title>Kelola Layanan</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-base-content">Kelola Layanan</h1>
                <p class="mt-1 text-base-content/60">Tambah, edit, dan hapus layanan kebersihan</p>
            </div>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Layanan
            </a>
        </div>

        <!-- Services Table -->
        <div class="bg-base-100 rounded-box shadow overflow-hidden">
            @if($services->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Slug</th>
                                <th>Harga</th>
                                <th>Ukuran Ruangan</th>
                                <th>Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            @if($service->image)
                                                <div class="avatar">
                                                    <div class="mask mask-squircle w-12 h-12">
                                                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" />
                                                    </div>
                                                </div>
                                            @else
                                                <div class="avatar placeholder">
                                                    <div class="bg-neutral text-neutral-content mask mask-squircle w-12 h-12">
                                                        <span class="text-lg">{{ substr($service->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold">{{ $service->name }}</div>
                                                <div class="text-sm text-base-content/50">{{ $service->estimation }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="font-mono text-sm text-base-content/60">{{ $service->slug }}</td>
                                    <td class="font-semibold">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                    <td>{{ $service->room_size }}</td>
                                    <td>
                                        <span class="badge badge-ghost">{{ $service->orders_count }}</span>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-ghost btn-sm btn-square" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus layanan {{ $service->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost btn-sm btn-square text-error" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-base-content/40 mb-4">Belum ada layanan</p>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">Tambah Layanan Pertama</a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
