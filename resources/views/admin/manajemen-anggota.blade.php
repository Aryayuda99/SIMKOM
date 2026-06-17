@extends('layouts.admin')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="page-title">
    <div>
        <h1>Manajemen Anggota</h1>
        <p class="subtitle">Kelola anggota per organisasi dan atur role mereka</p>
    </div>
</div>

<section class="card">
    <form method="GET" action="/manajemen-anggota-admin">
        <label>Pilih Organisasi</label>
        <select name="id_organisasi" onchange="this.form.submit()">
            <option value="">Pilih organisasi.</option>
            @foreach($organisasi as $org)
                <option value="{{ $org->id_organisasi }}" {{ request('id_organisasi') == $org->id_organisasi ? 'selected' : '' }}>
                    {{ $org->nama_organisasi }}
                </option>
            @endforeach
        </select>
    </form>
</section>

<section class="card">
    @if(!request('id_organisasi'))
        <div class="empty">
            <div>
                <div class="hero-icon" style="margin:0 auto 16px">🌟</div>
                <h2>Pilih Organisasi</h2>
                <p>Pilih organisasi untuk melihat daftar kegiatan.</p>
            </div>
        </div>
    @else
        <div class="split" style="margin-bottom:18px">
            <div>
                <h2>Daftar Anggota</h2>
                <p class="subtitle">Anggota organisasi terpilih</p>
            </div>
            <input style="max-width:360px" placeholder="Cari nama atau NIM...">
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Program Studi</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($anggota as $item)
                    <tr>
                        <td>
                            <div class="actions">
                                <div class="avatar">{{ strtoupper(substr($item->nama ?? 'AG', 0, 2)) }}</div>
                                <strong>{{ $item->nama }}</strong>
                            </div>
                        </td>
                        <td>{{ $item->program_studi ?? '-' }}</td>
                        <td>{{ $item->no_hp ?? '-' }}</td>
                        <td><span class="badge green">{{ $item->status_keanggotaan ?? 'aktif' }}</span></td>
                        <td class="actions">
                            <a class="btn" href="/ubah-role/{{ $item->id_user }}">Ubah Role</a>
                            <a class="btn" href="/reset-password/{{ $item->id_user }}">Reset Password</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="muted">Belum ada anggota pada organisasi ini.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <p class="subtitle">Menampilkan {{ count($anggota) }} anggota</p>
    @endif
</section>
@endsection
