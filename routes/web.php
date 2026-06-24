<?php

// Menghubungkan route web dengan controller yang menangani fitur SIMKOM.
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

use App\Http\Controllers\AnggotaController;

use App\Http\Controllers\PengurusController;

use App\Http\Controllers\PembinaController;

use App\Http\Controllers\AdminController;

// Route untuk menangani akses / pada aplikasi SIMKOM.
Route::get(
    '/',
    function () {
        return view('login');
    }
);

// Route untuk menangani akses /lupa-password pada aplikasi SIMKOM.
Route::get(
    '/lupa-password',
    function () {
        return view('forgot-password');
    }
);

// Route untuk menangani akses /login pada aplikasi SIMKOM.
Route::post(
    '/login',
    [AuthController::class, 'login']
);

// Route untuk menangani akses /logout pada aplikasi SIMKOM.
Route::get(
    '/logout',
    [AuthController::class, 'logout']
);



//==========UNTUK MENGAMBIL DATA DASHBOARD MAHASISWA==============
// Route untuk menangani akses /dashboard-mahasiswa pada aplikasi SIMKOM.
Route::get(
    '/dashboard-mahasiswa',
    function () {
        return view('mahasiswa.dashboard');
    }
);

// Route untuk menangani akses /dashboard-mahasiswa pada aplikasi SIMKOM.
Route::get(
    '/dashboard-mahasiswa',
    [MahasiswaController::class, 'dashboard']
);

// Route untuk menangani akses /daftar-anggota pada aplikasi SIMKOM.
Route::get(
    '/daftar-anggota',
    [MahasiswaController::class, 'daftarAnggota']
);

// Route untuk menangani akses /pendaftaran-anggota/{id} pada aplikasi SIMKOM.
Route::get(
    '/pendaftaran-anggota/{id}',
    [MahasiswaController::class, 'formPendaftaranAnggota']
);

// Route untuk menangani akses /pendaftaran-anggota pada aplikasi SIMKOM.
Route::post(
    '/pendaftaran-anggota',
    [MahasiswaController::class, 'simpanPendaftaranAnggota']
);

// Route untuk menangani akses /pendaftaran-kegiatan/{id} pada aplikasi SIMKOM.
Route::get(
    '/pendaftaran-kegiatan/{id}',
    [MahasiswaController::class, 'formPendaftaranKegiatan']
);

// Route untuk menangani akses /pendaftaran-kegiatan pada aplikasi SIMKOM.
Route::post(
    '/pendaftaran-kegiatan',
    [MahasiswaController::class, 'simpanPendaftaranKegiatan']
);

// Route untuk menangani akses /daftar-kegiatan pada aplikasi SIMKOM.
Route::get(
    '/daftar-kegiatan',
    [MahasiswaController::class, 'daftarKegiatan']
);



//=====================ANGGOTA====================
// Route untuk menangani akses /dashboard-anggota pada aplikasi SIMKOM.
Route::get(
    '/dashboard-anggota',
    [AnggotaController::class, 'dashboard']
);

// Route untuk menangani akses /anggota/kegiatan pada aplikasi SIMKOM.
Route::get(
    '/anggota/kegiatan',
    [AnggotaController::class, 'jelajahiKegiatan']
);

// Route untuk menangani akses /anggota/aktivitas pada aplikasi SIMKOM.
Route::get(
    '/anggota/aktivitas',
    [AnggotaController::class, 'aktivitasSaya']
);

// Route untuk menangani akses /anggota/profil pada aplikasi SIMKOM.
Route::get(
    '/anggota/profil',
    [AnggotaController::class, 'profil']
);

//=============PENGURUS================

// Route untuk menangani akses /dashboard-pengurus pada aplikasi SIMKOM.
Route::get(
    '/dashboard-pengurus',
    [PengurusController::class, 'dashboard']
);

// Route untuk menangani akses /profil-organisasi pada aplikasi SIMKOM.
Route::get(
    '/profil-organisasi',
    [PengurusController::class, 'profilOrganisasi']
);

// Route untuk menangani akses /edit-profil-organisasi pada aplikasi SIMKOM.
Route::get(
    '/edit-profil-organisasi',
    [PengurusController::class, 'formEditProfilOrganisasi']
);

// Route untuk menangani akses /update-profil-organisasi pada aplikasi SIMKOM.
Route::post(
    '/update-profil-organisasi',
    [PengurusController::class, 'updateProfilOrganisasi']
);

// Route untuk menangani akses /manajemen-anggota pada aplikasi SIMKOM.
Route::get(
    '/manajemen-anggota',
    [PengurusController::class, 'manajemenAnggota']
);

// Route untuk menangani akses /terima-anggota/{id} pada aplikasi SIMKOM.
Route::get(
    '/terima-anggota/{id}',
    [PengurusController::class, 'terimaAnggota']
);

// Route untuk menangani akses /tolak-anggota/{id} pada aplikasi SIMKOM.
Route::get(
    '/tolak-anggota/{id}',
    [PengurusController::class, 'tolakAnggota']
);

// Route untuk menangani akses /nonaktifkan-anggota/{id} pada aplikasi SIMKOM.
Route::get(
    '/nonaktifkan-anggota/{id}',
    [PengurusController::class, 'nonaktifkanAnggota']
);

// Route untuk menangani akses /aktifkan-anggota/{id} pada aplikasi SIMKOM.
Route::get(
    '/aktifkan-anggota/{id}',
    [PengurusController::class, 'aktifkanAnggota']
);

// Route untuk menangani akses /manajemen-kegiatan pada aplikasi SIMKOM.
Route::get(
    '/manajemen-kegiatan',
    [PengurusController::class, 'manajemenKegiatan']
);

// Route untuk menangani akses /detail-kegiatan/{id} pada aplikasi SIMKOM.
Route::get(
    '/detail-kegiatan/{id}',
    [PengurusController::class, 'detailKegiatan']
);

// Route untuk menangani akses /hapus-peserta-kegiatan/{id} pada aplikasi SIMKOM.
Route::get(
    '/hapus-peserta-kegiatan/{id}',
    [PengurusController::class, 'hapusPesertaKegiatan']
);

// Route untuk menangani akses /edit-kegiatan/{id} pada aplikasi SIMKOM.
Route::get(
    '/edit-kegiatan/{id}',
    [PengurusController::class, 'formEditKegiatan']
);

// Route untuk menangani akses /update-kegiatan pada aplikasi SIMKOM.
Route::post(
    '/update-kegiatan',
    [PengurusController::class, 'updateKegiatan']
);

// Route untuk menangani akses /riwayat-kegiatan pada aplikasi SIMKOM.
Route::get(
    '/riwayat-kegiatan',
    [PengurusController::class, 'riwayatKegiatan']
);

// Route untuk menangani akses /selesaikan-kegiatan/{id} pada aplikasi SIMKOM.
Route::get(
    '/selesaikan-kegiatan/{id}',
    [PengurusController::class, 'selesaikanKegiatan']
);

// Route untuk menangani akses /keuangan pada aplikasi SIMKOM.
Route::get(
    '/keuangan',
    [PengurusController::class, 'keuangan']
);

// Route untuk menangani akses /tambah-transaksi pada aplikasi SIMKOM.
Route::post(
    '/tambah-transaksi',
    [PengurusController::class, 'tambahTransaksi']
);

// Route untuk menangani akses /hapus-transaksi/{id} pada aplikasi SIMKOM.
Route::get(
    '/hapus-transaksi/{id}',
    [PengurusController::class, 'hapusTransaksi']
);

// Route untuk menangani akses /edit-transaksi/{id} pada aplikasi SIMKOM.
Route::get(
    '/edit-transaksi/{id}',
    [PengurusController::class, 'editTransaksi']
);

// Route untuk menangani akses /update-transaksi/{id} pada aplikasi SIMKOM.
Route::post(
    '/update-transaksi/{id}',
    [PengurusController::class, 'updateTransaksi']
);

// Route untuk menangani akses /proposal-lpj pada aplikasi SIMKOM.
Route::get(
    '/proposal-lpj',
    [PengurusController::class, 'proposalLpj']
);

// Route untuk menangani akses /upload-dokumen pada aplikasi SIMKOM.
Route::post(
    '/upload-dokumen',
    [PengurusController::class, 'uploadDokumen']
);

// Route untuk menangani akses /hapus-dokumen/{id} pada aplikasi SIMKOM.
Route::get(
    '/hapus-dokumen/{id}',
    [PengurusController::class, 'hapusDokumen']
);

// Route untuk menangani akses /hapus-dokumen/{id} pada aplikasi SIMKOM.
Route::get(
    '/hapus-dokumen/{id}',
    [PengurusController::class, 'hapusDokumen']
);

// Route untuk menangani akses /ekspor-laporan pada aplikasi SIMKOM.
Route::get(
    '/ekspor-laporan',
    [PengurusController::class, 'eksporLaporan']
);

// Route untuk menangani akses /export-kegiatan-pdf pada aplikasi SIMKOM.
Route::get(
    '/export-kegiatan-pdf',
    [PengurusController::class, 'exportKegiatanPdf']
);

// Route untuk menangani akses /export-kegiatan-excel pada aplikasi SIMKOM.
Route::get(
    '/export-kegiatan-excel',
    [PengurusController::class, 'exportKegiatanExcel']
);

// Route untuk menangani akses /export-keuangan-pdf pada aplikasi SIMKOM.
Route::get(
    '/export-keuangan-pdf',
    [PengurusController::class, 'exportKeuanganPdf']
);

// Route untuk menangani akses /export-keuangan-excel pada aplikasi SIMKOM.
Route::get(
    '/export-keuangan-excel',
    [PengurusController::class, 'exportKeuanganExcel']
);

//=====================PEMBINA============================
// Route untuk menangani akses /dashboard-pembina pada aplikasi SIMKOM.
Route::get(
    '/dashboard-pembina',
    [PembinaController::class, 'dashboard']
);

// Route untuk menangani akses /dokumen-pembina pada aplikasi SIMKOM.
Route::get(
    '/dokumen-pembina',
    [PembinaController::class, 'dokumenProposalLpj']
);

// Route untuk menangani akses /riwayat-kegiatan-pembina pada aplikasi SIMKOM.
Route::get(
    '/riwayat-kegiatan-pembina',
    [PembinaController::class, 'riwayatKegiatan']
);

// Route untuk menangani akses /riwayat-kegiatan-pembina/evaluasi/{id} pada aplikasi SIMKOM.
Route::post(
    '/riwayat-kegiatan-pembina/evaluasi/{id}',
    [PembinaController::class, 'simpanEvaluasiRiwayat']
);

//===================ADMIN======================
// Route untuk menangani akses /dashboard-admin pada aplikasi SIMKOM.
Route::get(
    '/dashboard-admin',
    [AdminController::class, 'dashboard']
);

// Route untuk menangani akses /profil-organisasi-admin pada aplikasi SIMKOM.
Route::get(
    '/profil-organisasi-admin',
    [AdminController::class, 'profilOrganisasi']
);

// Route untuk menangani akses /tambah-ukm pada aplikasi SIMKOM.
Route::get(
    '/tambah-ukm',
    [AdminController::class, 'formTambahOrganisasi']
);

// Route untuk menangani akses /simpan-ukm pada aplikasi SIMKOM.
Route::post(
    '/simpan-ukm',
    [AdminController::class, 'simpanOrganisasi']
);

// Route untuk menangani akses /edit-organisasi/{id} pada aplikasi SIMKOM.
Route::get(
    '/edit-organisasi/{id}',
    [AdminController::class, 'formEditOrganisasi']
);

// Route untuk menangani akses /hapus-organisasi/{id} pada aplikasi SIMKOM.
Route::get(
    '/hapus-organisasi/{id}',
    [AdminController::class, 'hapusOrganisasi']
);

// Route untuk menangani akses /update-organisasi pada aplikasi SIMKOM.
Route::post(
    '/update-organisasi',
    [AdminController::class, 'updateOrganisasi']
);

// Route untuk menangani akses /manajemen-anggota-admin pada aplikasi SIMKOM.
Route::get(
    '/manajemen-anggota-admin',
    [AdminController::class, 'manajemenAnggota']
);

// Route untuk menangani akses /ubah-role/{id} pada aplikasi SIMKOM.
Route::get(
    '/ubah-role/{id}',
    [AdminController::class, 'formUbahRole']
);

// Route untuk menangani akses /simpan-role pada aplikasi SIMKOM.
Route::post(
    '/simpan-role',
    [AdminController::class, 'simpanRole']
);

// Route untuk menangani akses /manajemen-kegiatan-admin pada aplikasi SIMKOM.
Route::get(
    '/manajemen-kegiatan-admin',
    [AdminController::class, 'manajemenKegiatan']
);

// Route untuk menangani akses /tambah-kegiatan pada aplikasi SIMKOM.
Route::get(
    '/tambah-kegiatan',
    [AdminController::class, 'formTambahKegiatan']
);

// Route untuk menangani akses /simpan-kegiatan pada aplikasi SIMKOM.
Route::post(
    '/simpan-kegiatan',
    [AdminController::class, 'simpanKegiatan']
);

// Route untuk menangani akses /edit-kegiatan-admin/{id} pada aplikasi SIMKOM.
Route::get(
    '/edit-kegiatan-admin/{id}',
    [AdminController::class, 'formEditKegiatan']
);

// Route untuk menangani akses /update-kegiatan-admin pada aplikasi SIMKOM.
Route::post(
    '/update-kegiatan-admin',
    [AdminController::class, 'updateKegiatan']
);

// Route untuk menangani akses /hapus-kegiatan/{id} pada aplikasi SIMKOM.
Route::get(
    '/hapus-kegiatan/{id}',
    [AdminController::class, 'hapusKegiatan']
);

// Route untuk menangani akses /reset-password/{id} pada aplikasi SIMKOM.
Route::get(
    '/reset-password/{id}',
    [AdminController::class, 'formResetPassword']
);

// Route untuk menangani akses /simpan-password pada aplikasi SIMKOM.
Route::post(
    '/simpan-password',
    [AdminController::class, 'simpanPassword']
);
