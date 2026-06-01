@extends('layouts.admin')

@section('title', 'Reset Password')

@section('content')
<form class="card modal-page" method="POST" action="/simpan-password">
    @csrf
    <input type="hidden" name="id_user" value="{{ $user->id_user }}">
    <h2>Reset Password</h2>
    <p class="subtitle">Password baru akan disimpan untuk pengguna ini</p>

    <div class="card" style="background:#f9fafb;margin:18px 0">
        <h3>{{ $user->nama ?? $user->name ?? 'Pengguna' }}</h3>
        <p class="muted">{{ $user->email ?? '-' }}</p>
    </div>

    <div class="field">
        <label>Password Baru</label>
        <input type="password" name="password" required placeholder="Masukkan password baru">
    </div>

    <div class="notice" style="background:var(--yellow-soft);border-color:#fde68a">
        <p>Password baru akan menggantikan password lama pengguna.</p>
    </div>

    <div class="grid two">
        <a class="btn" href="/manajemen-anggota-admin">Batal</a>
        <button class="primary" type="submit">Reset Password</button>
    </div>
</form>
@endsection
