@extends('layouts.mahasiswa')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kegiatan</title>
</head>
<body>

@if(session('success'))

<script>
    alert("{{ session('success') }}");
</script>

@endif

<h1>Daftar Kegiatan</h1>

@foreach($kegiatan as $item)

<div>

    <h2>
        {{ $item->nama_kegiatan }}
    </h2>

    <p>
        Penyelenggara:
        {{ $item->nama_organisasi }}
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
        {{ $item->deskripsi }}
    </p>

    <p>
        Biaya:
        Rp {{ $item->biaya_pendaftaran }}
    </p>

    <a href="/pendaftaran-kegiatan/{{ $item->id_kegiatan }}">
        <button>
            Daftar Sekarang
        </button>
    </a>

</div>

<hr>

@endforeach

</body>
</html>

@endsection