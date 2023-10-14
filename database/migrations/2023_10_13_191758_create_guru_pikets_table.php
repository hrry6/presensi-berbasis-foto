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
        Schema::create('guru_piket', function (Blueprint $table) {
            $table->integer('id_piket', true);
            $table->integer('id_guru');

            // Foreign Key

            $table->foreign('id_guru')->on('guru')
                ->references('id_guru')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_piket');
    }
};
