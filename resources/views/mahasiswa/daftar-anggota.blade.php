@extends('layouts.mahasiswa')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Anggota</title>
</head>
<body>

@if(session('success'))

<script>
    alert("{{ session('success') }}");
</script>

@endif

<h1>Daftar Organisasi</h1>

@foreach($organisasi as $item)

<div>

    <h2>
        {{ $item->nama_organisasi }}
    </h2>

    <p>
        {{ $item->visi }}
    </p>

    <a href="/pendaftaran-anggota/{{ $item->id_organisasi }}">
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