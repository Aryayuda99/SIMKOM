@extends('layouts.pembina')

@section('title', 'Riwayat Kegiatan')

@section('content')
<div class="page-title">
    <div>
        <h1>Riwayat Kegiatan</h1>
        <p class="subtitle">Daftar kegiatan yang telah selesai dilaksanakan</p>
    </div>
</div>

<section class="card">
    <h2>Daftar Kegiatan</h2>
    <p class="subtitle">Kegiatan yang sudah selesai dilaksanakan</p>
    <div class="list" style="margin-top:24px">
        @forelse($kegiatan as $item)
            <article class="list-item">
                <span class="badge">{{ $item->nama_organisasi }}</span>
                <h2 style="margin-top:12px">{{ $item->nama_kegiatan }}</h2>
                <div class="grid two" style="margin-top:16px">
                    <p><span class="muted">Tanggal</span><br>{{ $item->tanggal_pelaksanaan }}</p>
                    <p><span class="muted">Peserta</span><br>{{ $item->kuota_peserta ?? 0 }} orang</p>
                </div>
            </article>
        @empty
            <div class="empty"><p>Belum ada riwayat kegiatan.</p></div>
        @endforelse
    </div>
</section>
@endsection
