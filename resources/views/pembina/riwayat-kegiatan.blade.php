{{-- Halaman Riwayat Kegiatan --}}
@extends('layouts.pembina')

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
    {{-- Kondisi tampilan berdasarkan data yang tersedia --}}
    @if(session('success'))
        <div class="notice" style="background:#ecfdf5;border-color:#bbf7d0;margin-top:18px">{{ session('success') }}</div>
    @endif
    {{-- Kondisi tampilan berdasarkan data yang tersedia --}}
    @if(session('error'))
        <div class="notice" style="background:#fef2f2;border-color:#fecaca;margin-top:18px">{{ session('error') }}</div>
    @endif
    {{-- Kondisi tampilan berdasarkan data yang tersedia --}}
    @if($errors->any())
        <div class="notice" style="background:#fef2f2;border-color:#fecaca;margin-top:18px">{{ $errors->first() }}</div>
    @endif
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
                {{-- Form input data --}}
                <form method="POST" action="/riwayat-kegiatan-pembina/evaluasi/{{ $item->id_riwayat }}" style="margin-top:16px">
                    @csrf
                    <label for="evaluasi-{{ $item->id_riwayat }}">Evaluasi Pembina</label>
                    <textarea id="evaluasi-{{ $item->id_riwayat }}" name="evaluasi" required placeholder="Tulis evaluasi kegiatan">{{ $item->evaluasi && $item->evaluasi !== '-' ? $item->evaluasi : '' }}</textarea>
                    <div class="actions" style="margin-top:12px">
                        <button class="primary" type="submit">Simpan Evaluasi</button>
                    </div>
                </form>
            </article>
        @empty
            <div class="empty"><p>Belum ada riwayat kegiatan.</p></div>
        @endforelse
    </div>
</section>
@endsection
