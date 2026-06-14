@extends('layouts.pengurus')

@section('content')

<h1>Edit Transaksi</h1>

<form method="POST"
      action="/update-transaksi/{{ $transaksi->id_transaksi }}">
    @csrf

    <label>Kegiatan</label>
    <select name="id_kegiatan">
        @foreach($kegiatan as $item)
            <option
                value="{{ $item->id_kegiatan }}"
                {{ $transaksi->id_kegiatan == $item->id_kegiatan ? 'selected' : '' }}>
                {{ $item->nama_kegiatan }}
            </option>
        @endforeach
    </select>

    <label>Jenis</label>
    <select name="jenis_transaksi">
        <option value="Pemasukan"
            {{ $transaksi->jenis_transaksi == 'Pemasukan' ? 'selected' : '' }}>
            Pemasukan
        </option>

        <option value="Pengeluaran"
            {{ $transaksi->jenis_transaksi == 'Pengeluaran' ? 'selected' : '' }}>
            Pengeluaran
        </option>
    </select>

    <label>Jumlah</label>
    <input type="number"
           name="jumlah"
           value="{{ $transaksi->jumlah }}">

    <label>Keterangan</label>
    <input type="text"
           name="keterangan"
           value="{{ $transaksi->keterangan }}">

    <button type="submit">
        Simpan Perubahan
    </button>

</form>

@endsection