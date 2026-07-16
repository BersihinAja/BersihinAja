<?php

namespace App\Mcp\Servers;

use App\Mcp\Servers\Resources\PricingGuideResource;
use App\Mcp\Servers\Resources\ServiceCatalogResource;
use App\Mcp\Servers\Tools\CreateOrderTool;
use App\Mcp\Servers\Tools\GetOrderHistoryTool;
use App\Mcp\Servers\Tools\GetOrderStatusTool;
use App\Mcp\Servers\Tools\ListAvailableWorkersTool;
use App\Mcp\Servers\Tools\ListServicesTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('bersihinaja')]
#[Version('1.0')]
#[Instructions('BersihinAja MCP Server — interact with the BersihinAja cleaning service platform. Browse services, check order status, create orders, find available workers, and view order history.')]
class BersihinAjaServer extends Server
{
    protected array $tools = [
        ListServicesTool::class,
        GetOrderStatusTool::class,
        CreateOrderTool::class,
        ListAvailableWorkersTool::class,
        GetOrderHistoryTool::class,
    ];

    protected array $resources = [
        ServiceCatalogResource::class,
        PricingGuideResource::class,
    ];

    protected array $prompts = [
        //
    ];
}
