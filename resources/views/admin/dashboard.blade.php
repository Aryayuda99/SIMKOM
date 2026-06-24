{{-- Halaman Dashboard --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

{{-- Konten utama halaman Dashboard --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Dashboard Admin</h1>
        <p class="subtitle">Sistem Informasi Manajemen Kegiatan Organisasi Mahasiswa</p>
    </div>
</div>

{{-- Section informasi halaman --}}

<section class="hero">
    <div class="hero-icon">SI</div>
    <div>
        <h2>Selamat Datang di SIMKOM</h2>
        <p class="subtitle">Sistem manajemen terpadu untuk mengelola organisasi mahasiswa, kegiatan, dan pengguna.</p>
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="grid three">
    <a class="tile" href="/profil-organisasi-admin">
        <div class="tile-icon">🏢</div>
        <div>
            <h3>Manajemen Data Organisasi</h3>
            <p class="muted">Kelola data organisasi mahasiswa</p>
        </div>
    </a>
    <a class="tile" href="/manajemen-anggota-admin">
        <div class="tile-icon">👥</div>
        <div>
            <h3>Manajemen Anggota</h3>
            <p class="muted">Kelola anggota dan role organisasi</p>
        </div>
    </a>
    <a class="tile" href="/manajemen-kegiatan-admin">
        <div class="tile-icon">📅</div>
        <div>
            <h3>Manajemen Kegiatan</h3>
            <p class="muted">Kelola kegiatan per organisasi</p>
        </div>
    </a>
</section>

{{-- Section informasi halaman --}}

<section class="card">
    <h2>Fitur Admin</h2>
    <div class="grid two" style="margin-top:16px">
        <p><span class="blue">•</span> <strong>Manajemen Data Organisasi:</strong> tambah, hapus, edit identitas, periode, visi, dan misi organisasi.</p>
        <p><span class="blue">•</span> <strong>Manajemen Anggota:</strong> pilih organisasi, atur role, dan reset password.</p>
        <p><span class="blue">•</span> <strong>Manajemen Kegiatan:</strong> tambah dan edit kegiatan per organisasi.</p>
    </div>
</section>
@endsection
