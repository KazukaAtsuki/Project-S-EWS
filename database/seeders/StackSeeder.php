<?php

namespace Database\Seeders;

use App\Models\Stack;
use App\Models\Company;
use Illuminate\Database\Seeder;

class StackSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada company dulu
        $company = Company::first();

        if ($company) {
            Stack::create([
                'company_id' => $company->id,
                'stack_name' => 'Cerobong Utama 01',
                'government_code' => 'K-01-A',
                'longitude' => '106.8456',
                'latitude' => '-6.2088',
                'oxygen_reference' => '7',
            ]);

            Stack::create([
                'company_id' => $company->id,
                'stack_name' => 'Cerobong Boiler B',
                'government_code' => 'K-02-B',
                'longitude' => '107.1234',
                'latitude' => '-6.3456',
                'oxygen_reference' => '5.5',
            ]);
        }
    }
}