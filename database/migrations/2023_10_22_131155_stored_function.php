<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS CountTeachers');
        DB::unprepared('DROP FUNCTION IF EXISTS CountBkTeachers');
        DB::unprepared('DROP FUNCTION IF EXISTS CountPiketTeachers');
        DB::unprepared('DROP FUNCTION IF EXISTS CountClasses');
        DB::unprepared('DROP FUNCTION IF EXISTS CountClassMembers');
        DB::unprepared('DROP FUNCTION IF EXISTS CountWaliKelas');
        DB::unprepared('DROP FUNCTION IF EXISTS CountStudents');
        DB::unprepared('DROP FUNCTION IF EXISTS CountTotalStudents');
        DB::unprepared('DROP FUNCTION IF EXISTS CountStatus');
        
        DB::unprepared('
            CREATE FUNCTION CountTeachers() RETURNS INT
            BEGIN
                DECLARE teacherCount INT;
                SELECT COUNT(*) INTO teacherCount FROM guru;
                RETURN teacherCount;
            END
        ');

        DB::unprepared('
            CREATE FUNCTION CountBkTeachers() RETURNS INT
            BEGIN
                DECLARE bkTeacherCount INT;
                SELECT COUNT(*) INTO bkTeacherCount FROM guru_bk;
                RETURN bkTeacherCount;
            END
        ');

        DB::unprepared('
            CREATE FUNCTION CountPiketTeachers() RETURNS INT
            BEGIN
                DECLARE piketTeacherCount INT;
                SELECT COUNT(*) INTO piketTeacherCount FROM guru_piket;
                RETURN piketTeacherCount;
            END
        ');

        DB::unprepared('
            CREATE FUNCTION CountClasses() RETURNS INT
            BEGIN
                DECLARE classCount INT;
                SELECT COUNT(*) INTO classCount FROM kelas;
                RETURN classCount;
            END
        ');

        DB::unprepared('
            CREATE FUNCTION CountClassMembers() RETURNS INT
            BEGIN
                DECLARE classMemberCount INT;
                SELECT COUNT(*) INTO classMemberCount FROM pengurus_kelas;
                RETURN classMemberCount;
            END
        ');


        DB::unprepared('
            CREATE FUNCTION CountWaliKelas() RETURNS INT
            BEGIN
                DECLARE waliKelasCount INT;
                SELECT COUNT(*) INTO waliKelasCount FROM kelas WHERE id_wali_kelas IS NOT NULL;
                RETURN waliKelasCount;
            END
        ');

        DB::unprepared('
            CREATE FUNCTION CountTotalStudents() RETURNS INT
            BEGIN
                DECLARE total INT;
                SELECT COUNT(*) INTO total FROM siswa;
                RETURN total;
            END
        ');

        DB::unprepared('
            CREATE FUNCTION CountStatus(status VARCHAR(10)) RETURNS INT
            BEGIN
                DECLARE count INT;
                SELECT COUNT(*) INTO count FROM presensi_siswa WHERE status_kehadiran = status;
                RETURN count;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS CountTeachers');
        DB::unprepared('DROP FUNCTION IF EXISTS CountBkTeachers');
        DB::unprepared('DROP FUNCTION IF EXISTS CountPiketTeachers');
        DB::unprepared('DROP FUNCTION IF EXISTS CountClasses');
        DB::unprepared('DROP FUNCTION IF EXISTS CountClassMembers');
        DB::unprepared('DROP FUNCTION IF EXISTS CountWaliKelas');
        DB::unprepared('DROP FUNCTION IF EXISTS CountStudents');
        DB::unprepared('DROP FUNCTION IF EXISTS CountTotalStudents');
        DB::unprepared('DROP FUNCTION IF EXISTS CountStatus');
    }
};