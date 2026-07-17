<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Livewire\ServiceDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_detail_renders_correctly()
    {
        // Mock Region API calls
        Http::fake([
            'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json' => Http::response([
                ['id' => '11', 'name' => 'ACEH'],
            ]),
            'https://www.emsifa.com/api-wilayah-indonesia/api/regencies/11.json' => Http::response([
                ['id' => '1101', 'province_id' => '11', 'name' => 'KABUPATEN ACEH SELATAN'],
            ]),
        ]);

        $service = Service::create([
            'name' => 'Medium Cleaning',
            'slug' => 'medium-cleaning',
            'price' => 75000,
            'room_size' => '7x7',
            'max_hours' => 3,
            'estimation' => '3 Jam',
            'cleaners_required' => 2,
        ]);

        Livewire::test(ServiceDetail::class, ['service' => $service])
            ->assertStatus(200)
            ->assertSet('provinces', [['id' => '11', 'name' => 'ACEH']])
            ->set('selectedProvince', '11')
            ->assertSet('regencies', [['id' => '1101', 'province_id' => '11', 'name' => 'KABUPATEN ACEH SELATAN']]);
    }
}
