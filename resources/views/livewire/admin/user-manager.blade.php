<div>
    <!-- Page Header -->
    <div class="mb-10 reveal active">
        <p class="text-[10px] font-black tracking-[0.4em] text-mint">// ADMINISTRASI</p>
        <h1 class="mt-3 text-4xl font-black tracking-tighter">Kelola Pengguna</h1>
        <p class="mt-1 text-sm font-medium text-charcoal/50">Daftar pengguna terdaftar di platform BersihinAja</p>
    </div>

    <!-- Filters & Search -->
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4 reveal active">
        <!-- Role Tabs -->
        <div class="flex items-center gap-1 bg-cream-alt p-1 rounded-2xl border border-charcoal/5">
            @foreach(['all' => 'Semua', 'customer' => 'Customer', 'pekerja' => 'Pekerja', 'admin' => 'Admin'] as $key => $label)
                <button wire:click="$set('role', '{{ $key }}')" 
                        class="rounded-xl px-4 py-2 text-[10px] font-black tracking-wider uppercase ease-premium {{ $role === $key ? 'bg-mint text-charcoal' : 'text-charcoal/50 hover:text-charcoal hover:bg-cream' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <!-- Search Bar -->
        <div class="relative w-full max-w-xs">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, telepon..." 
                class="w-full rounded-xl border border-charcoal/10 bg-cream-alt px-4 py-2.5 pl-10 text-xs font-bold text-charcoal outline-none ease-premium focus:border-mint">
            <iconify-icon icon="lucide:search" class="absolute left-3.5 top-3.5 text-sm text-charcoal/40"></iconify-icon>
        </div>
    </div>

    <!-- Main Grid (User Table / Detail Panel) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start reveal active">
        <!-- Table Area -->
        <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 {{ $selectedUser ? 'lg:col-span-8' : 'lg:col-span-12' }}">
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-charcoal/10 text-[10px] font-black tracking-[0.2em] text-charcoal/40">
                                <th class="pb-4">PENGGUNA</th>
                                <th class="pb-4">EMAIL</th>
                                <th class="pb-4">ROLE</th>
                                <th class="pb-4">PESANAN</th>
                                <th class="pb-4">BERGABUNG</th>
                                <th class="pb-4 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-charcoal/5 text-sm">
                            @foreach($users as $u)
                                <tr wire:key="user-row-{{ $u->id }}" class="hover:bg-cream/40 ease-premium {{ $selectedUserId === $u->id ? 'bg-cream' : '' }}">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-mint/10 text-mint font-black">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-charcoal truncate">{{ $u->name }}</p>
                                                @if($u->phone)
                                                    <p class="text-[10px] font-medium text-charcoal/40 mt-0.5">{{ $u->phone }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 font-medium text-charcoal/70">{{ $u->email }}</td>
                                    <td class="py-4">
                                        @foreach($u->roles as $userRole)
                                            @php
                                                $badgeStyles = match($userRole->name) {
                                                    'admin' => 'bg-charcoal/80 text-cream',
                                                    'pekerja' => 'bg-mint/10 text-mint',
                                                    'customer' => 'bg-purple/10 text-purple',
                                                    default => 'bg-charcoal/5 text-charcoal/50',
                                                };
                                            @endphp
                                            <span class="inline-flex rounded-full px-3 py-1 text-[9px] font-black tracking-wider {{ $badgeStyles }}">{{ strtoupper($userRole->name) }}</span>
                                        @endforeach
                                    </td>
                                    <td class="py-4 font-bold text-charcoal/70">{{ $u->orders_count }}</td>
                                    <td class="py-4 font-medium text-charcoal/40">{{ $u->created_at->format('d M Y') }}</td>
                                    <td class="py-4 text-right">
                                        <button wire:click="selectUser({{ $u->id }})" class="inline-flex items-center border-b border-charcoal pb-0.5 text-xs font-black uppercase tracking-widest ease-premium hover:border-mint">
                                            Lihat
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <iconify-icon icon="lucide:users" class="text-4xl text-charcoal/20"></iconify-icon>
                    <p class="mt-4 text-sm font-medium text-charcoal/40">Tidak ada pengguna ditemukan</p>
                </div>
            @endif
        </div>

        <!-- Detail Panel -->
        @if($selectedUser)
            <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 lg:col-span-4 relative">
                <!-- Close Button -->
                <button wire:click="selectUser(null)" class="absolute right-6 top-6 text-charcoal/40 hover:text-charcoal ease-premium">
                    <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                </button>

                <div class="text-center mb-6">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-mint text-charcoal text-2xl font-black mb-4">
                        {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                    </div>
                    <h2 class="text-2xl font-black tracking-tighter text-charcoal">{{ $selectedUser->name }}</h2>
                    <p class="text-xs font-medium text-charcoal/50 mt-1">{{ $selectedUser->email }}</p>
                </div>

                <div class="border-t border-charcoal/5 py-4 space-y-3.5 text-xs">
                    @if($selectedUser->phone)
                        <div class="flex justify-between">
                            <span class="font-black text-charcoal/40 uppercase tracking-wider">TELEPON</span>
                            <span class="font-bold text-charcoal">{{ $selectedUser->phone }}</span>
                        </div>
                    @endif
                    @if($selectedUser->address)
                        <div class="flex flex-col gap-1">
                            <span class="font-black text-charcoal/40 uppercase tracking-wider">ALAMAT</span>
                            <span class="font-medium text-charcoal/70 bg-cream p-3 rounded-xl leading-relaxed">{{ $selectedUser->address }}</span>
                        </div>
                    @endif
                    @if($selectedUser->regency_name)
                        <div class="flex justify-between">
                            <span class="font-black text-charcoal/40 uppercase tracking-wider">KABUPATEN/KOTA</span>
                            <span class="font-bold text-charcoal">{{ $selectedUser->regency_name }}</span>
                        </div>
                    @endif
                    @if($selectedUser->province_name)
                        <div class="flex justify-between">
                            <span class="font-black text-charcoal/40 uppercase tracking-wider">PROVINSI</span>
                            <span class="font-bold text-charcoal">{{ $selectedUser->province_name }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="font-black text-charcoal/40 uppercase tracking-wider">BERGABUNG</span>
                        <span class="font-bold text-charcoal">{{ $selectedUser->created_at->format('d M Y') }}</span>
                    </div>
                    @if($selectedUser->hasRole('pekerja'))
                        <div class="flex justify-between">
                            <span class="font-black text-charcoal/40 uppercase tracking-wider">STATUS KERJA</span>
                            @php
                                $statusStyles = $selectedUser->status === 'available' ? 'bg-[#36D399]/10 text-[#36D399]' : 'bg-[#FBBD23]/10 text-[#FBBD23]';
                            @endphp
                            <span class="inline-flex rounded-full px-2 py-0.5 text-[9px] font-black tracking-wide {{ $statusStyles }}">{{ strtoupper($selectedUser->status ?? 'AVAILABLE') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Stats summary -->
                <div class="border-t border-charcoal/5 pt-6 grid grid-cols-2 gap-4 text-center">
                    <div>
                        <p class="text-2xl font-black text-charcoal">{{ $selectedUser->orders->count() }}</p>
                        <p class="text-[9px] font-black tracking-wider text-charcoal/30 mt-1 uppercase">PESANAN</p>
                    </div>
                    <div>
                        <p class="text-xl font-black text-mint">Rp {{ number_format($selectedUser->orders->sum('total'), 0, ',', '.') }}</p>
                        <p class="text-[9px] font-black tracking-wider text-charcoal/30 mt-1.5 uppercase">TOTAL BELANJA</p>
                    </div>
                </div>

                <!-- Recent User Orders -->
                @if($selectedUser->orders->count() > 0)
                    <div class="border-t border-charcoal/5 mt-6 pt-6">
                        <h3 class="text-xs font-black tracking-wider text-charcoal/50 mb-3 uppercase">10 PESANAN TERAKHIR</h3>
                        <div class="space-y-2 max-h-[220px] overflow-y-auto pr-1">
                            @foreach($selectedUser->orders as $o)
                                <div wire:key="user-detail-order-{{ $o->id }}" class="flex justify-between items-center bg-cream p-3 rounded-xl border border-charcoal/5">
                                    <div class="min-w-0">
                                        <p class="font-mono text-[10px] font-bold text-charcoal">{{ $o->order_number }}</p>
                                        <p class="text-[10px] font-medium text-charcoal/50 mt-0.5">{{ $o->service->name ?? '-' }}</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-[10px] font-black text-charcoal">Rp {{ number_format($o->total, 0, ',', '.') }}</p>
                                        @php
                                            $orderColor = match($o->order_status) {
                                                'completed' => 'text-[#36D399]',
                                                'cancelled' => 'text-[#F87272]',
                                                default => 'text-[#FBBD23]',
                                            };
                                        @endphp
                                        <p class="text-[9px] font-black {{ $orderColor }} uppercase mt-0.5">{{ str_replace('_', ' ', $o->order_status) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
