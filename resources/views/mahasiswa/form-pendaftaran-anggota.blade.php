{{-- Halaman Form Pendaftaran Anggota --}}
@extends('layouts.mahasiswa')

@section('title', 'Formulir Pendaftaran Anggota')

{{-- Konten utama halaman Form Pendaftaran Anggota --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Formulir Pendaftaran Anggota</h1>
        <p class="subtitle">Lengkapi data diri Anda untuk mendaftar</p>
    </div>
    <a class="btn" href="/daftar-anggota">Pilih Organisasi Lain</a>
</div>

{{-- Section informasi halaman --}}

<section class="notice">
    <div class="hero-icon">🌟</div>
    <div>
        <h2>{{ $organisasi->nama_organisasi }}</h2>
        <p class="subtitle">{{ $organisasi->periode_kepengurusan ?? 'Pendaftaran Dibuka' }}</p>
    </div>
</section>

{{-- Form input data --}}

<form class="card" method="POST" action="/pendaftaran-anggota" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_organisasi" value="{{ $organisasi->id_organisasi }}">
    <h2>Data Pribadi</h2>
    <p class="subtitle">Isi semua informasi dengan benar dan lengkap</p>
    <div class="form-grid" style="margin-top:24px">
        <div class="field"><label>Nama Lengkap</label><input name="nama" required placeholder="Nama sesuai KTM"></div>
        <div class="field"><label>NIM</label><input name="nim" required placeholder="Nomor Induk Mahasiswa"></div>
        <div class="field"><label>Program Studi</label><input name="program_studi" required placeholder="Program studi"></div>
        <div class="field"><label>No. Telepon/WhatsApp</label><input name="no_hp" required placeholder="08xxxxxxxxxx"></div>
    </div>
    <label>Upload Foto KTM</label>
    <div class="upload">
        <div>
            <strong>Klik untuk upload atau drag & drop</strong>
            <p>JPG, PNG (Max 2MB)</p>
            <input type="file" name="kartu_identitas" required style="margin-top:12px">
        </div>
    </div>
    <div class="grid two">
        <a class="btn" href="/daftar-anggota">Kembali</a>
        <button class="primary" type="submit">Kirim Pendaftaran</button>
    </div>
</form>

{{-- Section informasi halaman --}}

<section class="notice">
    <div class="hero-icon">✓</div>
    <div>
        <h2>Tahapan Setelah Pendaftaran</h2>
        <p class="subtitle">Tim akan memverifikasi data Anda, lalu menghubungi melalui email.</p>
    </div>
</section>
@endsection
