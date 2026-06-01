<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMKOM Pembina')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">SI</div>
            <div>
                <strong>SIMKOM</strong>
                <span>Pembina</span>
            </div>
        </div>
        <nav class="nav">
            <a class="{{ request()->is('dashboard-pembina') ? 'active' : '' }}" href="/dashboard-pembina"><span>▦</span>Dashboard Monitoring</a>
            <a class="{{ request()->is('dokumen-pembina') ? 'active' : '' }}" href="/dokumen-pembina"><span>✓</span>Dokumen Proposal & LPJ</a>
            <a class="{{ request()->is('riwayat-kegiatan-pembina') ? 'active' : '' }}" href="/riwayat-kegiatan-pembina"><span>↺</span>Riwayat Kegiatan</a>
        </nav>
        <div class="sidebar-footer">
            <div class="avatar">PB</div>
            <div><strong>Pembina</strong><span>Supervisor</span></div>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="user-chip"><b>PB</b><div><strong>Pembina</strong><span>Supervisor</span></div></div>
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
