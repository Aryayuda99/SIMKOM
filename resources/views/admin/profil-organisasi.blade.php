@extends('layouts.admin')

@section('content')

<h1>
    Profil Organisasi
</h1>

<table border="1" cellpadding="10">

    <tr>

        <th>
            Nama Organisasi
        </th>

        <th>
            Periode
        </th>

        <th>
            Aksi
        </th>

    </tr>

    @foreach($organisasi as $item)

    <tr>

        <td>
            {{ $item->nama_organisasi }}
        </td>

        <td>
            {{ $item->periode_kepengurusan }}
        </td>

        <td>

            <a
                href="/edit-organisasi/{{ $item->id_organisasi }}"
            >
                Edit
            </a>

        </td>

    </tr>

    @endforeach

</table>

@endsection