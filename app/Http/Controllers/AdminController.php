<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

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

public function formEditOrganisasi($id)
{
    $organisasi = DB::table(
        'data_organisasi'
    )
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

public function formTambahOrganisasi()
{
    return view('admin.tambah-ukm');
}

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

public function updateOrganisasi(Request $request)
{
    $request->validate([
        'nama_organisasi' => 'required',
        'periode_kepengurusan' => 'required',
        'visi' => 'required',
        'misi' => 'required'
    ]);

    DB::table('data_organisasi')
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

public function hapusOrganisasi($id)
{
    DB::transaction(function () use ($id) {
        $kegiatanIds = DB::table('kegiatan')
            ->where('id_organisasi', $id)
            ->pluck('id_kegiatan');

        $userIds = collect()
            ->merge(
                DB::table('anggota')
                    ->where('id_organisasi', $id)
                    ->pluck('id_user')
            )
            ->merge(
                DB::table('pengurus')
                    ->where('id_organisasi', $id)
                    ->pluck('id_user')
            )
            ->merge(
                DB::table('pembina')
                    ->where('id_organisasi', $id)
                    ->pluck('id_user')
            )
            ->filter()
            ->unique()
            ->values();

        if ($kegiatanIds->isNotEmpty()) {
            DB::table('keuangan')
                ->whereIn('id_kegiatan', $kegiatanIds)
                ->delete();

            DB::table('dokumen_kegiatan')
                ->whereIn('id_kegiatan', $kegiatanIds)
                ->delete();

            DB::table('pendaftaran_kegiatan')
                ->whereIn('id_kegiatan', $kegiatanIds)
                ->delete();

            DB::table('riwayat_kegiatan')
                ->whereIn('id_kegiatan', $kegiatanIds)
                ->delete();
        }

        DB::table('kegiatan')
            ->where('id_organisasi', $id)
            ->delete();

        DB::table('pendaftaran_anggota_online')
            ->where('id_organisasi', $id)
            ->delete();

        DB::table('anggota')
            ->where('id_organisasi', $id)
            ->delete();

        DB::table('pengurus')
            ->where('id_organisasi', $id)
            ->delete();

        DB::table('pembina')
            ->where('id_organisasi', $id)
            ->delete();

        if ($userIds->isNotEmpty()) {
            DB::table('users')
                ->whereIn('id_user', $userIds)
                ->update([
                    'role' => 'mahasiswa'
                ]);
        }

        DB::table('data_organisasi')
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

public function manajemenAnggota(Request $request)
{
    $organisasi = DB::table(
        'data_organisasi'
    )->get();

    $anggota = [];

    if ($request->id_organisasi)
    {
        $anggota = DB::table('anggota')
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

public function formUbahRole($id)
{
    $user = DB::table('users')
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

public function simpanRole(Request $request)
{
    DB::table('users')
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

public function manajemenKegiatan(Request $request)
{
    $organisasi = DB::table(
        'data_organisasi'
    )->get();

    $kegiatan = [];

    if($request->id_organisasi)
    {
        $kegiatan = DB::table('kegiatan')
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

public function formEditKegiatan($id)
{
    $kegiatan = DB::table('kegiatan')
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

public function updateKegiatan(Request $request)
{
    DB::table('kegiatan')
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

public function hapusKegiatan($id)
{
    DB::table('keuangan')
        ->where('id_kegiatan', $id)
        ->delete();

    DB::table('dokumen_kegiatan')
        ->where('id_kegiatan', $id)
        ->delete();

    DB::table('pendaftaran_kegiatan')
        ->where('id_kegiatan', $id)
        ->delete();

    DB::table('kegiatan')
        ->where('id_kegiatan', $id)
        ->delete();

    return redirect(
        '/manajemen-kegiatan-admin'
    );
}

public function formResetPassword($id)
{
    $user = DB::table('users')
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

public function simpanPassword(Request $request)
{
    DB::table('users')
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
