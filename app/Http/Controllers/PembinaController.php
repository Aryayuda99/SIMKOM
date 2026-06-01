<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PembinaController extends Controller
{
public function dashboard()
{
    $pembina = DB::table('pembina')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $organisasi = DB::table('data_organisasi')
        ->where(
            'id_organisasi',
            $pembina->id_organisasi
        )
        ->first();

    $jumlahKegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pembina->id_organisasi
        )
        ->count();

    $jumlahDokumen = DB::table('dokumen_kegiatan')
        ->join(
            'kegiatan',
            'dokumen_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'kegiatan.id_organisasi',
            $pembina->id_organisasi
        )
        ->count();

    $kegiatan = DB::table('kegiatan')
    ->where(
        'id_organisasi',
        $pembina->id_organisasi
    )
    ->orderBy(
        'tanggal_pelaksanaan',
        'desc'
    )
    ->limit(5)
    ->get();

    return view(
        'pembina.dashboard',
        compact(
            'organisasi',
            'jumlahKegiatan',
            'jumlahDokumen',
            'kegiatan'
        )
    );
}

    public function dokumenProposalLpj()
{
    $pembina = DB::table('pembina')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $dokumen = DB::table('dokumen_kegiatan')
        ->join(
            'kegiatan',
            'dokumen_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'data_organisasi.id_organisasi',
            $pembina->id_organisasi
        )
        ->select(
            'dokumen_kegiatan.*',
            'kegiatan.nama_kegiatan',
            'data_organisasi.nama_organisasi'
        )
        ->orderBy(
            'tanggal_upload',
            'desc'
        )
        ->get();

    return view(
        'pembina.dokumen-proposal-lpj',
        compact('dokumen')
    );
}

public function riwayatKegiatan()
{
    $pembina = DB::table('pembina')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'kegiatan.id_organisasi',
            $pembina->id_organisasi
        )
        ->select(
            'kegiatan.*',
            'data_organisasi.nama_organisasi'
        )
        ->orderBy(
            'tanggal_pelaksanaan',
            'desc'
        )
        ->get();

    return view(
        'pembina.riwayat-kegiatan',
        compact('kegiatan')
    );
}
}
