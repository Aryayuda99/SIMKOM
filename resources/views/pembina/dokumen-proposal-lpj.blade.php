@extends('layouts.pembina')

@section('content')

<h1>
    Dokumen Proposal & LPJ
</h1>

<p>
    Unduh proposal dan LPJ organisasi
</p>

@foreach($dokumen as $item)

<div>

    <p>
        {{ strtoupper($item->jenis) }}
    </p>

    <h3>
        {{ $item->nama_dokumen }}
    </h3>

    <p>
        Organisasi:
        {{ $item->nama_organisasi }}
    </p>

    <p>
        Kegiatan:
        {{ $item->nama_kegiatan }}
    </p>

    <p>
        Tanggal Upload:
        {{ $item->tanggal_upload }}
    </p>

    <a
        href="{{ asset('uploads/'.$item->file_dokumen) }}"
        target="_blank"
    >
        Download
    </a>

</div>

<hr>

@endforeach

@endsection