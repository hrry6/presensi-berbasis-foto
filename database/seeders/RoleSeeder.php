<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Siswa',
            'Wali Kelas',
            'Pengurus Kelas',
            'Guru Piket',
            'Guru BK',
            'Tata Usaha Kesiswaan',
        ];
        
        foreach ($roles as $role) {
            DB::table('role_akun')->insert([
                'nama_role' => $role,
            ]);
        }        
    }
}
