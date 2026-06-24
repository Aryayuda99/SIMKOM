<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PembinaController extends Controller
{
// Menampilkan halaman dashboard sesuai peran pengguna dan mengirim data ringkasan ke view.
public function dashboard()
{
    // Mengakses tabel pembina untuk menentukan organisasi yang dibina user.
    $pembina = DB::table('pembina')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel data_organisasi untuk informasi profil organisasi.
    $organisasi = DB::table('data_organisasi')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pembina->id_organisasi
        )
        ->first();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $jumlahKegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pembina->id_organisasi
        )
        ->count();

    // Mengakses tabel dokumen_kegiatan untuk metadata dokumen kegiatan.
    $jumlahDokumen = DB::table('dokumen_kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'dokumen_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $pembina->id_organisasi
        )
        ->count();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'id_organisasi',
        $pembina->id_organisasi
    )
    // OrderBy mengurutkan data agar tampil sesuai urutan yang dibutuhkan.
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

    // Menampilkan dokumen proposal, LPJ, dan dokumentasi untuk organisasi pembina.

    public function dokumenProposalLpj()
{
    // Mengakses tabel pembina untuk menentukan organisasi yang dibina user.
    $pembina = DB::table('pembina')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel dokumen_kegiatan untuk metadata dokumen kegiatan.
    $dokumen = DB::table('dokumen_kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'dokumen_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
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
            'data_organisasi.id_organisasi',
            $pembina->id_organisasi
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'dokumen_kegiatan.*',
            'kegiatan.nama_kegiatan',
            'data_organisasi.nama_organisasi'
        )
        // OrderBy mengurutkan data agar tampil sesuai urutan yang dibutuhkan.
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

// Memvalidasi dan menyimpan evaluasi pembina pada riwayat kegiatan organisasi.

public function simpanEvaluasiRiwayat(Request $request, $id)
{
    $request->validate([
        'evaluasi' => 'required|string|max:1000',
    ]);

    // Mengakses tabel pembina untuk menentukan organisasi yang dibina user.
    $pembina = DB::table('pembina')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel riwayat_kegiatan untuk data kegiatan yang sudah selesai.
    $riwayat = DB::table('riwayat_kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'riwayat_kegiatan.id_riwayat',
            $id
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $pembina->id_organisasi
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
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

    // Mengakses tabel riwayat_kegiatan untuk data kegiatan yang sudah selesai.
    DB::table('riwayat_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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

// Menampilkan riwayat kegiatan beserta informasi kegiatan dan organisasi terkait.

public function riwayatKegiatan()
{
    // Mengakses tabel pembina untuk menentukan organisasi yang dibina user.
    $pembina = DB::table('pembina')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel riwayat_kegiatan untuk data kegiatan yang sudah selesai.
    $riwayat = DB::table('riwayat_kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
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
            $pembina->id_organisasi
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'riwayat_kegiatan.*',
            'kegiatan.nama_kegiatan',
            'kegiatan.deskripsi',
            'kegiatan.biaya_pendaftaran',
            'data_organisasi.nama_organisasi'
        )
        // OrderBy mengurutkan data agar tampil sesuai urutan yang dibutuhkan.
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
