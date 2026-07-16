<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Order::with(['customer', 'service']);
        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'service', 'workers', 'packages', 'review']);
        return view('admin.orders.show', compact('order'));
    }
}
