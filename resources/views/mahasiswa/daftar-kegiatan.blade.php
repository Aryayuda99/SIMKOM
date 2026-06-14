@extends('layouts.mahasiswa')

@section('title', 'Pendaftaran Kegiatan')

@section('content')
<div class="page-title">
    <div>
        <h1>Pendaftaran Kegiatan</h1>
        <p class="subtitle">Daftar kegiatan terbuka untuk semua mahasiswa</p>
    </div>
</div>

<section class="notice">
    <div class="hero-icon">✓</div>
    <div>
        <h2>Informasi Penting</h2>
        <p class="subtitle">Pendaftaran online dilakukan melalui platform ini. Konfirmasi dikirim via email.</p>
    </div>
</section>

<section class="grid two">
    @forelse($kegiatan as $item)
        @php
            $kuota = (int) $item->kuota_peserta;
            $terisi = $item->jumlah_peserta;
            $slotTersisa = max($kuota - $terisi, 0);
            $slotPenuh = $kuota <= 0 || $slotTersisa <= 0;
            $persen = $kuota > 0 ? round(($terisi / $kuota) * 100) : 0;
        @endphp
        <article class="card">
            <div class="split">
                <div class="actions">
                    <span class="badge">{{ $item->kategori ?? 'Seminar' }}</span>
                    <span class="badge green">{{ ($item->biaya_pendaftaran ?? 0) > 0 ? 'Rp '.number_format($item->biaya_pendaftaran,0,',','.') : 'Gratis' }}</span>
                </div>
                <span class="badge purple">Sertifikat</span>
            </div>
            <h2 style="margin-top:18px">{{ $item->nama_kegiatan }}</h2>
            <p class="subtitle">{{ $item->deskripsi ?? 'Deskripsi kegiatan' }}</p>
            <div class="meta">
                <span>📅 {{ $item->tanggal_pelaksanaan }}</span>
                <span>📍 {{ $item->lokasi ?? 'Lokasi belum diisi' }}</span>
                <span>👥 Diselenggarakan oleh {{ $item->nama_organisasi }}</span>
            </div>
            <div style="margin-top:18px">
                <div class="split"><span>{{ $terisi }}/{{ $kuota }} peserta</span><span>{{ $slotTersisa }} slot tersisa</span></div>
                <div class="progress" style="margin-top:8px"><span style="width:{{ $persen }}%"></span></div>
            </div>
            @if($slotPenuh)
                <button class="btn" style="width:100%;margin-top:16px" type="button" disabled>Slot Penuh</button>
            @else
                <a class="btn primary" style="width:100%;margin-top:16px" href="/pendaftaran-kegiatan/{{ $item->id_kegiatan }}">Daftar Sekarang</a>
            @endif
        </article>
    @empty
        <section class="card empty"><p>Belum ada kegiatan tersedia.</p></section>
    @endforelse
</section>
@endsection
