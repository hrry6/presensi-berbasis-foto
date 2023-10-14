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
        Schema::create('tata_usaha_kesiswaaan', function (Blueprint $table) {
            $table->integer('id_kesiswaan', true);
            $table->integer('id_akun');
            $table->string('nama_kesiswaan', 80);
            $table->text('foto_kesiswaan');

            // Foreign Key

            $table->foreign('id_akun')->on('akun')
                ->references('id_akun')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tata_usaha_kesiswaaan');
    }
};
