<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request, Service $service)
    {
        $service->load('packages');
        $regencyName = $request->query('regency_name', '');
        $regencyId = $request->query('regency_id', '');

        $workers = User::workers()->available()->inRegency($regencyId)->get();

        return view('orders.create', compact('service', 'workers', 'regencyName', 'regencyId'));
    }

    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->create([
            'customer_id' => auth()->id(),
            'service_id' => $request->service_id,
            'worker_ids' => $request->worker_ids,
            'package_ids' => $request->package_ids ?? [],
            'address' => $request->address,
            'regency_name' => $request->regency_name,
        ]);

        return redirect()->route('orders.confirm', $order);
    }

    public function confirm(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['service', 'workers', 'packages']);
        return view('orders.confirm', compact('order'));
    }

    public function receipt(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['service', 'workers', 'packages', 'review']);
        return view('orders.receipt', compact('order'));
    }

    public function history()
    {
        $orders = Order::forCustomer(auth()->id())
            ->with(['service', 'review'])
            ->latest()
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }
}
