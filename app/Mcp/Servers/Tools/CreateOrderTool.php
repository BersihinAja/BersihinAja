<?php

namespace App\Mcp\Servers\Tools;

use App\Services\OrderService;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Create a new cleaning order. Requires service, workers, address, regency, and customer. Optionally attach add-on packages.')]
class CreateOrderTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'worker_ids' => 'required|array|min:1',
            'worker_ids.*' => 'integer|exists:users,id',
            'address' => 'required|string',
            'regency_name' => 'required|string',
            'customer_id' => 'required|integer|exists:users,id',
            'package_ids' => 'sometimes|array',
            'package_ids.*' => 'integer|exists:packages,id',
        ]);

        $orderService = app(OrderService::class);
        $order = $orderService->create([
            'customer_id' => $validated['customer_id'],
            'service_id' => $validated['service_id'],
            'worker_ids' => $validated['worker_ids'],
            'package_ids' => $validated['package_ids'] ?? [],
            'address' => $validated['address'],
            'regency_name' => $validated['regency_name'],
        ]);

        return Response::json([
            'order_number' => $order->order_number,
            'total' => $order->total,
            'status' => $order->order_status,
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
            'service_id' => $schema->integer()
                ->required()
                ->description('The ID of the cleaning service to order'),
            'worker_ids' => $schema->array()
                ->required()
                ->items($schema->integer())
                ->description('Array of worker IDs to assign to the order'),
            'address' => $schema->string()
                ->required()
                ->description('The full address for the cleaning service'),
            'regency_name' => $schema->string()
                ->required()
                ->description('The regency/city name for the service location'),
            'customer_id' => $schema->integer()
                ->required()
                ->description('The ID of the customer placing the order'),
            'package_ids' => $schema->array()
                ->items($schema->integer())
                ->description('Optional array of add-on package IDs'),
        ];
    }
}
