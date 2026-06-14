@extends('layouts.admin')

@section('title', 'Tambah UKM')

@section('content')
<div class="page-title">
    <div>
        <h1>Tambah UKM</h1>
        <p class="subtitle">Tambahkan data UKM baru ke sistem</p>
    </div>
</div>

<form class="card" method="POST" action="/simpan-ukm">
    @csrf
    <div class="split" style="margin-bottom:24px">
        <h2>Informasi Dasar</h2>
        <div class="actions">
            <a class="btn" href="/profil-organisasi-admin">Batal</a>
            <button class="green" type="submit">Tambah UKM</button>
        </div>
    </div>
    <div class="form-grid">
        <div class="field">
            <label>Nama UKM</label>
            <input name="nama_organisasi" required placeholder="Contoh: UKM Musik">
        </div>
        <div class="field">
            <label>Periode Kepengurusan</label>
            <input name="periode_kepengurusan" required placeholder="Contoh: 2026/2027">
        </div>
    </div>
    <div class="field">
        <label>Visi</label>
        <textarea name="visi" required placeholder="Visi UKM"></textarea>
    </div>
    <div class="field">
        <label>Misi</label>
        <textarea name="misi" required placeholder="Misi UKM"></textarea>
    </div>
</form>
@endsection
