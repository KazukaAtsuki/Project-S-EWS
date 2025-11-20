<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Critical',
                'description' => 'Masalah yang memerlukan penanganan segera (Sangat Mendesak).',
            ],
            [
                'name' => 'High',
                'description' => 'Masalah penting yang berdampak pada operasional.',
            ],
            [
                'name' => 'Medium',
                'description' => 'Masalah standar, tidak terlalu mendesak.',
            ],
            [
                'name' => 'Low',
                'description' => 'Masalah minor atau saran perbaikan.',
            ],
        ];

        foreach ($data as $item) {
            Priority::create($item);
        }
    }
}