<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RegionService
{
    private string $baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    public function getProvinces(): Collection
    {
        $data = Cache::remember('provinces', now()->addHours(24), function () {
            $response = Http::get("{$this->baseUrl}/provinces.json");
            return $response->json(); // store plain array, not Collection
        });

        return collect($data);
    }

    public function getRegencies(string $provinceId): Collection
    {
        $data = Cache::remember("regencies_{$provinceId}", now()->addHours(24), function () use ($provinceId) {
            $response = Http::get("{$this->baseUrl}/regencies/{$provinceId}.json");
            return $response->json(); // store plain array, not Collection
        });

        return collect($data);
    }
}

