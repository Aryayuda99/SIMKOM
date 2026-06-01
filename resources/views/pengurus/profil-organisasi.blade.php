@extends('layouts.pengurus')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Profil Organisasi</title>
</head>
<body>

<h1>Profil Organisasi</h1>

<p>
    Informasi organisasi
</p>

<hr>

<h3>Nama Organisasi</h3>

<p>
    {{ $organisasi->nama_organisasi }}
</p>

<h3>Periode Kepengurusan</h3>

<p>
    {{ $organisasi->periode_kepengurusan }}
</p>

<hr>

<h3>Visi</h3>

<p>
    {{ $organisasi->visi }}
</p>

<hr>

<h3>Misi</h3>

<p>
    {{ $organisasi->misi }}
</p>

</body>
</html>

@endsection

