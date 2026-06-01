@extends('layouts.admin')

@section('content')

<h1>
    Reset Password
</h1>

<p>
    {{ $user->email }}
</p>

<form
    action="/simpan-password"
    method="POST"
>

    @csrf

    <input
        type="hidden"
        name="id_user"
        value="{{ $user->id_user }}"
    >

    <label>
        Password Baru
    </label>

    <br>

    <input
        type="text"
        name="password"
        required
    >

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>

@endsection