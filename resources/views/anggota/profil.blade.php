<!DOCTYPE html>
<html>
<head>
    <title>Profil Anggota</title>
</head>
<body>

<h1>Profil Anggota</h1>

<p>
    Nama:
    {{ $profil->nama }}
</p>

<p>
    Program Studi:
    {{ $profil->program_studi }}
</p>

<p>
    No HP:
    {{ $profil->no_hp }}
</p>

<p>
    Organisasi:
    {{ $profil->nama_organisasi }}
</p>

<p>
    Status:
    {{ $profil->status_keanggotaan }}
</p>

</body>
</html>