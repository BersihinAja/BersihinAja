<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $packages = Package::all();
        return view('home', compact('services', 'packages'));
    }
}
