<?php

namespace App\Http\Controllers\Pekerja;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status', 'all');

        $query = $user->assignedOrders()->with(['customer', 'service', 'packages']);

        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        $orders = $query->latest()->paginate(10);

        return view('pekerja.orders', compact('orders', 'status'));
    }

    public function complete(Order $order, OrderService $orderService)
    {
        // Verify this worker is assigned to this order
        $user = Auth::user();
        if (!$order->workers->contains('id', $user->id)) {
            abort(403);
        }

        $orderService->complete($order);

        return redirect()->route('pekerja.orders.index')
            ->with('success', 'Pesanan berhasil diselesaikan!');
    }
}
