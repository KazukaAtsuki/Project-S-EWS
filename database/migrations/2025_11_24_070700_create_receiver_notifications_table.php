<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receiver_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode Unik (Auto-generate)

            // Relasi ke Company
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

            // Relasi ke Media (Web, Telegram, Email, WA)
            $table->foreignId('notification_media_id')->constrained('notification_medias')->onDelete('cascade');

            $table->string('contact_value'); // Isinya bisa Email, No HP, atau Chat ID Telegram
            $table->boolean('is_active')->default(true); // Status: Active / Disabled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receiver_notifications');
    }
};