<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $datas = [
            'Rekayasa Perangkat Lunak', 'Teknik Komputer dan Jaringan',
            'Teknik Pengelasan', 'Teknik Permesinan', 'Teknik Kendaraan Ringan dan Otomotif',
            'Multimedia', 'Akuntansi', 'Tata Busana'
        ];

        foreach ($datas as $data) {
            // for ($i = 1; $i <= 6; $i++) {
                DB::table('jurusan')->insert([
                    'nama_jurusan' => $data,
                    'pembuat' => 'Tata Usaha',
                ]);
            // }
        }
    }
}
