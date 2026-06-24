<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Service provider utama untuk registrasi dan bootstrap layanan aplikasi.
class AppServiceProvider extends ServiceProvider
{
    /**
     * Mendaftarkan layanan aplikasi jika dibutuhkan.
     */
    public function register(): void
    {
        //
    }

    /**
     * Menjalankan konfigurasi awal layanan saat aplikasi mulai berjalan.
     */
    public function boot(): void
    {
        //
    }
}
