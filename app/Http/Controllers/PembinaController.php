<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

public function simpanEvaluasiRiwayat(Request $request, $id)
{
    $request->validate([
        'evaluasi' => 'required|string|max:1000',
    ]);

    $pembina = DB::table('pembina')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $riwayat = DB::table('riwayat_kegiatan')
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'riwayat_kegiatan.id_riwayat',
            $id
        )
        ->where(
            'kegiatan.id_organisasi',
            $pembina->id_organisasi
        )
        ->select(
            'riwayat_kegiatan.id_riwayat'
        )
        ->first();

    if (!$riwayat) {
        return redirect('/riwayat-kegiatan-pembina')
            ->with(
                'error',
                'Riwayat kegiatan tidak ditemukan'
            );
    }

    DB::table('riwayat_kegiatan')
        ->where(
            'id_riwayat',
            $id
        )
        ->update([
            'evaluasi' => $request->evaluasi,
        ]);

    return redirect('/riwayat-kegiatan-pembina')
        ->with(
            'success',
            'Evaluasi berhasil disimpan'
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

    $riwayat = DB::table('riwayat_kegiatan')
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
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
            'kegiatan.id_organisasi',
            $pembina->id_organisasi
        )
        ->select(
            'riwayat_kegiatan.*',
            'kegiatan.nama_kegiatan',
            'kegiatan.deskripsi',
            'kegiatan.biaya_pendaftaran',
            'data_organisasi.nama_organisasi'
        )
        ->orderBy(
            'riwayat_kegiatan.tanggal_selesai',
            'desc'
        )
        ->get();

    return view(
        'pembina.riwayat-kegiatan',
        compact('riwayat')
    );
}
}
