<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
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
        DB::unprepared('DROP FUNCTION IF EXISTS CountTotalStudents');
        DB::unprepared('DROP FUNCTION IF EXISTS CountStatus');
    }
};
