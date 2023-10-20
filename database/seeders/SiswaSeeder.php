<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
    
        $datas = [1, 2, 3, 4, 5];
    
        foreach ($datas as $data) {
            for ($i = 1; $i <= 1; $i++) {
                DB::table('siswa')->insert([
                    'id_siswa' => $data,
                    'id_akun' => $data,
                    'id_kelas' => $data,
                    'nis' => $faker->numerify('2########'),
                    'nama_siswa' => $faker->name(),
                    'nomer_hp' => $faker->numerify('08##########'),
                    'jenis_kelamin' => Arr::random(['Laki-Laki', 'Perempuan']),
                    'foto_siswa' => $faker->image(),
                    'pembuat' =>  6
                ]);
            }
        }
    }
}
