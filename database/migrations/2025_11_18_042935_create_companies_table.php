<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Gunakan Schema::create karena kita membangun ulang tabelnya
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->unique(); // Kode perusahaan (misal: TEST-PT)
            $table->string('name'); // Nama Perusahaan

            // --- INI BAGIAN UTAMA YANG DIUBAH ---
            // Kita pakai foreignId untuk relasi ke tabel 'industries'
            // Pastikan tabel 'industries' dibuat SEBELUM tabel 'companies' (tanggal filenya lebih lama)
            $table->foreignId('industry_id')
                  ->constrained('industries')
                  ->onDelete('cascade');
            // ------------------------------------

            $table->string('contact_person');
            $table->string('contact_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['industry_id']);
            $table->dropColumn('industry_id');
        });
    }
};