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
        Schema::create('kontrak_karyawan', function (Blueprint $table) {
            $table->id('id_kontrak');
            $table->foreignId('id_karyawan')->constrained('karyawan', 'id_karyawan')->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('jenis_kontrak', ['kontrak_awal', 'perpanjangan']);
            $table->integer('nomor_urut_kontrak')->default(1);
            $table->foreignId('id_kontrak_sebelumnya')->nullable()->constrained('kontrak_karyawan', 'id_kontrak')->nullOnDelete();
            $table->text('catatan')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_karyawans');
    }
};
