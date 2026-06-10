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
                <div class="detail-label">Estado</div>
                <span class="badge">Activo</span>
            </div>

            @if($imputado->audiencias->count() > 0)
                <div class="related-info">
                    <div class="related-info-title">Audiencias asociadas</div>
                    <div>Este imputado esta vinculado a {{ $imputado->audiencias->count() }} audiencia(s) en el sistema.</div>
                </div>
            @endif

            <div class="detail-actions">
                @if($userRole === 'admin')
                    <a href="{{ route('imputados.edit', $imputado) }}" class="btn-edit">Editar</a>

                    <form action="{{ route('imputados.destroy', $imputado) }}"
                          method="POST"
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
