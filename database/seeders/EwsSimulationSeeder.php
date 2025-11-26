<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Stack;
use App\Models\Parameter;
use App\Models\Industry; // Pastikan model Industry ada/diimport jika Company butuh relasi

class EwsSimulationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan ada Industry (untuk Company)
        // Jika kamu tidak pakai tabel industry, hapus bagian ini dan sesuaikan Company
        $industry = Industry::firstOrCreate(
            ['code' => 'IND-01'],
            ['name' => 'General Industry']
        );

        // 2. Buat Company
        $company = Company::firstOrCreate(
            ['company_code' => 'TEST-PT'],
            [
                'name' => 'PT Simulasi EWS',
                'industry_id' => $industry->id,
                'contact_person' => 'Admin Test',
            ]
        );

        // 3. Buat Stack (Cerobong) -> Kode: ST-01
        Stack::firstOrCreate(
            ['government_code' => 'ST-01'],
            [
                'company_id' => $company->id,
                'stack_name' => 'Cerobong Utama Simulasi',
                'longitude' => '106.8',
                'latitude' => '-6.2',
            ]
        );

        // 4. Buat Parameter -> Kode: CO, Batas: 100
        // Pastikan kolom 'max_threshold' sudah ada di tabel parameters (dari migration sebelumnya)
        Parameter::firstOrCreate(
            ['name' => 'CO'], // Asumsi kita pakai 'name' sebagai kode
            [
                'description' => 'Karbon Monoksida',
                'max_threshold' => 100, // Batas Aman
                'unit' => 'mg/m3'
            ]
        );
    }
}