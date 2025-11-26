<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Industry;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada industry dulu
        $labServices = Industry::where('code', 'lab')->first();
        $pertambangan = Industry::where('code', 'mining')->first();
        $minyakGas = Industry::where('code', 'EBjSTphYy')->first();

        $companies = [
            [
                'company_code' => 'trusur',
                'name' => 'PT Trusur Unggul Teknusa',
                'industry_id' => $labServices?->id,
                'contact_person' => 'Jhon Doe',
                'contact_phone' => '+6281234567890',
            ],
            [
                'company_code' => 'smelting',
                'name' => 'PT.Smelting',
                'industry_id' => $labServices?->id,
                'contact_person' => 'Imam M',
                'contact_phone' => '+6281234567891',
            ],
            [
                'company_code' => 'sA34AA56SW',
                'name' => 'PT. Freeport Indonesia',
                'industry_id' => $pertambangan?->id,
                'contact_person' => 'Adrian',
                'contact_phone' => '+6281234567892',
            ],
            [
                'company_code' => '7vw8bozS91',
                'name' => 'PT Bhumi Jepara Service',
                'industry_id' => $pertambangan?->id,
                'contact_person' => 'Fakhrian Aji Rahmanyo',
                'contact_phone' => '+62 821-3606-2411',
            ],
            [
                'company_code' => 'FUzKr86uOX',
                'name' => 'PT. Badak NGL',
                'industry_id' => $minyakGas?->id,
                'contact_person' => 'Irwan Antonio',
                'contact_phone' => '+6281234567894',
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}