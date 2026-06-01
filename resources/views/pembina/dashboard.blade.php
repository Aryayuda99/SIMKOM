@extends('layouts.pembina')

@section('content')

<h1>
    Dashboard Monitoring
</h1>

<p>
    Organisasi:
    {{ $organisasi->nama_organisasi }}
</p>

<hr>

@foreach($kegiatan as $item)

<div>

    <h3>
        {{ $item->nama_kegiatan }}
    </h3>

    <p>
        {{ $item->tanggal_pelaksanaan }}
    </p>

    <p>
        {{ $item->lokasi }}
    </p>

</div>

<hr>

@endforeach

@endsection