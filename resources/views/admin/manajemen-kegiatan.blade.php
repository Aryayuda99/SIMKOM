@extends('layouts.admin')

@section('content')

<h1>
    Manajemen Kegiatan
</h1>

<form method="GET">

    <label>
        Pilih Organisasi
    </label>

    <br>

    <select
        name="id_organisasi"
        onchange="this.form.submit()"
    >

        <option value="">
            Pilih Organisasi
        </option>

        @foreach($organisasi as $org)

        <option
            value="{{ $org->id_organisasi }}"
            {{ request('id_organisasi') == $org->id_organisasi ? 'selected' : '' }}
        >
            {{ $org->nama_organisasi }}
        </option>

        @endforeach

    </select>

</form>

<br>

<a
    href="/tambah-kegiatan?id_organisasi={{ request('id_organisasi') }}"
>
    Tambah Kegiatan
</a>

<br><br>

@if(count($kegiatan) > 0)

<table border="1" cellpadding="10">

    <tr>

        <th>
            Nama Kegiatan
        </th>

        <th>
            Deskripsi
        </th>

        <th>
            Aksi
        </th>

    </tr>

    @foreach($kegiatan as $item)

    <tr>

        <td>
            {{ $item->nama_kegiatan }}
        </td>

        <td>
            {{ $item->deskripsi }}
        </td>

        <td>

            <a
                href="/edit-kegiatan-admin/{{ $item->id_kegiatan }}"
            >
                Edit
            </a>

            |

            <a
                href="/hapus-kegiatan/{{ $item->id_kegiatan }}"
            >
                Hapus
            </a>

        </td>

    </tr>

    @endforeach

</table>

@else

<p>
    Belum ada kegiatan untuk organisasi yang dipilih.
</p>

@endif

@endsection