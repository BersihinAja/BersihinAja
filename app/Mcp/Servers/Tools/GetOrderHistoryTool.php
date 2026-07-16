<?php

namespace App\Mcp\Servers\Tools;

use App\Models\Order;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Get order history for a specific user. Returns the 20 most recent orders with service details.')]
class GetOrderHistoryTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
        ]);

        $orders = Order::forCustomer($validated['user_id'])
            ->with('service')
            ->latest()
            ->take(20)
            ->get()
            ->map(fn ($o) => [
                'order_number' => $o->order_number,
                'service' => $o->service->name,
                'total' => $o->total,
                'status' => $o->order_status,
                'date' => $o->created_at->toDateString(),
            ])
            ->toArray();

        return Response::json($orders);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\Types\Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'user_id' => $schema->integer()
                ->required()
                ->description('The customer user ID to retrieve order history for'),
        ];
    }
}
