@extends('layouts.pengurus')

@section('title', 'Dashboard Pengurus')

@section('content')
<div class="page-title">
    <div>
        <h1>Dashboard Pengurus</h1>
        <p class="subtitle">Selamat datang kembali! Berikut ringkasan organisasi Anda</p>
    </div>
</div>

<section class="grid two">
    <div class="card stat">
        <div><p class="muted">Organisasi</p><div class="stat-value">{{ $pengurus->nama_organisasi ?? 'HIMATIF' }}</div></div>
        <div class="tile-icon">🌟</div>
    </div>
    <div class="card stat">
        <div><p class="muted">Jumlah Kegiatan Aktif</p><div class="stat-value">{{ $kegiatanAktif->count() }}</div></div>
        <div class="tile-icon">🎯</div>
    </div>
</section>

<section class="card">
    <h2>Keuangan Kegiatan Terbaru</h2>
    <p class="subtitle">{{ optional($kegiatanAktif->first())->nama_kegiatan ?? 'Belum ada kegiatan' }}</p>
    <div class="grid three" style="margin-top:24px">
        <div class="notice" style="background:#ecfdf5;border-color:#bbf7d0;margin:0"><div class="tile-icon">🟢</div><div><p class="muted">Pemasukan</p><h3 class="green">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3></div></div>
        <div class="notice" style="background:#fef2f2;border-color:#fecaca;margin:0"><div class="tile-icon">🔴</div><div><p class="muted">Pengeluaran</p><h3 class="red">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3></div></div>
        <div class="notice" style="margin:0"><div class="tile-icon">💰</div><div><p class="muted">Sisa</p><h3 class="blue">Rp {{ number_format($saldo, 0, ',', '.') }}</h3></div></div>
    </div>
</section>

<section class="card">
    <h2>Kegiatan Aktif</h2>
    <p class="subtitle">Daftar kegiatan aktif</p>
    <div class="list" style="margin-top:22px">
        @forelse($kegiatanAktif as $item)
            @php
                $tanggalKosong = empty($item->tanggal_pelaksanaan) || $item->tanggal_pelaksanaan === '1000-01-01';
            @endphp
            <div class="list-item">
                <h3>{{ $item->nama_kegiatan }}</h3>
                <div class="meta">
                    <span>📅 {{ $tanggalKosong ? 'Tanggal belum diisi' : $item->tanggal_pelaksanaan }}</span>
                    <span>📍 {{ $item->lokasi ?? 'Lokasi belum diisi' }}</span>
                    <span>👥 {{ $item->kuota_peserta ? $item->kuota_peserta . ' peserta' : 'Peserta belum diisi' }}</span>
                </div>
            </div>
        @empty
            <div class="empty"><p>Belum ada kegiatan aktif.</p></div>
        @endforelse
    </div>
</section>
@endsection
