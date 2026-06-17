@extends('layouts.pembina')

@section('title', 'Dashboard Monitoring')

@section('content')
<div class="page-title">
    <div>
        <h1>Dashboard Monitoring</h1>
        <p class="subtitle">Sistem monitoring kegiatan organisasi mahasiswa</p>
    </div>
</div>

<section class="grid two">
    <div class="card stat">
        <div><p class="muted">Organisasi Binaan</p><div class="stat-value">{{ $organisasi->nama_organisasi ?? '-' }}</div></div>
        <div class="tile-icon">🌟</div>
    </div>
    <div class="card stat">
        <div><p class="muted">Dokumen Tersedia</p><div class="stat-value">{{ $jumlahDokumen }}</div></div>
        <div class="tile-icon">📄</div>
    </div>
</section>

<section class="card">
    <h2>Kegiatan yang terbaru</h2>
    <p class="subtitle">Status kegiatan aktif dari organisasi binaan</p>
    <div class="list" style="margin-top:24px">
        @forelse($kegiatan as $item)
            <article class="list-item">
                <span class="badge green">{{ $organisasi->nama_organisasi ?? 'Organisasi' }}</span>
                <h2 style="margin-top:12px">{{ $item->nama_kegiatan }}</h2>
                <div class="meta">
                    <span>📅 {{ $item->tanggal_pelaksanaan }}</span>
                    <span>📍 {{ $item->lokasi ?? 'Lokasi belum diisi' }}</span>
                    <span>👥 {{ $item->kuota_peserta ?? 0 }} peserta</span>
                </div>
            </article>
        @empty
            <div class="empty"><p>Belum ada kegiatan untuk dimonitor.</p></div>
        @endforelse
    </div>
</section>
@endsection
