<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('event_name')->unique(); // Contoh: 'new_ticket_created'
            $table->string('description')->nullable(); // Penjelasan setting
            $table->boolean('email_enabled')->default(false);
            $table->boolean('telegram_enabled')->default(false);
            $table->boolean('whatsapp_enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};