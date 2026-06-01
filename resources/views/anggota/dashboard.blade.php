<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Anggota</title>
</head>
<body>

<a href="/dashboard-anggota">Beranda</a>

<a href="/anggota/kegiatan">Jelajahi Kegiatan</a>

<a href="/anggota/aktivitas">Aktivitas Saya</a>

<a href="/anggota/profil">Profil Saya</a>

<h1>
    Selamat Datang Anggota
</h1>

<hr>

<h2>
    {{ $organisasi->nama_organisasi }}
</h2>

<h3>Visi</h3>

<p>
    {{ $organisasi->visi }}
</p>

<h3>Misi</h3>

<p>
    {{ $organisasi->misi }}
</p>

<hr>

<h2>
    Kegiatan yang Sudah Didaftar
</h2>

@if($kegiatanDiikuti->count() > 0)

    @foreach($kegiatanDiikuti as $item)

        <div>

            <h3>
                {{ $item->nama_kegiatan }}
            </h3>

            <p>
                Status Pembayaran:
                {{ $item->status_pembayaran }}
            </p>

        </div>

        <hr>

    @endforeach

@else

    <p>
        Belum ada kegiatan yang didaftarkan
    </p>

@endif

<hr>

<h2>
    Kegiatan Tersedia
</h2>

@foreach($kegiatan as $item)

<div>

    <h3>
        {{ $item->nama_kegiatan }}
    </h3>

    <p>
        {{ $item->tanggal_pelaksanaan }}
    </p>

    <p>
        {{ $item->lokasi }}
    </p>

</div>

<hr>

@endforeach

<a href="/daftar-kegiatan">
    <button>
        Lihat Semua
    </button>
</a>


</body>
</html>