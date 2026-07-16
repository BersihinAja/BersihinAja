<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RegionService;

class RegionController extends Controller
{
    public function provinces(RegionService $regionService)
    {
        return response()->json($regionService->getProvinces());
    }

    public function regencies(string $provinceId, RegionService $regionService)
    {
        return response()->json($regionService->getRegencies($provinceId));
    }
}
