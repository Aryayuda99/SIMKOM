@extends('layouts.pembina')

@section('title', 'Dokumen Proposal & LPJ')

@section('content')
<div class="page-title">
    <div>
        <h1>Dokumen Proposal & LPJ</h1>
        <p class="subtitle">Unduh proposal dan LPJ organisasi</p>
    </div>
</div>

<section class="card">
    <h2>Daftar Dokumen</h2>
    <p class="subtitle">Proposal dan LPJ yang tersedia untuk diunduh</p>
    <div class="list" style="margin-top:24px">
        @forelse($dokumen as $item)
            <article class="list-item split">
                <div>
                    <div class="actions">
                        <span class="badge">{{ $item->jenis }}</span>
                        <span class="badge blue">{{ $item->nama_organisasi }}</span>
                    </div>
                    <h2 style="margin-top:12px">{{ $item->nama_dokumen }}</h2>
                    <div class="meta">
                        <span>Kegiatan<br><strong>{{ $item->nama_kegiatan }}</strong></span>
                        <span>Tanggal Upload<br><strong>{{ $item->tanggal_upload }}</strong></span>
                    </div>
                </div>
                <a class="btn primary" href="/uploads/{{ $item->file_dokumen }}" target="_blank">Download</a>
            </article>
        @empty
            <div class="empty"><p>Belum ada dokumen.</p></div>
        @endforelse
    </div>
</section>
@endsection
