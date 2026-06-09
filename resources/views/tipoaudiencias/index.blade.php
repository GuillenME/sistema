@extends('layouts.app')

@section('title', 'Tipos de audiencia')

@push('styles')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
    .page-title { font-size: 2rem; font-weight: 800; color: #111827; }
    .btn-primary { display: inline-flex; align-items: center; gap: 8px; background: #4f46e5; color: white; padding: 12px 24px; border-radius: 12px; font-weight: 700; transition: background 0.2s; }
    .btn-primary:hover { background: #3730a3; }
    .btn-sm { padding: 8px 12px; font-size: 0.875rem; }
    .btn-secondary { background: #6b7280; color: white; padding: 8px 12px; border-radius: 8px; font-weight: 600; transition: background 0.2s; }
    .btn-secondary:hover { background: #4b5563; }
    .btn-danger { background: #dc2626; color: white; padding: 8px 12px; border-radius: 8px; font-weight: 600; transition: background 0.2s; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-info { background: #3b82f6; color: white; padding: 8px 12px; border-radius: 8px; font-weight: 600; transition: background 0.2s; }
    .btn-info:hover { background: #2563eb; }
    .table-container { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f3f4f6; padding: 16px; text-align: left; font-weight: 700; color: #374151; border-bottom: 2px solid #e5e7eb; }
    td { padding: 16px; border-bottom: 1px solid #e5e7eb; }
    tr:hover { background: #f9fafb; }
    .empty-state { text-align: center; padding: 60px 24px; color: #6b7280; }
    .empty-state-icon { font-size: 3rem; margin-bottom: 16px; }
    .actions { display: flex; gap: 8px; align-items: center; }
    .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 32px; }
    .pagination a, .pagination span { padding: 8px 12px; border-radius: 8px; border: 1px solid #e5e7eb; }
    .pagination .active { background: #4f46e5; color: white; border-color: #4f46e5; }
    .pagination a:hover { background: #f3f4f6; }
</style>
@endpush

@section('content')
    <div class="page-header">
        <h1 class="page-title">Tipos de audiencia</h1>
        <a href="{{ route('tipoaudiencias.create') }}" class="btn-primary">
            Nuevo tipo de audiencia
        </a>
    </div>

    @if($tipoaudiencias->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Tipo de audiencia</th>
                        <th style="width: 220px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tipoaudiencias as $tipoaudiencia)
                        <tr>
                            <td><strong>#{{ $tipoaudiencia->id }}</strong></td>
                            <td>
                                <div style="font-weight: 600; color: #111827;">{{ $tipoaudiencia->tipo }}</div>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('tipoaudiencias.show', $tipoaudiencia) }}" class="btn-info btn-sm">Ver</a>
                                    <a href="{{ route('tipoaudiencias.edit', $tipoaudiencia) }}" class="btn-secondary btn-sm">Editar</a>
                                    <form action="{{ route('tipoaudiencias.destroy', $tipoaudiencia) }}" method="POST" style="display: inline;" onsubmit="return confirm('Desea eliminar este tipo de audiencia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $tipoaudiencias->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">--</div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 8px;">No hay tipos de audiencia registrados</h3>
            <p style="margin-bottom: 24px;">Comienza agregando un nuevo tipo de audiencia al sistema</p>
            <a href="{{ route('tipoaudiencias.create') }}" class="btn-primary">Crear primer tipo de audiencia</a>
        </div>
    @endif
@endsection
