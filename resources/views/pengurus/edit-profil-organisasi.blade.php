@extends('layouts.pengurus')

@section('title', 'Edit Profil Organisasi')

@section('content')
<div class="page-title">
    <div>
        <h1>Edit Profil Organisasi</h1>
        <p class="subtitle">Pengurus hanya dapat mengubah informasi dasar organisasi</p>
    </div>
</div>

<form class="card" method="POST" action="/update-profil-organisasi">
    @csrf

    <div class="split" style="margin-bottom:24px">
        <h2>Informasi Dasar</h2>
        <div class="actions">
            <a class="btn" href="/profil-organisasi">Batal</a>
            <button class="primary" type="submit">Simpan</button>
        </div>
    </div>

    <div class="form-grid">
        <div class="field">
            <label>Nama Organisasi</label>
            <input name="nama_organisasi" value="{{ $organisasi->nama_organisasi ?? '' }}" required>
        </div>
        <div class="field">
            <label>Periode Kepengurusan</label>
            <input name="periode_kepengurusan" value="{{ $organisasi->periode_kepengurusan ?? '' }}" required>
        </div>
    </div>

    <section class="notice" style="margin:6px 0 0">
        <div class="hero-icon">Info</div>
        <div>
            <h3>Visi & Misi</h3>
            <p class="subtitle">Visi dan misi hanya dapat diubah oleh Admin.</p>
        </div>
    </section>
</form>
@endsection
