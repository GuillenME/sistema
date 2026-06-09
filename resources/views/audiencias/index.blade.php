@extends('layouts.app')

@section('title', 'Audiencias')

@section('content')
    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Agenda</div>
                <h1 class="page-title">Audiencias</h1>
                <p class="page-subtitle">Listado general de audiencias registradas.</p>
            </div>

            @if(in_array(Auth::user()->role->tipo, ['admin', 'oficinista']))
                <a href="{{ route('audiencias.create') }}" class="btn-primary">Nueva audiencia</a>
            @endif
        </div>

        <div class="panel table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Causa</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Delito</th>
                        <th>Tipo</th>
                        <th>Juez</th>
                        <th>Traductor</th>
                        <th>Psicologo</th>
                        <th>Sala</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($audiencias as $audiencia)
                        <tr>
                            <td><strong>#{{ $audiencia->id }}</strong></td>
                            <td><span class="text-strong">{{ $audiencia->causa }}</span></td>
                            <td>{{ optional($audiencia->fecha)->format('Y-m-d') ?? '-' }}</td>
                            <td>{{ optional($audiencia->hora)->format('H:i') ?? $audiencia->hora ?? '-' }}</td>
                            <td>{{ optional($audiencia->delito)->delito ?? '-' }}</td>
                            <td>{{ optional($audiencia->tipoAudiencia)->tipo ?? '-' }}</td>
                            <td>{{ optional($audiencia->juez)->nombre ?? '-' }}</td>
                            <td>{{ optional($audiencia->traductor)->nombres ?? '-' }}</td>
                            <td>{{ optional($audiencia->psicologo)->nombre ?? '-' }}</td>
                            <td><span class="badge">{{ optional($audiencia->sala)->sala ?? '-' }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
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
