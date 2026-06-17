@extends('layouts.pengurus')

@section('title', 'Proposal & LPJ')

@section('content')

@if ($errors->any())
<script>
    alert('{{ $errors->first() }}');
</script>
@endif

@if(session('error'))
<script>
    alert('{{ session('error') }}');
</script>
@endif
<div class="page-title">
    <div>
        <h1>Proposal & LPJ</h1>
        <p class="subtitle">Kelola dokumen proposal dan laporan pertanggungjawaban</p>
    </div>
</div>

<section class="card">
    <h2>Pusat Dokumen</h2>
    <p class="subtitle">Upload dan kelola dokumen kegiatan</p>

    <form method="POST" action="/upload-dokumen" enctype="multipart/form-data">
        @csrf
        <div class="form-grid" style="margin-top:22px">
            <div class="field">
                <label>Kegiatan</label>
                <select name="id_kegiatan" required>
                    @foreach($kegiatan as $item)
                        <option value="{{ $item->id_kegiatan }}">{{ $item->nama_kegiatan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>Jenis Dokumen</label>
                <select name="jenis" required>
                    <option value="Proposal">Proposal</option>
                    <option value="LPJ">LPJ</option>
                    <option value="Dokumentasi">Dokumentasi</option>
                </select>
            </div>
            <div class="field">
                <label>Nama Dokumen</label>
                <input name="nama_dokumen" required placeholder="Nama dokumen">
            </div>
            <div class="field">
                <label>Deskripsi</label>
                <input name="deskripsi" placeholder="Deskripsi singkat">
            </div>
        </div>
        <label>Upload File</label>
        <div class="upload">
            <div>
                <strong>Pilih file dokumen</strong>
                <p>PDF, DOCX, JPG, PNG, ZIP</p>
                <input type="file" name="file_dokumen" required style="margin-top:12px">
            </div>
        </div>
        <button class="primary" type="submit">Upload Dokumen</button>
    </form>
</section>

<section class="card">
    <h2>Daftar Dokumen</h2>
    <div class="list" style="margin-top:20px">
        @forelse($dokumen as $item)
            <div class="list-item">
                <div class="split">
                    <div>
                        <div class="actions">
                            <span class="badge">{{ $item->jenis }}</span>
                            <span class="badge blue">{{ $item->nama_kegiatan }}</span>
                        </div>
                        <h3 style="margin-top:10px">{{ $item->nama_dokumen }}</h3>
                    </div>
                    <div class="actions">
                        <a class="btn" href="/uploads/{{ $item->file_dokumen }}" target="_blank">Download</a>
                        <a class="btn danger" href="/hapus-dokumen/{{ $item->id_dokumen }}" onclick="return confirm('Hapus dokumen ini?')">Hapus</a>
                    </div>
                </div>
                <div class="meta">
                    <span>Tanggal Upload {{ $item->tanggal_upload }}</span>
                    <span>{{ $item->deskripsi }}</span>
                </div>
            </div>
        @empty
            <div class="empty"><p>Belum ada dokumen.</p></div>
        @endforelse
    </div>
</section>

<section class="notice">
    <div class="hero-icon">📄</div>
    <div>
        <h2>Informasi Upload Dokumen</h2>
        <p class="subtitle">Format proposal dan LPJ: PDF atau DOCX. Format dokumentasi: JPG, PNG, atau ZIP.</p>
    </div>
</section>
@endsection
