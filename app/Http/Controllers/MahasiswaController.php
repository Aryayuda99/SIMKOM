<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class MahasiswaController extends Controller
{
    private function buatIdPendaftaranKegiatan()
    {
        $nomorTerakhir = DB::table('pendaftaran_kegiatan')
            ->selectRaw("MAX(CAST(SUBSTRING(id_pendaftaran, 3) AS UNSIGNED)) as nomor")
            ->value('nomor');

        $nomor = ((int) $nomorTerakhir) + 1;

        do {
            $idBaru = 'PK' .
                str_pad(
                    $nomor,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

            $sudahAda = DB::table('pendaftaran_kegiatan')
                ->where(
                    'id_pendaftaran',
                    $idBaru
                )
                ->exists();

            $nomor++;
        } while ($sudahAda);

        return $idBaru;
    }

    private function buatIdPendaftaranAnggota()
    {
        $nomorTerakhir = DB::table('pendaftaran_anggota_online')
            ->selectRaw("MAX(CAST(SUBSTRING(id_pendaftaranA, 3) AS UNSIGNED)) as nomor")
            ->value('nomor');

        $nomor = ((int) $nomorTerakhir) + 1;

        do {
            $idBaru = 'PA' .
                str_pad(
                    $nomor,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

            $sudahAda = DB::table('pendaftaran_anggota_online')
                ->where(
                    'id_pendaftaranA',
                    $idBaru
                )
                ->exists();

            $nomor++;
        } while ($sudahAda);

        return $idBaru;
    }

    //FUNGSI DASHBOARD
    public function dashboard()
    {
        $organisasi = DB::table('data_organisasi')
            ->limit(3)
            ->get();

        return view(
            'mahasiswa.dashboard',
            compact('organisasi')
        );
    }

    //FUNGSI DAFTAR ANGGOTA
    public function daftarAnggota()
{
    $organisasi = DB::table('data_organisasi')->get();

    return view(
        'mahasiswa.daftar-anggota',
        compact('organisasi')
    );
}

public function formPendaftaranAnggota($id)
{
    $organisasi = DB::table('data_organisasi')
        ->where('id_organisasi', $id)
        ->first();

    return view(
        'mahasiswa.form-pendaftaran-anggota',
        compact('organisasi')
    );
}

public function simpanPendaftaranAnggota(Request $request)
{
    if (!session('id_user')) {
        return redirect('/')
            ->with('success', 'Silakan login terlebih dahulu');
    }

    $validated = $request->validate([
        'id_organisasi' => 'required|exists:data_organisasi,id_organisasi',
        'nim' => 'required|string|max:20',
        'nama' => 'required|string|max:100',
        'program_studi' => 'required|string|max:100',
        'no_hp' => 'required|string|max:20',
        'kartu_identitas' => 'required|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    $file = $request->file('kartu_identitas');

    $namaFile = time() .
        '_' .
        $file->getClientOriginalName();

    $file->move(
        public_path('uploads'),
        $namaFile
    );

    $idBaru = $this->buatIdPendaftaranAnggota();

    DB::table('pendaftaran_anggota_online')
        ->insert([
            'id_pendaftaranA' => $idBaru,
            'id_user' => session('id_user'),
            'id_organisasi' => $validated['id_organisasi'],
            'nim' => $validated['nim'],
            'nama' => $validated['nama'],
            'program_studi' => $validated['program_studi'],
            'no_hp' => $validated['no_hp'],
            'kartu_identitas' => $namaFile
        ]);

    return redirect(
        '/daftar-anggota'
    )->with(
        'success',
        'Pendaftaran berhasil'
    );
    
}

public function formPendaftaranKegiatan($id)
{
    if (session('role') === 'pengurus') {
        return redirect('/manajemen-kegiatan')
            ->with('success', 'Pengurus tidak dapat mendaftar kegiatan');
    }

    $kegiatan = DB::table('kegiatan')
        ->where('id_kegiatan', $id)
        ->first();

    $jumlahPeserta = DB::table('pendaftaran_kegiatan')
        ->where('id_kegiatan', $id)
        ->count();

    if (!$kegiatan || (int) $kegiatan->kuota_peserta <= $jumlahPeserta) {
        return redirect('/daftar-kegiatan')
            ->with('success', 'Slot kegiatan sudah penuh');
    }

    return view(
        'mahasiswa.form-pendaftaran-kegiatan',
        compact('kegiatan')
    );
}

public function simpanPendaftaranKegiatan(Request $request)
{
    if (session('role') === 'pengurus') {
        return redirect('/manajemen-kegiatan')
            ->with('success', 'Pengurus tidak dapat mendaftar kegiatan');
    }

    $kegiatan = DB::table('kegiatan')
        ->where('id_kegiatan', $request->id_kegiatan)
        ->first();

    $jumlahPesertaKegiatan = DB::table('pendaftaran_kegiatan')
        ->where('id_kegiatan', $request->id_kegiatan)
        ->count();

    if (!$kegiatan || (int) $kegiatan->kuota_peserta <= $jumlahPesertaKegiatan) {
        return redirect('/daftar-kegiatan')
            ->with('success', 'Slot kegiatan sudah penuh');
    }

    $sudahDaftar = DB::table('pendaftaran_kegiatan')
        ->where(
            'id_user',
            session('id_user')
        )
        ->where(
            'id_kegiatan',
            $request->id_kegiatan
        )
        ->exists();

    if ($sudahDaftar) {
        return redirect('/daftar-kegiatan')
            ->with('success', 'Anda sudah terdaftar pada kegiatan ini');
    }

    $file = $request->file('bukti_pembayaran');

    $namaFile = time() .
        '_' .
        $file->getClientOriginalName();

    $file->move(
        public_path('uploads'),
        $namaFile
    );

    $idBaru = $this->buatIdPendaftaranKegiatan();

    DB::table(
        'pendaftaran_kegiatan'
    )->insert([

        'id_pendaftaran' => $idBaru,

        'id_user' => session('id_user'),

        'id_kegiatan' => $request->id_kegiatan,

        'NIM' => $request->NIM,

        'nama' => $request->nama,

        'program_studi' => $request->program_studi,

        'email' => $request->email,

        'no_hp' => $request->no_hp,

        'bukti_pembayaran' => $namaFile

    ]);

    return redirect('/daftar-kegiatan')
        ->with(
            'success',
            'Pendaftaran kegiatan berhasil'
        );
}
public function daftarKegiatan()
{
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
        'mahasiswa.daftar-kegiatan',
        compact('kegiatan')
    );
}
}
