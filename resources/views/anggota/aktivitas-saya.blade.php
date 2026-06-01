<!DOCTYPE html>
<html>
<head>
    <title>Aktivitas Saya</title>
</head>
<body>

<h1>
    Aktivitas Saya
</h1>

@foreach($aktivitas as $item)

<div>

    <h2>
        {{ $item->nama_kegiatan }}
    </h2>

    <p>
        Tanggal:
        {{ $item->tanggal_pelaksanaan }}
    </p>

    <p>
        Lokasi:
        {{ $item->lokasi }}
    </p>

    <p>
        Status Pembayaran:
        {{ $item->status_pembayaran }}
    </p>

    <p>

    Bukti Pembayaran:

    <a
        href="/uploads/{{ $item->bukti_pembayaran }}"
        target="_blank"
    >
        Lihat Bukti
    </a>

</p>

</div>

<hr>

@endforeach

</body>
</html>