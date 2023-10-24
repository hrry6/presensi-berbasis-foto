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
        DB::unprepared('DROP Procedure IF EXISTS CreateGuruBK');
        DB::unprepared('DROP Procedure IF EXISTS CreateGuruPiket');
        DB::unprepared('DROP Procedure IF EXISTS CreateWaliKelas');
        DB::unprepared('DROP Procedure IF EXISTS CreateAkunSiswa');

        DB::unprepared("
        CREATE PROCEDURE CreateGuruBK(
            IN new_id_akun INT,
            IN new_nama_guru VARCHAR(255),
            IN new_foto_guru VARCHAR(255),
            IN new_pembuat VARCHAR(255)
        )
        BEGIN
            DECLARE new_id_guru INT;
            DECLARE pesan_error CHAR(5) DEFAULT '000';
        
            DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
            BEGIN
                SET pesan_error = '001';
            END;
        
            START TRANSACTION; -- Memulai transaction
        
            INSERT INTO guru (id_akun, nama_guru, foto_guru, pembuat)
            VALUES (new_id_akun, new_nama_guru, new_foto_guru, new_pembuat);
        
            SET new_id_guru = LAST_INSERT_ID();
        
            INSERT INTO guru_bk (id_guru) VALUES (new_id_guru);
        
            IF pesan_error = '000' THEN
                COMMIT; -- Commit jika tidak ada error
            ELSE
                ROLLBACK; -- Rollback jika terdapat error
            END IF;
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
            DECLARE pesan_error CHAR(5) DEFAULT '000';
        
            DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
            BEGIN
                SET pesan_error = '001';
            END;
        
            START TRANSACTION; -- Memulai transaction
        
            INSERT INTO guru (id_akun, nama_guru, foto_guru, pembuat)
            VALUES (new_id_akun, new_nama_guru, new_foto_guru, new_pembuat);
        
            SET new_id_guru = LAST_INSERT_ID();  

            INSERT INTO guru_piket (id_guru) VALUES (new_id_guru);

            IF pesan_error = '000' THEN
                COMMIT; -- Commit jika tidak ada error
            ELSE
                ROLLBACK; -- Rollback jika terdapat error
            END IF;
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
            DECLARE pesan_error CHAR(5) DEFAULT '000';
        
            DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
            BEGIN
                SET pesan_error = '001';
            END;
        
            START TRANSACTION; -- Memulai transaction
            
            INSERT INTO guru (id_akun, nama_guru, foto_guru, pembuat)
            VALUES (new_id_akun, new_nama_guru, new_foto_guru, new_pembuat);
        
            SET new_id_wali_kelas = LAST_INSERT_ID();  

            UPDATE kelas SET id_wali_kelas = new_id_wali_kelas WHERE id_kelas = new_id_kelas;

            IF pesan_error = '000' THEN
                COMMIT; -- Commit jika tidak ada error
            ELSE
                ROLLBACK; -- Rollback jika terdapat error
            END IF;
        END
        ");

        DB::unprepared("
        CREATE PROCEDURE CreateAkunSiswa(
            IN p_id_siswa INT,
            IN p_username VARCHAR(60),
            IN p_password VARCHAR(225)
        )
        BEGIN
            DECLARE p_id_akun INT;

            DECLARE pesan_error CHAR(5) DEFAULT '000';
        
            DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
            BEGIN
                SET pesan_error = '001';
            END;
        
            START TRANSACTION; -- Memulai transaction
            
            INSERT INTO akun (id_role, username, password)
            VALUES (1, p_username, p_password);
            
            SET p_id_akun = LAST_INSERT_ID();  
            
            UPDATE siswa
            SET id_akun = p_id_akun
            WHERE id_siswa = p_id_siswa;

            IF pesan_error = '000' THEN
                COMMIT; -- Commit jika tidak ada error
            ELSE
                ROLLBACK; -- Rollback jika terdapat error
            END IF;
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
        DB::unprepared('DROP Procedure IF EXISTS CreateAkunSiswa');
    }
};