<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function dashboard()
{
    $pengurus = DB::table('pengurus')
        ->join(
            'data_organisasi',
            'pengurus.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'pengurus.id_user',
            session('id_user')
        )
        ->first();

    $kegiatanAktif = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->orderBy(
            'tanggal_pelaksanaan',
            'asc'
        )
        ->get();

    return view(
        'pengurus.dashboard',
        compact(
            'pengurus',
            'kegiatanAktif'
        )
    );
}

public function profilOrganisasi()
{
    $organisasi = DB::table('pengurus')
        ->join(
            'data_organisasi',
            'pengurus.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'pengurus.id_user',
            session('id_user')
        )
        ->select('data_organisasi.*')
        ->first();

    return view(
        'pengurus.profil-organisasi',
        compact('organisasi')
    );
}

public function manajemenAnggota()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $pendaftaran = DB::table(
        'pendaftaran_anggota_online'
    )
    ->where(
        'id_organisasi',
        $pengurus->id_organisasi
    )
    ->get();

    $anggota = DB::table('anggota')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    return view(
        'pengurus.manajemen-anggota',
        compact(
            'pendaftaran',
            'anggota'
        )
    );
}

public function terimaAnggota($id)
{
    $pendaftaran = DB::table(
        'pendaftaran_anggota_online'
    )
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->first();

    $idAnggota =
        $pendaftaran->id_organisasi .
        $pendaftaran->id_user;

    DB::table('anggota')
    ->insert([

        'id_anggota' => $idAnggota,

        'id_user' => $pendaftaran->id_user,

        'id_organisasi' => $pendaftaran->id_organisasi,

        'nama' => $pendaftaran->nama,

        'no_hp' => $pendaftaran->no_hp,

        'program_studi' => $pendaftaran->program_studi,

        'status_keanggotaan' => 'aktif'

    ]);

    DB::table('users')
    ->where(
        'id_user',
        $pendaftaran->id_user
    )
    ->update([

        'role' => 'anggota'

    ]);

    DB::table(
        'pendaftaran_anggota_online'
    )
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->delete();

    return redirect(
        '/manajemen-anggota'
    );
}

public function tolakAnggota($id)
{
    DB::table(
        'pendaftaran_anggota_online'
    )
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->delete();

    return redirect(
        '/manajemen-anggota'
    );
}

public function nonaktifkanAnggota($id)
{
    $anggota = DB::table('anggota')
        ->where(
            'id_anggota',
            $id
        )
        ->first();

    DB::table('anggota')
        ->where(
            'id_anggota',
            $id
        )
        ->update([
            'status_keanggotaan' => 'nonaktif'
        ]);

    DB::table('users')
        ->where(
            'id_user',
            $anggota->id_user
        )
        ->update([
            'role' => 'mahasiswa'
        ]);

    return redirect(
        '/manajemen-anggota'
    )->with(
        'success',
        'Anggota berhasil dinonaktifkan'
    );
}

public function manajemenKegiatan()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    return view(
        'pengurus.manajemen-kegiatan',
        compact('kegiatan')
    );
}

public function formEditKegiatan($id)
{
    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_kegiatan',
            $id
        )
        ->first();

    return view(
        'pengurus.edit-kegiatan',
        compact('kegiatan')
    );
}

public function updateKegiatan(Request $request)
{
    DB::table('kegiatan')
        ->where(
            'id_kegiatan',
            $request->id_kegiatan
        )
        ->update([

            'tanggal_pelaksanaan'
                => $request->tanggal_pelaksanaan,

            'lokasi'
                => $request->lokasi,

            'kuota_peserta'
                => $request->kuota_peserta

        ]);

    return redirect(
        '/manajemen-kegiatan'
    )->with(
        'success',
        'Kegiatan berhasil diperbarui'
    );
}

public function selesaikanKegiatan($id)
{
    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_kegiatan',
            $id
        )
        ->first();

    $jumlahRiwayat = DB::table(
        'riwayat_kegiatan'
    )->count();

    $idRiwayat =
        'R' .
        str_pad(
            $jumlahRiwayat + 1,
            2,
            '0',
            STR_PAD_LEFT
        );

    $jumlahPeserta = DB::table(
        'pendaftaran_kegiatan'
    )
    ->where(
        'id_kegiatan',
        $id
    )
    ->count();

    DB::table('riwayat_kegiatan')
        ->insert([

            'id_riwayat'
                => $idRiwayat,

            'id_kegiatan'
                => $id,

            'jumlah_peserta'
                => $jumlahPeserta . ' orang',

            'tanggal_selesai'
                => now(),

            'evaluasi'
                => '-',

            'status'
                => 'Selesai'

        ]);

    return redirect(
        '/riwayat-kegiatan'
    );
}


public function riwayatKegiatan()
{
    $riwayat = DB::table('riwayat_kegiatan')
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->select(
            'riwayat_kegiatan.*',
            'kegiatan.nama_kegiatan',
            'kegiatan.deskripsi',
            'kegiatan.biaya_pendaftaran'
        )
        ->get();

    return view(
        'pengurus.riwayat-kegiatan',
        compact('riwayat')
    );
}

public function keuangan()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $transaksi = DB::table('keuangan')
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        ->select(
            'keuangan.*',
            'kegiatan.nama_kegiatan'
        )
        ->orderBy(
            'tanggal_transaksi',
            'desc'
        )
        ->get();

        $totalPemasukan = DB::table('keuangan')
    ->where(
        'jenis_transaksi',
        'pemasukan'
    )
    ->sum('jumlah');

$totalPengeluaran = DB::table('keuangan')
    ->where(
        'jenis_transaksi',
        'pengeluaran'
    )
    ->sum('jumlah');

$saldo = $totalPemasukan - $totalPengeluaran;

    return view(
    'pengurus.keuangan',
    compact(
        'kegiatan',
        'transaksi',
        'totalPemasukan',
        'totalPengeluaran',
        'saldo'
    )
);
}

public function tambahTransaksi(Request $request)
{
    $jumlah = DB::table('keuangan')
        ->count();

    $idBaru =
        'TR' .
        str_pad(
            $jumlah + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

    DB::table('keuangan')
        ->insert([

            'id_transaksi' => $idBaru,

            'id_kegiatan' => $request->id_kegiatan,

            'jenis_transaksi'
                => $request->jenis_transaksi,

            'jumlah'
                => $request->jumlah,

            'tanggal_transaksi'
                => now(),

            'keterangan'
                => $request->keterangan

        ]);

    return redirect(
        '/keuangan'
    )->with(
        'success',
        'Transaksi berhasil ditambahkan'
    );
}

public function proposalLpj()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $dokumen = DB::table('dokumen_kegiatan')
        ->join(
            'kegiatan',
            'dokumen_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->select(
            'dokumen_kegiatan.*',
            'kegiatan.nama_kegiatan'
        )
        ->get();

    return view(
        'pengurus.proposal-lpj',
        compact(
            'kegiatan',
            'dokumen'
        )
    );
}

public function uploadDokumen(Request $request)
{
    $file = $request->file('file_dokumen');

    $namaFile = time() .
        '_' .
        $file->getClientOriginalName();

    $file->move(
        public_path('uploads'),
        $namaFile
    );

    $jumlah = DB::table(
        'dokumen_kegiatan'
    )->count();

    $idBaru =
        'D' .
        str_pad(
            $jumlah + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

    DB::table('dokumen_kegiatan')
        ->insert([

            'id_dokumen' => $idBaru,

            'id_kegiatan'
                => $request->id_kegiatan,

            'nama_dokumen'
                => $request->nama_dokumen,

            'jenis'
                => $request->jenis,

            'deskripsi'
                => $request->deskripsi,

            'tanggal_upload'
                => now(),

            'file_dokumen'
                => $namaFile

        ]);

    return redirect(
        '/proposal-lpj'
    );
}

public function hapusDokumen($id)
{
    $dokumen = DB::table('dokumen_kegiatan')
        ->where(
            'id_dokumen',
            $id
        )
        ->first();

    if ($dokumen) {

        $path = public_path(
            'uploads/' .
            $dokumen->file_dokumen
        );

        if (file_exists($path)) {

            unlink($path);

        }

        DB::table('dokumen_kegiatan')
            ->where(
                'id_dokumen',
                $id
            )
            ->delete();
    }

    return redirect(
        '/proposal-lpj'
    )->with(
        'success',
        'Dokumen berhasil dihapus'
    );
}

public function eksporLaporan()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $anggota = DB::table('anggota')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $keuangan = DB::table('keuangan')
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        ->select(
            'keuangan.*',
            'kegiatan.nama_kegiatan'
        )
        ->get();

    return view(
        'pengurus.ekspor-laporan',
        compact(
            'anggota',
            'kegiatan',
            'keuangan'
        )
    );
}
}

