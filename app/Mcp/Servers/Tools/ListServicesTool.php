<?php

namespace App\Mcp\Servers\Tools;

use App\Models\Service;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Lists all available cleaning services with pricing and details.')]
class ListServicesTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $services = Service::all()->map(fn ($s) => [
            'id' => $s->id,
            'name' => $s->name,
            'price' => $s->price,
            'room_size' => $s->room_size,
            'max_hours' => $s->max_hours,
            'estimation' => $s->estimation,
            'cleaners_required' => $s->cleaners_required,
        ])->toArray();

        return Response::json($services);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\Types\Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
