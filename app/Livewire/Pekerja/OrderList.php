<?php

namespace App\Livewire\Pekerja;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public string $status = 'all';

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function completeOrder(Order $order, OrderService $orderService)
    {
        // Verify this worker is assigned to this order
        $user = Auth::user();
        if (!$order->workers->contains('id', $user->id)) {
            abort(403);
        }

        $orderService->complete($order);
        session()->flash('success', 'Pesanan ' . $order->order_number . ' berhasil diselesaikan!');
    }

    public function render()
    {
        $user = Auth::user();
        $query = $user->assignedOrders()->with(['customer', 'service', 'packages']);

        if ($this->status !== 'all') {
            $query->where('order_status', $this->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('livewire.pekerja.order-list', [
            'orders' => $orders,
        ])->layout('layouts.pekerja', ['title' => 'Pesanan Saya']);
    }
}
