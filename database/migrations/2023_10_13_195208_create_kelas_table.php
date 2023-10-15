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
        Schema::create('kelas', function (Blueprint $table) {
            $table->integer('id_kelas', true);
            $table->integer('id_wali_kelas');
            $table->integer('id_jurusan');
            $table->string('nama_kelas', 60);
            $table->char('tingkatan', 3);
            $table->enum('status_kelas', ['aktif', 'tidak aktif']);

            // Foreign Key
            $table->foreign('id_wali_kelas')->on('guru')
                ->references('id_guru')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_jurusan')->on('jurusan')
                ->references('id_jurusan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
