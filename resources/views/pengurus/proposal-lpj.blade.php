@extends('layouts.pengurus')

@section('content')

<h1>
    Proposal & LPJ
</h1>

<form
    action="/upload-dokumen"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    <label>
        Kegiatan
    </label>

    <br>

    <select name="id_kegiatan">

        @foreach($kegiatan as $item)

        <option
            value="{{ $item->id_kegiatan }}"
        >
            {{ $item->nama_kegiatan }}
        </option>

        @endforeach

    </select>

    <br><br>

    <label>
        Nama Dokumen
    </label>

    <br>

    <input
        type="text"
        name="nama_dokumen"
    >

    <br><br>

    <label>
        Jenis
    </label>

    <br>

    <select name="jenis">

        <option value="proposal">
            Proposal
        </option>

        <option value="lpj">
            LPJ
        </option>

        <option value="dokumentasi">
            Dokumentasi
        </option>

    </select>

    <br><br>

    <label>
        Deskripsi
    </label>

    <br>

    <input
        type="text"
        name="deskripsi"
    >

    <br><br>

    <input
        type="file"
        name="file_dokumen"
    >

    <br><br>

    <button type="submit">
        Upload
    </button>

</form>

<hr>

<h2>
    Daftar Dokumen
</h2>

@foreach($dokumen as $item)

<div>

    <h3>
        {{ $item->nama_dokumen }}
    </h3>

    <p>
        {{ $item->nama_kegiatan }}
    </p>

    <p>
        {{ $item->jenis }}
    </p>

    <p>
        {{ $item->tanggal_upload }}
    </p>

    <a
        href="{{ asset('uploads/'.$item->file_dokumen) }}"
        target="_blank"
    >
        Download
    </a>

    |

    <a
    href="/hapus-dokumen/{{ $item->id_dokumen }}"
    onclick="
        return confirm(
            'Yakin ingin menghapus dokumen ini?'
        )
    "
>
    Hapus
</a>

</div>

<hr>

@endforeach

@endsection