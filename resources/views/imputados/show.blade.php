@extends('layouts.app')

@section('title', 'Imputado: ' . $imputado->nombre . ' ' . $imputado->apellidos)

@section('content')
    @php $userRole = Auth::user()->role->tipo ?? ''; @endphp

    <div class="detail-container">
        <div class="detail-card">
            <h1 class="detail-title">{{ $imputado->nombre }} {{ $imputado->apellidos }}</h1>
            <p class="detail-id">ID: #{{ $imputado->id }}</p>

            <div class="detail-field">
                <div class="detail-label">Nombre</div>
                <div class="detail-value">{{ $imputado->nombre }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Apellidos</div>
                <div class="detail-value">{{ $imputado->apellidos }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Fecha de registro</div>
                <div class="detail-value">
                    {{ \Carbon\Carbon::parse($imputado->fecha_registro)->format('d/m/Y') }}
                </div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Causa inicial</div>
                <div class="detail-value">
                    {{ $imputado->causa ?? 'No registrada' }}
                </div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Delito inicial</div>
                <div class="detail-value">
                    {{ $imputado->delito->delito ?? 'No registrado' }}
                </div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Estado</div>
                <span class="badge">Activo</span>
            </div>

            @if ($imputado->audiencias->count() > 0)
                <div class="related-info">

                    <div class="related-info-title">
                        Resumen de audiencias
                    </div>

                    <div style="margin-bottom:20px;">
                        <strong>Total de audiencias:</strong>
                        {{ $imputado->audiencias->count() }}
                    </div>

                    @if ($ultimaAudiencia)
                        <div
                            style="
                background:#fff;
                border-left:5px solid var(--wine);
                padding:16px;
                margin-top:10px;
            ">
                            <h4 style="color:var(--wine); margin-bottom:12px;">
                                Última audiencia registrada
                            </h4>

                            <p>
                                <strong>Causa:</strong>
                                {{ $ultimaAudiencia->causa }}
                            </p>

                            <p>
                                <strong>Fecha:</strong>
                                {{ $ultimaAudiencia->fecha->format('d/m/Y') }}
                            </p>

                            <p>
                                <strong>Juez:</strong>
                                {{ $ultimaAudiencia->juez->nombre ?? 'No asignado' }}
                            </p>


                        </div>
                    @endif

                </div>
            @endif

            <div class="detail-actions">
                @if ($userRole === 'admin')
                    <a href="{{ route('imputados.edit', $imputado) }}" class="btn-edit">Editar</a>

                    <form action="{{ route('imputados.destroy', $imputado) }}" method="POST"
                        onsubmit="return confirm('Desea eliminar este imputado? Esta accion no se puede deshacer.');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-delete">Eliminar</button>
                    </form>
                @endif

                <a href="{{ route('imputados.index') }}" class="btn-back">Volver</a>
            </div>
        </div>
    </div>
@endsection
