<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration untuk membuat tabel user, reset password, dan session.
     */
    public function up(): void
    {
        // Membuat tabel users untuk menyimpan akun pengguna aplikasi.
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Email dibuat unik agar satu akun tidak memakai email yang sama.
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            // Password menyimpan kredensial login pengguna.
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Membuat tabel token reset password berdasarkan email pengguna.

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Membuat tabel sessions untuk menyimpan data sesi login pengguna.

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            // user_id menghubungkan sesi dengan akun pengguna jika tersedia.
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            // Payload menyimpan isi data sesi atau pekerjaan antrean.
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Membatalkan migration dengan menghapus tabel yang dibuat.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
