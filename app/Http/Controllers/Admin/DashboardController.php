<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_users' => User::count(),
            'total_customers' => User::role('customer')->count(),
            'total_workers' => User::role('pekerja')->count(),
            'active_workers' => User::role('pekerja')->where('status', 'working')->count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'in_progress_orders' => Order::where('order_status', 'in_progress')->count(),
        ];

        $recentOrders = Order::with(['customer', 'service'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
