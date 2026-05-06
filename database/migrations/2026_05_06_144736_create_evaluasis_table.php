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
        Schema::create('evaluasi', function (Blueprint $table) {
            $table->id('id_evaluasi');
            $table->foreignId('id_penempatan')->constrained('penempatans', 'id_penempatan')->cascadeOnDelete();
            $table->string('periode', 20)->comment('Format: YYYY-MM, contoh: 2026-05');
            $table->decimal('total_nilai_akhir', 5, 2)->nullable()->comment('Hasil rata-rata/akumulasi bobot');
            $table->text('komentar_klien')->nullable();
            $table->date('tanggal_diisi_klien')->nullable();
            $table->enum('status_evaluasi', ['menunggu_klien', 'menunggu_verifikasi', 'verified', 'rejected'])->default('menunggu_klien');
            $table->foreignId('id_user_verifikator')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan_verifikator')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            // Pastikan 1 penempatan hanya ada 1 evaluasi di bulan/periode yang sama
            $table->unique(['id_penempatan', 'periode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi');
    }
};
