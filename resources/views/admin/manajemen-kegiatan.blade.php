@extends('layouts.admin')

@section('title', 'Manajemen Kegiatan')

@section('content')
<div class="page-title">
    <div>
        <h1>Manajemen Kegiatan</h1>
        <p class="subtitle">Kelola kegiatan per organisasi</p>
    </div>
    <a class="btn green" href="/tambah-kegiatan">+ Tambah Kegiatan</a>
</div>

<section class="card">
    <form method="GET" action="/manajemen-kegiatan-admin">
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
        <div class="list">
            @forelse($kegiatan as $item)
                <div class="list-item split">
                    <div>
                        <h3>{{ $item->nama_kegiatan }}</h3>
                        <p class="subtitle">{{ $item->deskripsi ?? 'Deskripsi kegiatan belum tersedia' }}</p>
                    </div>
                    <div class="actions">
                        <a class="btn" href="/edit-kegiatan-admin/{{ $item->id_kegiatan }}">Edit</a>
                        <a class="btn danger" href="/hapus-kegiatan/{{ $item->id_kegiatan }}" onclick="return confirm('Hapus kegiatan ini?')">Hapus</a>
                    </div>
                </div>
            @empty
                <div class="empty"><p>Belum ada kegiatan pada organisasi ini.</p></div>
            @endforelse
        </div>
    @endif
</section>
@endsection
