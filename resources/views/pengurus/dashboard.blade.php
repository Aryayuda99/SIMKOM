@extends('layouts.pengurus')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pengurus</title>
</head>
<body>

<h1>
    Dashboard Pengurus
</h1>

<hr>

<h2>
    {{ $pengurus->nama_organisasi }}
</h2>

<p>
    Jabatan:
    {{ $pengurus->jabatan }}
</p>

<hr>

<h2>
    Kegiatan Aktif
</h2>

<p>
    Daftar kegiatan organisasi
</p>

@foreach($kegiatanAktif as $item)

<div>

    <h3>
        {{ $item->nama_kegiatan }}
    </h3>

    <p>
        Tanggal:
        {{ $item->tanggal_pelaksanaan }}
    </p>

    <p>
        Lokasi:
        {{ $item->lokasi }}
    </p>

</div>

<hr>

@endforeach

</body>
</html>

@endsection