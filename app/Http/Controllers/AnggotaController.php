<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
public function dashboard()
{
    $organisasi = DB::table(
    'anggota'
)
->join(
    'data_organisasi',
    'anggota.id_organisasi',
    '=',
    'data_organisasi.id_organisasi'
)
->where(
    'anggota.id_user',
    session('id_user')
)
->first();

    $kegiatan = DB::table('kegiatan')
        ->leftJoin(
            'pendaftaran_kegiatan',
            'kegiatan.id_kegiatan',
            '=',
            'pendaftaran_kegiatan.id_kegiatan'
        )
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'kegiatan.id_organisasi',
            $organisasi->id_organisasi
        )
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
    ->join(
        'kegiatan',
        'pendaftaran_kegiatan.id_kegiatan',
        '=',
        'kegiatan.id_kegiatan'
    )
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

public function jelajahiKegiatan()
{
$kegiatanOrganisasi = DB::table('kegiatan')
    ->leftJoin(
        'pendaftaran_kegiatan',
        'kegiatan.id_kegiatan',
        '=',
        'pendaftaran_kegiatan.id_kegiatan'
    )
    ->join(
        'anggota',
        'kegiatan.id_organisasi',
        '=',
        'anggota.id_organisasi'
    )
    ->join(
        'data_organisasi',
        'kegiatan.id_organisasi',
        '=',
        'data_organisasi.id_organisasi'
    )
    ->where(
        'anggota.id_user',
        session('id_user')
    )
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

    $semuaKegiatan = DB::table('kegiatan')
        ->leftJoin(
            'pendaftaran_kegiatan',
            'kegiatan.id_kegiatan',
            '=',
            'pendaftaran_kegiatan.id_kegiatan'
        )
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
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

public function aktivitasSaya()
{
    $aktivitas = DB::table(
        'pendaftaran_kegiatan'
    )
    ->join(
        'kegiatan',
        'pendaftaran_kegiatan.id_kegiatan',
        '=',
        'kegiatan.id_kegiatan'
    )
    ->where(
        'pendaftaran_kegiatan.id_user',
        session('id_user')
    )
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

public function profil()
{
    $profil = DB::table(
    'anggota'
)
->join(
    'data_organisasi',
    'anggota.id_organisasi',
    '=',
    'data_organisasi.id_organisasi'
)
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
