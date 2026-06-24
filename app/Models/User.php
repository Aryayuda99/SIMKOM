<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Model User merepresentasikan akun pengguna yang dapat login ke SIMKOM.
// Fillable menentukan atribut akun yang boleh diisi secara massal.
#[Fillable(['name', 'email', 'password'])]
// Hidden menyembunyikan password dan remember token saat data user diubah menjadi array atau JSON.
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Mengatur tipe data otomatis untuk verifikasi email dan hashing password.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
