<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuruBkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [11, 12, 13, 14, 15];

        foreach ($datas as $data) {
            for ($i = 1; $i <= 1; $i++) {
                DB::table('guru_bk')->insert([
                    'id_guru' => $data,
                ]);
            }
        }
    }
}
