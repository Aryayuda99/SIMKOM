<!DOCTYPE html>
<html>
<head>
    <title>Jelajahi Kegiatan</title>
</head>
<body>

<h1>Jelajahi Kegiatan</h1>

<h2>
    Kegiatan Organisasi Saya
</h2>

@foreach($kegiatanOrganisasi as $item)

<div>

    <h3>
        {{ $item->nama_kegiatan }}
    </h3>

        <p>
        Tanggal:
        {{ $item->tanggal_pelaksanaan }}
    </p>

    <p>
        Lokasi:
        {{ $item->lokasi }}
    </p>

    <a
        href="/pendaftaran-kegiatan/{{ $item->id_kegiatan }}"
    >
        <button>
            Daftar Kegiatan
        </button>
    </a>

</div>

<hr>

@endforeach

<hr>

<h2>
    Semua Kegiatan
</h2>

@foreach($semuaKegiatan as $item)

<div>

    <h3>
        {{ $item->nama_kegiatan }}
    </h3>

    <p>
        Organisasi:
        {{ $item->nama_organisasi }}
    </p>

    <p>
        Tanggal:
        {{ $item->tanggal_pelaksanaan }}
    </p>

    <p>
        Lokasi:
        {{ $item->lokasi }}
    </p>

    <a
        href="/pendaftaran-kegiatan/{{ $item->id_kegiatan }}"
    >
        <button>
            Daftar Kegiatan
        </button>
    </a>

</div>

<hr>

@endforeach

</body>
</html>