<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'name' => 'Small',
            'slug' => 'small',
            'price' => 50000,
            'image' => null,
            'room_size' => '5 x 5',
            'max_hours' => 2,
            'estimation' => '~2 jam',
            'cleaners_required' => 1,
            'description' => 'Layanan pembersihan untuk ruangan kecil.',
        ]);

        Service::create([
            'name' => 'Medium',
            'slug' => 'medium',
            'price' => 75000,
            'image' => null,
            'room_size' => '7 x 7',
            'max_hours' => 3,
            'estimation' => '~3 jam',
            'cleaners_required' => 2,
            'description' => 'Layanan pembersihan untuk ruangan sedang.',
        ]);

        Service::create([
            'name' => 'Large',
            'slug' => 'large',
            'price' => 100000,
            'image' => null,
            'room_size' => '10 x 10',
            'max_hours' => 4,
            'estimation' => '~4 jam',
            'cleaners_required' => 3,
            'description' => 'Layanan pembersihan untuk ruangan besar.',
        ]);
    }
}
