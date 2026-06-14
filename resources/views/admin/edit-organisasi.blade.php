@extends('layouts.admin')

@section('title', 'Edit Profil Organisasi')

@section('content')
<div class="page-title">
    <div>
        <h1>Profil Organisasi</h1>
        <p class="subtitle">Informasi dan identitas organisasi</p>
    </div>
</div>

<form class="card" method="POST" action="/update-organisasi">
    @csrf
    <input type="hidden" name="id_organisasi" value="{{ $organisasi->id_organisasi }}">
    <div class="split" style="margin-bottom:24px">
        <h2>Informasi Dasar</h2>
        <div class="actions">
            <a class="btn" href="/profil-organisasi-admin">Batal</a>
            <button class="primary" type="submit">Simpan</button>
        </div>
    </div>
    <div class="actions" style="margin-bottom:22px">
        <div class="hero-icon">▤</div>
        <div>
            <p class="muted">Logo Organisasi</p>
            <button type="button">Ganti Logo</button>
            <p class="muted" style="margin-top:6px">PNG, JPG (maks. 2MB)</p>
        </div>
    </div>
    <div class="form-grid">
        <div class="field">
            <label>Nama Organisasi</label>
            <input name="nama_organisasi" value="{{ $organisasi->nama_organisasi }}" required>
        </div>
        <div class="field">
            <label>Periode Kepengurusan</label>
            <input name="periode_kepengurusan" value="{{ $organisasi->periode_kepengurusan }}" required>
        </div>
    </div>
    <div class="field">
        <label>Visi</label>
        <textarea name="visi" required>{{ $organisasi->visi }}</textarea>
    </div>
    <div class="field">
        <label>Misi</label>
        <textarea name="misi" required>{{ $organisasi->misi }}</textarea>
    </div>
</form>
@endsection
