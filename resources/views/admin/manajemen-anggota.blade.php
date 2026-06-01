@extends('layouts.admin')

@section('content')

<h1>
    Manajemen Anggota
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

        @foreach($organisasi as $item)

        <option
            value="{{ $item->id_organisasi }}"
        >
            {{ $item->nama_organisasi }}
        </option>

        @endforeach

    </select>

    @if(count($anggota) > 0)

<table border="1" cellpadding="10">

    <tr>

        <th>Nama</th>

        <th>Program Studi</th>

        <th>No HP</th>

        <th>Status</th>

        <th>Role</th>

        <th>Aksi</th>

    </tr>

    @foreach($anggota as $item)

    @php

    $user = DB::table('users')
        ->where(
            'id_user',
            $item->id_user
        )
        ->first();

    @endphp

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
            {{ $user->role ?? '-' }}
        </td>

        <td>

            <a
                href="/ubah-role/{{ $item->id_user }}"
            >
                Ubah Role
            </a>

            |

            <a
                href="/nonaktifkan-anggota/{{ $item->id_user }}"
            >
                Nonaktifkan
            </a>

        </td>

    </tr>

    @endforeach

</table>

@endif

</form>

@endsection