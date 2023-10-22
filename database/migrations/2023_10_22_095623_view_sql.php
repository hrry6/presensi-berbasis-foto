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
        DB::unprepared("DROP VIEW IF EXISTS view_presensi;");

        DB::unprepared("
        CREATE VIEW view_presensi AS
        SELECT
            p.foto_bukti AS foto_bukti,
            p.tanggal AS tanggal,
            p.status_kehadiran AS status_kehadiran,
            s.nama_siswa AS nama_siswa,	
            k.nama_kelas AS nama_kelas,
            k.tingkatan AS tingkatan,
            j.nama_jurusan AS jurusan
        FROM presensi_siswa p
        LEFT JOIN siswa s ON p.id_siswa = s.id_siswa
        LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
        LEFT JOIN jurusan j ON k.id_jurusan = j.id_jurusan
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS view_presensi;");
    }
};
