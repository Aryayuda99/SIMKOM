{{-- Halaman Keuangan --}}
@extends('layouts.pengurus')

@section('title', 'Manajemen Keuangan')

{{-- Konten utama halaman Keuangan --}}

@section('content')
<div class="page-title">
    <div>
        <h1>Manajemen Keuangan</h1>
        <p class="subtitle">Kelola pemasukan dan pengeluaran organisasi</p>
    </div>
    <a class="btn primary" href="#tambah-transaksi">+ Tambah Transaksi</a>
</div>

{{-- Section informasi halaman --}}

<section class="grid three">
    <div class="card stat"><div><p class="muted">Total Pemasukan</p><div class="stat-value green">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div></div><div class="tile-icon">🟢</div></div>
    <div class="card stat"><div><p class="muted">Total Pengeluaran</p><div class="stat-value red">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div></div><div class="tile-icon">🔴</div></div>
    <div class="card stat"><div><p class="muted">Saldo</p><div class="stat-value blue">Rp {{ number_format($saldo, 0, ',', '.') }}</div></div><div class="tile-icon">💰</div></div>
</section>

{{-- Section informasi halaman --}}

<section class="card">
    <div class="split" style="margin-bottom:18px">
        <div>
            <h2>Riwayat Transaksi</h2>
            <p class="subtitle">Daftar transaksi keuangan organisasi</p>
        </div>
        <button>Export</button>
    </div>

    <form method="GET" action="/keuangan" class="filter-grid" style="margin-bottom:18px">
        <div class="field" style="margin-bottom:0">
            <label>Bulan</label>
            <select name="bulan">
                <option value="">Semua Bulan</option>
                @foreach($namaBulan as $angkaBulan => $bulan)
                    <option value="{{ $angkaBulan }}" {{ (string) $filter['bulan'] === (string) $angkaBulan ? 'selected' : '' }}>
                        {{ $bulan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field" style="margin-bottom:0">
            <label>Tahun</label>
            <select name="tahun">
                <option value="">Semua Tahun</option>
                @foreach($tahunTransaksi as $tahun)
                    <option value="{{ $tahun }}" {{ (string) $filter['tahun'] === (string) $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field" style="margin-bottom:0">
            <label>Kegiatan</label>
            <select name="id_kegiatan">
                <option value="">Semua Kegiatan</option>
                @foreach($kegiatan as $item)
                    <option value="{{ $item->id_kegiatan }}" {{ (string) $filter['id_kegiatan'] === (string) $item->id_kegiatan ? 'selected' : '' }}>
                        {{ $item->nama_kegiatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field" style="margin-bottom:0; align-self:end">
            <button class="primary" type="submit" style="width:100%">Filter</button>
        </div>

        <div class="field" style="margin-bottom:0; align-self:end">
            <a class="btn" href="/keuangan" style="width:100%">Reset</a>
        </div>
    </form>

    <div class="table-wrap">
        {{-- Tabel data --}}
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Tipe</th>
                    <th>Nominal</th>
                    <th>Sumber</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($transaksi as $item)
                <tr>
                    <td>{{ $item->tanggal_transaksi }}</td>

                    <td>{{ $item->keterangan }}</td>

                    <td>
                        <span class="badge {{ $item->jenis_transaksi === 'pemasukan' ? 'green' : 'red' }}">
                            {{ ucfirst($item->jenis_transaksi) }}
                        </span>
                    </td>

                    <td class="{{ $item->jenis_transaksi === 'pemasukan' ? 'green' : 'red' }}">
                        <strong>
                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                        </strong>
                    </td>

                    <td>{{ $item->nama_kegiatan }}</td>

                    <td>
                        <a href="/edit-transaksi/{{ $item->id_transaksi }}"
                           class="btn">
                            Edit
                        </a>

                        <a href="/hapus-transaksi/{{ $item->id_transaksi }}"
                           class="btn danger"
                           onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="muted">
                        Belum ada transaksi.
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</section>

{{-- Form input data --}}

<form id="tambah-transaksi" class="card" method="POST" action="/tambah-transaksi">
    @csrf
    <h2>Tambah Transaksi</h2>
    <p class="subtitle">Input data transaksi keuangan</p>
    <div class="form-grid" style="margin-top:20px">
        <div class="field">
            <label>Kegiatan</label>
            <select name="id_kegiatan" required>
                {{-- Perulangan data untuk ditampilkan ke pengguna --}}
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
