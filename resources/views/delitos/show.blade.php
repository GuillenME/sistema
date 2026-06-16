@extends('layouts.app')

@section('title', 'Delito: ' . $delito->delito)

@section('content')
    <div class="detail-container">
        <div class="detail-card">
            <h1 class="detail-title">{{ $delito->delito }}</h1>
            <p class="detail-id">ID: #{{ $delito->id }}</p>

            <div class="detail-field">
                <div class="detail-label">Estado</div>
                <span class="badge">Activo</span>
            </div>

            @if($delito->audiencias->count() > 0)
                <div class="related-info">
                    <div class="related-info-title">Audiencias asociadas</div>
                    <div>Este delito esta vinculado a {{ $delito->audiencias->count() }} audiencia(s) en el sistema.</div>
                </div>
            @endif

            <div class="detail-actions">
                <a href="{{ route('delitos.edit', $delito) }}" class="btn-edit">Editar</a>
                <form action="{{ route('delitos.destroy', $delito) }}" method="POST" onsubmit="return confirm('Desea eliminar este delito? Esta accion no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Eliminar</button>
                </form>
                <a href="{{ route('delitos.index') }}" class="btn-back">Volver</a>
            </div>
        </div>
    </div>
@endsection
