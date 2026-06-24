{{-- Halaman Aktivitas Saya --}}
@extends('layouts.anggota')

@section('title', 'Aktivitas Saya')

{{-- Konten utama halaman Aktivitas Saya --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Aktivitas Saya</h1>
        <p class="subtitle">Riwayat kegiatan yang telah Anda ikuti</p>
    </div>
</div>

{{-- Section informasi halaman --}}

<section class="card">
    <h2>Kegiatan yang Dihadiri</h2>
    <p class="subtitle">Daftar kegiatan yang telah Anda ikuti dan hadiri</p>
    <div class="list" style="margin-top:24px">
        @forelse($aktivitas as $item)
            <article class="list-item">
                <div class="actions">
                    <span class="badge">Kegiatan</span>
                </div>
                <h2 style="margin-top:12px">{{ $item->nama_kegiatan }}</h2>
                <div class="meta">
                    <span>▣ {{ $item->tanggal_pelaksanaan }}</span>
                    <span>⌖ {{ $item->lokasi }}</span>
                </div>
                <div class="actions" style="border-top:1px solid var(--line);margin-top:16px;padding-top:14px">
                    <a class="btn" href="/uploads/{{ $item->bukti_pembayaran }}" target="_blank">Lihat Bukti</a>
                    <button type="button">Download Sertifikat</button>
                </div>
            </article>
        @empty
            <div class="empty"><p>Belum ada aktivitas.</p></div>
        @endforelse
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="notice">
    <div class="hero-icon">✓</div>
    <div>
        <h2>Informasi Kegiatan</h2>
        <p class="subtitle">Sertifikat tersedia untuk kegiatan tertentu yang Anda hadiri.</p>
    </div>
</section>
@endsection
