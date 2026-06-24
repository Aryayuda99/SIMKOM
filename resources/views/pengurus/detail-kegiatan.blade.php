{{-- Halaman Detail Kegiatan --}}
@extends('layouts.pengurus')

@section('title', 'Detail Kegiatan')

{{-- Konten utama halaman Detail Kegiatan --}}

@section('content')
@php
    $kuota = (int) ($kegiatan->kuota_peserta ?? 0);
    $jumlahPendaftar = $pendaftar->count();
    $slotTersisa = max($kuota - $jumlahPendaftar, 0);
    $persen = $kuota > 0 ? min(round(($jumlahPendaftar / $kuota) * 100), 100) : 0;
    $tanggalKosong = empty($kegiatan->tanggal_pelaksanaan) || $kegiatan->tanggal_pelaksanaan === '1000-01-01';
    $detailKosong = $tanggalKosong && empty($kegiatan->lokasi) && empty($kegiatan->kuota_peserta) && $jumlahPendaftar === 0;
@endphp

<div class="page-title">
    <div>
        <h1>Detail Kegiatan</h1>
        <p class="subtitle">Informasi kegiatan dan daftar peserta yang mendaftar</p>
    </div>
    <div class="actions">
        <a class="btn" href="/manajemen-kegiatan">Kembali</a>
        <a class="btn primary" href="/edit-kegiatan/{{ $kegiatan->id_kegiatan }}">Edit Detail</a>
    </div>
</div>

{{-- Section informasi halaman --}}

<section class="card">
    <div class="split">
        <div class="actions">
            <span class="badge">{{ $kegiatan->kategori ?? 'Kegiatan' }}</span>
            <span class="badge green">
                {{ ($kegiatan->biaya_pendaftaran ?? 0) > 0
                    ? 'Rp '.number_format($kegiatan->biaya_pendaftaran, 0, ',', '.')
                    : 'Gratis' }}
            </span>
        </div>
        {{-- Kondisi tampilan berdasarkan data yang tersedia --}}
        @if(!$detailKosong)
            <a
                class="btn primary"
                href="/selesaikan-kegiatan/{{ $kegiatan->id_kegiatan }}"
                onclick="return confirm('Selesaikan kegiatan ini dan pindahkan ke riwayat?')"
            >
                Selesaikan Kegiatan
            </a>
        @else
            <span class="badge">Belum dijadwalkan</span>
        @endif
    </div>

    <h2 style="margin-top:18px">{{ $kegiatan->nama_kegiatan }}</h2>
    <p class="subtitle">{{ $kegiatan->deskripsi ?? 'Deskripsi kegiatan belum tersedia' }}</p>

    <div class="grid four" style="margin-top:22px">
        <div class="tile" style="min-height:auto">
            <span class="muted">Tanggal</span>
            <h3>{{ $tanggalKosong ? '-' : $kegiatan->tanggal_pelaksanaan }}</h3>
        </div>
        <div class="tile" style="min-height:auto">
            <span class="muted">Lokasi</span>
            <h3>{{ $kegiatan->lokasi ?? '-' }}</h3>
        </div>
        <div class="tile" style="min-height:auto">
            <span class="muted">Organisasi</span>
            <h3>{{ $kegiatan->nama_organisasi ?? '-' }}</h3>
        </div>
        <div class="tile" style="min-height:auto">
            <span class="muted">Kuota</span>
            <h3>{{ $kegiatan->kuota_peserta ? $kuota . ' peserta' : '-' }}</h3>
        </div>
    </div>

    <div style="margin-top:24px">
        <div class="split">
            <span>{{ $kegiatan->kuota_peserta ? $jumlahPendaftar . '/' . $kuota . ' peserta terdaftar' : '-' }}</span>
            <span>{{ $kegiatan->kuota_peserta ? $slotTersisa . ' slot tersisa' : '-' }}</span>
        </div>
        <div class="progress" style="margin-top:8px">
            <span style="width:{{ $persen }}%"></span>
        </div>
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="card">
    <div class="split">
        <div>
            <h2>Daftar Pendaftar</h2>
            <p class="subtitle">Peserta yang sudah mengirim formulir dan bukti pembayaran</p>
        </div>
        <span class="badge blue">{{ $jumlahPendaftar }} pendaftar</span>
    </div>

    <div class="table-wrap" style="margin-top:18px">
        {{-- Tabel data --}}
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Bukti Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pendaftar as $item)
                <tr>
                    <td><strong>{{ $item->nama ?? '-' }}</strong></td>
                    <td>{{ $item->NIM ?? '-' }}</td>
                    <td>{{ $item->program_studi ?? '-' }}</td>
                    <td>{{ $item->email ?? '-' }}</td>
                    <td>{{ $item->no_hp ?? '-' }}</td>
                    <td>
                        {{-- Kondisi tampilan berdasarkan data yang tersedia --}}
                        @if($item->bukti_pembayaran)
                            <a class="btn" href="/uploads/{{ $item->bukti_pembayaran }}" target="_blank">Lihat Bukti</a>
                        @else
                            <span class="muted">Belum ada bukti</span>
                        @endif
                    </td>
                    <td>
                        <a
                            class="btn danger"
                            href="/hapus-peserta-kegiatan/{{ $item->id_pendaftaran }}"
                            onclick="return confirm('Hapus peserta ini dari kegiatan?')"
                        >
                            Hapus Peserta
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="muted">Belum ada peserta yang mendaftar.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
