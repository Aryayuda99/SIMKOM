{{-- Halaman Tambah Kegiatan --}}
@extends('layouts.admin')

@section('title', 'Tambah Kegiatan')

{{-- Konten utama halaman Tambah Kegiatan --}}

@section('content')
{{-- Form input data --}}
<form class="card modal-page" method="POST" action="/simpan-kegiatan">
    @csrf
    <h2>Tambah Kegiatan Baru</h2>
    <p class="subtitle">Tambahkan kegiatan untuk organisasi terpilih</p>

    <div class="field" style="margin-top:20px">
        <label>Organisasi</label>
        <select name="id_organisasi" required>
            {{-- Perulangan data untuk ditampilkan ke pengguna --}}
            @foreach($organisasi as $item)
                <option value="{{ $item->id_organisasi }}">{{ $item->nama_organisasi }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Nama Kegiatan</label>
        <input name="nama_kegiatan" required placeholder="Contoh: Workshop UI/UX Design">
    </div>
    <div class="field">
        <label>Deskripsi Kegiatan</label>
        <textarea name="deskripsi" required placeholder="Deskripsi singkat kegiatan"></textarea>
    </div>
    <div class="grid two">
        <a class="btn" href="/manajemen-kegiatan-admin">Batal</a>
        <button class="green" type="submit">Tambah Kegiatan</button>
    </div>
</form>
@endsection
