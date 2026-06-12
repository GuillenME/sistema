@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 18px;
    }

    .dashboard-card {
        background: var(--white);
        border: 1px solid var(--gold);
        box-shadow: 0 14px 32px rgba(89, 63, 38, 0.12);
        padding: 24px;
        min-height: 130px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .dashboard-label {
        color: var(--clay);
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .dashboard-value {
        color: var(--wine);
        font-size: 1.6rem;
        font-weight: 800;
        margin-top: 14px;
        overflow-wrap: anywhere;
    }

    .dashboard-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 12px;
    }

    .dashboard-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
    }

    .info-panel {
        background: var(--white);
        border-left: 6px solid var(--wine);
        box-shadow: inset 0 0 0 1px var(--gold);
        padding: 22px;
    }

    .info-panel h3 {
        color: var(--wine);
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .info-panel p {
        color: var(--earth);
        font-size: 1.1rem;
        line-height: 1.6;
        font-weight: 700;
    }
@endpush

@section('content')
    @php $userRole = Auth::user()->role->tipo ?? ''; @endphp

    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Inicio</div>
                <h1 class="page-title">Agenda JCTE Ocosingo 2026</h1>
                <p class="page-subtitle">Accede rapido a las acciones disponibles segun tu rol en el sistema.</p>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="dashboard-label">Usuario</div>
                <div class="dashboard-value">{{ Auth::user()->usuario }}</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-label">Puesto</div>
                <div class="dashboard-value">{{ Auth::user()->puesto }}</div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-label">Rol</div>
                <div class="dashboard-value">{{ $userRole ?: 'N/A' }}</div>
            </div>
        </div>

        <div class="panel" style="padding: 24px;">
            <div class="dashboard-label" style="margin-bottom: 14px;">Accesos</div>
            <div class="dashboard-actions">
                @if ($userRole === 'admin')
                    <a href="{{ route('audiencias.index') }}" class="btn-primary">Ver audiencias</a>
                    <a href="{{ route('resumen.index') }}" class="btn-info">Ver resumen</a>
                    <a href="{{ route('audiencias.report') }}" class="btn-secondary">Reporte audiencias</a>
                    <a href="{{ route('admin.jueces') }}" class="btn-secondary">Jueces</a>
                    <a href="{{ route('admin.delitos') }}" class="btn-secondary">Delitos</a>
                @elseif($userRole === 'oficinista')
                    <a href="{{ route('audiencias.create') }}" class="btn-primary">Crear audiencia</a>
                    <a href="{{ route('resumen.create') }}" class="btn-info">Crear resumen</a>
                    <a href="{{ route('audiencias.index') }}" class="btn-secondary">Ver audiencias</a>
                    <a href="{{ route('resumen.index') }}" class="btn-secondary">Ver resumen</a>
                    <a href="{{ route('audiencias.report') }}" class="btn-secondary">Reporte audiencias</a>
                @elseif($userRole === 'secretario')
                    <a href="{{ route('audiencias.index') }}" class="btn-primary">Ver audiencias</a>
                    <a href="{{ route('resumen.index') }}" class="btn-info">Ver resumen</a>
                    <a href="{{ route('audiencias.report') }}" class="btn-secondary">Reporte audiencias</a>
                @elseif($userRole === 'capturista_imputados')
                    <a href="{{ route('imputados.create') }}" class="btn-primary">Agregar imputado</a>
                    <a href="{{ route('imputados.index') }}" class="btn-secondary">Ver imputados</a>
                    <a href="{{ route('audiencias.index') }}" class="btn-secondary">Ver audiencias</a>
                    <a href="{{ route('resumen.index') }}" class="btn-info">Ver resumen</a>
                    <a href="{{ route('audiencias.report') }}" class="btn-secondary">Reporte audiencias</a>
                @else
                    <a href="{{ route('audiencias.index') }}" class="btn-primary">Ver audiencias</a>
                    <a href="{{ route('resumen.index') }}" class="btn-info">Ver resumen</a>
                @endif
            </div>
        </div>

        <div class="dashboard-info">
            @if (in_array($userRole, ['admin', 'oficinista']))
                <div class="info-panel">
                    <h3>Acceso de edicion</h3>
                    <p>Puede crear y editar audiencias y resumenes.</p>
                </div>
                <div class="info-panel">
                    <h3>Atencion</h3>
                    <p>Los cambios quedan registrados en el sistema.</p>
                </div>
            @elseif($userRole === 'secretario')
                <div class="info-panel">
                    <h3>Acceso de solo lectura</h3>
                    <p>Solo puede ver listados de audiencias y resumenes.</p>
                </div>
                <div class="info-panel">
                    <h3>Restriccion</h3>
                    <p>No tiene permiso para crear ni editar datos.</p>
                </div>
            @elseif($userRole === 'capturista_imputados')
                <div class="info-panel">
                    <h3>Captura de imputados</h3>
                    <p>Puede ver audiencias y resumenes, ademas de consultar y agregar imputados.</p>
                </div>
                <div class="info-panel">
                    <h3>Restriccion</h3>
                    <p>No tiene permiso para crear audiencias ni editar o eliminar imputados.</p>
                </div>
            @else
                <div class="info-panel">
                    <h3>Acceso</h3>
                    <p>Debe contactarse con el administrador si su rol no es valido.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
