{{-- Halaman Profil Organisasi --}}
@extends('layouts.pengurus')

@section('title', 'Profil Organisasi')

{{-- Konten utama halaman Profil Organisasi --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Profil Organisasi</h1>
        <p class="subtitle">Informasi dan identitas organisasi</p>
    </div>
    <a class="btn primary" href="/edit-profil-organisasi">Edit Profil</a>
</div>

{{-- Section informasi halaman --}}

<section class="card">
    <h2>Informasi Dasar</h2>
    <div class="actions" style="margin-top:28px;align-items:flex-start">
        <div class="hero-icon">🌟</div>
        <div class="grid" style="gap:28px">
            <div>
                <p class="muted">Nama Organisasi</p>
                <h3>{{ $organisasi->nama_organisasi ?? '-' }}</h3>
            </div>
            <div>
                <p class="muted">Periode Kepengurusan</p>
                <h3>{{ $organisasi->periode_kepengurusan ?? '-' }}</h3>
            </div>
        </div>
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="card">
    <div class="split">
        <h2>Visi & Misi</h2>
        <span class="badge">Hanya dapat diubah Admin</span>
    </div>
    <div style="margin-top:28px">
        <h3>Visi</h3>
        <p class="subtitle">{{ $organisasi->visi ?? 'Visi belum tersedia.' }}</p>
    </div>
    <div style="margin-top:24px">
        <h3>Misi</h3>
        <p class="subtitle">{{ $organisasi->misi ?? 'Misi belum tersedia.' }}</p>
    </div>
</section>
@endsection
