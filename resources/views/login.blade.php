@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Login SIMKOM</title>
</head>
<body>

<h1>Login SIMKOM</h1>

<form method="POST" action="/login">

    @csrf

    <input
        type="email"
        name="email"
        placeholder="Email"
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password"
    >

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

</body>
</html>
</form>

@endsection