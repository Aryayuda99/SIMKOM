<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
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
}