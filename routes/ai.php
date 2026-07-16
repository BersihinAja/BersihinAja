<?php

use App\Mcp\Servers\BersihinAjaServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/bersihinaja', BersihinAjaServer::class)
    ->middleware(['throttle:mcp']);

Mcp::local('bersihinaja', BersihinAjaServer::class);
