<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    // Menghitung ringkasan pemasukan, pengeluaran, dan saldo organisasi.
    private function ringkasanKeuanganOrganisasi($idOrganisasi)
    {
        // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
        $totalPemasukan = DB::table('keuangan')
            // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
            ->join(
                'kegiatan',
                'keuangan.id_kegiatan',
                '=',
                'kegiatan.id_kegiatan'
            )
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where(
                'kegiatan.id_organisasi',
                $idOrganisasi
            )
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where(
                'keuangan.jenis_transaksi',
                'pemasukan'
            )
            ->sum('keuangan.jumlah');

        // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
        $totalPengeluaran = DB::table('keuangan')
            // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
            ->join(
                'kegiatan',
                'keuangan.id_kegiatan',
                '=',
                'kegiatan.id_kegiatan'
            )
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where(
                'kegiatan.id_organisasi',
                $idOrganisasi
            )
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where(
                'keuangan.jenis_transaksi',
                'pengeluaran'
            )
            ->sum('keuangan.jumlah');

        return [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $totalPemasukan - $totalPengeluaran,
        ];
    }

    // Menampilkan halaman dashboard sesuai peran pengguna dan mengirim data ringkasan ke view.

    public function dashboard()
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'data_organisasi',
            'pengurus.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'pengurus.id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatanAktif = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        // OrderBy mengurutkan data agar tampil sesuai urutan yang dibutuhkan.
        ->orderBy(
            'tanggal_pelaksanaan',
            'asc'
        )
        ->get();

    $ringkasanKeuangan = $this->ringkasanKeuanganOrganisasi(
        $pengurus->id_organisasi
    );

    return view(
        'pengurus.dashboard',
        array_merge(
            compact(
            'pengurus',
            'kegiatanAktif'
            ),
            $ringkasanKeuangan
        )
    );
}

// Menampilkan profil organisasi dengan data organisasi yang relevan.

public function profilOrganisasi()
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $organisasi = DB::table('pengurus')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'data_organisasi',
            'pengurus.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'pengurus.id_user',
            session('id_user')
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select('data_organisasi.*')
        ->first();

    return view(
        'pengurus.profil-organisasi',
        compact('organisasi')
    );
}

// Menampilkan form edit profil organisasi milik pengurus yang sedang login.

public function formEditProfilOrganisasi()
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $organisasi = DB::table('pengurus')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'data_organisasi',
            'pengurus.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'pengurus.id_user',
            session('id_user')
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select('data_organisasi.*')
        ->first();

    return view(
        'pengurus.edit-profil-organisasi',
        compact('organisasi')
    );
}

// Memperbarui profil organisasi milik pengurus yang sedang login.

public function updateProfilOrganisasi(Request $request)
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel data_organisasi untuk informasi profil organisasi.
    DB::table('data_organisasi')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->update([
            'nama_organisasi' => $request->nama_organisasi,
            'periode_kepengurusan' => $request->periode_kepengurusan,
        ]);

    return redirect('/profil-organisasi')
        ->with(
            'success',
            'Profil organisasi berhasil diperbarui'
        );
}

// Menampilkan data anggota atau pendaftaran anggota untuk kebutuhan manajemen.

public function manajemenAnggota()
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $pendaftaran = DB::table(
        'pendaftaran_anggota_online'
    )
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'id_organisasi',
        $pengurus->id_organisasi
    )
    ->get();

    // Mengakses tabel anggota untuk data keanggotaan organisasi.
    $anggota = DB::table('anggota')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'id_anggota',
            'id_user',
            'id_organisasi',
            'nim',
            'nama',
            'no_hp',
            'program_studi',
            'status_keanggotaan'
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

// Menerima pendaftaran anggota, membuat data anggota, memperbarui role, dan menghapus data pendaftaran.

public function terimaAnggota($id)
{
    $pendaftaran = DB::table(
        'pendaftaran_anggota_online'
    )
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->first();

    $idAnggota =
        $pendaftaran->id_organisasi .
        $pendaftaran->id_user;

    // Mengakses tabel anggota untuk data keanggotaan organisasi.
    DB::table('anggota')
    ->insert([

        'id_anggota' => $idAnggota,

        'id_user' => $pendaftaran->id_user,

        'id_organisasi' => $pendaftaran->id_organisasi,

        'nim' => $pendaftaran->nim,

        'nama' => $pendaftaran->nama,

        'no_hp' => $pendaftaran->no_hp,

        'program_studi' => $pendaftaran->program_studi,

        'status_keanggotaan' => 'aktif'

    ]);

    // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
    DB::table('users')
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'id_user',
        $pendaftaran->id_user
    )
    ->update([

        'role' => 'anggota'

    ]);

    // Mengakses tabel pendaftaran_anggota_online untuk data calon anggota.
    DB::table(
        'pendaftaran_anggota_online'
    )
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->delete();

    return redirect(
        '/manajemen-anggota'
    );
}

// Menolak pendaftaran anggota dengan menghapus data pendaftaran online.

public function tolakAnggota($id)
{
    // Mengakses tabel pendaftaran_anggota_online untuk data calon anggota.
    DB::table(
        'pendaftaran_anggota_online'
    )
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->delete();

    return redirect(
        '/manajemen-anggota'
    );
}

// Menonaktifkan status anggota dan mengembalikan role user menjadi mahasiswa.

public function nonaktifkanAnggota($id)
{
    // Mengakses tabel anggota untuk data keanggotaan organisasi.
    $anggota = DB::table('anggota')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_anggota',
            $id
        )
        ->first();

    // Mengakses tabel anggota untuk data keanggotaan organisasi.
    DB::table('anggota')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_anggota',
            $id
        )
        ->update([
            'status_keanggotaan' => 'nonaktif'
        ]);

    // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
    DB::table('users')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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

// Mengaktifkan kembali status anggota dan mengubah role user menjadi anggota.

public function aktifkanAnggota($id)
{
    // Mengakses tabel anggota untuk data keanggotaan organisasi.
    $anggota = DB::table('anggota')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_anggota',
            $id
        )
        ->first();

    // Mengakses tabel anggota untuk data keanggotaan organisasi.
    DB::table('anggota')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_anggota',
            $id
        )
        ->update([
            'status_keanggotaan' => 'aktif'
        ]);

    // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
    DB::table('users')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            $anggota->id_user
        )
        ->update([
            'role' => 'anggota'
        ]);

    return redirect(
        '/manajemen-anggota'
    )->with(
        'success',
        'Anggota berhasil diaktifkan'
    );
}

// Menampilkan daftar kegiatan sesuai organisasi yang sedang dikelola.

public function manajemenKegiatan()
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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

// Menampilkan detail kegiatan dan daftar pendaftar untuk organisasi pengurus.

public function detailKegiatan($id)
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_kegiatan',
            $id
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'kegiatan.*',
            'data_organisasi.nama_organisasi'
        )
        ->first();

    if (!$kegiatan) {
        abort(404);
    }

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
    $pendaftar = DB::table('pendaftaran_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_kegiatan',
            $id
        )
        ->get();

    return view(
        'pengurus.detail-kegiatan',
        compact(
            'kegiatan',
            'pendaftar'
        )
    );
}

// Menghapus peserta dari kegiatan setelah memastikan kegiatan milik organisasi pengurus.

public function hapusPesertaKegiatan($id)
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
    $pendaftaran = DB::table('pendaftaran_kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'pendaftaran_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'pendaftaran_kegiatan.id_pendaftaran',
            $id
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'pendaftaran_kegiatan.id_kegiatan'
        )
        ->first();

    if (!$pendaftaran) {
        abort(404);
    }

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
    DB::table('pendaftaran_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_pendaftaran',
            $id
        )
        ->delete();

    return redirect(
        '/detail-kegiatan/' . $pendaftaran->id_kegiatan
    )->with(
        'success',
        'Peserta berhasil dihapus'
    );
}

// Menampilkan form edit kegiatan berdasarkan ID kegiatan.

public function formEditKegiatan($id)
{
    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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

// Memperbarui data kegiatan berdasarkan input dari form.

public function updateKegiatan(Request $request)
{
    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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
                => $request->kuota_peserta,

            'biaya_pendaftaran'
                => $request->biaya_pendaftaran

        ]);

    return redirect(
        '/manajemen-kegiatan'
    )->with(
        'success',
        'Kegiatan berhasil diperbarui'
    );
}

// Memindahkan kegiatan ke riwayat, menghitung peserta, dan mengosongkan data pelaksanaan aktif.

public function selesaikanKegiatan($id)
{
    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'id_kegiatan',
        $id
    )
    ->count();

    // Mengakses tabel riwayat_kegiatan untuk data kegiatan yang sudah selesai.
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

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
    DB::table('pendaftaran_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_kegiatan',
            $id
        )
        ->delete();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_kegiatan',
            $id
        )
        ->update([
            'tanggal_pelaksanaan' => '1000-01-01',
            'lokasi' => null,
            'kuota_peserta' => null,
        ]);

    return redirect(
        '/riwayat-kegiatan'
    )->with(
        'success',
        'Kegiatan berhasil diselesaikan'
    );
}


// Menampilkan riwayat kegiatan beserta informasi kegiatan dan organisasi terkait.


public function riwayatKegiatan()
{
    // Mengakses tabel riwayat_kegiatan untuk data kegiatan yang sudah selesai.
    $riwayat = DB::table('riwayat_kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
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

// Menampilkan halaman keuangan berisi kegiatan, transaksi, dan ringkasan saldo organisasi.

public function keuangan(Request $request)
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Pengambilan data kegiatan untuk pilihan filter dan form tambah transaksi.
    $kegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $filter = [
        'bulan' => $request->bulan,
        'tahun' => $request->tahun,
        'id_kegiatan' => $request->id_kegiatan,
    ];

    // Mengakses tahun transaksi untuk pilihan filter tahunan.
    $tahunTransaksi = DB::table('keuangan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        ->selectRaw('YEAR(keuangan.tanggal_transaksi) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    // Filter transaksi berdasarkan bulan, tahun, dan kegiatan jika dipilih.
    $queryTransaksi = DB::table('keuangan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        );

    if ($filter['bulan']) {
        $queryTransaksi->whereMonth(
            'keuangan.tanggal_transaksi',
            $filter['bulan']
        );
    }

    if ($filter['tahun']) {
        $queryTransaksi->whereYear(
            'keuangan.tanggal_transaksi',
            $filter['tahun']
        );
    }

    if ($filter['id_kegiatan']) {
        $queryTransaksi->where(
            'keuangan.id_kegiatan',
            $filter['id_kegiatan']
        );
    }

    $transaksi = $queryTransaksi
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'keuangan.*',
            'kegiatan.nama_kegiatan'
        )
        // OrderBy mengurutkan data agar tampil sesuai urutan yang dibutuhkan.
        ->orderBy(
            'tanggal_transaksi',
            'desc'
        )
        ->get();

    // Perhitungan pemasukan mengikuti transaksi yang sudah difilter.
    $totalPemasukan = $transaksi
        ->where('jenis_transaksi', 'pemasukan')
        ->sum('jumlah');

    // Perhitungan pengeluaran mengikuti transaksi yang sudah difilter.
    $totalPengeluaran = $transaksi
        ->where('jenis_transaksi', 'pengeluaran')
        ->sum('jumlah');

    // Perhitungan saldo dari total pemasukan dikurangi total pengeluaran terfilter.
    $saldo = $totalPemasukan - $totalPengeluaran;

    $namaBulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    );

    return view(
    'pengurus.keuangan',
    compact(
        'kegiatan',
        'transaksi',
        'totalPemasukan',
        'totalPengeluaran',
        'saldo',
        'filter',
        'namaBulan',
        'tahunTransaksi'
    )
);
}

// Membuat ID transaksi dan menyimpan transaksi keuangan baru.

public function tambahTransaksi(Request $request)
{
    // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
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

    // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
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

// Menghapus transaksi keuangan berdasarkan ID transaksi.

public function hapusTransaksi($id)
{
    // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
    DB::table('keuangan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_transaksi', $id)
        ->delete();

    return redirect('/keuangan')
        ->with(
            'success',
            'Transaksi berhasil dihapus'
        );
}

// Menampilkan form edit transaksi beserta daftar kegiatan.

public function editTransaksi($id)
{
    // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
    $transaksi = DB::table('keuangan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_transaksi',
            $id
        )
        ->first();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        ->get();

    return view(
        'pengurus.edit-transaksi',
        compact(
            'transaksi',
            'kegiatan'
        )
    );
}

// Memperbarui data transaksi keuangan berdasarkan input form.

public function updateTransaksi(Request $request, $id)
{
    // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
    DB::table('keuangan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_transaksi',
            $id
        )
        ->update([

            'id_kegiatan'
                => $request->id_kegiatan,

            'jenis_transaksi'
                => $request->jenis_transaksi,

            'jumlah'
                => $request->jumlah,

            'keterangan'
                => $request->keterangan

        ]);

    return redirect('/keuangan')
        ->with(
            'success',
            'Transaksi berhasil diperbarui'
        );
}

// Menampilkan daftar kegiatan dan dokumen proposal, LPJ, atau dokumentasi.

public function proposalLpj()
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    // Mengakses tabel dokumen_kegiatan untuk metadata dokumen kegiatan.
    $dokumen = DB::table('dokumen_kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'dokumen_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
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

// Memvalidasi file, mengunggah dokumen, dan menyimpan metadata dokumen kegiatan.

public function uploadDokumen(Request $request)
{

if (in_array($request->jenis, ['Proposal', 'LPJ'])) {

        $request->validate([
            'file_dokumen' => 'required|mimes:pdf,doc,docx|max:5120'
        ], [
            'file_dokumen.mimes' => 'Proposal dan LPJ hanya boleh PDF atau DOCX.'
        ]);

    } elseif ($request->jenis == 'Dokumentasi') {

        $request->validate([
            'file_dokumen' => 'required|mimes:jpg,jpeg,png,zip|max:5120'
        ], [
            'file_dokumen.mimes' => 'Dokumentasi hanya boleh JPG, PNG, atau ZIP.'
        ]);

    }

    $file = $request->file('file_dokumen');

    $namaFile = time() . '_' . $file->getClientOriginalName();

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

    // Mengakses tabel dokumen_kegiatan untuk metadata dokumen kegiatan.
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

// Menghapus file dokumen dari folder upload dan menghapus datanya dari database.

public function hapusDokumen($id)
{
    // Mengakses tabel dokumen_kegiatan untuk metadata dokumen kegiatan.
    $dokumen = DB::table('dokumen_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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

        // Mengakses tabel dokumen_kegiatan untuk metadata dokumen kegiatan.
        DB::table('dokumen_kegiatan')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
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

// Menampilkan halaman ekspor laporan anggota, kegiatan, dan keuangan organisasi.

public function eksporLaporan()
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    // Mengakses tabel anggota untuk data keanggotaan organisasi.
    $anggota = DB::table('anggota')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    $kegiatan = DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
    $keuangan = DB::table('keuangan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
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

// Mengambil ID organisasi pengurus yang sedang login dari session.

private function idOrganisasiPengurus()
{
    // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
    $pengurus = DB::table('pengurus')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    return $pengurus->id_organisasi;
}

// Mengubah kode periode laporan menjadi label yang mudah dibaca.

private function labelPeriode($periode)
{
    return $periode === 'tahun'
        ? 'Tahun Ini'
        : 'Bulan Ini';
}

// Menerapkan filter bulan atau tahun pada query laporan.

private function terapkanPeriode($query, $kolomTanggal, $periode)
{
    if ($periode === 'tahun') {
        return $query->whereYear(
            $kolomTanggal,
            now()->year
        );
    }

    return $query
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->whereYear(
            $kolomTanggal,
            now()->year
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->whereMonth(
            $kolomTanggal,
            now()->month
        );
}

// Mengambil data riwayat kegiatan untuk kebutuhan laporan berdasarkan periode.

private function dataLaporanKegiatan($periode)
{
    // Mengakses tabel riwayat_kegiatan untuk data kegiatan yang sudah selesai.
    $query = DB::table('riwayat_kegiatan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $this->idOrganisasiPengurus()
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'riwayat_kegiatan.*',
            'kegiatan.nama_kegiatan',
            'kegiatan.deskripsi',
            'kegiatan.biaya_pendaftaran'
        );

    return $this->terapkanPeriode(
        $query,
        'riwayat_kegiatan.tanggal_selesai',
        $periode
    )
    // OrderBy mengurutkan data agar tampil sesuai urutan yang dibutuhkan.
    ->orderBy(
        'riwayat_kegiatan.tanggal_selesai',
        'desc'
    )
    ->get();
}

// Mengambil data transaksi keuangan untuk kebutuhan laporan berdasarkan periode.

private function dataLaporanKeuangan($periode)
{
    // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
    $query = DB::table('keuangan')
        // Join digunakan untuk menggabungkan data dari tabel yang saling berelasi.
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'kegiatan.id_organisasi',
            $this->idOrganisasiPengurus()
        )
        // Select menentukan kolom yang dikirim ke proses atau view.
        ->select(
            'keuangan.*',
            'kegiatan.nama_kegiatan'
        );

    return $this->terapkanPeriode(
        $query,
        'keuangan.tanggal_transaksi',
        $periode
    )
    // OrderBy mengurutkan data agar tampil sesuai urutan yang dibutuhkan.
    ->orderBy(
        'keuangan.tanggal_transaksi',
        'desc'
    )
    ->get();
}

// Membersihkan karakter khusus agar aman ditulis ke konten PDF.

private function escapePdfText($text)
{
    return str_replace(
        ['\\', '(', ')', "\r", "\n"],
        ['\\\\', '\(', '\)', ' ', ' '],
        (string) $text
    );
}

// Menyusun struktur PDF sederhana dari baris teks laporan.

private function buatPdf($baris)
{
    $halaman = array_chunk(
        $baris,
        46
    );

    $objects = [];
    $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
    $objects[3] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';

    $kids = [];

    foreach ($halaman as $index => $isiHalaman) {
        $pageObject = 4 + ($index * 2);
        $contentObject = $pageObject + 1;
        $kids[] = $pageObject . ' 0 R';

        $content = "BT\n/F1 10 Tf\n50 800 Td\n14 TL\n";

        foreach ($isiHalaman as $line) {
            $content .= '(' . $this->escapePdfText($line) . ") Tj\nT*\n";
        }

        $content .= "ET";

        $objects[$pageObject] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 3 0 R >> >> /Contents ' . $contentObject . ' 0 R >>';
        $objects[$contentObject] = "<< /Length " . strlen($content) . " >>\nstream\n" . $content . "\nendstream";
    }

    $objects[2] = '<< /Type /Pages /Kids [' . implode(' ', $kids) . '] /Count ' . count($halaman) . ' >>';
    ksort($objects);

    $pdf = "%PDF-1.4\n";
    $offsets = [0];

    foreach ($objects as $number => $object) {
        $offsets[$number] = strlen($pdf);
        $pdf .= $number . " 0 obj\n" . $object . "\nendobj\n";
    }

    $xrefPosition = strlen($pdf);
    $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
    $pdf .= "0000000000 65535 f \n";

    for ($i = 1; $i <= count($objects); $i++) {
        $pdf .= str_pad($offsets[$i], 10, '0', STR_PAD_LEFT) . " 00000 n \n";
    }

    $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
    $pdf .= "startxref\n" . $xrefPosition . "\n%%EOF";

    return $pdf;
}

// Membuat response unduhan PDF berdasarkan judul, periode, header, dan baris data.

private function downloadPdf($judul, $periode, $header, $rows, $filename)
{
    $lines = [
        $judul,
        'Periode: ' . $this->labelPeriode($periode),
        'Tanggal Export: ' . now()->format('Y-m-d H:i'),
        '',
        implode(' | ', $header),
        str_repeat('-', 110),
    ];

    foreach ($rows as $row) {
        $line = implode(' | ', $row);

        foreach (str_split($line, 110) as $chunk) {
            $lines[] = $chunk;
        }
    }

    return response(
        $this->buatPdf($lines),
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]
    );
}

// Membuat response unduhan Excel berbasis HTML berdasarkan data laporan.

private function downloadExcel($judul, $periode, $header, $rows, $filename)
{
    $html = '<html><head><meta charset="UTF-8"></head><body>';
    $html .= '<h2>' . e($judul) . '</h2>';
    $html .= '<p>Periode: ' . e($this->labelPeriode($periode)) . '</p>';
    $html .= '<table border="1"><thead><tr>';

    foreach ($header as $item) {
        $html .= '<th>' . e($item) . '</th>';
    }

    $html .= '</tr></thead><tbody>';

    foreach ($rows as $row) {
        $html .= '<tr>';

        foreach ($row as $cell) {
            $html .= '<td>' . e($cell) . '</td>';
        }

        $html .= '</tr>';
    }

    $html .= '</tbody></table></body></html>';

    return response(
        $html,
        200,
        [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]
    );
}

// Mengubah koleksi kegiatan menjadi baris data laporan.

private function rowsKegiatan($kegiatan)
{
    return $kegiatan->map(function ($item) {
        return [
            $item->nama_kegiatan,
            $item->tanggal_selesai,
            $item->jumlah_peserta ?? '-',
            $item->status ?? '-',
            $item->evaluasi && $item->evaluasi !== '-' ? $item->evaluasi : 'Belum diisi',
            'Rp ' . number_format($item->biaya_pendaftaran ?? 0, 0, ',', '.'),
        ];
    })->toArray();
}

// Mengubah koleksi keuangan menjadi baris data laporan.

private function rowsKeuangan($keuangan)
{
    return $keuangan->map(function ($item) {
        return [
            $item->tanggal_transaksi,
            $item->nama_kegiatan,
            ucfirst($item->jenis_transaksi),
            'Rp ' . number_format($item->jumlah ?? 0, 0, ',', '.'),
            $item->keterangan ?? '-',
        ];
    })->toArray();
}

// Mengambil data kegiatan sesuai periode dan mengunduhnya sebagai PDF.

public function exportKegiatanPdf(Request $request)
{
    $periode = $request->get('periode', 'bulan');
    $kegiatan = $this->dataLaporanKegiatan($periode);

    return $this->downloadPdf(
        'Laporan Kegiatan',
        $periode,
        ['Nama Kegiatan', 'Tanggal Selesai', 'Peserta', 'Status', 'Evaluasi', 'Biaya'],
        $this->rowsKegiatan($kegiatan),
        'laporan-kegiatan.pdf'
    );
}

// Mengambil data kegiatan sesuai periode dan mengunduhnya sebagai Excel.

public function exportKegiatanExcel(Request $request)
{
    $periode = $request->get('periode', 'bulan');
    $kegiatan = $this->dataLaporanKegiatan($periode);

    return $this->downloadExcel(
        'Laporan Kegiatan',
        $periode,
        ['Nama Kegiatan', 'Tanggal Selesai', 'Peserta', 'Status', 'Evaluasi', 'Biaya'],
        $this->rowsKegiatan($kegiatan),
        'laporan-kegiatan.xls'
    );
}

// Mengambil data keuangan sesuai periode dan mengunduhnya sebagai PDF.

public function exportKeuanganPdf(Request $request)
{
    $periode = $request->get('periode', 'bulan');
    $keuangan = $this->dataLaporanKeuangan($periode);

    return $this->downloadPdf(
        'Laporan Keuangan',
        $periode,
        ['Tanggal', 'Kegiatan', 'Tipe', 'Nominal', 'Keterangan'],
        $this->rowsKeuangan($keuangan),
        'laporan-keuangan.pdf'
    );
}

// Mengambil data keuangan sesuai periode dan mengunduhnya sebagai Excel.

public function exportKeuanganExcel(Request $request)
{
    $periode = $request->get('periode', 'bulan');
    $keuangan = $this->dataLaporanKeuangan($periode);

    return $this->downloadExcel(
        'Laporan Keuangan',
        $periode,
        ['Tanggal', 'Kegiatan', 'Tipe', 'Nominal', 'Keterangan'],
        $this->rowsKeuangan($keuangan),
        'laporan-keuangan.xls'
    );
}
}
