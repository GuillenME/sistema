<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Agenda JCTE Ocosingo 2026')</title>
    <style>
        :root {
            --gold: #C79A59;
            --wine: #6B0F15;
            --copper: #BF845B;
            --clay: #874026;
            --earth: #593F26;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--white);
            color: var(--earth);
        }

        a {
            text-decoration: none;
        }

        .topbar {
            background: var(--wine);
            border-bottom: 5px solid var(--gold);
        }

        .topbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .brand {
            color: var(--white);
            font-size: 1.12rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            justify-content: center;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
        }

        .nav-links a,
        .nav-menu-trigger {
            color: var(--white);
            font-size: 0.92rem;
            font-weight: 700;
            padding: 9px 12px;
            border-radius: 6px;
            transition: background .2s, color .2s;
        }

        .nav-links a:hover,
        .nav-links a.active,
        .nav-menu-trigger:hover,
        .nav-menu-trigger.active {
            background: var(--gold);
            color: var(--wine);
        }

        .nav-menu {
            position: relative;
        }

        .nav-menu-trigger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: default;
        }

        .nav-menu-trigger::after {
            content: "v";
            font-size: 0.72rem;
        }

        .nav-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            z-index: 20;
            min-width: 210px;
            display: none;
            padding: 8px;
            background: var(--white);
            border: 1px solid var(--gold);
            box-shadow: 0 14px 32px rgba(89, 63, 38, 0.18);
        }

        .nav-menu:hover .nav-dropdown,
        .nav-menu:focus-within .nav-dropdown {
            display: grid;
            gap: 4px;
        }

        .nav-dropdown a {
            color: var(--earth);
            display: block;
        }

        .nav-dropdown a:hover,
        .nav-dropdown a.active {
            background: var(--gold);
            color: var(--wine);
        }

        .logout-btn {
            background: var(--earth);
            color: var(--white);

            border: 1px solid var(--copper);

            padding: 10px 18px;
            border-radius: 8px;

            font-weight: 700;
            cursor: pointer;

            transition: .3s;
        }

        .logout-btn:hover {
            background: var(--clay);
        }

        .main {
            width: 100%;
            max-width: 1400px;
            flex: 1;
            margin: 30px auto 50px;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        .footer-franja {
            width: 100%;
            margin-top: auto;
            display: flex;
            justify-content: center;
        }

        .footer-franja img {
            width: 100%;
            max-width: 1400px;
            display: block;
        }

        .watermark {
            position: absolute;
            inset: 0;
            pointer-events: none;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0.15;
            z-index: -1;
        }

        .watermark img {
            width: 520px;
            max-width: 80%;
        }

        .alert {
            background: var(--gold);
            color: var(--wine);
            padding: 16px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid var(--clay);
            font-weight: 700;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--wine);
            color: var(--white);
            padding: 14px 20px;
            border-radius: 8px;
            font-weight: 700;
            transition: background 0.2s;
        }

        .action-button:hover {
            background: var(--clay);
        }

        .page-shell {
            display: grid;
            gap: 22px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 18px;
            padding: 24px;
            background: var(--wine);
            color: var(--white);
            border-bottom: 6px solid var(--gold);
        }

        .page-kicker {
            color: var(--gold);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .page-title {
            color: var(--white);
            font-size: 2rem;
            font-weight: 800;
        }

        .page-subtitle {
            color: var(--white);
            margin-top: 6px;
            line-height: 1.5;
        }

        .panel {
            background: var(--white);
            border: 1px solid var(--gold);
            box-shadow: 0 14px 32px rgba(89, 63, 38, 0.12);
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }

        .data-table th {
            background: var(--earth);
            color: var(--white);
            padding: 14px 16px;
            text-align: left;
            font-size: 0.78rem;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid var(--gold);
            color: var(--earth);
            vertical-align: middle;
        }

        .data-table tr:hover td {
            background: rgba(199, 154, 89, 0.14);
        }

        .text-strong {
            color: var(--wine);
            font-weight: 800;
        }

        .text-muted {
            color: var(--earth);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .btn-primary,
        .btn-secondary,
        .btn-danger,
        .btn-info,
        .btn-submit,
        .btn-cancel,
        .btn-back,
        .btn-edit,
        .btn-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 10px 16px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 0.92rem;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }

        .btn-primary,
        .btn-submit {
            background: var(--gold);
            color: var(--wine);
            border-color: var(--gold);
        }

        .btn-primary:hover,
        .btn-submit:hover {
            background: var(--copper);
            color: var(--white);
        }

        .btn-info,
        .btn-edit {
            background: var(--wine);
            color: var(--white);
            border-color: var(--wine);
        }

        .btn-info:hover,
        .btn-edit:hover {
            background: var(--clay);
        }

        .btn-secondary,
        .btn-cancel,
        .btn-back {
            background: var(--white);
            color: var(--earth);
            border-color: var(--earth);
        }

        .btn-secondary:hover,
        .btn-cancel:hover,
        .btn-back:hover {
            background: var(--earth);
            color: var(--white);
        }

        .btn-danger,
        .btn-delete {
            background: var(--clay);
            color: var(--white);
            border-color: var(--clay);
        }

        .btn-danger:hover,
        .btn-delete:hover {
            background: var(--wine);
        }

        .btn-sm {
            min-height: 34px;
            padding: 8px 12px;
            font-size: 0.84rem;
        }

        .empty-state {
            text-align: center;
            padding: 52px 24px;
            color: var(--earth);
        }

        .empty-state-mark {
            width: 56px;
            height: 6px;
            margin: 0 auto 20px;
            background: var(--gold);
        }

        .pagination ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination li {
            list-style: none;
        }

        .pagination {
            margin-top: 25px;
            display: flex;
            justify-content: center;
        }

        .pagination nav {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }


        .pagination span,
        .pagination a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 14px;
            border: 1px solid var(--gold);
            border-radius: 8px;
            background: white;
            color: var(--earth);
            font-weight: 700;
            text-decoration: none;
        }

        .pagination a:hover {
            background: var(--gold);
            color: var(--wine);
        }

        .pagination .active span,
        .pagination [aria-current="page"] span {
            background: var(--wine);
            color: white;
            border-color: var(--wine);
        }

        ;



        .watermark img,
        .footer-franja img {
            width: 100%;
        }

        .pagination svg {
            width: 16px !important;
            height: 16px !important;
        }

        .form-container,
        .detail-container {
            max-width: 760px;
            margin: 0 auto;
        }

        .form-card,
        .detail-card {
            background: var(--white);
            border: 1px solid var(--gold);
            box-shadow: 0 14px 32px rgba(89, 63, 38, 0.12);
            padding: 32px;
        }

        .form-title,
        .detail-title {
            color: var(--wine);
            font-size: 2rem;
            font-weight: 800;
        }

        .form-subtitle,
        .detail-id {
            color: var(--earth);
            margin-top: 6px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 26px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full,
        .form-actions,
        .detail-actions {
            grid-column: 1 / -1;
        }

        label {
            color: var(--earth);
            font-weight: 800;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        select,
        textarea {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid var(--copper);
            border-radius: 8px;
            color: var(--earth);
            background: var(--white);
            font: inherit;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid var(--gold);
            border-color: var(--wine);
        }

        .form-error {
            color: var(--wine);
            font-size: 0.9rem;
            font-weight: 700;
        }

        .form-actions,
        .detail-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 26px;
            padding-top: 24px;
            border-top: 1px solid var(--gold);
        }

        .detail-field {
            padding: 18px 0;
            border-bottom: 1px solid var(--gold);
        }

        .detail-label {
            color: var(--clay);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .detail-value {
            color: var(--earth);
            margin-top: 6px;
            font-size: 1.08rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 7px 12px;
            background: var(--gold);
            color: var(--wine);
            border-radius: 8px;
            font-weight: 800;
        }

        .related-info {
            margin-top: 24px;
            padding: 16px;
            border-left: 5px solid var(--wine);
            background: var(--white);
            color: var(--earth);
            box-shadow: inset 0 0 0 1px var(--gold);
        }

        .related-info-title {
            color: var(--wine);
            font-weight: 800;
            margin-bottom: 6px;
        }

        .error-box {
            grid-column: 1 / -1;
            background: var(--white);
            color: var(--wine);
            border: 1px solid var(--wine);
            padding: 16px;
            border-radius: 8px;
        }

        @media (max-width: 860px) {
            .main {
                padding: 0 18px;
            }
        }

        @media (max-width: 760px) {
            .page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1200px) {

            .topbar-inner {
                flex-wrap: wrap;
            }

            .menu-toggle {
                display: block;
            }

            .nav-links {
                display: none;
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                margin-top: 15px;
                flex-wrap: nowrap;
            }

            .nav-links.show {
                display: flex;
            }

            .nav-links a {
                text-align: center;
                padding: 12px;
                border-bottom: 1px solid rgba(255, 255, 255, .1);
            }

            .logout-btn {
                width: 100%;
                margin-top: 10px;
            }
        }

        @stack('styles')
    </style>
</head>

<body>
    <header class="topbar">
        <div class="topbar-inner">
            <div class="brand">Agenda JCTE Ocosingo 2026</div>
            <button class="menu-toggle" onclick="toggleMenu()">
                ☰
            </button>
            @php $userRole = Auth::user()->role->tipo ?? ''; @endphp
            <nav class="nav-links" id="navbarMenu">
                <a href="{{ route('dashboard') }}">Inicio</a>
                @if ($userRole === 'admin')
                    <a href="{{ route('admin.jueces') }}">Jueces</a>
                    <a href="{{ route('audiencias.index') }}">Agendar Audiencias</a>
                    <a href="{{ route('admin.tipoaudiencias') }}">Tipo de audiencia</a>
                    <a href="{{ route('admin.delitos') }}">Delitos</a>
                    <a href="{{ route('admin.imputados') }}">Imputados</a>
                    <a href="{{ route('admin.psicologos') }}">Psicólogos</a>
                    <a href="{{ route('admin.traductores') }}">Traductores</a>
                    <a href="{{ route('resumen.index') }}">Resumen de audiencia </a>
                @elseif($userRole === 'oficinista')
                    <a href="{{ route('audiencias.index') }}">Agendar Audiencias</a>
                    <a href="{{ route('resumen.index') }}">Resumen</a>
                @elseif($userRole === 'secretario')
                    <a href="{{ route('audiencias.index') }}">Audiencias</a>
                    <a href="{{ route('resumen.index') }}">Resumen de audiencia </a>
                @elseif($userRole === 'capturista_imputados')
                    <a href="{{ route('audiencias.index') }}">Audiencias</a>
                    <a href="{{ route('resumen.index') }}">Resumen de audiencia </a>
                    <a href="{{ route('imputados.index') }}">Imputados</a>
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
    <script>
        function toggleMenu() {
            document.getElementById('navbarMenu')
                .classList.toggle('show');
        }
    </script>
</body>

</html>
