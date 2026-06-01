@extends('layouts.admin')

@section('content')

<h1>
    Edit Organisasi
</h1>

<form
    action="/update-organisasi"
    method="POST"
>

    @csrf

    <input
        type="hidden"
        name="id_organisasi"
        value="{{ $organisasi->id_organisasi }}"
    >

    <label>
        Nama Organisasi
    </label>

    <br>

    <input
        type="text"
        name="nama_organisasi"
        value="{{ $organisasi->nama_organisasi }}"
    >

    <br><br>

    <label>
        Periode Kepengurusan
    </label>

    <br>

    <input
        type="text"
        name="periode_kepengurusan"
        value="{{ $organisasi->periode_kepengurusan }}"
    >

    <br><br>

    <label>
        Visi
    </label>

    <br>

    <textarea
        name="visi"
    >{{ $organisasi->visi }}</textarea>

    <br><br>

    <label>
        Misi
    </label>

    <br>

    <textarea
        name="misi"
    >{{ $organisasi->misi }}</textarea>

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>

@endsection