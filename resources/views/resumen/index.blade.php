@extends('layouts.app')

@section('title', 'Resumen')

@section('content')
    @php $userRole = Auth::user()->role->tipo ?? ''; @endphp

    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Audiencias</div>
                <h1 class="page-title">Resumen</h1>
                <p class="page-subtitle">Consulta los datos finales registrados para las audiencias.</p>
            </div>

            @if(in_array($userRole, ['admin', 'oficinista']))
                <a href="{{ route('resumen.create') }}" class="btn-primary">Nuevo resumen</a>
            @endif
        </div>

        @if($resumenes->count() > 0)
            <div class="panel table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Audiencia</th>
                            <th>Fecha</th>
                            <th>Imputados</th>
                            <th>Hora inicio</th>
                            <th>Hora final</th>
                            <th>Defensa</th>
                            <th>Fiscalia</th>
                            <th>Medida</th>
                            <th style="width: 240px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resumenes as $resumen)
                            <tr>
                                <td><strong>#{{ $resumen->id }}</strong></td>
                                <td>
                                    <span class="text-strong">
                                        {{ optional($resumen->audiencia)->causa ?? 'Audiencia no disponible' }}
                                    </span>
                                    <div class="text-muted">
                                        {{ optional(optional($resumen->audiencia)->tipoAudiencia)->tipo ?? '-' }}
                                    </div>
                                </td>
                                <td>{{ optional(optional($resumen->audiencia)->fecha)->format('Y-m-d') ?? '-' }}</td>
                                <td>
                                    {{ optional($resumen->audiencia)->imputados
                                        ? $resumen->audiencia->imputados->map(function ($imputado) {
                                            return trim($imputado->nombre . ' ' . $imputado->apellidos);
                                        })->implode(', ')
                                        : '-' }}
                                </td>
                                <td>{{ optional($resumen->hora_inicio)->format('H:i') ?? '-' }}</td>
                                <td>{{ optional($resumen->hora_final)->format('H:i') ?? '-' }}</td>
                                <td>{{ $resumen->defensa ?? '-' }}</td>
                                <td>{{ $resumen->fiscalia ?? '-' }}</td>
                                <td>{{ $resumen->medida ?? '-' }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('resumen.show', $resumen) }}" class="btn-info btn-sm">Ver</a>

                                        @if(in_array($userRole, ['admin', 'oficinista']))
                                            <a href="{{ route('resumen.edit', $resumen) }}" class="btn-secondary btn-sm">Editar</a>

                                            <form action="{{ route('resumen.destroy', $resumen) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Desea eliminar este resumen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $resumenes->links() }}
            </div>
        @else
            <div class="panel empty-state">
                <div class="empty-state-mark"></div>
                <h3>No hay resumenes registrados</h3>
                @if(in_array($userRole, ['admin', 'oficinista']))
                    <p style="margin: 10px 0 24px;">Comienza agregando el resumen de una audiencia.</p>
                    <a href="{{ route('resumen.create') }}" class="btn-primary">Crear primer resumen</a>
                @endif
            </div>
        @endif
    </div>
@endsection
