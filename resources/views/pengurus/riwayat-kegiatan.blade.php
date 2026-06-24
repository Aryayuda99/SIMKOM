{{-- Halaman Riwayat Kegiatan --}}
@extends('layouts.pengurus')

@section('title', 'Riwayat Kegiatan')

{{-- Konten utama halaman Riwayat Kegiatan --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Riwayat Kegiatan</h1>
        <p class="subtitle">Timeline dan dokumentasi kegiatan yang telah dilaksanakan</p>
    </div>
</div>

{{-- Section informasi halaman --}}

<section class="card">
    <h2>Timeline Kegiatan</h2>
    <p class="subtitle">Riwayat kegiatan yang telah dilaksanakan dengan laporan lengkap</p>
    <div class="list" style="margin-top:24px">
        @forelse($riwayat as $item)
            <article class="list-item">
                <h2>{{ $item->nama_kegiatan }}</h2>
                <div class="meta">
                    <span>Tanggal Selesai<br><strong>{{ $item->tanggal_selesai }}</strong></span>
                    <span>Evaluasi Pembina<br><strong>{{ $item->evaluasi && $item->evaluasi !== '-' ? $item->evaluasi : 'Belum diisi' }}</strong></span>
                </div>
                <p class="subtitle">{{ $item->deskripsi }}</p>
                <div class="grid four" style="margin-top:16px">
                    <span>Peserta<br><strong>{{ $item->jumlah_peserta }}</strong></span>
                    <span>Status<br><strong>{{ $item->status }}</strong></span>
                    <span>Biaya<br><strong>Rp {{ number_format($item->biaya_pendaftaran ?? 0, 0, ',', '.') }}</strong></span>
                </div>
                <div class="actions" style="margin-top:16px">
                    <button>Ekspor Laporan</button>
                </div>
            </article>
        @empty
            <div class="empty"><p>Belum ada riwayat kegiatan.</p></div>
        @endforelse
    </div>
</section>
@endsection
