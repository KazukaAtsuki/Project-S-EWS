<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_medias', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // web, telegram, email
            $table->string('name'); // Web Notification, Telegram, Email
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_medias');
    }
};