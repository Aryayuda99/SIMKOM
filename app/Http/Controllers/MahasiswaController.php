<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class MahasiswaController extends Controller
{
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
    $file = $request->file('kartu_identitas');

    $namaFile = time() .
        '_' .
        $file->getClientOriginalName();

    $file->move(
        public_path('uploads'),
        $namaFile
    );

    $jumlah = DB::table(
    'pendaftaran_anggota_online'
)->count();

DB::table('pendaftaran_anggota_online')
->insert([

    'id_user' => session('id_user'),

    'id_organisasi' => $request->id_organisasi,

    'nim' => $request->nim,

    'nama' => $request->nama,

    'program_studi' => $request->program_studi,

    'no_hp' => $request->no_hp,

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
    $kegiatan = DB::table('kegiatan')
        ->where('id_kegiatan', $id)
        ->first();

    return view(
        'mahasiswa.form-pendaftaran-kegiatan',
        compact('kegiatan')
    );
}

public function simpanPendaftaranKegiatan(Request $request)
{
    $file = $request->file('bukti_pembayaran');

    $namaFile = time() .
        '_' .
        $file->getClientOriginalName();

    $file->move(
        public_path('uploads'),
        $namaFile
    );

    $jumlah = DB::table(
        'pendaftaran_kegiatan'
    )->count();

    $idBaru =
        'PK' .
        str_pad(
            $jumlah + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

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

        'bukti_pembayaran' => $namaFile,

        'status_pembayaran' => 'belum_lunas'

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
        'mahasiswa.daftar-kegiatan',
        compact('kegiatan')
    );
}
}