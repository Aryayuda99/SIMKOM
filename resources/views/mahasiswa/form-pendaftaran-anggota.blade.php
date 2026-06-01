<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Anggota</title>
</head>
<body>

<h1>
    Pendaftaran
    {{ $organisasi->nama_organisasi }}
</h1>

<form
    action="/pendaftaran-anggota"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    <input
        type="hidden"
        name="id_organisasi"
        value="{{ $organisasi->id_organisasi }}"
    >

    <input
        type="text"
        name="nim"
        placeholder="NIM"
        required
    >

    <br><br>

    <input
        type="text"
        name="nama"
        placeholder="Nama"
        required
    >

    <br><br>

    <input
        type="text"
        name="program_studi"
        placeholder="Program Studi"
        required
    >

    <br><br>

    <input
        type="text"
        name="no_hp"
        placeholder="No HP"
        required
    >

    <br><br>

    <input
        type="file"
        name="kartu_identitas"
        required
    >

    <br><br>

    <button type="submit">
        Daftar
    </button>

</form>

</body>
</html>