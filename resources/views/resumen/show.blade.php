@extends('layouts.app')

@section('title', 'Resumen #' . $resumen->id)

@section('content')
    @php $userRole = Auth::user()->role->tipo ?? ''; @endphp

    <div class="detail-container">
        <div class="detail-card">
            <h1 class="detail-title">Resumen #{{ $resumen->id }}</h1>
            <p class="detail-id">{{ optional($resumen->audiencia)->causa ?? 'Audiencia no disponible' }}</p>

            <div class="detail-field">
                <div class="detail-label">Audiencia</div>
                <div class="detail-value">
                    #{{ optional($resumen->audiencia)->id ?? '-' }}
                    - {{ optional(optional($resumen->audiencia)->fecha)->format('Y-m-d') ?? '-' }}
                    - {{ optional(optional($resumen->audiencia)->tipoAudiencia)->tipo ?? '-' }}
                </div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Imputados</div>
                <div class="detail-value">
                    {{ optional($resumen->audiencia)->imputados
                        ? $resumen->audiencia->imputados->map(function ($imputado) {
                                return trim($imputado->nombre . ' ' . $imputado->apellidos);
                            })->implode(', ')
                        : '-' }}
                </div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Hora inicio</div>
                <div class="detail-value">{{ optional($resumen->hora_inicio)->format('H:i') ?? '-' }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Hora final</div>
                <div class="detail-value">{{ optional($resumen->hora_final)->format('H:i') ?? '-' }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Defensa</div>
                <div class="detail-value">{{ $resumen->defensa ?? '-' }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Fiscalia</div>
                <div class="detail-value">{{ $resumen->fiscalia ?? '-' }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Auxiliar de sala</div>
                <div class="detail-value">{{ $resumen->auxiliar ?? '-' }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Victima(s)</div>
                <div class="detail-value">{{ $resumen->victima ?? '-' }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Plazo de investigación</div>
                <div class="detail-value">{{ $resumen->plazo ?? '-' }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Medida cautelar</div>
                <div class="detail-value">{{ $resumen->medida ?? '-' }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Resumen de los hechos ocurridos</div>
                <div class="detail-value">{{ $resumen->hechos_ocurridos ?? '-' }}</div>
            </div>

            <div class="detail-actions">
                @if (in_array($userRole, ['admin', 'oficinista']))
                    <a href="{{ route('resumen.edit', $resumen) }}" class="btn-edit">Editar</a>
                    <form action="{{ route('resumen.destroy', $resumen) }}" method="POST"
                        onsubmit="return confirm('Desea eliminar este resumen? Esta accion no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Eliminar</button>
                    </form>
                @endif

                <a href="{{ route('resumen.index') }}" class="btn-back">Volver</a>
            </div>
        </div>
    </div>
@endsection
