<?php

namespace App\Mcp\Servers\Tools;

use App\Models\Order;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Check order status by order number. Returns order details including service, customer, payment status, and assigned workers.')]
class GetOrderStatusTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::where('order_number', $validated['order_number'])
            ->with(['service', 'customer', 'workers'])
            ->firstOrFail();

        return Response::json([
            'order_number' => $order->order_number,
            'service' => $order->service->name,
            'customer' => $order->customer->name,
            'total' => $order->total,
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'workers' => $order->workers->pluck('name')->toArray(),
            'created_at' => $order->created_at->toISOString(),
        ]);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\Types\Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'order_number' => $schema->string()
                ->required()
                ->description('The order number to look up (e.g. ORD-20260101-ABCDE)'),
        ];
    }
}
