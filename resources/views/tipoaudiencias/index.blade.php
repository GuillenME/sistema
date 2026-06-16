@extends('layouts.app')

@section('title', 'Tipos de audiencia')

@section('content')
    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Catalogo</div>
                <h1 class="page-title">Tipos de audiencia</h1>
                <p class="page-subtitle">Consulta y administra los tipos de audiencia disponibles.</p>
            </div>
            <a href="{{ route('tipoaudiencias.create') }}" class="btn-primary">Nuevo tipo de audiencia</a>
        </div>

        @if($tipoaudiencias->count() > 0)
            <div class="panel table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Tipo de audiencia</th>
                            <th style="width: 260px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tipoaudiencias as $tipoaudiencia)
                            <tr>
                                <td><strong>#{{ $tipoaudiencia->id }}</strong></td>
                                <td><span class="text-strong">{{ $tipoaudiencia->tipo }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('tipoaudiencias.show', $tipoaudiencia) }}" class="btn-info btn-sm">Ver</a>
                                        <a href="{{ route('tipoaudiencias.edit', $tipoaudiencia) }}" class="btn-secondary btn-sm">Editar</a>
                                        <form action="{{ route('tipoaudiencias.destroy', $tipoaudiencia) }}" method="POST" onsubmit="return confirm('Desea eliminar este tipo de audiencia?');">
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
            <div class="panel empty-state">
                <div class="empty-state-mark"></div>
                <h3>No hay tipos de audiencia registrados</h3>
                <p style="margin: 10px 0 24px;">Comienza agregando un nuevo tipo de audiencia al sistema.</p>
                <a href="{{ route('tipoaudiencias.create') }}" class="btn-primary">Crear primer tipo de audiencia</a>
            </div>
        @endif
    </div>
@endsection
