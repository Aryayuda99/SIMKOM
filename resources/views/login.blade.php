@extends('layouts.app')

@section('title', 'Login SIMKOM')

@section('content')
<main class="login-wrap">
    <section class="login-card">
        <div class="brand" style="border:0;padding:0;margin-bottom:28px">
            <div class="brand-icon">SI</div>
            <div>
                <strong>SIMKOM</strong>
                <span>Sistem Informasi Manajemen Kegiatan Organisasi Mahasiswa</span>
            </div>
        </div>

        <h1>Masuk</h1>
        <p class="subtitle">Gunakan akun sesuai role Anda untuk membuka dashboard.</p>

        <form method="POST" action="/login" style="margin-top:28px">
            @csrf
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" placeholder="email@kampus.ac.id" required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button class="primary" style="width:100%" type="submit">Login</button>
        </form>
    </section>
</main>
@endsection
