@extends('layouts.app')

@section('title', 'Juez: ' . $juez->nombre . ' ' . $juez->apellidos)

@section('content')
    <div class="detail-container">
        <div class="detail-card">
            <h1 class="detail-title">{{ $juez->nombre }} {{ $juez->apellidos }}</h1>
            <p class="detail-id">ID: #{{ $juez->id }}</p>

            <div class="detail-field">
                <div class="detail-label">Nombre</div>
                <div class="detail-value">{{ $juez->nombre }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Apellidos</div>
                <div class="detail-value">{{ $juez->apellidos }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Lugar</div>
                <div class="detail-value">{{ $juez->lugar ?? '-' }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Estado</div>
                <span class="badge">Activo</span>
            </div>

            @if($juez->audiencias->count() > 0)
                <div class="related-info">
                    <div class="related-info-title">Audiencias asociadas</div>
                    <div>Este juez esta vinculado a {{ $juez->audiencias->count() }} audiencia(s) en el sistema.</div>
                </div>
            @endif

            <div class="detail-actions">
                <a href="{{ route('jueces.edit', $juez) }}" class="btn-edit">Editar</a>
                <form action="{{ route('jueces.destroy', $juez) }}" method="POST" onsubmit="return confirm('Desea eliminar este juez? Esta accion no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Eliminar</button>
                </form>
                <a href="{{ route('jueces.index') }}" class="btn-back">Volver</a>
            </div>
        </div>
    </div>
@endsection
