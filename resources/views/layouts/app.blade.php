<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agenda JCTE Ocosingo 2026')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #eef2ff; color: #1f2937; }
        a { text-decoration: none; }
        .topbar { background: #ffffff; border-bottom: 1px solid #e5e7eb; }
        .topbar-inner { max-width: 1400px; margin: 0 auto; padding: 18px 28px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; }
        .brand { font-size: 1.15rem; font-weight: 800; letter-spacing: -0.03em; color: #111827; }
        .nav-links { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
        .nav-links a { color: #4b5563; font-size: 0.95rem; font-weight: 600; padding: 10px 14px; border-radius: 999px; transition: background 0.2s, color 0.2s; }
        .nav-links a:hover { background: #e0e7ff; color: #1e3a8a; }
        .logout-btn { background: #dc2626; color: white; border: none; padding: 10px 18px; border-radius: 999px; cursor: pointer; font-size: 0.95rem; font-weight: 700; transition: background 0.2s; }
        .logout-btn:hover { background: #b91c1c; }
        .main { max-width: 1400px; margin: 30px auto 50px; padding: 0 24px; position: relative; }
        .footer-franja { width: 100vw; max-width: 100%; margin-left: calc(50% - 50vw); margin-top: 28px; display: flex; justify-content: center; }
        .footer-franja img { width: 100%; max-width: 1400px; border-radius: 20px; display: block; }
        .watermark { position: absolute; inset: 0; pointer-events: none; display: flex; justify-content: center; align-items: center; opacity: 0.15; z-index: 0; }
        .watermark img { width: 520px; max-width: 80%; }
        .alert { background: #d4edda; color: #155724; padding: 16px 18px; border-radius: 14px; margin-bottom: 24px; border: 1px solid #c3e6cb; }
        .action-button { display: inline-flex; align-items: center; justify-content: center; background: #4f46e5; color: #fff; padding: 14px 20px; border-radius: 16px; font-weight: 700; transition: background 0.2s; }
        .action-button:hover { background: #3730a3; }
        @media (max-width: 860px) { .main { padding: 0 18px; } }
        @media (max-width: 640px) { .topbar-inner { justify-content: center; } .nav-links { justify-content: center; } }
        @stack('styles')
    </style>
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <div class="brand">Agenda JCTE Ocosingo 2026</div>
            @php $userRole = Auth::user()->role->tipo ?? ''; @endphp
            <nav class="nav-links">
                <a href="{{ route('dashboard') }}">Inicio</a>
                @if($userRole === 'admin')
                    <a href="{{ route('admin.jueces') }}">Jueces</a>
                    <a href="{{ route('audiencias.index') }}">Agendar Audiencias</a>
                    <a href="{{ route('admin.tipo_audiencia') }}">Tipo de audiencia</a>
                    <a href="{{ route('admin.delitos') }}">Delitos</a>
                    <a href="{{ route('admin.psicologos') }}">Psicólogos</a>
                    <a href="{{ route('admin.traductores') }}">Traductores</a>
                    <a href="{{ route('resumen.index') }}">Resumen</a>
                @elseif($userRole === 'oficinista')
                    <a href="{{ route('audiencias.index') }}">Agendar Audiencias</a>
                    <a href="{{ route('resumen.index') }}">Resumen</a>
                @elseif($userRole === 'secretario')
                    <a href="{{ route('audiencias.index') }}">Audiencias</a>
                    <a href="{{ route('resumen.index') }}">Resumen</a>
                @endif
            </nav>
            <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <main class="main">
        <div class="watermark">
            <img src="{{ asset('img/fondo.png') }}" alt="Marca de agua">
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <div class="footer-franja">
        <img src="{{ asset('img/franja.png') }}" alt="Franja decorativa">
    </div>
</body>
</html>
