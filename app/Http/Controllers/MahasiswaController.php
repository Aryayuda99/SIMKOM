<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class MahasiswaController extends Controller
{
    // Membuat ID pendaftaran kegiatan yang unik berdasarkan nomor terakhir.
    private function buatIdPendaftaranKegiatan()
    {
        // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
        $nomorTerakhir = DB::table('pendaftaran_kegiatan')
            // Select menentukan kolom yang dikirim ke proses atau view.
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

            // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
            $sudahAda = DB::table('pendaftaran_kegiatan')
                // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                ->where(
                    'id_pendaftaran',
                    $idBaru
                )
                ->exists();

            $nomor++;
        } while ($sudahAda);

        return $idBaru;
    }

    // Membuat ID pendaftaran anggota yang unik berdasarkan nomor terakhir.

    private function buatIdPendaftaranAnggota()
    {
        // Mengakses tabel pendaftaran_anggota_online untuk data calon anggota.
        $nomorTerakhir = DB::table('pendaftaran_anggota_online')
            // Select menentukan kolom yang dikirim ke proses atau view.
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

            // Mengakses tabel pendaftaran_anggota_online untuk data calon anggota.
            $sudahAda = DB::table('pendaftaran_anggota_online')
                // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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
        // Mengakses tabel data_organisasi untuk informasi profil organisasi.
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
    // Mengakses tabel data_organisasi untuk informasi profil organisasi.
    $organisasi = DB::table('data_organisasi')->get();

    return view(
        'mahasiswa.daftar-anggota',
        compact('organisasi')
    );
}

// Menampilkan form pendaftaran anggota berdasarkan organisasi yang dipilih.

public function formPendaftaranAnggota($id)
{
    // Mengakses tabel data_organisasi untuk informasi profil organisasi.
    $organisasi = DB::table('data_organisasi')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_organisasi', $id)
        ->first();

    return view(
        'mahasiswa.form-pendaftaran-anggota',
        compact('organisasi')
    );
}

// Memvalidasi data pendaftaran anggota, mengunggah kartu identitas, dan menyimpan pendaftaran.

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

    // Mengakses tabel pendaftaran_anggota_online untuk data calon anggota.
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

// Menampilkan form pendaftaran kegiatan setelah memeriksa role dan kuota.

public function formPendaftaranKegiatan($id)
{
    if (session('role') === 'pengurus') {
        return redirect('/manajemen-kegiatan')
            ->with('success', 'Pengurus tidak dapat mendaftar kegiatan');
    }

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_kegiatan', $id)
        ->first();

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
    $jumlahPeserta = DB::table('pendaftaran_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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

// Memeriksa kuota, mencegah pendaftaran ganda, mengunggah bukti pembayaran, dan menyimpan pendaftaran kegiatan.

public function simpanPendaftaranKegiatan(Request $request)
{
    if (session('role') === 'pengurus') {
        return redirect('/manajemen-kegiatan')
            ->with('success', 'Pengurus tidak dapat mendaftar kegiatan');
    }

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_kegiatan', $request->id_kegiatan)
        ->first();

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
    $jumlahPesertaKegiatan = DB::table('pendaftaran_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_kegiatan', $request->id_kegiatan)
        ->count();

    if (!$kegiatan || (int) $kegiatan->kuota_peserta <= $jumlahPesertaKegiatan) {
        return redirect('/daftar-kegiatan')
            ->with('success', 'Slot kegiatan sudah penuh');
    }

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
    $sudahDaftar = DB::table('pendaftaran_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
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
// Menampilkan daftar kegiatan beserta organisasi dan jumlah peserta terdaftar.
public function daftarKegiatan()
{
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
        'mahasiswa.daftar-kegiatan',
        compact('kegiatan')
    );
}
}
