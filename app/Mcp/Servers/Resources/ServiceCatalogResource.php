<?php

namespace App\Mcp\Servers\Resources;

use App\Models\Service;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\MimeType;
use Laravel\Mcp\Server\Attributes\Uri;
use Laravel\Mcp\Server\Resource;

#[Description('Complete service catalog with available packages for each cleaning service.')]
#[Uri('bersihinaja://services/catalog')]
#[MimeType('application/json')]
class ServiceCatalogResource extends Resource
{
    /**
     * Handle the resource request.
     */
    public function handle(Request $request): Response
    {
        $catalog = Service::with('packages')->get()->map(fn ($s) => [
            'id' => $s->id,
            'name' => $s->name,
            'slug' => $s->slug,
            'price' => $s->price,
            'room_size' => $s->room_size,
            'packages' => $s->packages->map(fn ($p) => [
                'name' => $p->name,
                'price' => $p->price,
            ])->toArray(),
        ])->toArray();

        return Response::json($catalog);
    }
}
