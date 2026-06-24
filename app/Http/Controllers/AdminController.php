<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan halaman dashboard sesuai peran pengguna dan mengirim data ringkasan ke view.
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Menampilkan profil organisasi dengan data organisasi yang relevan.

    public function profilOrganisasi()
{
    $organisasi = DB::table(
        'data_organisasi'
    )->get();

    return view(
        'admin.profil-organisasi',
        compact('organisasi')
    );
}

// Menampilkan form edit organisasi berdasarkan ID organisasi yang dipilih.

public function formEditOrganisasi($id)
{
    $organisasi = DB::table(
        'data_organisasi'
    )
    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
    ->where(
        'id_organisasi',
        $id
    )
    ->first();

    return view(
        'admin.edit-organisasi',
        compact('organisasi')
    );
}

// Menampilkan form tambah organisasi baru.

public function formTambahOrganisasi()
{
    return view('admin.tambah-ukm');
}

// Memvalidasi input dan menyimpan data organisasi baru ke database.

public function simpanOrganisasi(Request $request)
{
    $request->validate([
        'nama_organisasi' => 'required',
        'periode_kepengurusan' => 'required',
        'visi' => 'required',
        'misi' => 'required'
    ]);

    $organisasi = DB::table(
        'data_organisasi'
    )->select('id_organisasi')->get();

    $nomorTerbesar = 0;

    foreach ($organisasi as $item) {
        $nomor = (int) preg_replace(
            '/\D/',
            '',
            $item->id_organisasi
        );

        if ($nomor > $nomorTerbesar) {
            $nomorTerbesar = $nomor;
        }
    }

    $idBaru =
        'O' .
        str_pad(
            $nomorTerbesar + 1,
            2,
            '0',
            STR_PAD_LEFT
        );

    // Mengakses tabel data_organisasi untuk informasi profil organisasi.
    DB::table('data_organisasi')
        ->insert([

            'id_organisasi'
                => $idBaru,

            'nama_organisasi'
                => $request->nama_organisasi,

            'periode_kepengurusan'
                => $request->periode_kepengurusan,

            'visi'
                => $request->visi,

            'misi'
                => $request->misi

        ]);

    return redirect(
        '/profil-organisasi-admin'
    )->with(
        'success',
        'UKM berhasil ditambahkan'
    );
}

// Memvalidasi input dan memperbarui data organisasi pada database.

public function updateOrganisasi(Request $request)
{
    $request->validate([
        'nama_organisasi' => 'required',
        'periode_kepengurusan' => 'required',
        'visi' => 'required',
        'misi' => 'required'
    ]);

    // Mengakses tabel data_organisasi untuk informasi profil organisasi.
    DB::table('data_organisasi')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_organisasi',
            $request->id_organisasi
        )
        ->update([

            'nama_organisasi'
                => $request->nama_organisasi,

            'periode_kepengurusan'
                => $request->periode_kepengurusan,

            'visi'
                => $request->visi,

            'misi'
                => $request->misi

        ]);

    return redirect(
        '/profil-organisasi-admin'
    );
}

// Menghapus organisasi beserta data terkait tanpa menyisakan relasi utama.

public function hapusOrganisasi($id)
{
    DB::transaction(function () use ($id) {
        // Mengakses tabel kegiatan untuk data kegiatan organisasi.
        $kegiatanIds = DB::table('kegiatan')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('id_organisasi', $id)
            ->pluck('id_kegiatan');

        $userIds = collect()
            ->merge(
                // Mengakses tabel anggota untuk data keanggotaan organisasi.
                DB::table('anggota')
                    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                    ->where('id_organisasi', $id)
                    ->pluck('id_user')
            )
            ->merge(
                // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
                DB::table('pengurus')
                    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                    ->where('id_organisasi', $id)
                    ->pluck('id_user')
            )
            ->merge(
                // Mengakses tabel pembina untuk menentukan organisasi yang dibina user.
                DB::table('pembina')
                    // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                    ->where('id_organisasi', $id)
                    ->pluck('id_user')
            )
            ->filter()
            ->unique()
            ->values();

        if ($kegiatanIds->isNotEmpty()) {
            // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
            DB::table('keuangan')
                // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                ->whereIn('id_kegiatan', $kegiatanIds)
                ->delete();

            // Mengakses tabel dokumen_kegiatan untuk metadata dokumen kegiatan.
            DB::table('dokumen_kegiatan')
                // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                ->whereIn('id_kegiatan', $kegiatanIds)
                ->delete();

            // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
            DB::table('pendaftaran_kegiatan')
                // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                ->whereIn('id_kegiatan', $kegiatanIds)
                ->delete();

            // Mengakses tabel riwayat_kegiatan untuk data kegiatan yang sudah selesai.
            DB::table('riwayat_kegiatan')
                // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                ->whereIn('id_kegiatan', $kegiatanIds)
                ->delete();
        }

        // Mengakses tabel kegiatan untuk data kegiatan organisasi.
        DB::table('kegiatan')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('id_organisasi', $id)
            ->delete();

        // Mengakses tabel pendaftaran_anggota_online untuk data calon anggota.
        DB::table('pendaftaran_anggota_online')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('id_organisasi', $id)
            ->delete();

        // Mengakses tabel anggota untuk data keanggotaan organisasi.
        DB::table('anggota')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('id_organisasi', $id)
            ->delete();

        // Mengakses tabel pengurus untuk menentukan organisasi yang dikelola user.
        DB::table('pengurus')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('id_organisasi', $id)
            ->delete();

        // Mengakses tabel pembina untuk menentukan organisasi yang dibina user.
        DB::table('pembina')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('id_organisasi', $id)
            ->delete();

        if ($userIds->isNotEmpty()) {
            // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
            DB::table('users')
                // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
                ->whereIn('id_user', $userIds)
                ->update([
                    'role' => 'mahasiswa'
                ]);
        }

        // Mengakses tabel data_organisasi untuk informasi profil organisasi.
        DB::table('data_organisasi')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('id_organisasi', $id)
            ->delete();
    });

    return redirect(
        '/profil-organisasi-admin'
    )->with(
        'success',
        'Organisasi berhasil dihapus'
    );
}

// Menampilkan data anggota atau pendaftaran anggota untuk kebutuhan manajemen.

public function manajemenAnggota(Request $request)
{
    $organisasi = DB::table(
        'data_organisasi'
    )->get();

    $anggota = [];

    if ($request->id_organisasi)
    {
        // Mengakses tabel anggota untuk data keanggotaan organisasi.
        $anggota = DB::table('anggota')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where(
                'id_organisasi',
                $request->id_organisasi
            )
            ->get();
    }

    return view(
        'admin.manajemen-anggota',
        compact(
            'organisasi',
            'anggota'
        )
    );
}

// Menampilkan form perubahan role pengguna berdasarkan ID user.

public function formUbahRole($id)
{
    // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
    $user = DB::table('users')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            $id
        )
        ->first();

    return view(
        'admin.ubah-role',
        compact('user')
    );
}

// Menyimpan perubahan role pengguna ke tabel users.

public function simpanRole(Request $request)
{
    // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
    DB::table('users')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            $request->id_user
        )
        ->update([

            'role'
                => $request->role

        ]);

    return redirect(
        '/manajemen-anggota-admin'
    );
}

// Menampilkan daftar kegiatan sesuai organisasi yang sedang dikelola.

public function manajemenKegiatan(Request $request)
{
    $organisasi = DB::table(
        'data_organisasi'
    )->get();

    $kegiatan = [];

    if($request->id_organisasi)
    {
        // Mengakses tabel kegiatan untuk data kegiatan organisasi.
        $kegiatan = DB::table('kegiatan')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where(
                'id_organisasi',
                $request->id_organisasi
            )
            ->get();
    }

    return view(
        'admin.manajemen-kegiatan',
        compact(
            'organisasi',
            'kegiatan'
        )
    );
}

// Menampilkan form tambah kegiatan dan data organisasi pendukung.

public function formTambahKegiatan()
{
    $organisasi = DB::table(
        'data_organisasi'
    )->get();

    return view(
        'admin.tambah-kegiatan',
        compact('organisasi')
    );
}

// Menyimpan data kegiatan baru ke database.

public function simpanKegiatan(Request $request)
{
    $jumlah = DB::table(
        'kegiatan'
    )->count();

    $idBaru =
        'K' .
        str_pad(
            $jumlah + 1,
            2,
            '0',
            STR_PAD_LEFT
        );

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    DB::table('kegiatan')
        ->insert([

            'id_kegiatan'
                => $idBaru,

            'id_organisasi'
                => $request->id_organisasi,

            'nama_kegiatan'
                => $request->nama_kegiatan,

            'deskripsi'
                => $request->deskripsi,

            'tanggal_pelaksanaan'
                => now(),

            'kuota_peserta'
                => 0

        ]);

    return redirect(
        '/manajemen-kegiatan-admin'
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
        'admin.edit-kegiatan',
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

            'nama_kegiatan'
                => $request->nama_kegiatan,

            'deskripsi'
                => $request->deskripsi

        ]);

    return redirect(
        '/manajemen-kegiatan-admin'
    );
}

// Menghapus kegiatan beserta data pendukung yang berkaitan.

public function hapusKegiatan($id)
{
    // Mengakses tabel keuangan untuk data transaksi pemasukan dan pengeluaran.
    DB::table('keuangan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_kegiatan', $id)
        ->delete();

    // Mengakses tabel dokumen_kegiatan untuk metadata dokumen kegiatan.
    DB::table('dokumen_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_kegiatan', $id)
        ->delete();

    // Mengakses tabel pendaftaran_kegiatan untuk data peserta kegiatan.
    DB::table('pendaftaran_kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_kegiatan', $id)
        ->delete();

    // Mengakses tabel kegiatan untuk data kegiatan organisasi.
    DB::table('kegiatan')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where('id_kegiatan', $id)
        ->delete();

    return redirect(
        '/manajemen-kegiatan-admin'
    );
}

// Menampilkan form reset password pengguna.

public function formResetPassword($id)
{
    // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
    $user = DB::table('users')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            $id
        )
        ->first();

    return view(
        'admin.reset-password',
        compact('user')
    );
}

// Menyimpan password baru pengguna ke tabel users.

public function simpanPassword(Request $request)
{
    // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
    DB::table('users')
        // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
        ->where(
            'id_user',
            $request->id_user
        )
        ->update([

            'password'
                => $request->password

        ]);

    return redirect(
        '/manajemen-anggota'
    )->with(
        'success',
        'Password berhasil direset'
    );
}
}
