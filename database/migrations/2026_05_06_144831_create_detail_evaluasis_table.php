<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_evaluasi', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_evaluasi')->constrained('evaluasi', 'id_evaluasi')->cascadeOnDelete();
            $table->foreignId('id_kriteria')->constrained('kriteria_penilaians', 'id_kriteria')->restrictOnDelete();
            $table->decimal('skor_nilai', 5, 2)->default(0)->comment('Skala 0-100');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_evaluasis');
    }
};
