<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMKOM Mahasiswa')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">SI</div>
            <div>
                <strong>SIMKOM</strong>
                <span>Portal Mahasiswa</span>
            </div>
        </div>
        <nav class="nav">
            <a class="{{ request()->is('dashboard-mahasiswa') ? 'active' : '' }}" href="/dashboard-mahasiswa"><span>▦</span>Beranda</a>
            <a class="{{ request()->is('daftar-anggota') || request()->is('pendaftaran-anggota/*') ? 'active' : '' }}" href="/daftar-anggota"><span>◎</span>Daftar Anggota</a>
            <a class="{{ request()->is('daftar-kegiatan') || request()->is('pendaftaran-kegiatan/*') ? 'active' : '' }}" href="/daftar-kegiatan"><span>▣</span>Daftar Kegiatan</a>
        </nav>
        <div class="sidebar-footer">
            <a href="/logout" class="logout">&#8617; Logout</a>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <span class="portal-badge">Portal Mahasiswa</span>
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
