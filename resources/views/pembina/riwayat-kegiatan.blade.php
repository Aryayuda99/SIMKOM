@extends('layouts.pembina')

@section('content')

<h1>
    Riwayat Kegiatan
</h1>

<p>
    Daftar kegiatan yang telah selesai dilaksanakan
</p>

@foreach($kegiatan as $item)

@php

$peserta = DB::table('pendaftaran_kegiatan')
    ->where(
        'id_kegiatan',
        $item->id_kegiatan
    )
    ->count();

@endphp

<div>

    <p>
        {{ $item->nama_organisasi }}
    </p>

    <h2>
        {{ $item->nama_kegiatan }}
    </h2>

    <div>

        <div>

            <p>
                Tanggal
            </p>

            <strong>
                {{ $item->tanggal_pelaksanaan }}
            </strong>

        </div>

        <div>

            <p>
                Peserta
            </p>

            <strong>
                {{ $peserta }} orang
            </strong>

        </div>

    </div>

</div>

<hr>

@endforeach

@endsection