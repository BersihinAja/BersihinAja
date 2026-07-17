<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManager extends Component
{
    use WithPagination;

    // Filter properties
    public string $status = 'all';
    public string $search = '';

    // Active detail view property
    public ?int $selectedOrderId = null;

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectOrder(?int $orderId)
    {
        $this->selectedOrderId = $orderId;
    }

    public function render()
    {
        $query = Order::with(['customer', 'service']);

        if ($this->status !== 'all') {
            $query->where('order_status', $this->status);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function($customerQuery) {
                      $customerQuery->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('service', function($serviceQuery) {
                      $serviceQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        // Load detail order if selected
        $selectedOrder = null;
        if ($this->selectedOrderId) {
            $selectedOrder = Order::with(['customer', 'service', 'workers', 'packages', 'review'])
                ->find($this->selectedOrderId);
        }

        return view('livewire.admin.order-manager', [
            'orders' => $orders,
            'selectedOrder' => $selectedOrder,
        ])->layout('layouts.admin', ['title' => 'Kelola Pesanan']);
    }
}
