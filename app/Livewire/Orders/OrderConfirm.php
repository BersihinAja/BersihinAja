<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Services\MidtransService;
use Livewire\Component;

class OrderConfirm extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->order->load(['service', 'workers', 'packages']);
    }

    public function initiatePayment(MidtransService $midtransService)
    {
        $snapToken = $midtransService->createSnapToken($this->order);
        $this->dispatch('pay-order', snapToken: $snapToken);
    }

    public function render()
    {
        return view('livewire.orders.order-confirm')
            ->layout('layouts.guest-public', ['title' => 'Konfirmasi & Pembayaran — BersihinAja']);
    }
}
