@extends('layouts.anggota')

@section('title', 'Jelajahi Kegiatan')

@section('content')
<div class="page-title">
    <div>
        <h1>Jelajahi Kegiatan</h1>
        <p class="subtitle">Temukan kegiatan organisasi dan kegiatan umum</p>
    </div>
</div>

<section class="card">
    <h2>Kegiatan Organisasi Saya</h2>
    <div class="grid two" style="margin-top:22px">
        @forelse($kegiatanOrganisasi as $item)
            <article class="list-item">
                <h3>{{ $item->nama_kegiatan }}</h3>
                <div class="meta">
                    <span>▣ {{ $item->tanggal_pelaksanaan }}</span>
                    <span>⌖ {{ $item->lokasi ?? '-' }}</span>
                </div>
                <a class="btn primary" style="margin-top:16px" href="/pendaftaran-kegiatan/{{ $item->id_kegiatan }}">Daftar Kegiatan</a>
            </article>
        @empty
            <div class="empty"><p>Belum ada kegiatan organisasi.</p></div>
        @endforelse
    </div>
</section>

<section class="card">
    <h2>Semua Kegiatan</h2>
    <div class="grid two" style="margin-top:22px">
        @forelse($semuaKegiatan as $item)
            <article class="list-item">
                <span class="badge blue">{{ $item->nama_organisasi }}</span>
                <h3 style="margin-top:12px">{{ $item->nama_kegiatan }}</h3>
                <div class="meta">
                    <span>▣ {{ $item->tanggal_pelaksanaan }}</span>
                    <span>⌖ {{ $item->lokasi ?? '-' }}</span>
                </div>
                <a class="btn primary" style="margin-top:16px" href="/pendaftaran-kegiatan/{{ $item->id_kegiatan }}">Daftar Kegiatan</a>
            </article>
        @empty
            <div class="empty"><p>Belum ada kegiatan tersedia.</p></div>
        @endforelse
    </div>
</section>
@endsection
