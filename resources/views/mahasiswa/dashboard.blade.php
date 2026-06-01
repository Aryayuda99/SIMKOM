@extends('layouts.mahasiswa')

@section('title', 'Beranda Mahasiswa')

@section('content')
<section class="hero solid">
    <div>
        <h1>Selamat Datang di SIMKOM</h1>
        <p class="subtitle" style="color:#dbeafe">Platform terpadu untuk bergabung dengan organisasi mahasiswa dan mengikuti berbagai kegiatan menarik</p>
        <div class="actions" style="margin-top:24px">
            <a class="btn" href="/daftar-anggota">Daftar Jadi Anggota</a>
            <a class="btn" href="/daftar-kegiatan">Lihat Kegiatan</a>
        </div>
    </div>
</section>

<section class="card">
    <div class="split">
        <div>
            <h2>Organisasi Mahasiswa</h2>
            <p class="subtitle">Pilih organisasi yang sesuai dengan minat Anda</p>
        </div>
        <a class="btn" href="/daftar-anggota">Lihat Semua</a>
    </div>
    <div class="grid three" style="margin-top:28px">
        @forelse($organisasi as $item)
            <a class="tile" href="/pendaftaran-anggota/{{ $item->id_organisasi }}">
                <div class="tile-icon">◎</div>
                <h3>{{ $item->nama_organisasi }}</h3>
                <strong>daftar</strong>
            </a>
        @empty
            <div class="empty"><p>Belum ada organisasi.</p></div>
        @endforelse
    </div>
</section>

<section class="card">
    <h2>Keuntungan Bergabung</h2>
    <p class="subtitle">Manfaat yang Anda dapatkan dengan bergabung</p>
    <div class="grid three" style="margin-top:28px;text-align:center">
        <div class="tile"><div class="tile-icon" style="margin:auto">◎</div><h3>Networking</h3><p class="muted">Bangun koneksi dengan mahasiswa lain</p></div>
        <div class="tile"><div class="tile-icon" style="margin:auto">↗</div><h3>Pengembangan Skill</h3><p class="muted">Ikuti workshop dan pelatihan</p></div>
        <div class="tile"><div class="tile-icon" style="margin:auto">✓</div><h3>Sertifikat</h3><p class="muted">Dapatkan sertifikat kegiatan</p></div>
    </div>
</section>

<section class="notice">
    <div class="hero-icon">i</div>
    <div>
        <h2>Informasi Pendaftaran</h2>
        <p class="subtitle">Pendaftaran anggota gratis dan terbuka sepanjang tahun. Kegiatan dapat diikuti oleh anggota maupun non-anggota.</p>
    </div>
</section>
@endsection
