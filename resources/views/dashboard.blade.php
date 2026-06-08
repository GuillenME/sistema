<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda JCTE Ocosingo 2026</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2ff;
            color: #1f2937;
        }

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .topbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 18px 28px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #111827;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
        }

        .nav-links a {
            color: #4b5563;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 10px 8px;
            border-radius: 999px;
            transition: background 0.2s, color 0.2s;
        }

        .nav-links a:hover {
            background: #e0e7ff;
            color: #1e3a8a;
        }

        .logout-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 999px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 700;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        .main {
            max-width: 1400px;
            margin: 30px auto 50px;
            padding: 0 24px;
        }

        .hero {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 28px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
            display: grid;
            grid-template-columns: 1fr;
            gap: 28px;
        }

        .hero-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 24px;
            align-items: center;
        }

        .hero-title {
            max-width: 700px;
        }

        .hero-title h1 {
            font-size: 2.6rem;
            line-height: 1.05;
            color: #111827;
            margin-bottom: 14px;
        }

        .hero-title p {
            font-size: 1rem;
            color: #4b5563;
            line-height: 1.8;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }

        .stat-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            padding: 26px;
            min-height: 130px;
        }

        .stat-card h3 {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #4f46e5;
            margin-bottom: 12px;
        }

        .stat-card p {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 24px;
        }

        .info-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            padding: 24px;
            min-height: 140px;
        }

        .info-card h3 {
            color: #4338ca;
            margin-bottom: 10px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .info-card p {
            color: #111827;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .alert {
            background: #d4edda;
            color: #155724;
            padding: 16px 18px;
            border-radius: 14px;
            margin-bottom: 24px;
            border: 1px solid #c3e6cb;
        }

        @media (max-width: 860px) {
            .hero {
                padding: 30px;
            }

            .hero-title h1 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 640px) {
            .topbar-inner {
                justify-content: center;
            }

            .nav-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <div class="brand">Agenda JCTE Ocosingo 2026</div>
            <nav class="nav-links">
                <a href="#">Jueces</a>
                <a href="#">Psicólogos</a>
                <a href="#">Traductor</a>
                <a href="#">Audiencias</a>
                <a href="#">Tipos de audiencias</a>
                <a href="#">Delitos</a>
                <a href="#">Resumen</a>
            </nav>
            <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <main class="main">
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <section class="hero">
            <div class="hero-header">
                <div class="hero-title">
                    <h1>Bienvenido a Agenda JCTE Ocosingo 2026</h1>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Usuario</h3>
                    <p>{{ Auth::user()->usuario }}</p>
                </div>
                <div class="stat-card">
                    <h3>Puesto</h3>
                    <p>{{ Auth::user()->puesto }}</p>
                </div>
                <div class="stat-card">
                    <h3>Rol</h3>
                    <p>{{ Auth::user()->role->tipo ?? 'N/A' }}</p>
                </div>
            </div>

           
        </section>
    </main>
</body>
</html>
