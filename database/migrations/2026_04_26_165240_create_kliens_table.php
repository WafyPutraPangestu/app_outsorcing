<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klien', function (Blueprint $table) {
            $table->id('id_klien');
            $table->string('nama_perusahaan', 200);
            $table->text('alamat_kantor')->nullable();
            $table->string('email_hrd_klien', 150);
            $table->string('nama_kontak_person', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klien');
    }
};
