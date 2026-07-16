<x-admin-layout>
    <x-slot:title>Kelola Pengguna</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Kelola Pengguna</h1>
            <p class="mt-1 text-base-content/60">Daftar semua pengguna terdaftar</p>
        </div>

        <!-- Filter Tabs -->
        <div class="tabs tabs-boxed bg-base-100 mb-6 p-1 w-fit">
            <a href="{{ route('admin.users.index', ['role' => 'all']) }}"
               class="tab {{ $role === 'all' ? 'tab-active' : '' }}">Semua</a>
            <a href="{{ route('admin.users.index', ['role' => 'customer']) }}"
               class="tab {{ $role === 'customer' ? 'tab-active' : '' }}">Customer</a>
            <a href="{{ route('admin.users.index', ['role' => 'pekerja']) }}"
               class="tab {{ $role === 'pekerja' ? 'tab-active' : '' }}">Pekerja</a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
               class="tab {{ $role === 'admin' ? 'tab-active' : '' }}">Admin</a>
        </div>

        <!-- Users Table -->
        <div class="bg-base-100 rounded-box shadow overflow-hidden">
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Pesanan</th>
                                <th>Bergabung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content rounded-full w-10">
                                                    <span>{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">{{ $user->name }}</div>
                                                @if($user->phone)
                                                    <div class="text-sm text-base-content/50">{{ $user->phone }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-sm">{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $userRole)
                                            @switch($userRole->name)
                                                @case('admin')
                                                    <span class="badge badge-primary badge-sm">Admin</span>
                                                    @break
                                                @case('pekerja')
                                                    <span class="badge badge-warning badge-sm">Pekerja</span>
                                                    @break
                                                @case('customer')
                                                    <span class="badge badge-info badge-sm">Customer</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-ghost badge-sm">{{ $userRole->name }}</span>
                                            @endswitch
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="badge badge-ghost">{{ $user->orders_count }}</span>
                                    </td>
                                    <td class="text-sm text-base-content/60">{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-ghost btn-sm btn-square" title="Detail">
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
                    {{ $users->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-base-content/40">Tidak ada pengguna ditemukan</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
