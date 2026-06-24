{{-- Halaman Edit Kegiatan --}}
@extends('layouts.admin')

@section('title', 'Edit Kegiatan')

{{-- Konten utama halaman Edit Kegiatan --}}

@section('content')
{{-- Form input data --}}
<form class="card modal-page" method="POST" action="/update-kegiatan-admin">
    @csrf
    <input type="hidden" name="id_kegiatan" value="{{ $kegiatan->id_kegiatan }}">
    <h2>Edit Kegiatan</h2>
    <p class="subtitle">Edit nama dan deskripsi kegiatan</p>

    <div class="field" style="margin-top:20px">
        <label>Nama Kegiatan</label>
        <input name="nama_kegiatan" value="{{ $kegiatan->nama_kegiatan }}" required>
    </div>
    <div class="field">
        <label>Deskripsi Kegiatan</label>
        <textarea name="deskripsi" required>{{ $kegiatan->deskripsi }}</textarea>
    </div>
    <div class="grid two">
        <a class="btn" href="/manajemen-kegiatan-admin">Batal</a>
        <button class="primary" type="submit">Simpan Perubahan</button>
    </div>
</form>
@endsection
