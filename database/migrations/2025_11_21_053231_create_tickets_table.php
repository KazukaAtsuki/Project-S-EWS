<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            // Relasi ke User (Issuer)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke Stack
            $table->foreignId('stack_id')->constrained('stacks')->onDelete('cascade');

            // Relasi ke Priority
            $table->foreignId('priority_id')->constrained('priorities')->onDelete('cascade');

            // Relasi ke Category (Problem Category)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            $table->string('subject');
            $table->text('description');
            $table->string('attachment')->nullable(); // Path file
            $table->string('status')->default('Open'); // Open, In Progress, Closed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};