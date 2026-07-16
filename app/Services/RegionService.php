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
        return Cache::remember('provinces', now()->addHours(24), function () {
            $response = Http::get("{$this->baseUrl}/provinces.json");
            return collect($response->json());
        });
    }

    public function getRegencies(string $provinceId): Collection
    {
        return Cache::remember("regencies_{$provinceId}", now()->addHours(24), function () use ($provinceId) {
            $response = Http::get("{$this->baseUrl}/regencies/{$provinceId}.json");
            return collect($response->json());
        });
    }
}
