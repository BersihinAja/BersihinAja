<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::create(['name' => 'Cuci Sofa', 'price' => 50000, 'description' => 'Pembersihan sofa menyeluruh.']);
        Package::create(['name' => 'Cuci Karpet', 'price' => 75000, 'description' => 'Pembersihan karpet dan permadani.']);
        Package::create(['name' => 'Pembersihan Halaman', 'price' => 100000, 'description' => 'Pembersihan area halaman dan taman.']);
        Package::create(['name' => 'Eco-Friendly', 'price' => 120000, 'description' => 'Pembersihan dengan bahan ramah lingkungan.']);
    }
}
