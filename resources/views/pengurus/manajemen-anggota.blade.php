@extends('layouts.pengurus')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Anggota</title>
</head>
<body>
<h2>
    Pendaftaran Anggota
</h2>

<p>
    Daftar calon anggota yang menunggu verifikasi
</p>

<table border="1" cellpadding="10">

    <tr>

        <th>
            Nama
        </th>

        <th>
            NIM
        </th>

        <th>
            Program Studi
        </th>

        <th>
            No HP
        </th>

        <th>
            Kartu Identitas
        </th>

        <th>
            Aksi
        </th>

    </tr>

    @foreach($pendaftaran as $item)

    <tr>

        <td>
            {{ $item->nama }}
        </td>

        <td>
            {{ $item->nim }}
        </td>

        <td>
            {{ $item->program_studi }}
        </td>

        <td>
            {{ $item->no_hp }}
        </td>

        <td>

            <a
                href="{{ asset('uploads/'.$item->kartu_identitas) }}"
                target="_blank"
            >
                Lihat File
            </a>

        </td>

        <td>

            <a
                href="/terima-anggota/{{ $item->id_pendaftaranA }}"
            >
                Terima
            </a>

            |

            <a
                href="/tolak-anggota/{{ $item->id_pendaftaranA }}"
            >
                Tolak
            </a>

        </td>

    </tr>

    @endforeach

</table>

<hr>

<h2>
    Daftar Anggota
</h2>

<p>
    Anggota aktif organisasi
</p>

<table border="1" cellpadding="10">

    <tr>

        <th>
            Nama
        </th>

        <th>
            Program Studi
        </th>

        <th>
            No HP
        </th>

        <th>
            Status
        </th>

        <th>
            Aksi
        </th>  

    </tr>

@foreach($anggota as $item)

<tr>

    <td>
        {{ $item->nama }}
    </td>

    <td>
        {{ $item->program_studi }}
    </td>

    <td>
        {{ $item->no_hp }}
    </td>

    <td>
        {{ $item->status_keanggotaan }}
    </td>

    <td>

        <a
            href="/nonaktifkan-anggota/{{ $item->id_anggota }}"
        >
            Nonaktifkan
        </a>

    </td>

</tr>

@endforeach

</table>

@endsection