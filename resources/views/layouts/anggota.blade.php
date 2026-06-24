{{-- Halaman Anggota --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMKOM Anggota')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">SI</div>
            <div>
                <strong>SIMKOM</strong>
                <span>Portal Anggota</span>
            </div>
        </div>
        {{-- Navigasi utama aplikasi --}}
        <nav class="nav">
            <a class="{{ request()->is('dashboard-anggota') ? 'active' : '' }}" href="/dashboard-anggota"><span>🏠</span>Dashboard</a>
            <a class="{{ request()->is('anggota/kegiatan') ? 'active' : '' }}" href="/anggota/kegiatan"><span>📋</span>Jelajahi Kegiatan</a>
            <a class="{{ request()->is('anggota/aktivitas') ? 'active' : '' }}" href="/anggota/aktivitas"><span>🔍</span>Aktivitas Saya</a>
            <a class="{{ request()->is('anggota/profil') ? 'active' : '' }}" href="/anggota/profil"><span>👤</span>Profil Saya</a>
        </nav>
        <div class="sidebar-footer">
            <a href="/logout" class="logout">&#8617; Logout</a>
        </div>
    </aside>

    {{-- Area konten utama --}}

    <main class="main">
        <header class="topbar">
        <div class="user-chip">
    <b>{{ strtoupper(substr(session('nama') ?? 'U', 0, 2)) }}</b>

    <div>
        <strong>{{ session('nama') }}</strong>
        <span>{{ ucfirst(session('role')) }}</span>
    </div>
</div>    
    </header>
        {{-- Section informasi halaman --}}
        <section class="content">
            {{-- Kondisi tampilan berdasarkan data yang tersedia --}}
            @if(session('success'))
                <div class="toast">{{ session('success') }}</div>
            @endif
            @yield('content')
        </section>
    </main>
</div>
</body>
</html>
