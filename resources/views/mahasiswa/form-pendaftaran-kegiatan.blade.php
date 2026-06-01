@extends('layouts.mahasiswa')

@section('title', 'Formulir Pendaftaran Kegiatan')

@section('content')
<form class="card modal-page" method="POST" action="/pendaftaran-kegiatan" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_kegiatan" value="{{ $kegiatan->id_kegiatan }}">
    <h2>Pendaftaran Kegiatan</h2>
    <p class="subtitle">Isi formulir di bawah untuk mendaftar ke kegiatan ini</p>

    <div class="notice" style="margin-top:20px">
        <div>
            <h3>{{ $kegiatan->nama_kegiatan }}</h3>
            <p class="subtitle">{{ $kegiatan->tanggal_pelaksanaan }} • {{ $kegiatan->lokasi ?? 'Lokasi belum diisi' }}</p>
        </div>
    </div>

    <div class="field"><label>Nama Lengkap</label><input name="nama" required placeholder="Nama sesuai identitas"></div>
    <div class="field"><label>NIM</label><input name="NIM" required placeholder="Nomor Induk Mahasiswa"></div>
    <div class="field"><label>Email</label><input type="email" name="email" required placeholder="email@student.edu"></div>
    <div class="field"><label>Program Studi</label><input name="program_studi" required placeholder="Pilih program studi"></div>
    <div class="field"><label>No. WhatsApp</label><input name="no_hp" required placeholder="08xxxxxxxxxx"></div>
    <div class="field"><label>Bukti Pembayaran</label><input type="file" name="bukti_pembayaran" required></div>

    <div class="grid two">
        <a class="btn" href="/daftar-kegiatan">Batal</a>
        <button class="primary" type="submit">Kirim Pendaftaran</button>
    </div>
</form>
@endsection
