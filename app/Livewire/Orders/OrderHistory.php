<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = Order::forCustomer(auth()->id())
            ->with(['service', 'review'])
            ->latest()
            ->paginate(10);

        return view('livewire.orders.order-history', [
            'orders' => $orders,
        ])->layout('layouts.guest-public', ['title' => 'Riwayat Pesanan — BersihinAja']);
    }
}
