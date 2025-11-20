<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Hapus kolom industry string lama
            if (Schema::hasColumn('companies', 'industry')) {
                $table->dropColumn('industry');
            }

            // Tambah foreign key ke industries
            $table->foreignId('industry_id')
                ->nullable()
                ->constrained('industries')
                ->onDelete('set null');
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