@extends('layouts.admin')

@section('content')

<h1>
    Ubah Role
</h1>

<form
    action="/simpan-role"
    method="POST"
>

    @csrf

    <input
        type="hidden"
        name="id_user"
        value="{{ $user->id_user }}"
    >

    <p>
        Email:
        {{ $user->email }}
    </p>

    <br>

    <label>
        Role
    </label>

    <br>

    <select
        name="role"
    >

        <option
            value="mahasiswa"
            {{ $user->role == 'mahasiswa' ? 'selected' : '' }}
        >
            Mahasiswa
        </option>

        <option
            value="anggota"
            {{ $user->role == 'anggota' ? 'selected' : '' }}
        >
            Anggota
        </option>

        <option
            value="pengurus"
            {{ $user->role == 'pengurus' ? 'selected' : '' }}
        >
            Pengurus
        </option>

        <option
            value="pembina"
            {{ $user->role == 'pembina' ? 'selected' : '' }}
        >
            Pembina
        </option>

        <option
            value="admin"
            {{ $user->role == 'admin' ? 'selected' : '' }}
        >
            Admin
        </option>

    </select>

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>

@endsection