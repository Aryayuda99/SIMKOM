{{-- Halaman Manajemen Anggota --}}
@extends('layouts.pengurus')

@section('title', 'Manajemen Anggota')

{{-- Konten utama halaman Manajemen Anggota --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Manajemen Anggota</h1>
        <p class="subtitle">Kelola pendaftaran dan anggota organisasi</p>
    </div>
</div>

{{-- Section informasi halaman --}}

<section class="card">
    <h2>Pendaftaran Anggota</h2>
    <div class="table-wrap" style="margin-top:18px">
        {{-- Tabel data --}}
        <table>
            <thead><tr><th>Nama</th><th>NIM</th><th>Program Studi</th><th>No HP</th><th>Bukti KTM</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($pendaftaran as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->program_studi }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td>
                        {{-- Kondisi tampilan berdasarkan data yang tersedia --}}
                        @if($item->kartu_identitas)
                            <a class="btn" href="/uploads/{{ $item->kartu_identitas }}" target="_blank">Lihat KTM</a>
                        @else
                            <span class="muted">Belum ada bukti</span>
                        @endif
                    </td>
                    <td class="actions">
                        <a class="btn primary" href="/terima-anggota/{{ $item->id_pendaftaranA }}">Terima</a>
                        <a class="btn danger" href="/tolak-anggota/{{ $item->id_pendaftaranA }}">Tolak</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Belum ada pendaftaran baru.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- Section informasi halaman --}}

<section class="card">
    <h2>Daftar Anggota</h2>
    <div class="table-wrap" style="margin-top:18px">
        {{-- Tabel data --}}
        <table>
            <thead><tr><th>Anggota</th><th>NIM</th><th>Program Studi</th><th>No HP</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($anggota as $item)
                <tr>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->program_studi }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td><span class="badge {{ $item->status_keanggotaan === 'aktif' ? 'green' : 'red' }}">{{ $item->status_keanggotaan }}</span></td>
                    <td>
                        {{-- Kondisi tampilan berdasarkan data yang tersedia --}}
                        @if($item->status_keanggotaan === 'aktif')
                            <a class="btn danger" href="/nonaktifkan-anggota/{{ $item->id_anggota }}">Nonaktifkan</a>
                        @else
                            <a class="btn primary" href="/aktifkan-anggota/{{ $item->id_anggota }}">Aktifkan Anggota</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Belum ada anggota.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
