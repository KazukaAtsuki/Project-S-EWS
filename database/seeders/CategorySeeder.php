<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Mechanical',
                'description' => 'Kategori untuk masalah mekanis mesin atau alat.',
            ],
            [
                'name' => 'Electrical',
                'description' => 'Kategori berhubungan dengan kelistrikan dan daya.',
            ],
            [
                'name' => 'Environmental',
                'description' => 'Isu terkait dampak lingkungan atau emisi.',
            ],
            [
                'name' => 'Operational',
                'description' => 'Kesalahan prosedur atau operasional manusia.',
            ],
        ];

        foreach ($data as $item) {
            Category::create($item);
        }
    }
}