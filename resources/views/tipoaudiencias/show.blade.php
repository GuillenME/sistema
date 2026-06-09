@extends('layouts.app')

@section('title', 'Tipo de audiencia: ' . $tipoaudiencia->tipo)

@push('styles')
<style>
    .detail-container { max-width: 600px; margin: 0 auto; }
    .detail-card { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .detail-header { margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-start; }
    .detail-title { font-size: 2rem; font-weight: 800; color: #111827; }
    .detail-id { font-size: 0.875rem; color: #6b7280; margin-top: 4px; }
    .detail-field { margin-bottom: 24px; }
    .detail-label { font-size: 0.875rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
    .badge { display: inline-block; background: #dbeafe; color: #1e40af; padding: 6px 12px; border-radius: 999px; font-size: 0.875rem; font-weight: 600; }
    .detail-actions { display: flex; gap: 12px; margin-top: 32px; padding-top: 32px; border-top: 2px solid #e5e7eb; }
    .btn-edit { background: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; transition: background 0.2s; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-edit:hover { background: #2563eb; }
    .btn-delete { background: #dc2626; color: white; padding: 12px 24px; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; transition: background 0.2s; }
    .btn-delete:hover { background: #b91c1c; }
    .btn-back { background: #e5e7eb; color: #374151; padding: 12px 24px; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; transition: background 0.2s; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-back:hover { background: #d1d5db; }
    .related-info { background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 16px; border-radius: 8px; margin-top: 32px; }
    .related-info-title { font-weight: 700; color: #1e40af; margin-bottom: 8px; }
    .related-info-text { color: #1e3a8a; font-size: 0.95rem; }
</style>
@endpush

@section('content')
    <div class="detail-container">
        <div class="detail-card">
            <div class="detail-header">
                <div>
                    <h1 class="detail-title">{{ $tipoaudiencia->tipo }}</h1>
                    <p class="detail-id">ID: #{{ $tipoaudiencia->id }}</p>
                </div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Estado</div>
                <span class="badge">Activo</span>
            </div>

            @if($tipoaudiencia->audiencias->count() > 0)
                <div class="related-info">
                    <div class="related-info-title">Audiencias asociadas</div>
                    <div class="related-info-text">
                        Este tipo de audiencia esta vinculado a {{ $tipoaudiencia->audiencias->count() }} audiencia(s) en el sistema.
                    </div>
                </div>
            @endif

            <div class="detail-actions">
                <a href="{{ route('tipoaudiencias.edit', $tipoaudiencia) }}" class="btn-edit">Editar</a>
                <form action="{{ route('tipoaudiencias.destroy', $tipoaudiencia) }}" method="POST" style="display: inline;" onsubmit="return confirm('Desea eliminar este tipo de audiencia? Esta accion no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Eliminar</button>
                </form>
                <a href="{{ route('tipoaudiencias.index') }}" class="btn-back">Volver</a>
            </div>
        </div>
    </div>
@endsection
