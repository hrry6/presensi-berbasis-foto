<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
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
            'Rekaya Perangkat Lunak', 'Teknik Komputer dan Jaringan',
            'Teknik Pengelasan', 'Teknik Permesinan', 'Teknik Kendaraan Ringan dan Otomotif',
            'Multimedia', 'Akutanasi', 'Tata Busana'
        ];

        foreach ($datas as $data) {
            for ($i = 1; $i <= 1; $i++) {
                DB::table('jurusan')->insert([
                    'nama_jurusan' => $data,
                ]);
            }
        }
    }
}
