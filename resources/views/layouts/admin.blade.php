<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMKOM Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">SI</div>
            <div>
                <strong>SIMKOM</strong>
                <span>Administrator</span>
            </div>
        </div>

        <nav class="nav">
            <a class="{{ request()->is('dashboard-admin') ? 'active' : '' }}" href="/dashboard-admin"><span>▦</span>Dashboard</a>
            <a class="{{ request()->is('profil-organisasi-admin') || request()->is('edit-organisasi/*') ? 'active' : '' }}" href="/profil-organisasi-admin"><span>▤</span>Profil Organisasi</a>
            <a class="{{ request()->is('manajemen-anggota-admin') || request()->is('ubah-role/*') || request()->is('reset-password/*') ? 'active' : '' }}" href="/manajemen-anggota-admin"><span>◎</span>Manajemen Anggota</a>
            <a class="{{ request()->is('manajemen-kegiatan-admin') || request()->is('tambah-kegiatan') || request()->is('edit-kegiatan-admin/*') ? 'active' : '' }}" href="/manajemen-kegiatan-admin"><span>▣</span>Manajemen Kegiatan</a>
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="user-chip"><b>AD</b><div><strong>Admin User</strong><span>Administrator</span></div></div>
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
