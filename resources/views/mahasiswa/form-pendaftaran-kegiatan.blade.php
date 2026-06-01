<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Kegiatan</title>
</head>
<body>

<h1>
    {{ $kegiatan->nama_kegiatan }}
</h1>


<p>
    {{ $kegiatan->deskripsi }}
</p>

<p>
    Tanggal:
    {{ $kegiatan->tanggal_pelaksanaan }}
</p>

<p>
    Lokasi:
    {{ $kegiatan->lokasi }}
</p>

<p>
    Biaya:
    Rp {{ $kegiatan->biaya_pendaftaran }}
</p>

<hr>

<form
    action="/pendaftaran-kegiatan"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    <input
        type="hidden"
        name="id_kegiatan"
        value="{{ $kegiatan->id_kegiatan }}"
    >

    <label>NIM</label>

    <br>

    <input
        type="text"
        name="NIM"
        required
    >

    <br><br>

    <label>Nama</label>

    <br>

    <input
        type="text"
        name="nama"
        required
    >

    <br><br>

    <label>Program Studi</label>

    <br>

    <input
        type="text"
        name="program_studi"
        required
    >

    <br><br>

    <label>Email</label>

    <br>

    <input
        type="email"
        name="email"
        required
    >

    <br><br>

    <label>No HP</label>

    <br>

    <input
        type="text"
        name="no_hp"
        required
    >

    <br><br>

    <label>Bukti Pembayaran</label>

    <br>

    <input
        type="file"
        name="bukti_pembayaran"
        required
    >

    <br><br>

    <button type="submit">
        Daftar Kegiatan
    </button>

</form>

</body>
</html>