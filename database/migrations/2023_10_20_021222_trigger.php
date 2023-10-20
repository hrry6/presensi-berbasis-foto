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
        DB::unprepared('
        CREATE TRIGGER add_siswa
        AFTER INSERT ON siswa
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

        // DB::unprepared('
        // CREATE TRIGGER delete_siswa
        // AFTER DELETE ON siswa
        // FOR EACH ROW
        // BEGIN
        //     INSERT logs(tabel, aktor, tanggal, jam, aksi, record)
        //     VALUES ("siswa", NEW.pembuat, CURDATE(), CURTIME(), "Hapus", "Sukses");
        // END
        // ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER add_siswa');
        DB::unprepared('DROP TRIGGER update_siswa');
        // DB::unprepared('DROP TRIGGER delete_siswa');
    }
};
