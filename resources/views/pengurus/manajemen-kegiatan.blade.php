{{-- Halaman Manajemen Kegiatan --}}
@extends('layouts.pengurus')

@section('title', 'Manajemen Kegiatan')

{{-- Konten utama halaman Manajemen Kegiatan --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Manajemen Kegiatan</h1>
        <p class="subtitle">Kelola jadwal dan detail kegiatan organisasi</p>
    </div>
</div>

{{-- Section informasi halaman --}}

<section class="notice">
    <div class="hero-icon">Edit</div>
    <div>
        <h2>Hak Akses Pengurus</h2>
        <p class="subtitle">Sebagai pengurus, Anda dapat mengedit tanggal, waktu, lokasi, dan jumlah peserta kegiatan.</p>
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="grid three">
    @forelse($kegiatan as $item)
        @php
            $tanggalKosong = empty($item->tanggal_pelaksanaan) || $item->tanggal_pelaksanaan === '1000-01-01';
        @endphp
        <article class="tile" style="align-content:start">
            <div class="split">
                <h2>{{ $item->nama_kegiatan }}</h2>
            </div>
            <p class="muted">{{ $item->deskripsi ?? 'Deskripsi kegiatan belum tersedia' }}</p>
            <div class="meta" style="display:grid;gap:12px">
                <span>📅 Tanggal: {{ $tanggalKosong ? 'Tanggal belum diisi' : $item->tanggal_pelaksanaan }}</span>
                <span>📍 Lokasi: {{ $item->lokasi ?? 'Lokasi belum diisi' }}</span>
                <span>👥 Peserta: {{ $item->kuota_peserta ? $item->kuota_peserta . ' peserta' : 'Peserta belum diisi' }}</span>
                <span>💰 Biaya: {{ ($item->biaya_pendaftaran ?? 0) > 0 ? 'Rp '.number_format($item->biaya_pendaftaran, 0, ',', '.') : 'Gratis' }}</span>
            </div>
            <div class="actions" style="margin-top:18px">
                <a class="btn primary" href="/detail-kegiatan/{{ $item->id_kegiatan }}">Lihat Detail</a>
                <a class="btn" href="/edit-kegiatan/{{ $item->id_kegiatan }}">Edit Detail</a>
            </div>
        </article>
    @empty
        {{-- Section informasi halaman --}}
        <section class="card empty"><p>Belum ada kegiatan.</p></section>
    @endforelse
</section>
@endsection
