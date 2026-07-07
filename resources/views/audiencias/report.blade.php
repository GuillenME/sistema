@extends('layouts.app')

@section('title', 'Reporte de audiencias')

@section('content')
    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Agenda</div>
                <h1 class="page-title">Reporte de audiencias</h1>
                <p class="page-subtitle">Filtra y genera reportes en pantalla, Excel o PDF.</p>
            </div>
            <a href="{{ route('audiencias.index') }}" class="btn-secondary">Volver al listado</a>
        </div>

        <div class="panel" style="padding: 24px;">
            <form method="GET" action="{{ route('audiencias.report') }}" class="form-grid">
                <div class="form-group">
                    <label for="fecha_desde">Fecha desde</label>
                    <input type="date" id="fecha_desde" name="fecha_desde"
                        value="{{ old('fecha_desde', $filters['fecha_desde'] ?? '') }}">
                    @error('fecha_desde')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_hasta">Fecha hasta</label>
                    <input type="date" id="fecha_hasta" name="fecha_hasta"
                        value="{{ old('fecha_hasta', $filters['fecha_hasta'] ?? '') }}">
                    @error('fecha_hasta')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado">
                        <option value="">Todos</option>
                        <option value="Programada" {{ ($filters['estado'] ?? '') === 'Programada' ? 'selected' : '' }}>
                            Programada</option>
                        <option value="Diferida" {{ ($filters['estado'] ?? '') === 'Diferida' ? 'selected' : '' }}>Diferida
                        </option>
                        <option value="Finalizada" {{ ($filters['estado'] ?? '') === 'Finalizada' ? 'selected' : '' }}>
                            Finalizada</option>
                    </select>
                    @error('estado')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="modalidad">Modalidad</label>
                    <select id="modalidad" name="modalidad">
                        <option value="">Todas</option>
                        <option value="Presencial" {{ ($filters['modalidad'] ?? '') === 'Presencial' ? 'selected' : '' }}>
                            Presencial</option>
                        <option value="Virtual" {{ ($filters['modalidad'] ?? '') === 'Virtual' ? 'selected' : '' }}>Virtual
                        </option>
                    </select>
                    @error('modalidad')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tipo_audiencia_id">Tipo de audiencia</label>
                    <select id="tipo_audiencia_id" name="tipo_audiencia_id">
                        <option value="">Todos</option>
                        @foreach ($tipoAudiencias as $tipo)
                            <option value="{{ $tipo->id }}"
                                {{ (string) ($filters['tipo_audiencia_id'] ?? '') === (string) $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->tipo }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_audiencia_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="juez_id">Juez</label>
                    <select id="juez_id" name="juez_id">
                        <option value="">Todos</option>
                        @foreach ($jueces as $juez)
                            <option value="{{ $juez->id }}"
                                {{ (string) ($filters['juez_id'] ?? '') === (string) $juez->id ? 'selected' : '' }}>
                                {{ $juez->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('juez_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Generar reporte</button>
                    <a href="{{ route('audiencias.report') }}" class="btn-secondary">Limpiar filtros</a>
                </div>
            </form>
        </div>

        <div class="panel" style="padding: 24px;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 18px;">
                <div>
                    <div class="page-kicker">Resultados</div>
                    <h2 style="color: var(--wine); font-size: 1.4rem; font-weight: 800;">
                        {{ $audiencias->count() }} audiencia(s) encontrada(s)
                    </h2>
                </div>
                <div class="actions">
                    <a href="{{ route('audiencias.report.export', request()->query()) }}" class="btn-info">Exportar
                        Excel</a>
                    <a href="{{ route('audiencias.report.print', request()->query()) }}" class="btn-secondary"
                        target="_blank">Imprimir / PDF</a>
                </div>
            </div>

            @if ($audiencias->count() > 0)
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Causa</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Delito</th>
                                <th>Tipo</th>
                                <th>Imputados</th>
                                <th>Sala</th>
                                <th>Modalidad</th>
                                <th>Juez</th>
                                <th>Traductor</th>
                                <th>Psicólogo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($audiencias as $audiencia)
                                <tr>
                                    <td><strong>#{{ $audiencia->id }}</strong></td>
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
                                    <td>{{ optional($audiencia->sala)->sala ?? '-' }}</td>
                                    <td>{{ $audiencia->modalidad ?? '-' }}</td>
                                    <td>{{ optional($audiencia->juez)->nombre ?? '-' }}</td>
                                    <td>
                                        @if ($audiencia->traductor)
                                            {{ $audiencia->traductor->nombres }}
                                            @if ($audiencia->traductor->lengua)
                                                - {{ $audiencia->traductor->lengua }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>{{ optional($audiencia->psicologo)->nombre ?? '-' }}</td>
                                    <td>{{ $audiencia->estado ?? 'Programada' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-mark"></div>
                    <h3>No hay audiencias con esos filtros</h3>
                </div>
            @endif
        </div>
    </div>
@endsection
