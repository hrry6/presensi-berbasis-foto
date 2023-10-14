<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_role' => $this->faker->randomElement(['Siswa', 'Wali Kelas', 'Pengurus Kelas', 'Guru Piket', 'Guru BK', 'Tata Usaha Kesiswaan']),
        ];
    }
}