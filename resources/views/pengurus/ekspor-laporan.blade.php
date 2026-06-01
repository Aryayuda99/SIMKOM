@extends('layouts.pengurus')

@section('content')

<h1>
    Ekspor Laporan
</h1>

<h2>
    Jenis Laporan
</h2>

<hr>

<div>

    <h3>
        Laporan Kegiatan
    </h3>

    <p>
        Ringkasan semua kegiatan organisasi
    </p>

    <label>
        Periode
    </label>

    <br>

    <select>

        <option>
            Bulan Ini
        </option>

        <option>
            Tahun Ini
        </option>

    </select>

    <br><br>

    <button
        onclick="
        alert('Fitur export PDF belum tersedia')
        "
    >
        Export PDF
    </button>

    <button
        onclick="
        alert('Fitur export Excel belum tersedia')
        "
    >
        Export Excel
    </button>

</div>

<hr>

<div>

    <h3>
        Laporan Keuangan
    </h3>

    <p>
        Rincian pemasukan,
        pengeluaran,
        dan saldo keuangan
    </p>

    <label>
        Periode
    </label>

    <br>

    <select>

        <option>
            Bulan Ini
        </option>

        <option>
            Tahun Ini
        </option>

    </select>

    <br><br>

    <button
        onclick="
        alert('Export PDF berhasil')
        "
    >
        Export PDF
    </button>

    <button
        onclick="
        alert('Export Excel berhasil')
        "
    >
        Export Excel
    </button>

</div>

@endsection