@extends('layouts.app')

@section('title', 'Audiencias')
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
        <x-search-form :action="route('audiencias.index')" placeholder="Buscar por causa, juez, delito o imputado..." />
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
                                    $estadoAudiencia = $audiencia->estado ?? 'Programada';
                                    $puedeDiferir = now()->lte(
                                        \Carbon\Carbon::parse($audiencia->fecha)->addDays(2)->endOfDay(),
                                    );
                                @endphp

                                <td>
                                    <div class="table-actions">

                                        <a href="{{ route('audiencias.edit', $audiencia) }}" class="btn-secondary btn-sm">
                                            Modificar
                                        </a>

                                        @if ($estadoAudiencia === 'Diferida')
                                            <a href="{{ route('audiencias.reagendar', $audiencia) }}"
                                                class="btn-primary btn-sm">
                                                Reagendar
                                            </a>
                                        @endif

                                        @if ($estadoAudiencia === 'Programada' && $puedeDiferir)
                                            <form action="{{ route('audiencias.diferir', $audiencia) }}" method="POST"
                                                onsubmit="return confirm('¿Desea diferir esta audiencia?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn-danger btn-sm">
                                                    Diferir
                                                </button>
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
