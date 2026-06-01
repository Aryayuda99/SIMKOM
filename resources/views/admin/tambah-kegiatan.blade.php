@extends('layouts.admin')

@section('content')

<h1>
    Tambah Kegiatan Baru
</h1>

<p>
    Tambahkan kegiatan untuk organisasi
</p>

<form
    action="/simpan-kegiatan"
    method="POST"
>

    @csrf

    <label>
        Organisasi
    </label>

    <br>

    <select name="id_organisasi">

        @foreach($organisasi as $item)

        <option
            value="{{ $item->id_organisasi }}"
        >
            {{ $item->nama_organisasi }}
        </option>

        @endforeach

    </select>

    <br><br>

    <label>
        Nama Kegiatan
    </label>

    <br>

    <input
        type="text"
        name="nama_kegiatan"
    >

    <br><br>

    <label>
        Deskripsi
    </label>

    <br>

    <textarea
        name="deskripsi"
    ></textarea>

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>

@endsection