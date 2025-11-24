<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_logs', function (Blueprint $table) {
            $table->id();
            // Relasi ke Stack (Cerobong)
            $table->foreignId('stack_id')->constrained('stacks')->onDelete('cascade');

            // Relasi ke Parameter (Zat Kimia: CO, NO2, dll)
            $table->foreignId('parameter_id')->constrained('parameters')->onDelete('cascade');

            // Nilai hasil pembacaan
            $table->double('value');

            // Waktu pencatatan (created_at otomatis jadi Time Group)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_logs');
    }
};