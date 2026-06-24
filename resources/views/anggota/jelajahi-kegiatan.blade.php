{{-- Halaman Jelajahi Kegiatan --}}
@extends('layouts.anggota')

@section('title', 'Jelajahi Kegiatan')

{{-- Konten utama halaman Jelajahi Kegiatan --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Jelajahi Kegiatan</h1>
        <p class="subtitle">Temukan kegiatan organisasi dan kegiatan umum</p>
    </div>
</div>

{{-- Section informasi halaman --}}

<section class="notice">
    <div class="hero-icon">Info</div>
    <div>
        <h2>Informasi Kegiatan</h2>
        <p class="subtitle">
            Jelajahi berbagai kegiatan organisasi mahasiswa dan daftarkan diri Anda secara online.
        </p>
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="card">
    <h2>Kegiatan Organisasi Saya</h2>

    <div class="grid two" style="margin-top:22px">
        @forelse($kegiatanOrganisasi as $item)
            @include('anggota.partials.kartu-kegiatan', ['item' => $item, 'label' => 'Seminar'])
        @empty
            {{-- Section informasi halaman --}}
            <section class="card empty">
                <p>Belum ada kegiatan organisasi.</p>
            </section>
        @endforelse
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="card">
    <h2>Semua Kegiatan</h2>

    <div class="grid two" style="margin-top:22px">
        @forelse($semuaKegiatan as $item)
            @include('anggota.partials.kartu-kegiatan', ['item' => $item, 'label' => $item->nama_organisasi])
        @empty
            {{-- Section informasi halaman --}}
            <section class="card empty">
                <p>Belum ada kegiatan tersedia.</p>
            </section>
        @endforelse
    </div>
</section>
@endsection
