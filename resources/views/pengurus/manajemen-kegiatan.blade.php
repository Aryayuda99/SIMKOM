@extends('layouts.pengurus')

@section('title', 'Manajemen Kegiatan')

@section('content')
<div class="page-title">
    <div>
        <h1>Manajemen Kegiatan</h1>
        <p class="subtitle">Kelola jadwal dan detail kegiatan organisasi</p>
    </div>
</div>

<section class="notice">
    <div class="hero-icon">✎</div>
    <div>
        <h2>Hak Akses Pengurus</h2>
        <p class="subtitle">Sebagai pengurus, Anda dapat mengedit tanggal, waktu, lokasi, dan jumlah peserta kegiatan.</p>
    </div>
</section>

<section class="grid three">
    @forelse($kegiatan as $item)
        <article class="tile" style="align-content:start">
            <div class="split">
                <h2>{{ $item->nama_kegiatan }}</h2>
                @if(($item->status ?? '') === 'Selesai')
                    <span class="badge">Selesai</span>
                @endif
            </div>
            <p class="muted">{{ $item->deskripsi ?? 'Deskripsi kegiatan belum tersedia' }}</p>
            <div class="meta">
                <span>▣ {{ $item->tanggal_pelaksanaan ?? '-' }}</span>
                <span>⌖ {{ $item->lokasi ?? 'Lokasi belum diisi' }}</span>
                <span>◎ {{ $item->kuota_peserta ?? 0 }} peserta</span>
            </div>
            <a class="btn" href="/edit-kegiatan/{{ $item->id_kegiatan }}">Edit Detail</a>
        </article>
    @empty
        <section class="card empty"><p>Belum ada kegiatan.</p></section>
    @endforelse
</section>
@endsection
