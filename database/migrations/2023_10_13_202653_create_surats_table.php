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
        Schema::create('surat_keterangan', function (Blueprint $table) {
            $table->integer('id_presensi');
            $table->text('surat_keterangan');

            // Foreign Key

            $table->foreign('id_presensi')->on('presensi_siswa')
                ->references('id_presensi')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan');
    }
};
