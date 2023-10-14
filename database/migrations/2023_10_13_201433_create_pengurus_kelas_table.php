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
        Schema::create('pengurus_kelas', function (Blueprint $table) {
            $table->integer('id_pengurus', true);
            $table->integer('id_siswa');
            $table->string('jabatan', 20);

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
        Schema::dropIfExists('pengurus_kelas');
    }
};
