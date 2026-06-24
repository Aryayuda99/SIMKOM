{{-- Halaman Dashboard --}}
@extends('layouts.anggota')

@section('title', 'Dashboard Anggota')

{{-- Konten utama halaman Dashboard --}}

@section('content')
{{-- Section informasi halaman --}}
<section class="hero solid">
    <div>
        <h1>Selamat Datang!</h1>
        <p class="subtitle" style="color:#dbeafe">{{ $organisasi->nama_organisasi ?? 'Organisasi Anda' }}</p>
    </div>
    <div class="hero-icon" style="margin-left:auto">◎</div>
</section>

{{-- Section informasi halaman --}}

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

{{-- Section informasi halaman --}}

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
                <p class="meta">📅 {{ $item->tanggal_pelaksanaan ?? '-' }} • 📍 {{ $item->lokasi ?? '-' }}</p>
            </article>
        @empty
            <div class="empty" style="
        grid-column: 1 / -1;
        display:flex;
        justify-content:center;
        align-items:center;
        min-height:300px;
        text-align:center;">
     <p>Belum ada kegiatan yang didaftarkan.</p></div>
        @endforelse
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="notice">
    <div class="hero-icon">✓</div>
    <div>
        <h2>Kegiatan Organisasi</h2>
        <p class="subtitle">Kegiatan yang tampil hanya berasal dari organisasi yang Anda ikuti.</p>
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="grid two">
    @forelse($kegiatan as $item)
        @php
            $kuota = (int) ($item->kuota_peserta ?? 0);
            $terisi = (int) ($item->jumlah_peserta ?? 0);
            $slotTersisa = max($kuota - $terisi, 0);
            $slotPenuh = $kuota <= 0 || $slotTersisa <= 0;
            $persen = $kuota > 0 ? min(round(($terisi / $kuota) * 100), 100) : 0;
        @endphp
        <article class="card">
            <div class="split">
                <div class="actions">
                    <span class="badge">{{ $item->kategori ?? 'Seminar' }}</span>
                    <span class="badge green">
                        {{ ($item->biaya_pendaftaran ?? 0) > 0
                            ? 'Rp '.number_format($item->biaya_pendaftaran,0,',','.')
                            : 'Gratis' }}
                    </span>
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
                <div class="split">
                    <span>{{ $terisi }}/{{ $kuota }} peserta</span>
                    <span>{{ $slotTersisa }} slot tersisa</span>
                </div>
                <div class="progress" style="margin-top:8px">
                    <span style="width:{{ $persen }}%"></span>
                </div>
            </div>

            {{-- Kondisi tampilan berdasarkan data yang tersedia --}}

            @if($slotPenuh)
                <button class="btn" style="width:100%;margin-top:16px" type="button" disabled>Slot Penuh</button>
            @else
                <a class="btn primary" style="width:100%;margin-top:16px" href="/pendaftaran-kegiatan/{{ $item->id_kegiatan }}">Daftar Sekarang</a>
            @endif
        </article>
    @empty
        {{-- Section informasi halaman --}}
        <section class="card empty"><p>Belum ada kegiatan tersedia dari organisasi Anda.</p></section>
    @endforelse
</section>
@endsection
