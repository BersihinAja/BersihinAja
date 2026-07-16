<?php

namespace App\Mcp\Servers\Tools;

use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('List available workers filtered by regency. Returns workers who are currently available for new cleaning orders.')]
class ListAvailableWorkersTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'regency_id' => 'required|string',
        ]);

        $workers = User::workers()
            ->available()
            ->inRegency($validated['regency_id'])
            ->get()
            ->map(fn ($w) => [
                'id' => $w->id,
                'name' => $w->name,
                'status' => $w->status,
                'regency' => $w->regency_name,
            ])
            ->toArray();

        return Response::json($workers);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\Types\Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'regency_id' => $schema->string()
                ->required()
                ->description('The regency ID to filter available workers by location'),
        ];
    }
}
