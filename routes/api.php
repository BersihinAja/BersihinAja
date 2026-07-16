<?php

use App\Http\Controllers\Api\RegionController;
use Illuminate\Support\Facades\Route;

Route::get('/regions/provinces', [RegionController::class, 'provinces']);
Route::get('/regions/regencies/{provinceId}', [RegionController::class, 'regencies']);
