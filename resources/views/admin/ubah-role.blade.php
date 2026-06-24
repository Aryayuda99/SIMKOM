{{-- Halaman Ubah Role --}}
@extends('layouts.admin')

@section('title', 'Ubah Role Anggota')

{{-- Konten utama halaman Ubah Role --}}

@section('content')
{{-- Form input data --}}
<form class="card modal-page" method="POST" action="/simpan-role">
    @csrf
    <input type="hidden" name="id_user" value="{{ $user->id_user }}">
    <h2>Ubah Role Anggota</h2>
    <p class="subtitle">Mengubah role akan mempengaruhi hak akses anggota dalam sistem</p>

    <div class="card" style="background:#f9fafb;margin:18px 0">
        <h3>{{ $user->nama ?? $user->name ?? 'Pengguna' }}</h3>
        <p class="muted">{{ $user->email ?? '-' }}</p>
    </div>

    <div class="field">
        <label>Role Baru</label>
        <select name="role">
            {{-- Perulangan data untuk ditampilkan ke pengguna --}}
            @foreach(['admin', 'pengurus', 'pembina', 'anggota', 'mahasiswa'] as $role)
                <option value="{{ $role }}" {{ ($user->role ?? '') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
    </div>

    <div class="notice">
        <p><strong>Catatan:</strong> Perubahan role akan berlaku setelah anggota login ulang ke sistem.</p>
    </div>

    <div class="grid two">
        <a class="btn" href="/manajemen-anggota-admin">Batal</a>
        <button class="primary" type="submit">Simpan</button>
    </div>
</form>
@endsection
