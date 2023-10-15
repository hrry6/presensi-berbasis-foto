<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\AkunSeeder;
use Database\Seeders\GuruSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SiswaSeeder;
use Database\Seeders\GuruBkSeeder;
use Database\Seeders\JurusanSeeder;
use Database\Seeders\GuruPiketSeeder;
use Database\Seeders\PengurusKelasSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            RoleSeeder::class,
            AkunSeeder::class,
            GuruSeeder::class,
            GuruPiketSeeder::class,
            GuruBkSeeder::class,
            JurusanSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            PengurusKelasSeeder::class
        ];
    
        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
    }
}
