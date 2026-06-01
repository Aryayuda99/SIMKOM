@extends('layouts.pengurus')

@section('title', 'Manajemen Keuangan')

@section('content')
<div class="page-title">
    <div>
        <h1>Manajemen Keuangan</h1>
        <p class="subtitle">Kelola pemasukan dan pengeluaran organisasi</p>
    </div>
    <a class="btn primary" href="#tambah-transaksi">+ Tambah Transaksi</a>
</div>

<section class="grid three">
    <div class="card stat"><div><p class="muted">Total Pemasukan</p><div class="stat-value green">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div></div><div class="tile-icon">↗</div></div>
    <div class="card stat"><div><p class="muted">Total Pengeluaran</p><div class="stat-value red">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div></div><div class="tile-icon">↘</div></div>
    <div class="card stat"><div><p class="muted">Saldo</p><div class="stat-value blue">Rp {{ number_format($saldo, 0, ',', '.') }}</div></div><div class="tile-icon">▨</div></div>
</section>

<section class="card">
    <div class="split" style="margin-bottom:18px">
        <div>
            <h2>Riwayat Transaksi</h2>
            <p class="subtitle">Daftar transaksi keuangan organisasi</p>
        </div>
        <button>Export</button>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Tanggal</th><th>Deskripsi</th><th>Tipe</th><th>Nominal</th><th>Sumber</th></tr></thead>
            <tbody>
            @forelse($transaksi as $item)
                <tr>
                    <td>{{ $item->tanggal_transaksi }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td><span class="badge {{ $item->jenis_transaksi === 'pemasukan' ? 'green' : 'red' }}">{{ ucfirst($item->jenis_transaksi) }}</span></td>
                    <td class="{{ $item->jenis_transaksi === 'pemasukan' ? 'green' : 'red' }}"><strong>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</strong></td>
                    <td>{{ $item->nama_kegiatan }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>

<form id="tambah-transaksi" class="card" method="POST" action="/tambah-transaksi">
    @csrf
    <h2>Tambah Transaksi</h2>
    <p class="subtitle">Input data transaksi keuangan</p>
    <div class="form-grid" style="margin-top:20px">
        <div class="field">
            <label>Kegiatan</label>
            <select name="id_kegiatan" required>
                @foreach($kegiatan as $item)
                    <option value="{{ $item->id_kegiatan }}">{{ $item->nama_kegiatan }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Tipe Transaksi</label>
            <select name="jenis_transaksi" required>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
        </div>
        <div class="field">
            <label>Nominal</label>
            <input type="number" name="jumlah" required placeholder="0">
        </div>
        <div class="field">
            <label>Deskripsi</label>
            <input name="keterangan" required placeholder="Keterangan transaksi">
        </div>
    </div>
    <button class="primary" type="submit">Simpan</button>
</form>
@endsection
