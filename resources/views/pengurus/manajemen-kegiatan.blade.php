@extends('layouts.pengurus')

@section('content')

<h1>
    Manajemen Kegiatan
</h1>

<p>
    Kelola kegiatan organisasi
</p>

<hr>

@foreach($kegiatan as $item)

<div
    style="
        border:1px solid #ccc;
        padding:15px;
        margin-bottom:15px;
    "
>

    <h3>
        {{ $item->nama_kegiatan }}
    </h3>

    <p>
        {{ $item->deskripsi }}
    </p>

    <p>
        Tanggal:
        {{ $item->tanggal_pelaksanaan }}
    </p>

    <p>
        Lokasi:
        {{ $item->lokasi }}
    </p>

    <p>
        Kuota:
        {{ $item->kuota_peserta }}
        peserta
    </p>

    <a
        href="/edit-kegiatan/{{ $item->id_kegiatan }}"
    >
        Edit Detail
    </a>

    <a
    href="/selesaikan-kegiatan/{{ $item->id_kegiatan }}"
>
    Tandai Selesai
</a>

</div>

@endforeach

@endsection