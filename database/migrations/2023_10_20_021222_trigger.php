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
        DB::unprepared('
        CREATE TRIGGER add_siswa
        BEFORE INSERT ON siswa
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("siswa", NEW.pembuat, CURDATE(), CURTIME(), "Tambah", "Sukses");
        END
        ');

        DB::unprepared('
        CREATE TRIGGER update_siswa
        AFTER UPDATE ON siswa
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("siswa", NEW.pembuat, CURDATE(), CURTIME(), "Update", "Sukses");
        END
        ');

        DB::unprepared('
        CREATE TRIGGER delete_siswa
        AFTER DELETE ON siswa
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("siswa", OLD.pembuat, CURDATE(), CURTIME(), "Hapus", "Sukses");
        END
        ');

        DB::unprepared('
        CREATE TRIGGER add_pengurus
        BEFORE INSERT ON pengurus_kelas
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("pengurus_kelas", NEW.pembuat, CURDATE(), CURTIME(), "Tambah", "Sukses");
        END
        ');
    
        DB::unprepared('
        CREATE TRIGGER update_pengurus
        AFTER UPDATE ON pengurus_kelas
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("pengurus_kelas", NEW.pembuat, CURDATE(), CURTIME(), "Update", "Sukses");
        END
        ');
    
        DB::unprepared('
        CREATE TRIGGER delete_pengurus
        AFTER DELETE ON pengurus_kelas
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("pengurus_kelas", OLD.pembuat, CURDATE(), CURTIME(), "Hapus", "Sukses");
        END
        ');

        DB::unprepared('
        CREATE TRIGGER add_guru
        BEFORE INSERT ON guru
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("guru", NEW.pembuat, CURDATE(), CURTIME(), "Tambah", "Sukses");
        END
        ');
    
        DB::unprepared('
        CREATE TRIGGER update_guru
        AFTER UPDATE ON guru
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("pengurus", NEW.pembuat, CURDATE(), CURTIME(), "Update", "Sukses");
        END
        ');
    
        DB::unprepared('
        CREATE TRIGGER delete_guru
        AFTER DELETE ON guru
        FOR EACH ROW
        BEGIN
            INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
            VALUES ("guru", OLD.pembuat, CURDATE(), CURTIME(), "Hapus", "Sukses");
        END
        ');
    }





    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER add_siswa');
        DB::unprepared('DROP TRIGGER update_siswa');
        DB::unprepared('DROP TRIGGER delete_siswa');
        DB::unprepared('DROP TRIGGER add_pengurus');
        DB::unprepared('DROP TRIGGER update_pengurus');
        DB::unprepared('DROP TRIGGER delete_pengurus');
        DB::unprepared('DROP TRIGGER add_guru');
        DB::unprepared('DROP TRIGGER update_guru');
        DB::unprepared('DROP TRIGGER delete_guru');
    }
};
