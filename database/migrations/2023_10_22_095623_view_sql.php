<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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

        DB::unprepared("DROP VIEW IF EXISTS view_siswa;");

        DB::unprepared("
            CREATE VIEW view_siswa AS
            SELECT
                s.id_siswa AS id_siswa,
                s.nis AS nis,
                s.nama_siswa AS nama_siswa,
                s.id_kelas AS id_kelas,
                s.jenis_kelamin AS jenis_kelamin,
                s.nomer_hp AS nomer_hp,
                s.foto_siswa AS foto_siswa,
                k.tingkatan AS tingkatan,
                k.nama_kelas AS nama_kelas, 
                j.nama_jurusan AS nama_jurusan
            FROM siswa s
            JOIN kelas k ON s.id_kelas = k.id_kelas
            JOIN jurusan j ON k.id_jurusan = j.id_jurusan
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS view_presensi;");
        DB::unprepared("DROP VIEW IF EXISTS view_siswa;");
    }
};
