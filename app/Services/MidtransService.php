<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapToken(Order $order): string
    {
        $midtransOrderId = 'BA-' . $order->id . '-' . time();
        $order->update(['midtrans_order_id' => $midtransOrderId]);

        $serverKey = config('midtrans.server_key');
        if (str_contains($serverKey, 'xxxxxx') || empty($serverKey)) {
            $snapToken = 'mock-snap-token-' . $order->id . '-' . time();
            $order->update(['midtrans_snap_token' => $snapToken]);
            return $snapToken;
        }

        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->customer->name,
                'email' => $order->customer->email,
                'phone' => $order->customer->phone ?? '',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $order->update(['midtrans_snap_token' => $snapToken]);

        return $snapToken;
    }

    public function handleNotification(array $payload): void
    {
        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $signatureKey = $payload['signature_key'];

        // Verify signature
        $expectedSignature = hash('sha512',
            $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
        );

        if ($signatureKey !== $expectedSignature) {
            throw new \Exception('Invalid Midtrans signature');
        }

        $order = Order::where('midtrans_order_id', $orderId)->firstOrFail();
        $transactionStatus = $payload['transaction_status'];

        match ($transactionStatus) {
            'capture', 'settlement' => $this->handlePaymentSuccess($order),
            'pending' => $order->update(['payment_status' => 'pending']),
            'deny', 'cancel' => $this->handlePaymentFailed($order, 'cancelled'),
            'expire' => $this->handlePaymentFailed($order, 'expired'),
            default => null,
        };
    }

    private function handlePaymentSuccess(Order $order): void
    {
        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'in_progress',
            'paid_at' => now(),
        ]);

        // Set workers to 'working'
        foreach ($order->workers as $worker) {
            $worker->update(['status' => 'working']);
        }
    }

    private function handlePaymentFailed(Order $order, string $status): void
    {
        $order->update([
            'payment_status' => $status,
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
}
