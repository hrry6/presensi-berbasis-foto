<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TataUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $datas = [6];

        foreach ($datas as $data) {
            for ($i = 1; $i <= 6; $i++) {
                DB::table('tata_usaha')->insert([
                    'id_akun' => $data,
                    'nama_kesiswaan' => $faker->name(),
                    'foto_kesiswaan' => $faker->image(),
                ]);
            }
        }
    }
}
