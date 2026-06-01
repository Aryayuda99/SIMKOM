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
        <div class="tile-icon">◎</div>
    </div>
    <div class="card stat">
        <div><p class="muted">Jumlah Kegiatan Aktif</p><div class="stat-value">{{ $kegiatanAktif->count() }}</div></div>
        <div class="tile-icon">▣</div>
    </div>
</section>

<section class="card">
    <h2>Keuangan Kegiatan Terbaru</h2>
    <p class="subtitle">{{ optional($kegiatanAktif->first())->nama_kegiatan ?? 'Belum ada kegiatan' }}</p>
    <div class="grid three" style="margin-top:24px">
        <div class="notice" style="background:#ecfdf5;border-color:#bbf7d0;margin:0"><div class="tile-icon">↗</div><div><p class="muted">Pemasukan</p><h3 class="green">Rp 20.000.000</h3></div></div>
        <div class="notice" style="background:#fef2f2;border-color:#fecaca;margin:0"><div class="tile-icon">↘</div><div><p class="muted">Pengeluaran</p><h3 class="red">Rp 15.000.000</h3></div></div>
        <div class="notice" style="margin:0"><div class="tile-icon">↗</div><div><p class="muted">Sisa</p><h3 class="blue">Rp 5.000.000</h3></div></div>
    </div>
</section>

<section class="card">
    <h2>Kegiatan Aktif</h2>
    <p class="subtitle">Daftar kegiatan yang sedang berjalan</p>
    <div class="list" style="margin-top:22px">
        @forelse($kegiatanAktif as $item)
            <div class="list-item">
                <h3>{{ $item->nama_kegiatan }}</h3>
                <p class="meta">▣ {{ $item->tanggal_pelaksanaan }} • {{ $item->lokasi ?? 'Lokasi belum diisi' }}</p>
            </div>
        @empty
            <div class="empty"><p>Belum ada kegiatan aktif.</p></div>
        @endforelse
    </div>
</section>
@endsection
