<?php

//==============mengkonekkan====================================
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

use App\Http\Controllers\AnggotaController;

use App\Http\Controllers\PengurusController;

use App\Http\Controllers\PembinaController;

use App\Http\Controllers\AdminController;

Route::get(
    '/',
    function () {
        return view('login');
    }
);

Route::post(
    '/login',
    [AuthController::class, 'login']
);



//==========UNTUK MENGAMBIL DATA DASHBOARD MAHASISWA==============
Route::get(
    '/dashboard-mahasiswa',
    function () {
        return view('mahasiswa.dashboard');
    }
);

Route::get(
    '/dashboard-mahasiswa',
    [MahasiswaController::class, 'dashboard']
);

Route::get(
    '/daftar-anggota',
    [MahasiswaController::class, 'daftarAnggota']
);

Route::get(
    '/pendaftaran-anggota/{id}',
    [MahasiswaController::class, 'formPendaftaranAnggota']
);

Route::post(
    '/pendaftaran-anggota',
    [MahasiswaController::class, 'simpanPendaftaranAnggota']
);

Route::get(
    '/pendaftaran-kegiatan/{id}',
    [MahasiswaController::class, 'formPendaftaranKegiatan']
);

Route::post(
    '/pendaftaran-kegiatan',
    [MahasiswaController::class, 'simpanPendaftaranKegiatan']
);

Route::get(
    '/daftar-kegiatan',
    [MahasiswaController::class, 'daftarKegiatan']
);



//=====================ANGGOTA====================
Route::get(
    '/dashboard-anggota',
    [AnggotaController::class, 'dashboard']
);

Route::get(
    '/anggota/kegiatan',
    [AnggotaController::class, 'jelajahiKegiatan']
);

Route::get(
    '/anggota/aktivitas',
    [AnggotaController::class, 'aktivitasSaya']
);

Route::get(
    '/anggota/profil',
    [AnggotaController::class, 'profil']
);

//=============PENGURUS================

Route::get(
    '/dashboard-pengurus',
    [PengurusController::class, 'dashboard']
);

Route::get(
    '/profil-organisasi',
    [PengurusController::class, 'profilOrganisasi']
);

Route::get(
    '/manajemen-anggota',
    [PengurusController::class, 'manajemenAnggota']
);

Route::get(
    '/terima-anggota/{id}',
    [PengurusController::class, 'terimaAnggota']
);

Route::get(
    '/tolak-anggota/{id}',
    [PengurusController::class, 'tolakAnggota']
);

Route::get(
    '/nonaktifkan-anggota/{id}',
    [PengurusController::class, 'nonaktifkanAnggota']
);

Route::get(
    '/manajemen-kegiatan',
    [PengurusController::class, 'manajemenKegiatan']
);

Route::get(
    '/edit-kegiatan/{id}',
    [PengurusController::class, 'formEditKegiatan']
);

Route::post(
    '/update-kegiatan',
    [PengurusController::class, 'updateKegiatan']
);

Route::get(
    '/riwayat-kegiatan',
    [PengurusController::class, 'riwayatKegiatan']
);

Route::get(
    '/selesaikan-kegiatan/{id}',
    [PengurusController::class, 'selesaikanKegiatan']
);

Route::get(
    '/keuangan',
    [PengurusController::class, 'keuangan']
);

Route::post(
    '/tambah-transaksi',
    [PengurusController::class, 'tambahTransaksi']
);

Route::get(
    '/proposal-lpj',
    [PengurusController::class, 'proposalLpj']
);

Route::post(
    '/upload-dokumen',
    [PengurusController::class, 'uploadDokumen']
);

Route::get(
    '/hapus-dokumen/{id}',
    [PengurusController::class, 'hapusDokumen']
);

Route::get(
    '/hapus-dokumen/{id}',
    [PengurusController::class, 'hapusDokumen']
);

Route::get(
    '/ekspor-laporan',
    [PengurusController::class, 'eksporLaporan']
);

Route::get(
    '/export-kegiatan-pdf',
    [PengurusController::class, 'exportKegiatanPdf']
);

Route::get(
    '/export-keuangan-pdf',
    [PengurusController::class, 'exportKeuanganPdf']
);

//=====================PEMBINA============================
Route::get(
    '/pembina/dashboard',
    [PembinaController::class, 'dashboard']
);

Route::get(
    '/dokumen-pembina',
    [PembinaController::class, 'dokumenProposalLpj']
);

Route::get(
    '/riwayat-kegiatan-pembina',
    [PembinaController::class, 'riwayatKegiatan']
);

//===================ADMIN======================
Route::get(
    '/dashboard-admin',
    [AdminController::class, 'dashboard']
);

Route::get(
    '/profil-organisasi-admin',
    [AdminController::class, 'profilOrganisasi']
);

Route::get(
    '/edit-organisasi/{id}',
    [AdminController::class, 'formEditOrganisasi']
);

Route::post(
    '/update-organisasi',
    [AdminController::class, 'updateOrganisasi']
);

Route::get(
    '/manajemen-anggota-admin',
    [AdminController::class, 'manajemenAnggota']
);

Route::get(
    '/ubah-role/{id}',
    [AdminController::class, 'formUbahRole']
);

Route::post(
    '/simpan-role',
    [AdminController::class, 'simpanRole']
);

Route::get(
    '/manajemen-kegiatan-admin',
    [AdminController::class, 'manajemenKegiatan']
);

Route::get(
    '/tambah-kegiatan',
    [AdminController::class, 'formTambahKegiatan']
);

Route::post(
    '/simpan-kegiatan',
    [AdminController::class, 'simpanKegiatan']
);

Route::get(
    '/edit-kegiatan-admin/{id}',
    [AdminController::class, 'formEditKegiatan']
);

Route::post(
    '/update-kegiatan-admin',
    [AdminController::class, 'updateKegiatan']
);

Route::get(
    '/hapus-kegiatan/{id}',
    [AdminController::class, 'hapusKegiatan']
);