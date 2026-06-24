{{-- Halaman Profil --}}
@extends('layouts.anggota')

@section('title', 'Profil Saya')

{{-- Konten utama halaman Profil --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Profil Saya</h1>
        <p class="subtitle">Kelola informasi profil dan lihat pencapaian Anda</p>
    </div>
    <button>Edit Profil</button>
</div>

{{-- Section informasi halaman --}}

<section class="card">
    <div class="actions" style="align-items:center;gap:32px">
        <div style="text-align:center">
            <div class="avatar" style="width:130px;height:130px;font-size:34px;margin:auto">AN</div>
            <h2 style="margin-top:14px">{{ $profil->nama }}</h2>
            <span class="badge green">{{ $profil->status_keanggotaan }}</span>
        </div>
        <div>
            <h2>Informasi Pribadi</h2>
            <div class="grid two" style="margin-top:24px">
                <p><span class="muted">Program studi</span><br><strong>{{ $profil->program_studi }}</strong></p>
                <p><span class="muted">No HP</span><br><strong>{{ $profil->no_hp }}</strong></p>
                <p><span class="muted">Organisasi</span><br><strong>{{ $profil->nama_organisasi }}</strong></p>
            </div>
        </div>
    </div>
</section>
@endsection
