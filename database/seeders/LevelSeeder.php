<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['code' => 'admin', 'level' => 'Administrator'],
            ['code' => 'noc', 'level' => 'NOC'],
            ['code' => 'operator', 'level' => 'CEMS Operator'],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}