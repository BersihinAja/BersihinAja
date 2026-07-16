<x-pekerja-layout>
    <x-slot:title>Pelanggan</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Pelanggan</h1>
            <p class="mt-1 text-base-content/60">Daftar pelanggan yang pernah Anda layani</p>
        </div>

        <!-- Customers List -->
        @if($customers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @foreach($customers as $customer)
                    <a href="{{ route('pekerja.customers.show', $customer) }}"
                       class="card bg-base-100 shadow hover:shadow-lg transition-shadow duration-200">
                        <div class="card-body">
                            <div class="flex items-center gap-4">
                                <div class="avatar placeholder">
                                    <div class="bg-primary text-primary-content rounded-full w-12">
                                        <span class="text-lg font-bold">{{ substr($customer->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-base-content truncate">{{ $customer->name }}</h3>
                                    <p class="text-sm text-base-content/60 truncate">{{ $customer->email }}</p>
                                </div>
                            </div>
                            <div class="divider my-2"></div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-base-content/60">Total Pesanan</span>
                                <span class="badge badge-primary badge-sm">{{ $customer->orders_count }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $customers->links() }}
            </div>
        @else
            <div class="bg-base-100 rounded-box shadow p-16 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-base-content/40 text-lg">Belum ada pelanggan</p>
                <p class="text-base-content/30 text-sm mt-1">Pelanggan akan muncul setelah Anda menyelesaikan pesanan</p>
            </div>
        @endif
    </div>
</x-pekerja-layout>
