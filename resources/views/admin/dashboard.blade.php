@extends('layouts.admin')

@section('content')

<h1>
    Dashboard Admin
</h1>

<p>
    Sistem Informasi Manajemen Kegiatan Organisasi Mahasiswa
</p>

<div>

    <h2>
        Selamat Datang di SIMKOM
    </h2>

    <p>
        Sistem manajemen terpadu untuk mengelola
        organisasi mahasiswa, kegiatan, dan pengguna.
        Gunakan menu di sidebar untuk mengakses
        fitur-fitur yang tersedia.
    </p>

</div>

<br>

<div>

    <div>

        <h3>
            Profil Organisasi
        </h3>

        <p>
            Kelola visi dan misi organisasi mahasiswa
        </p>

    </div>

    <br>

    <div>

        <h3>
            Manajemen Anggota
        </h3>

        <p>
            Kelola anggota dan role organisasi
        </p>

    </div>

    <br>

    <div>

        <h3>
            Manajemen Kegiatan
        </h3>

        <p>
            Kelola kegiatan per organisasi
        </p>

    </div>

</div>

<br>

<div>

    <h2>
        Fitur Admin
    </h2>

    <ul>

        <li>
            Profil Organisasi:
            Edit visi dan misi semua organisasi
        </li>

        <li>
            Manajemen Anggota:
            Kelola anggota per organisasi
        </li>

        <li>
            Manajemen Kegiatan:
            Tambah dan edit kegiatan
        </li>

    </ul>

</div>

@endsection