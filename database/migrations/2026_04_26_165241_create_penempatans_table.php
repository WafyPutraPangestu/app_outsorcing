<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penempatans', function (Blueprint $table) {
            $table->id('id_penempatan');
            $table->foreignId('id_karyawan')->constrained('karyawan', 'id_karyawan')->cascadeOnDelete();
            $table->foreignId('id_klien')->constrained('klien', 'id_klien')->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->enum('rekomendasi_sistem', ['belum_dievaluasi', 'lanjut_kontrak', 'putus_kontrak'])->default('belum_dievaluasi');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('penempatans');
    }
};
