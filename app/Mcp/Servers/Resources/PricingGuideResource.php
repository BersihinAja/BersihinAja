<?php

namespace App\Mcp\Servers\Resources;

use App\Models\Package;
use App\Models\Service;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\MimeType;
use Laravel\Mcp\Server\Attributes\Uri;
use Laravel\Mcp\Server\Resource;

#[Description('Pricing guide with base service prices, add-on packages, and calculation notes.')]
#[Uri('bersihinaja://pricing/guide')]
#[MimeType('application/json')]
class PricingGuideResource extends Resource
{
    /**
     * Handle the resource request.
     */
    public function handle(Request $request): Response
    {
        $services = Service::all();
        $packages = Package::all();

        return Response::json([
            'services' => $services->map(fn ($s) => [
                'name' => $s->name,
                'base_price' => $s->price,
            ])->toArray(),
            'addon_packages' => $packages->map(fn ($p) => [
                'name' => $p->name,
                'price' => $p->price,
            ])->toArray(),
            'notes' => 'Total = service base price + sum of selected add-on packages',
        ]);
    }
}
