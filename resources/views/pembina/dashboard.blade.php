@extends('layouts.pembina')

@section('content')

<h1>
    Dashboard Monitoring
</h1>

<p>
    Organisasi yang dibina
</p>

<hr>

<h2>
    {{ $organisasi->nama_organisasi }}
</h2>

<br>

<table border="1" cellpadding="15">

    <tr>

        <td>

            <b>
                Jumlah Kegiatan
            </b>

            <br>

            {{ $jumlahKegiatan }}

        </td>

        <td>

            <b>
                Jumlah Dokumen
            </b>

            <br>

            {{ $jumlahDokumen }}

        </td>

    </tr>

</table>

<br>

<h2>
    Kegiatan Terbaru
</h2>

<table border="1" cellpadding="10">

    <tr>

        <th>
            Nama Kegiatan
        </th>

        <th>
            Tanggal
        </th>

    </tr>

    @foreach($kegiatan as $item)

    <tr>

        <td>
            {{ $item->nama_kegiatan }}
        </td>

        <td>
            {{ $item->tanggal_pelaksanaan }}
        </td>

    </tr>

    @endforeach

</table>

@endsection