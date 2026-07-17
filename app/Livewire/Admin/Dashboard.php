<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    #[Computed]
    public function stats()
    {
        return [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_users' => User::count(),
            'total_customers' => User::role('customer')->count(),
            'total_workers' => User::role('pekerja')->count(),
            'active_workers' => User::role('pekerja')->where('status', 'working')->count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'in_progress_orders' => Order::where('order_status', 'in_progress')->count(),
        ];
    }

    #[Computed]
    public function recentOrders()
    {
        return Order::with(['customer', 'service'])
            ->latest()
            ->take(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.admin', ['title' => 'Dashboard']);
    }
}
