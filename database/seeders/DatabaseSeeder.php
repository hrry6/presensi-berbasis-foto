<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(AkunSeeder::class);
        $this->call(GuruSeeder::class);
        $this->call(GuruPiketSeeder::class);
        $this->call(GuruBkSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(SiswaSeeder::class);
        $this->call(PresensiSeeder::class);
        $this->call(PengurusKelasSeeder::class);
        $this->call(TataUsahaSeeder::class);
    }
}
