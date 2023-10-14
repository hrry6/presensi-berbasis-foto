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
        Schema::create('validasi', function (Blueprint $table) {
            $table->integer('id_validasi', true);
            $table->integer('id_pengurus');
            $table->integer('id_presensi');
            $table->text('keterangan');
            $table->enum('waktu_pelajaran', ['Istirahat pertama', 'Istirahat kedua', 'Istirahat ketiga']);

            // Foreign Key

            $table->foreign('id_pengurus')->on('pengurus_kelas')
                ->references('id_pengurus')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_presensi')->on('presensi_siswa')
                ->references('id_presensi')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasi');
    }
};
