<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Services\RegionService;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('packages')->get();
        return view('services.index', compact('services'));
    }

    public function show(Service $service, RegionService $regionService)
    {
        $service->load('packages');
        $provinces = $regionService->getProvinces();
        return view('services.show', compact('service', 'provinces'));
    }
}
