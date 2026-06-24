<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Menonaktifkan event model saat proses seeding berjalan.
    use WithoutModelEvents;

    /**
     * Mengisi database dengan data awal untuk kebutuhan pengujian aplikasi.
     */
    public function run(): void
    {
        // Contoh pembuatan banyak user jika dibutuhkan saat pengujian.
        // User::factory(10)->create();

        // Membuat satu akun user contoh menggunakan factory.
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
