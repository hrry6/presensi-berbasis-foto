<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
    
        $datas = [1, 2, 3, 4, 5, 6];
    
        foreach ($datas as $data) {
            for ($i = 1; $i <= 6; $i++) {
                DB::table('akun')->insert([
                    'id_role' => $data,
                    'username' => $faker->randomNumber(6, true),
                    'password' => random_int(100000, 999999),
                ]);
            }
        }
    }
}
