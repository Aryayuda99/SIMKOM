<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Factory untuk membuat data dummy akun user.
 *
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Password default yang digunakan ulang oleh factory.
     */
    protected static ?string $password;

    /**
     * Menentukan nilai default atribut user saat factory dijalankan.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Nama, email, dan token dibuat otomatis untuk data dummy.
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Membuat kondisi user dengan email yang belum terverifikasi.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
