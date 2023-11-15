<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Arr;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [1, 2, 3, 4, 5];
        

        foreach ($datas as $data) {
            for ($i = 1; $i <= 8; $i++) {
                DB::table('kelas')->insert([
                    'id_jurusan' => $data,
                    'id_wali_kelas' => $data,
                    'nama_kelas' => 'Kelas ' . Arr::random(['A', 'B', 'C']),
                    'tingkatan' => Arr::random(['X', 'XI', 'XII']),
                    'status_kelas' => Arr::random(['aktif', 'tidak_aktif']),
                    'pembuat' => 'Tata Usaha',
                ]);
            }
        }
    }
}
