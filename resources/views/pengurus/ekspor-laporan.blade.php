@extends('layouts.pengurus')

@section('title', 'Ekspor Laporan')

@section('content')
<div class="page-title">
    <div>
        <h1>Ekspor Laporan</h1>
        <p class="subtitle">Generate dan download laporan dalam berbagai format</p>
    </div>
</div>

<h2 style="margin-bottom:18px">Jenis Laporan</h2>
<section class="grid two">
    <article class="card">
        <div class="actions">
            <div class="tile-icon">▣</div>
            <div><h2>Laporan Kegiatan</h2><p class="muted">Ringkasan semua kegiatan organisasi dalam periode tertentu</p></div>
        </div>
        <form method="GET" style="margin-top:20px">
        <div class="field">
            <label>Periode</label>
            <select name="periode">
                <option value="bulan">Bulan Ini</option>
                <option value="tahun">Tahun Ini</option>
            </select>
        </div>
        <div class="grid two">
            <button class="primary" type="submit" formaction="/export-kegiatan-pdf">Export PDF</button>
            <button type="submit" formaction="/export-kegiatan-excel">Export Excel</button>
        </div>
        </form>
    </article>
    <article class="card">
        <div class="actions">
            <div class="tile-icon">▧</div>
            <div><h2>Laporan Keuangan</h2><p class="muted">Rincian pemasukan, pengeluaran, dan saldo keuangan</p></div>
        </div>
        <form method="GET" style="margin-top:20px">
        <div class="field">
            <label>Periode</label>
            <select name="periode">
                <option value="bulan">Bulan Ini</option>
                <option value="tahun">Tahun Ini</option>
            </select>
        </div>
        <div class="grid two">
            <button class="primary" type="submit" formaction="/export-keuangan-pdf">Export PDF</button>
            <button type="submit" formaction="/export-keuangan-excel">Export Excel</button>
        </div>
        </form>
    </article>
</section>

<section class="card">
    <h2>Ringkasan Data</h2>
    <div class="grid three" style="margin-top:18px">
        <div class="tile"><p class="muted">Anggota</p><h2>{{ $anggota->count() }}</h2></div>
        <div class="tile"><p class="muted">Kegiatan</p><h2>{{ $kegiatan->count() }}</h2></div>
        <div class="tile"><p class="muted">Transaksi</p><h2>{{ $keuangan->count() }}</h2></div>
    </div>
</section>
@endsection
