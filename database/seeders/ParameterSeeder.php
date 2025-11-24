<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'CO',
                'unit' => 'mg/m3',
                'max_threshold' => 100, // Jika sensor kirim > 100, Telegram Bunyi
                'description' => 'Karbon Monoksida',
            ],
            [
                'name' => 'NO2',
                'unit' => 'mg/m3',
                'max_threshold' => 80,
                'description' => 'Nitrogen Dioksida',
            ],
            [
                'name' => 'SO2',
                'unit' => 'mg/m3',
                'max_threshold' => 60,
                'description' => 'Sulfur Dioksida',
            ],
            [
                'name' => 'O3',
                'unit' => 'ppm',
                'max_threshold' => 50,
                'description' => 'Ozon Permukaan',
            ],
        ];

        foreach ($data as $item) {
            Parameter::firstOrCreate(['name' => $item['name']], $item);
        }
    }
}