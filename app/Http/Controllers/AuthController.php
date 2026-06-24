<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    // Memvalidasi kredensial login, mengambil data user, menyimpan session, dan mengarahkan sesuai role.
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Mengakses tabel users untuk data akun, role, dan autentikasi pengguna.
        $user = DB::table('users')
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('email', $request->email)
            // Filter digunakan untuk membatasi data sesuai kondisi yang dibutuhkan.
            ->where('password', $request->password)
            ->first();


        if (!$user) {

            return back()
                ->with('error', 'Email atau password salah');

        }

//===============PENGECEKAN ROLE==============================//
        session([
    'id_user' => $user->id_user,
    'role' => $user->role
]);

if ($request->has('remember')) {
    Cookie::queue('simkom_remember_email', $request->email, 60 * 24 * 30);
} else {
    Cookie::queue(Cookie::forget('simkom_remember_email'));
}

if ($user->role == 'mahasiswa') {

    return redirect('/dashboard-mahasiswa');

}

if ($user->role == 'anggota') {

    return redirect('/dashboard-anggota');

}

if ($user->role == 'pengurus') {

    return redirect('/dashboard-pengurus');

}

if ($user->role == 'pembina') {

    return redirect('/dashboard-pembina');

}

if ($user->role == 'admin') {

    return redirect('/dashboard-admin');

}
}

    // Menghapus session pengguna dan mengarahkan kembali ke halaman login.

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
