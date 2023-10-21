<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
        CREATE PROCEDURE CreateGuruBK(
            IN new_id_akun INT,
            IN new_nama_guru VARCHAR(255),
            IN new_foto_guru VARCHAR(255),
            IN new_pembuat VARCHAR(255)
        )
        BEGIN
            DECLARE new_id_guru INT;
        
            INSERT INTO guru (id_akun, nama_guru, foto_guru, pembuat)
            VALUES (new_id_akun, new_nama_guru, new_foto_guru, new_pembuat);
        
            SET new_id_guru = LAST_INSERT_ID();  

            INSERT INTO guru_bk (id_guru) VALUES (new_id_guru);
        END
        ");

        DB::unprepared("
        CREATE PROCEDURE CreateGuruPiket(
            IN new_id_akun INT,
            IN new_nama_guru VARCHAR(255),
            IN new_foto_guru VARCHAR(255),
            IN new_pembuat VARCHAR(255)
        )
        BEGIN
            DECLARE new_id_guru INT;
        
            INSERT INTO guru (id_akun, nama_guru, foto_guru, pembuat)
            VALUES (new_id_akun, new_nama_guru, new_foto_guru, new_pembuat);
        
            SET new_id_guru = LAST_INSERT_ID();  

            INSERT INTO guru_piket (id_guru) VALUES (new_id_guru);
        END
        ");

        DB::unprepared("
        CREATE PROCEDURE CreateWaliKelas(
            IN new_id_akun INT,
            IN new_nama_guru VARCHAR(255),
            IN new_foto_guru VARCHAR(255),
            IN new_pembuat VARCHAR(255),
            IN new_id_kelas INT
        )
        BEGIN
            DECLARE new_id_wali_kelas INT;
        
            INSERT INTO guru (id_akun, nama_guru, foto_guru, pembuat)
            VALUES (new_id_akun, new_nama_guru, new_foto_guru, new_pembuat);
        
            SET new_id_wali_kelas = LAST_INSERT_ID();  

            UPDATE kelas SET id_wali_kelas = new_id_wali_kelas WHERE id_kelas = new_id_kelas;
        END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP Procedure IF EXISTS CreateGuruBK');
        DB::unprepared('DROP Procedure IF EXISTS CreateGuruPiket');
        DB::unprepared('DROP Procedure IF EXISTS CreateWaliKelas');
    }
};
