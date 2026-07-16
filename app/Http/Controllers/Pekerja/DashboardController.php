<?php

namespace App\Http\Controllers\Pekerja;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'active_orders' => $user->assignedOrders()->where('order_status', 'in_progress')->count(),
            'completed_orders' => $user->assignedOrders()->where('order_status', 'completed')->count(),
            'total_earnings' => $user->assignedOrders()->where('payment_status', 'paid')->sum('total'),
            'status' => $user->status,
        ];

        $recentOrders = $user->assignedOrders()
            ->with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();

        return view('pekerja.dashboard', compact('stats', 'recentOrders'));
    }
}
