{{-- Halaman Forgot Password --}}
@extends('layouts.app')

@section('title', 'Hubungi Admin SIMKOM')

{{-- Konten utama halaman Forgot Password --}}

@section('content')
<style>
    body {
        margin: 0;
        color: #111827;
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        background: #f8fbff;
    }

    .login-screen {
        min-height: 100vh;
        display: grid;
        grid-template-columns: minmax(280px, 420px) minmax(280px, 360px);
        align-items: center;
        justify-content: center;
        gap: 160px;
        padding: 48px;
        background:
            radial-gradient(circle at 27% 48%, rgba(37, 99, 235, .13), transparent 24%),
            linear-gradient(120deg, #f8fbff 0%, #ffffff 50%, #f5f9ff 100%);
    }

    .login-info {
        text-align: center;
    }

    .login-logo {
        width: 86px;
        height: 86px;
        margin: 0 auto 24px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        color: #fff;
        background: #2563eb;
        box-shadow: 0 14px 28px rgba(37, 99, 235, .28);
        font-size: 38px;
        font-weight: 800;
    }

    .login-info h1 {
        margin: 0 0 12px;
        font-size: 28px;
        line-height: 1.2;
    }

    .login-info > p {
        max-width: 350px;
        margin: 0 auto;
        line-height: 1.7;
        color: #111827;
        font-size: 14px;
    }

    .login-benefits {
        margin-top: 24px;
        padding: 20px;
        text-align: left;
        background: rgba(255, 255, 255, .72);
        border: 1px solid #dfe6f2;
        border-radius: 12px;
    }

    .benefit-item {
        display: grid;
        grid-template-columns: 14px 1fr;
        gap: 10px;
        padding: 8px 0;
    }

    .benefit-item span {
        width: 6px;
        height: 6px;
        margin-top: 8px;
        border-radius: 999px;
        background: #2563eb;
    }

    .benefit-item strong {
        display: block;
        font-size: 13px;
    }

    .benefit-item p {
        margin: 3px 0 0;
        color: #4b5563;
        font-size: 12px;
    }

    .login-panel {
        width: 100%;
        background: #fff;
        border: 1px solid #dfe6f2;
        border-radius: 12px;
        padding: 22px 22px 28px;
        box-shadow: 0 20px 34px rgba(15, 23, 42, .18);
    }

    .login-panel h2 {
        margin: 0 0 10px;
        text-align: center;
        font-size: 18px;
    }

    .login-panel > p {
        margin: 0 0 20px;
        text-align: center;
        color: #6b7280;
        font-size: 12px;
    }

    .contact-field {
        margin-bottom: 14px;
    }

    .contact-field label {
        display: block;
        margin-bottom: 7px;
        font-size: 11px;
        font-weight: 700;
    }

    .contact-value {
        min-height: 34px;
        border-radius: 7px;
        padding: 9px 11px;
        font-size: 12px;
        background: #f0f0f3;
        box-sizing: border-box;
        color: #4b5563;
        cursor: pointer;
    }

    .login-submit {
        display: inline-grid;
        place-items: center;
        width: 100%;
        min-height: 36px;
        border: 1px solid #2563eb;
        border-radius: 7px;
        background: #2563eb;
        color: #fff;
        font: inherit;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
    }

    @media (max-width: 920px) {
        .login-screen {
            grid-template-columns: 1fr;
            gap: 32px;
            padding: 32px 18px;
        }

        .login-info > p {
            max-width: 420px;
        }
    }
</style>

{{-- Area konten utama --}}

<main class="login-screen">
    {{-- Section informasi halaman --}}
    <section class="login-info">
        <div class="login-logo">S</div>
        <h1>SIMKOM</h1>
        <p>Sistem Informasi Manajemen Kegiatan Organisasi Mahasiswa</p>

        <div class="login-benefits">
            <div class="benefit-item">
                <span></span>
                <div>
                    <strong>Manajemen Terintegrasi</strong>
                    <p>Kelola seluruh kegiatan organisasi dalam satu platform</p>
                </div>
            </div>
            <div class="benefit-item">
                <span></span>
                <div>
                    <strong>Monitoring Real-time</strong>
                    <p>Pantau aktivitas dan keuangan secara langsung</p>
                </div>
            </div>
            <div class="benefit-item">
                <span></span>
                <div>
                    <strong>Administrasi Transparan</strong>
                    <p>Dokumentasi lengkap dan akuntabel</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section informasi halaman --}}

    <section class="login-panel">
        <h2>Hubungi Admin</h2>
        <p>Dapatkan kembali password anda</p>

        <div class="contact-field">
            <label>Email</label>
            <div class="contact-value">admin@gmail.com</div>
        </div>

        <div class="contact-field">
            <label>WhatsApp</label>
            <div class="contact-value">081xxxxxxx</div>
        </div>

        <a class="login-submit" href="/">Kembali</a>
    </section>
</main>
@endsection
