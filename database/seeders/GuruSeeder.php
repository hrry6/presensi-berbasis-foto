<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Faker dengan region Indonesia
        $faker = Faker::create('id_ID');

        $datas = [2, 4, 5];

        foreach ($datas as $data) {
            for ($i = 1; $i <= 5; $i++) {
                DB::table('guru')->insert([
                    'id_akun' => $data,
                    'nama_guru' => $faker->name(). Arr::random(['S.Pd', 'S.Kom']),
                    'foto_guru' => $faker->image(),
                ]);
            }
        }
    }
}
