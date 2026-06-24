<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
// Menampilkan halaman dashboard sesuai peran pengguna dan mengirim data ringkasan ke view.
public function dashboard()
{
    $organisasi = DB::table(
    'anggota'
)
// Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
->join(
    'data_organisasi',
    'anggota.id_organisasi',
    '=',
    'data_organisasi.id_organisasi'
)
// Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
->where(
    'anggota.id_user',
    session('id_user')
)
->first();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        ->leftJoin(
            'pendaftaran_kegiatan',
            'kegiatan.id_kegiatan',
            '=',
            'pendaftaran_kegiatan.id_kegiatan'
        )
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $organisasi->id_organisasi
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'kegiatan.*',
            'data_organisasi.nama_organisasi',
            DB::raw('COUNT(pendaftaran_kegiatan.id_pendaftaran) as jumlah_peserta')
        )
        ->groupBy(
            'kegiatan.id_kegiatan',
            'kegiatan.id_organisasi',
            'kegiatan.nama_kegiatan',
            'kegiatan.tanggal_pelaksanaan',
            'kegiatan.kuota_peserta',
            'kegiatan.deskripsi',
            'kegiatan.lokasi',
            'kegiatan.biaya_pendaftaran',
            'data_organisasi.nama_organisasi'
        )
        ->get();

    $kegiatanDiikuti = DB::table(
        'pendaftaran_kegiatan'
    )
    // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
    ->join(
        'kegiatan',
        'pendaftaran_kegiatan.id_kegiatan',
        '=',
        'kegiatan.id_kegiatan'
    )
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'pendaftaran_kegiatan.id_user',
        session('id_user')
    )
    ->get();

    return view(
        'anggota.dashboard',
        compact(
            'organisasi',
            'kegiatan',
            'kegiatanDiikuti'
        )
    );
}

// Menampilkan kegiatan organisasi anggota dan seluruh kegiatan yang tersedia.

public function jelajahiKegiatan()
{
// Mengakses tabel kegiatan untuk data kegiatan organisasi.
$kegiatanOrganisasi = DB::table('kegiatan')
    ->leftJoin(
        'pendaftaran_kegiatan',
        'kegiatan.id_kegiatan',
        '=',
        'pendaftaran_kegiatan.id_kegiatan'
    )
    // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
    ->join(
        'anggota',
        'kegiatan.id_organisasi',
        '=',
        'anggota.id_organisasi'
    )
    // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
    ->join(
        'data_organisasi',
        'kegiatan.id_organisasi',
        '=',
        'data_organisasi.id_organisasi'
    )
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'anggota.id_user',
        session('id_user')
    )
    // Select menentukan kolom yang dikirim ke proses atau view.
    ->select(
        'kegiatan.*',
        'data_organisasi.nama_organisasi',
        DB::raw('COUNT(pendaftaran_kegiatan.id_pendaftaran) as jumlah_peserta')
    )
    ->groupBy(
        'kegiatan.id_kegiatan',
        'kegiatan.id_organisasi',
        'kegiatan.nama_kegiatan',
        'kegiatan.tanggal_pelaksanaan',
        'kegiatan.kuota_peserta',
        'kegiatan.deskripsi',
        'kegiatan.lokasi',
        'kegiatan.biaya_pendaftaran',
        'data_organisasi.nama_organisasi'
    )
    ->get();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $semuaKegiatan = DB::table('kegiatan')
        ->leftJoin(
            'pendaftaran_kegiatan',
            'kegiatan.id_kegiatan',
            '=',
            'pendaftaran_kegiatan.id_kegiatan'
        )
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'kegiatan.*',
            'data_organisasi.nama_organisasi',
            DB::raw('COUNT(pendaftaran_kegiatan.id_pendaftaran) as jumlah_peserta')
        )
        ->groupBy(
            'kegiatan.id_kegiatan',
            'kegiatan.id_organisasi',
            'kegiatan.nama_kegiatan',
            'kegiatan.tanggal_pelaksanaan',
            'kegiatan.kuota_peserta',
            'kegiatan.deskripsi',
            'kegiatan.lokasi',
            'kegiatan.biaya_pendaftaran',
            'data_organisasi.nama_organisasi'
        )
        ->get();

    return view(
        'anggota.jelajahi-kegiatan',
        compact(
            'kegiatanOrganisasi',
            'semuaKegiatan'
        )
    );
}

// Menampilkan daftar kegiatan yang diikuti oleh anggota yang sedang login.

public function aktivitasSaya()
{
    $aktivitas = DB::table(
        'pendaftaran_kegiatan'
    )
    // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
    ->join(
        'kegiatan',
        'pendaftaran_kegiatan.id_kegiatan',
        '=',
        'kegiatan.id_kegiatan'
    )
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'pendaftaran_kegiatan.id_user',
        session('id_user')
    )
    // Select menentukan kolom yang dikirim ke proses atau view.
    ->select(
        'pendaftaran_kegiatan.*',
        'kegiatan.nama_kegiatan',
        'kegiatan.tanggal_pelaksanaan',
        'kegiatan.lokasi'
    )
    ->get();

    return view(
        'anggota.aktivitas-saya',
        compact('aktivitas')
    );
}

// Menampilkan profil anggota beserta data organisasi yang diikuti.

public function profil()
{
    $profil = DB::table(
    'anggota'
)
// Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
->join(
    'data_organisasi',
    'anggota.id_organisasi',
    '=',
    'data_organisasi.id_organisasi'
)
// Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
->where(
    'anggota.id_user',
    session('id_user')
)
->first();

    return view(
        'anggota.profil',
        compact('profil')
    );
}
}
