@extends('layouts.pengurus')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="page-title">
    <div>
        <h1>Manajemen Anggota</h1>
        <p class="subtitle">Kelola pendaftaran dan anggota organisasi</p>
    </div>
</div>

<section class="card">
    <h2>Pendaftaran Anggota</h2>
    <div class="table-wrap" style="margin-top:18px">
        <table>
            <thead><tr><th>Nama</th><th>NIM</th><th>Program Studi</th><th>No HP</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($pendaftaran as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->program_studi }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td class="actions">
                        <a class="btn primary" href="/terima-anggota/{{ $item->id_pendaftaranA }}">Terima</a>
                        <a class="btn danger" href="/tolak-anggota/{{ $item->id_pendaftaranA }}">Tolak</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Belum ada pendaftaran baru.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>

<section class="card">
    <h2>Daftar Anggota</h2>
    <div class="table-wrap" style="margin-top:18px">
        <table>
            <thead><tr><th>Anggota</th><th>Program Studi</th><th>No HP</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($anggota as $item)
                <tr>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td>{{ $item->program_studi }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td><span class="badge {{ $item->status_keanggotaan === 'aktif' ? 'green' : 'red' }}">{{ $item->status_keanggotaan }}</span></td>
                    <td><a class="btn danger" href="/nonaktifkan-anggota/{{ $item->id_anggota }}">Nonaktifkan</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Belum ada anggota.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
