@extends('layouts.pengurus')

@section('content')

<h1>
    Edit Kegiatan
</h1>

<p>
    Atur detail pelaksanaan kegiatan
</p>

<hr>

<h3>
    {{ $kegiatan->nama_kegiatan }}
</h3>

<p>
    {{ $kegiatan->deskripsi }}
</p>

<form
    action="/update-kegiatan"
    method="POST"
>

    @csrf

    <input
        type="hidden"
        name="id_kegiatan"
        value="{{ $kegiatan->id_kegiatan }}"
    >

    <label>
        Tanggal Pelaksanaan
    </label>

    <br>

    <input
        type="date"
        name="tanggal_pelaksanaan"
        value="{{ $kegiatan->tanggal_pelaksanaan }}"
        required
    >

    <br><br>

    <label>
        Lokasi
    </label>

    <br>

    <input
        type="text"
        name="lokasi"
        value="{{ $kegiatan->lokasi }}"
        required
    >

    <br><br>

    <label>
        Kuota Peserta
    </label>

    <br>

    <input
        type="number"
        name="kuota_peserta"
        value="{{ $kegiatan->kuota_peserta }}"
        required
    >

    <br><br>

    <button type="submit">
        Simpan Perubahan
    </button>

</form>

@endsection