<div>
    <!-- Page Header -->
    <div class="mb-10 reveal active">
        <p class="text-[10px] font-black tracking-[0.4em] text-mint">// HUBUNGAN</p>
        <h1 class="mt-3 text-4xl font-black tracking-tighter">Pelanggan Saya</h1>
        <p class="mt-1 text-sm font-medium text-charcoal/50">Daftar pelanggan yang pernah Anda layani</p>
    </div>

    <!-- Filters & Search -->
    <div class="mb-8 flex justify-end reveal active">
        <!-- Search Bar -->
        <div class="relative w-full max-w-xs">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, telepon..." 
                class="w-full rounded-xl border border-charcoal/10 bg-cream-alt px-4 py-2.5 pl-10 text-xs font-bold text-charcoal outline-none ease-premium focus:border-mint">
            <iconify-icon icon="lucide:search" class="absolute left-3.5 top-3.5 text-sm text-charcoal/40"></iconify-icon>
        </div>
    </div>

    <!-- Main Grid (Customer Table / Detail Panel) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start reveal active">
        <!-- Table Area -->
        <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 {{ $selectedCustomer ? 'lg:col-span-8' : 'lg:col-span-12' }}">
            @if($customers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-charcoal/10 text-[10px] font-black tracking-[0.2em] text-charcoal/40">
                                <th class="pb-4">PELANGGAN</th>
                                <th class="pb-4">EMAIL</th>
                                <th class="pb-4">TELEPON</th>
                                <th class="pb-4">TOTAL TUGAS</th>
                                <th class="pb-4 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-charcoal/5 text-sm">
                            @foreach($customers as $c)
                                <tr wire:key="customer-row-{{ $c->id }}" class="hover:bg-cream/40 ease-premium {{ $selectedCustomerId === $c->id ? 'bg-cream' : '' }}">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-mint/10 text-mint font-black">
                                                {{ strtoupper(substr($c->name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-charcoal truncate">{{ $c->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 font-medium text-charcoal/70">{{ $c->email }}</td>
                                    <td class="py-4 font-medium text-charcoal/70">{{ $c->phone ?: '—' }}</td>
                                    <td class="py-4 font-black">{{ $c->orders_count }} Kali</td>
                                    <td class="py-4 text-right">
                                        <button wire:click="selectCustomer({{ $c->id }})" class="inline-flex items-center border-b border-charcoal pb-0.5 text-xs font-black uppercase tracking-widest ease-premium hover:border-mint">
                                            Riwayat
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $customers->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <iconify-icon icon="lucide:users" class="text-4xl text-charcoal/20"></iconify-icon>
                    <p class="mt-4 text-sm font-medium text-charcoal/40">Belum ada pelanggan terdaftar yang dilayani</p>
                </div>
            @endif
        </div>

        <!-- Detail Panel -->
        @if($selectedCustomer)
            <div class="rounded-3xl bg-cream-alt p-8 border border-charcoal/5 lg:col-span-4 relative">
                <!-- Close Button -->
                <button wire:click="selectCustomer(null)" class="absolute right-6 top-6 text-charcoal/40 hover:text-charcoal ease-premium">
                    <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                </button>

                <div class="text-center mb-6">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-mint text-charcoal text-2xl font-black mb-4">
                        {{ strtoupper(substr($selectedCustomer->name, 0, 1)) }}
                    </div>
                    <h2 class="text-2xl font-black tracking-tighter text-charcoal">{{ $selectedCustomer->name }}</h2>
                    <p class="text-xs font-medium text-charcoal/50 mt-1">{{ $selectedCustomer->email }}</p>
                </div>

                <div class="border-t border-charcoal/5 py-4 space-y-3.5 text-xs">
                    @if($selectedCustomer->phone)
                        <div class="flex justify-between">
                            <span class="font-black text-charcoal/40 uppercase tracking-wider">TELEPON</span>
                            <span class="font-bold text-charcoal">{{ $selectedCustomer->phone }}</span>
                        </div>
                    @endif
                    @if($selectedCustomer->address)
                        <div class="flex flex-col gap-1">
                            <span class="font-black text-charcoal/40 uppercase tracking-wider">ALAMAT</span>
                            <span class="font-medium text-charcoal/70 bg-cream p-3 rounded-xl leading-relaxed">{{ $selectedCustomer->address }}</span>
                        </div>
                    @endif
                </div>

                <!-- Customer Tasks served by this worker -->
                @if(count($customerOrders) > 0)
                    <div class="border-t border-charcoal/5 mt-6 pt-6">
                        <h3 class="text-xs font-black tracking-wider text-charcoal/50 mb-3 uppercase">TUGAS DENGAN PELANGGAN INI</h3>
                        <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1">
                            @foreach($customerOrders as $o)
                                <div wire:key="customer-order-{{ $o->id }}" class="bg-cream p-4 rounded-xl border border-charcoal/5">
                                    <div class="flex justify-between items-start">
                                        <div class="min-w-0">
                                            <p class="font-mono text-[10px] font-bold text-charcoal">{{ $o->order_number }}</p>
                                            <p class="text-xs font-bold text-charcoal/75 mt-1">{{ $o->service->name ?? '-' }}</p>
                                            <p class="text-[10px] text-charcoal/40 mt-0.5">{{ $o->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="shrink-0 text-right">
                                            @php
                                                $orderColor = match($o->order_status) {
                                                    'completed' => 'text-[#36D399]',
                                                    'cancelled' => 'text-[#F87272]',
                                                    default => 'text-[#FBBD23]',
                                                };
                                            @endphp
                                            <span class="text-[9px] font-black {{ $orderColor }} uppercase">{{ str_replace('_', ' ', $o->order_status) }}</span>
                                        </div>
                                    </div>
                                    @if($o->review)
                                        <div class="border-t border-charcoal/5 mt-3 pt-3">
                                            <div class="flex items-center gap-0.5 text-[#FBBD23]">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <iconify-icon icon="lucide:star" class="text-[10px] {{ $i <= $o->review->rating ? 'fill-current' : 'text-charcoal/10' }}"></iconify-icon>
                                                @endfor
                                            </div>
                                            @if($o->review->comment)
                                                <p class="text-[10px] italic text-charcoal/50 mt-1">"{{ $o->review->comment }}"</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
