@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    .hero {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 28px;
        padding: 40px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        display: grid;
        grid-template-columns: 1fr;
        gap: 28px;
        position: relative;
        z-index: 1;
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

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 24px;
    }

    .action-button {
        background: #4f46e5;
        color: white;
        padding: 16px 22px;
        border-radius: 18px;
        text-decoration: none;
        font-weight: 700;
        min-width: 180px;
        text-align: center;
        transition: background 0.2s;
    }

    .action-button:hover {
        background: #3730a3;
    }

    @media (max-width: 860px) {
        .hero { padding: 30px; }
        .hero-title h1 { font-size: 2.2rem; }
    }
@endpush

@section('content')
    @php $userRole = Auth::user()->role->tipo ?? ''; @endphp

    <section class="hero">
        <div class="hero-header">
            <div class="hero-title">
                <h1>Bienvenido a Agenda JCTE Ocosingo 2026</h1>
                <p>Accede rápido a las acciones disponibles según tu rol en el sistema.</p>
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
                <p>{{ $userRole ?: 'N/A' }}</p>
            </div>
        </div>

        <div class="action-buttons">
            @if ($userRole === 'admin')
                <a href="{{ route('audiencias.index') }}" class="action-button">Ver audiencias</a>
                <a href="{{ route('resumen.index') }}" class="action-button">Ver resumen</a>
                
            @elseif($userRole === 'oficinista')
                <a href="{{ route('audiencias.create') }}" class="action-button">Crear audiencia</a>
                <a href="{{ route('resumen.create') }}" class="action-button">Crear resumen</a>
                <a href="{{ route('audiencias.index') }}" class="action-button">Ver audiencias</a>
                <a href="{{ route('resumen.index') }}" class="action-button">Ver resumen</a>
            @elseif($userRole === 'secretario')
                <a href="{{ route('audiencias.index') }}" class="action-button">Ver audiencias</a>
                <a href="{{ route('resumen.index') }}" class="action-button">Ver resumen</a>
            @else
                <a href="{{ route('audiencias.index') }}" class="action-button">Ver audiencias</a>
                <a href="{{ route('resumen.index') }}" class="action-button">Ver resumen</a>
            @endif
        </div>

        <div class="info-grid" style="margin-top: 32px;">
            @if (in_array($userRole, ['admin', 'oficinista']))
                <div class="info-card">
                    <h3>Acceso de edición</h3>
                    <p>Puede crear y editar audiencias y resúmenes.</p>
                </div>
                <div class="info-card">
                    <h3>Atención</h3>
                    <p>Los cambios quedan registrados en el sistema.</p>
                </div>
            @elseif($userRole === 'secretario')
                <div class="info-card">
                    <h3>Acceso de solo lectura</h3>
                    <p>Solo puede ver listados de audiencias y resúmenes.</p>
                </div>
                <div class="info-card">
                    <h3>Restricción</h3>
                    <p>No tiene permiso para crear ni editar datos.</p>
                </div>
            @else
                <div class="info-card">
                    <h3>Acceso</h3>
                    <p>Debe contactarse con el administrador si su rol no es válido.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
