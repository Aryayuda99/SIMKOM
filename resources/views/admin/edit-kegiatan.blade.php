@extends('layouts.admin')

@section('content')

<h1>
    Edit Kegiatan
</h1>

<form
    action="/update-kegiatan-admin"
    method="POST"
>

    @csrf

    <input
        type="hidden"
        name="id_kegiatan"
        value="{{ $kegiatan->id_kegiatan }}"
    >

    <input
        type="text"
        name="nama_kegiatan"
        value="{{ $kegiatan->nama_kegiatan }}"
    >

    <br><br>

    <textarea
        name="deskripsi"
    >{{ $kegiatan->deskripsi }}</textarea>

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>

@endsection