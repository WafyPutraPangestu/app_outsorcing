<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasi_tokens', function (Blueprint $table) {
            $table->id('id_token');
            $table->foreignId('id_evaluasi')->constrained('evaluasi', 'id_evaluasi')->cascadeOnDelete();
            $table->uuid('token')->unique();
            $table->string('email_tujuan', 150);
            $table->enum('status', ['unused', 'used', 'expired'])->default('unused');
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi_tokens');
    }
};
