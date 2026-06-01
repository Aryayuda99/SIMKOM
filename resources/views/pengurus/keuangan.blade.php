@extends('layouts.pengurus')

@section('content')

<h1>
    Keuangan
</h1>

<div>

    <h3>
        Total Pemasukan
    </h3>

    <h2 style="color:green">
        Rp {{ number_format($totalPemasukan,0,',','.') }}
    </h2>

</div>

<br>

<div>

    <h3>
        Total Pengeluaran
    </h3>

    <h2 style="color:red">
        Rp {{ number_format($totalPengeluaran,0,',','.') }}
    </h2>

</div>

<br>

<div>

    <h3>
        Saldo
    </h3>

    <h2 style="color:blue">
        Rp {{ number_format($saldo,0,',','.') }}
    </h2>

</div>

<hr>

<p>
    Kelola transaksi keuangan kegiatan
</p>

<hr>

<h2>
    Tambah Transaksi
</h2>

<form
    action="/tambah-transaksi"
    method="POST"
>

    @csrf

    <label>
        Kegiatan
    </label>

    <br>

    <select name="id_kegiatan">

        @foreach($kegiatan as $item)

        <option
            value="{{ $item->id_kegiatan }}"
        >
            {{ $item->nama_kegiatan }}
        </option>

        @endforeach

    </select>

    <br><br>

    <label>
        Jenis Transaksi
    </label>

    <br>

    <select name="jenis_transaksi">

        <option value="pemasukan">
            Pemasukan
        </option>

        <option value="pengeluaran">
            Pengeluaran
        </option>

    </select>

    <br><br>

    <label>
        Jumlah
    </label>

    <br>

    <input
        type="number"
        name="jumlah"
        required
    >

    <br><br>

    <label>
        Keterangan
    </label>

    <br>

    <input
        type="text"
        name="keterangan"
        required
    >

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>

<hr>

<h2>
    Riwayat Transaksi
</h2>

<table border="1" cellpadding="10">

    <tr>

        <th>Kegiatan</th>

        <th>Jenis</th>

        <th>Jumlah</th>

        <th>Tanggal</th>

        <th>Keterangan</th>

    </tr>

    @foreach($transaksi as $item)

    <tr>

        <td>
            {{ $item->nama_kegiatan }}
        </td>

        <td>
            {{ $item->jenis_transaksi }}
        </td>

        <td>
            Rp {{ number_format($item->jumlah,0,',','.') }}
        </td>

        <td>
            {{ $item->tanggal_transaksi }}
        </td>

        <td>
            {{ $item->keterangan }}
        </td>

    </tr>

    @endforeach

</table>

@endsection