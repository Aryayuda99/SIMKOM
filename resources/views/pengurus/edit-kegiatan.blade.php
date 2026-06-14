@extends('layouts.pengurus')

@section('title', 'Edit Detail Kegiatan')

@section('content')
@php
    $tanggalKosong = empty($kegiatan->tanggal_pelaksanaan) || $kegiatan->tanggal_pelaksanaan === '1000-01-01';
@endphp

<form class="card modal-page" method="POST" action="/update-kegiatan">
    @csrf
    <input type="hidden" name="id_kegiatan" value="{{ $kegiatan->id_kegiatan }}">
    <h2>Edit Detail Kegiatan</h2>
    <p class="subtitle">Edit tanggal, lokasi, dan jumlah peserta kegiatan</p>

    <div class="card" style="background:#f9fafb;margin:18px 0">
        <h3>{{ $kegiatan->nama_kegiatan }}</h3>
        <p class="muted">{{ $kegiatan->deskripsi }}</p>
    </div>

    <div class="field">
        <label>Tanggal Kegiatan</label>
        <input type="date" name="tanggal_pelaksanaan" value="{{ $tanggalKosong ? '' : $kegiatan->tanggal_pelaksanaan }}" required>
    </div>
    <div class="field">
        <label>Lokasi</label>
        <input name="lokasi" value="{{ $kegiatan->lokasi }}" required>
    </div>
    <div class="field">
        <label>Jumlah Peserta (Kuota)</label>
        <input type="number" name="kuota_peserta" value="{{ $kegiatan->kuota_peserta }}" required>
    </div>
    <div class="grid two">
        <a class="btn" href="/manajemen-kegiatan">Batal</a>
        <button class="primary" type="submit">Simpan Perubahan</button>
    </div>
</form>
@endsection
