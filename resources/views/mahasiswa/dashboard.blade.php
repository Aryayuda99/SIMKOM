@extends('layouts.mahasiswa')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Mahasiswa</title>
</head>
<body>

<h1>Dashboard Mahasiswa</h1>

<h2>Selamat Datang di SIMKOM</h2>


    <a href="/daftar-anggota">
    <button>
        Daftar Jadi Anggota
    </button>


<a href="/daftar-kegiatan">
    <button>
        Lihat Kegiatan
    </button>
</a>

<hr>

<h2>Organisasi Mahasiswa</h2>

@foreach($organisasi as $item)

    <div>

        <h3>
            {{ $item->nama_organisasi }}
        </h3>

        <a href="/pendaftaran-anggota/{{ $item->id_organisasi }}">
            <button>
                Daftar
            </button>
        </a>

    </div>

@endforeach

<br>

<a href="/daftar-anggota">
    <button>
        Lihat Semua
    </button>
</a>

</body>
</html>

@endsection