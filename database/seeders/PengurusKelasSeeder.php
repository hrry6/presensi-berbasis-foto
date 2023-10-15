<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengurusKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $datas = [1, 2, 3, 4, 5];

        foreach ($datas as $data) {
            for ($i = 1; $i <= 1; $i++) {
                DB::table('pengurus_kelas')->insert([
                    'id_siswa' => $data,
                    'jabatan' => 'Sekretaris'
                ]);
            }
        }
    }
}
