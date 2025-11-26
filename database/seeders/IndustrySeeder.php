<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            [
                'code' => 'lab',
                'name' => 'Lab & Services',
                'description' => 'Laboratory and professional services',
            ],
            [
                'code' => 'mining',
                'name' => 'Pertambangan',
                'description' => 'Mining and extraction industry',
            ],
            [
                'code' => 'EBjSTphYy',
                'name' => 'Minyak & Gas',
                'description' => 'Oil and Gas industry',
            ],
        ];

        foreach ($industries as $industry) {
            Industry::create($industry);
        }
    }
}