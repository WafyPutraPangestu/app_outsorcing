<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_user')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('aksi', 100)->comment('create, update, delete, verify, send_token, dst');
            $table->string('tabel_target', 100)->nullable();
            $table->unsignedBigInteger('id_target')->nullable();
            $table->json('data_lama')->nullable()->comment('Snapshot sebelum perubahan');
            $table->json('data_baru')->nullable()->comment('Snapshot setelah perubahan');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['tabel_target', 'id_target']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
