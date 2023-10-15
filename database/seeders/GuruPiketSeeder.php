<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruPiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $datas = [6, 7, 8, 9, 10];

        foreach ($datas as $data) {
            for ($i = 1; $i <= 1; $i++) {
                DB::table('guru_piket')->insert([
                    'id_guru' => $data,
                ]);
            }
        }
    }
}
