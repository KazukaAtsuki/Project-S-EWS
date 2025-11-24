<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Contoh: CO, NO2, SO2
            $table->string('unit')->nullable(); // Contoh: mg/m3, ppm
            $table->double('max_threshold')->default(0); // Batas Aman (PENTING BUAT EWS)
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};