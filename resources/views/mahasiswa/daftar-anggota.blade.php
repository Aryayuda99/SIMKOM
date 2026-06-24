{{-- Halaman Daftar Anggota --}}
@extends('layouts.mahasiswa')

@section('title', 'Pendaftaran Anggota')

{{-- Konten utama halaman Daftar Anggota --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Pendaftaran Anggota</h1>
        <p class="subtitle">Pilih organisasi yang ingin Anda ikuti</p>
    </div>
</div>

{{-- Section informasi halaman --}}

<section class="notice">
    <div class="hero-icon">✓</div>
    <div>
        <h2>Persyaratan Pendaftaran</h2>
        <p class="subtitle">Mahasiswa aktif, mengisi formulir lengkap, dan bersedia mengikuti kegiatan organisasi.</p>
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="grid three">
    @forelse($organisasi as $item)
        <article class="tile" style="min-height:250px">
            <div class="tile-icon">🌟</div>
            <h2>{{ $item->nama_organisasi }}</h2>
            <p class="muted">{{ $item->visi ?? 'Organisasi mahasiswa' }}</p>
            <a class="btn primary" href="/pendaftaran-anggota/{{ $item->id_organisasi }}">Daftar Sekarang</a>
        </article>
    @empty
        {{-- Section informasi halaman --}}
        <section class="card empty"><p>Belum ada organisasi.</p></section>
    @endforelse
</section>
@endsection
