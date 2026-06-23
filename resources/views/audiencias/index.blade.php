@extends('layouts.app')

@section('title', 'Audiencias')
@push('styles')
    <style>
        .search-panel {
            border: none !important;
            box-shadow: none !important;
            padding: 0;
            background: transparent;
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-input {
            flex: 1;
            min-width: 300px;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
        }

        .search-input:focus {
            border-color: #2563eb;
        }
    </style>
@endpush
@section('content')
    @php $userRole = Auth::user()->role->tipo ?? ''; @endphp

    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Agenda</div>
                <h1 class="page-title">Audiencias</h1>
                <p class="page-subtitle">Listado general de audiencias registradas.</p>
            </div>

            <div class="actions">
                <a href="{{ route('audiencias.report') }}" class="btn-info">Generar reporte</a>
                @if (in_array($userRole, ['admin', 'oficinista']))
                    <a href="{{ route('audiencias.create') }}" class="btn-primary">Nueva audiencia</a>
                @endif
            </div>
        </div>
        <div class=" search-panel">
            <form method="GET" action="{{ route('audiencias.index') }}" class="search-form">
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                    placeholder="Buscar por causa, juez, delito o imputado..." class="search-input">

                <button type="submit" class="btn-primary">
                    Buscar
                </button>

                @if (request('buscar'))
                    <a href="{{ route('audiencias.index') }}" class="btn-secondary">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>
        <div class="panel table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Causa</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Delito</th>
                        <th>Tipo</th>
                        <th>Imputados</th>
                        <th>Sala</th>
                        <th>Traductor</th>
                        <th>Psicologo</th>
                        <th>Juez</th>
                        <th>Agendo</th>
                        <th>Estado</th>
                        @if ($userRole === 'admin')
                            <th style="width: 210px;">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($audiencias as $audiencia)
                        <tr>
                            <td><span class="text-strong">{{ $audiencia->causa }}</span></td>
                            <td>{{ optional($audiencia->fecha)->format('Y-m-d') ?? '-' }}</td>
                            <td>{{ optional($audiencia->hora)->format('H:i') ?? ($audiencia->hora ?? '-') }}</td>
                            <td>{{ optional($audiencia->delito)->delito ?? '-' }}</td>
                            <td>{{ optional($audiencia->tipoAudiencia)->tipo ?? '-' }}</td>
                            <td>
                                {{ $audiencia->imputados->map(function ($imputado) {
                                        return trim($imputado->nombre . ' ' . $imputado->apellidos);
                                    })->implode(', ') ?:
                                    '-' }}
                            </td>
                            <td><span class="badge">{{ optional($audiencia->sala)->sala ?? '-' }}</span></td>
                            <td>
                                {{ $audiencia->traductor ? $audiencia->traductor->lengua . ' - ' . $audiencia->traductor->nombres : '-' }}
                            </td>
                            <td>{{ optional($audiencia->psicologo)->nombre ?? '-' }}</td>
                            <td>{{ optional($audiencia->juez)->nombre ?? '-' }}</td>

                            <td>{{ optional($audiencia->creador)->nombre ?? '-' }}</td>
                            <td>
                                <span class="badge">{{ $audiencia->estado ?? 'Programada' }}</span>
                            </td>
                            @if ($userRole === 'admin')
                                @php
                                    $puedeDiferir = now()->lte(\Carbon\Carbon::parse($audiencia->fecha)->addDays(3));
                                @endphp

                                <td>
                                    <div class="table-actions">

                                        <a href="{{ route('audiencias.edit', $audiencia) }}"
                                            class="btn-secondary btn-sm">Modificar</a>

                                        @if (($audiencia->estado ?? 'Programada') !== 'Diferida' && $puedeDiferir)
                                            <form action="{{ route('audiencias.diferir', $audiencia) }}" method="POST"
                                                onsubmit="return confirm('¿Desea diferir esta audiencia?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn-danger btn-sm">Diferir</button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $userRole === 'admin' ? 14 : 13 }}">
                                <div class="empty-state">
                                    <div class="empty-state-mark"></div>
                                    <h3>No hay audiencias registradas</h3>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $audiencias->links() ?? '' }}
        </div>
    </div>
@endsection
