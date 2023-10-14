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
        Schema::create('presensi_siswa', function (Blueprint $table) {
            $table->integer('id_presensi', true);
            $table->integer('id_siswa');
            $table->text('foto_bukti');
            $table->time('jam_masuk');
            $table->date('tanggal');
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Alpha']);

            // Foreign Key

            $table->foreign('id_siswa')->on('siswa')
                ->references('id_siswa')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_siswa');
    }
};
