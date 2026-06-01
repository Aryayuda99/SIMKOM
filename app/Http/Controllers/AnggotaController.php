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
        ->limit(3)
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
    ->join(
        'anggota',
        'kegiatan.id_organisasi',
        '=',
        'anggota.id_organisasi'
    )
    ->where(
        'anggota.id_user',
        session('id_user')
    )
    ->select('kegiatan.*')
    ->get();

    $semuaKegiatan = DB::table('kegiatan')
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->select(
            'kegiatan.*',
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