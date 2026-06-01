@extends('layouts.pengurus')

@section('content')

<h1>
    Riwayat Kegiatan
</h1>

<p>
    Timeline dan dokumentasi kegiatan yang telah dilaksanakan
</p>

<hr>

@foreach($riwayat as $item)

@php

$pemasukan = DB::table('keuangan')
->where(
'id_kegiatan',
$item->id_kegiatan
)
->where(
'jenis_transaksi',
'pemasukan'
)
->sum('jumlah');

$pengeluaran = DB::table('keuangan')
->where(
'id_kegiatan',
$item->id_kegiatan
)
->where(
'jenis_transaksi',
'pengeluaran'
)
->sum('jumlah');

$saldo = $pemasukan - $pengeluaran;

$jumlahPeserta = $item->jumlah_peserta;

$jumlahDokumen = DB::table(
'dokumen_kegiatan'
)
->where(
'id_kegiatan',
$item->id_kegiatan
)
->count();

@endphp

<div
    style="
        border:1px solid #dbeafe;
        border-radius:15px;
        padding:25px;
        margin-bottom:25px;
        background:white;
    "
>

```
<h2>
    {{ $item->nama_kegiatan }}
</h2>

<p>
    {{ $item->tanggal_selesai }}
</p>

<p>
    {{ $item->deskripsi }}
</p>

<p>
    Status :
    {{ $item->status }}
</p>

<p>
    Evaluasi :
    {{ $item->evaluasi }}
</p>

<br>

<table width="100%">

    <tr>

        <td>

            Peserta

            <br>

            <b>
                {{ $jumlahPeserta }}
            </b>

        </td>

        <td>

            Dokumentasi

            <br>

            <b>
                {{ $jumlahDokumen }} file
            </b>

        </td>

        <td>

            Anggaran

            <br>

            <b>
                Rp {{ number_format($item->biaya_pendaftaran) }}
            </b>

        </td>

        <td>

            Saldo

            <br>

            <b>
                Rp {{ number_format($saldo) }}
            </b>

        </td>

    </tr>

</table>

<br>

<div
    style="
        border:1px solid #e5e7eb;
        border-radius:10px;
        padding:20px;
        background:#fafafa;
    "
>

    <h3>
        Ringkasan Keuangan
    </h3>

    <table width="100%">

        <tr>

            <td>

                Pemasukan

                <br>

                <span style="color:green">
                    Rp {{ number_format($pemasukan) }}
                </span>

            </td>

            <td>

                Pengeluaran

                <br>

                <span style="color:red">
                    Rp {{ number_format($pengeluaran) }}
                </span>

            </td>

            <td>

                Sisa

                <br>

                <span style="color:blue">
                    Rp {{ number_format($saldo) }}
                </span>

            </td>

        </tr>

    </table>

</div>

<br>

<button>
    Ekspor Laporan
</button>
```

</div>

@endforeach

@endsection
