<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMKOM Pengurus')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">SI</div>
            <div>
                <strong>SIMKOM</strong>
                <span>Panel Pengurus</span>
            </div>
        </div>

        <nav class="nav">
            <a class="{{ request()->is('dashboard-pengurus') ? 'active' : '' }}" href="/dashboard-pengurus"><span>▦</span>Dashboard</a>
            <a class="{{ request()->is('profil-organisasi') || request()->is('edit-profil-organisasi') ? 'active' : '' }}" href="/profil-organisasi"><span>▤</span>Profil Organisasi</a>
            <a class="{{ request()->is('manajemen-anggota') ? 'active' : '' }}" href="/manajemen-anggota"><span>◎</span>Manajemen Anggota</a>
            <div class="nav-group">
                <span class="nav-title">▣ Kegiatan</span>
                <a class="{{ request()->is('manajemen-kegiatan') || request()->is('detail-kegiatan/*') || request()->is('edit-kegiatan/*') ? 'active' : '' }}" href="/manajemen-kegiatan">Manajemen Kegiatan</a>
                <a class="{{ request()->is('riwayat-kegiatan') ? 'active' : '' }}" href="/riwayat-kegiatan">Riwayat Kegiatan</a>
            </div>
            <a class="{{ request()->is('proposal-lpj') ? 'active' : '' }}" href="/proposal-lpj"><span>▧</span>Proposal & LPJ</a>
            <a class="{{ request()->is('keuangan') ? 'active' : '' }}" href="/keuangan"><span>▨</span>Keuangan</a>
            <a class="{{ request()->is('ekspor-laporan') ? 'active' : '' }}" href="/ekspor-laporan"><span>⇩</span>Ekspor Laporan</a>
        </nav>

        <div class="sidebar-footer">
            <a href="/logout" class="logout">&#8617; Logout</a>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="user-chip"><b>PO</b><div><strong>Pengurus Organisasi</strong><span>HIMATIF</span></div></div>
        </header>
        <section class="content">
            @if(session('success'))
                <div class="toast">{{ session('success') }}</div>
            @endif
            @yield('content')
        </section>
    </main>
</div>
</body>
</html>
