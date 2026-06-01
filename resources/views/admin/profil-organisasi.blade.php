@extends('layouts.admin')

@section('title', 'Profil Organisasi')

@section('content')
<div class="page-title">
    <div>
        <h1>Profil Organisasi</h1>
        <p class="subtitle">Informasi dan identitas seluruh organisasi</p>
    </div>
</div>

<div class="grid two">
    @forelse($organisasi as $item)
        <section class="card">
            <div class="split">
                <div class="actions">
                    <div class="tile-icon">▤</div>
                    <div>
                        <h2>{{ $item->nama_organisasi }}</h2>
                        <p class="muted">{{ $item->periode_kepengurusan ?? 'Periode belum diisi' }}</p>
                    </div>
                </div>
                <a class="btn primary" href="/edit-organisasi/{{ $item->id_organisasi }}">Edit Profil</a>
            </div>
            <div style="margin-top:24px">
                <h3>Visi</h3>
                <p class="subtitle">{{ $item->visi ?? 'Visi belum tersedia.' }}</p>
            </div>
            <div style="margin-top:18px">
                <h3>Misi</h3>
                <p class="subtitle">{{ $item->misi ?? 'Misi belum tersedia.' }}</p>
            </div>
        </section>
    @empty
        <section class="card empty">
            <div>
                <h2>Belum ada organisasi</h2>
                <p>Data organisasi belum tersedia di backend.</p>
            </div>
        </section>
    @endforelse
</div>
@endsection
