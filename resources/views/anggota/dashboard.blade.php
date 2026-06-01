@extends('layouts.anggota')

@section('title', 'Dashboard Anggota')

@section('content')
<section class="hero solid">
    <div>
        <h1>Selamat Datang!</h1>
        <p class="subtitle" style="color:#dbeafe">{{ $organisasi->nama_organisasi ?? 'Organisasi Anda' }}</p>
    </div>
    <div class="hero-icon" style="margin-left:auto">◎</div>
</section>

<section class="card">
    <h2>Visi & Misi Organisasi</h2>
    <div style="margin-top:28px">
        <h3>Visi</h3>
        <p class="subtitle">{{ $organisasi->visi ?? 'Visi belum tersedia.' }}</p>
    </div>
    <div style="margin-top:22px">
        <h3>Misi</h3>
        <p class="subtitle">{{ $organisasi->misi ?? 'Misi belum tersedia.' }}</p>
    </div>
</section>

<section class="card">
    <div class="split">
        <div>
            <h2>Kegiatan Sudah Didaftar</h2>
            <p class="subtitle">Kegiatan yang telah Anda daftarkan</p>
        </div>
        <a class="btn" href="/anggota/aktivitas">Lihat Semua</a>
    </div>
    <div class="grid two" style="margin-top:24px">
        @forelse($kegiatanDiikuti as $item)
            <article class="list-item">
                <span class="badge green">Terdaftar</span>
                <h3 style="margin-top:12px">{{ $item->nama_kegiatan }}</h3>
                <p class="meta">▣ {{ $item->tanggal_pelaksanaan ?? '-' }} • {{ $item->lokasi ?? '-' }}</p>
                <p class="subtitle">Status pembayaran: {{ $item->status_pembayaran }}</p>
            </article>
        @empty
            <div class="empty"><p>Belum ada kegiatan yang didaftarkan.</p></div>
        @endforelse
    </div>
</section>

<section class="card">
    <div class="split">
        <div>
            <h2>Kegiatan Tersedia</h2>
            <p class="subtitle">Kegiatan organisasi yang dapat Anda ikuti</p>
        </div>
        <a class="btn" href="/anggota/kegiatan">Lihat Semua</a>
    </div>
    <div class="grid two" style="margin-top:24px">
        @forelse($kegiatan as $item)
            <article class="list-item">
                <span class="badge blue">Tersedia</span>
                <h3 style="margin-top:12px">{{ $item->nama_kegiatan }}</h3>
                <div class="meta">
                    <span>▣ {{ $item->tanggal_pelaksanaan }}</span>
                    <span>⌖ {{ $item->lokasi ?? '-' }}</span>
                </div>
            </article>
        @empty
            <div class="empty"><p>Belum ada kegiatan tersedia.</p></div>
        @endforelse
    </div>
</section>
@endsection
