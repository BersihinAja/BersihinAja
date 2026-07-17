<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Package;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Str;

class OrderService
{
    public function create(array $data): Order
    {
        $service = Service::findOrFail($data['service_id']);
        $packages = isset($data['package_ids'])
            ? Package::whereIn('id', $data['package_ids'])->get()
            : collect();

        $total = $service->price + $packages->sum('price');

        $order = Order::create([
            'order_number' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'customer_id' => $data['customer_id'],
            'service_id' => $service->id,
            'total' => $total,
            'address' => $data['address'],
            'regency_name' => $data['regency_name'] ?? '',
            'payment_status' => 'unpaid',
            'order_status' => 'pending',
            'expires_at' => now()->addMinutes(3),
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        // Attach workers
        if (isset($data['worker_ids'])) {
            $order->workers()->attach($data['worker_ids']);
        }

        // Attach packages with price snapshot
        foreach ($packages as $package) {
            $order->packages()->attach($package->id, ['price' => $package->price]);
        }

        return $order->load(['service', 'workers', 'packages']);
    }

    public function cancelExpired(): int
    {
        $expiredOrders = Order::expired()->with('workers')->get();

        foreach ($expiredOrders as $order) {
            $order->update([
                'payment_status' => 'expired',
                'order_status' => 'cancelled',
            ]);

            // Release workers
            foreach ($order->workers as $worker) {
                $activeOrders = $worker->assignedOrders()
                    ->where('order_status', 'in_progress')
                    ->where('orders.id', '!=', $order->id)
                    ->count();

                if ($activeOrders === 0) {
                    $worker->update(['status' => 'available']);
                }
            }
        }

        return $expiredOrders->count();
    }

    public function complete(Order $order): void
    {
        $order->update(['order_status' => 'completed']);

        foreach ($order->workers as $worker) {
            $activeOrders = $worker->assignedOrders()
                ->where('order_status', 'in_progress')
                ->where('orders.id', '!=', $order->id)
                ->count();

            if ($activeOrders === 0) {
                $worker->update(['status' => 'available']);
            }
        }
    }
}
