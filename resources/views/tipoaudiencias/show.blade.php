@extends('layouts.app')

@section('title', 'Tipo de audiencia: ' . $tipoaudiencia->tipo)

@section('content')
    <div class="detail-container">
        <div class="detail-card">
            <h1 class="detail-title">{{ $tipoaudiencia->tipo }}</h1>
            <p class="detail-id">ID: #{{ $tipoaudiencia->id }}</p>

            <div class="detail-field">
                <div class="detail-label">Estado</div>
                <span class="badge">Activo</span>
            </div>

            @if($tipoaudiencia->audiencias->count() > 0)
                <div class="related-info">
                    <div class="related-info-title">Audiencias asociadas</div>
                    <div>Este tipo de audiencia esta vinculado a {{ $tipoaudiencia->audiencias->count() }} audiencia(s) en el sistema.</div>
                </div>
            @endif

            <div class="detail-actions">
                <a href="{{ route('tipoaudiencias.edit', $tipoaudiencia) }}" class="btn-edit">Editar</a>
                <form action="{{ route('tipoaudiencias.destroy', $tipoaudiencia) }}" method="POST" onsubmit="return confirm('Desea eliminar este tipo de audiencia? Esta accion no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Eliminar</button>
                </form>
                <a href="{{ route('tipoaudiencias.index') }}" class="btn-back">Volver</a>
            </div>
        </div>
    </div>
@endsection
