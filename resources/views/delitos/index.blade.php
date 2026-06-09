@extends('layouts.app')

@section('title', 'Delitos')

@section('content')
    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Catalogo</div>
                <h1 class="page-title">Delitos</h1>
                <p class="page-subtitle">Consulta y administra los delitos disponibles para las audiencias.</p>
            </div>
            <a href="{{ route('delitos.create') }}" class="btn-primary">Nuevo delito</a>
        </div>

        @if($delitos->count() > 0)
            <div class="panel table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Delito</th>
                            <th style="width: 260px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($delitos as $delito)
                            <tr>
                                <td><strong>#{{ $delito->id }}</strong></td>
                                <td><span class="text-strong">{{ $delito->delito }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('delitos.show', $delito) }}" class="btn-info btn-sm">Ver</a>
                                        <a href="{{ route('delitos.edit', $delito) }}" class="btn-secondary btn-sm">Editar</a>
                                        <form action="{{ route('delitos.destroy', $delito) }}" method="POST" onsubmit="return confirm('Desea eliminar este delito?');">
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
                {{ $delitos->links() }}
            </div>
        @else
            <div class="panel empty-state">
                <div class="empty-state-mark"></div>
                <h3>No hay delitos registrados</h3>
                <p style="margin: 10px 0 24px;">Comienza agregando un nuevo delito al sistema.</p>
                <a href="{{ route('delitos.create') }}" class="btn-primary">Crear primer delito</a>
            </div>
        @endif
    </div>
@endsection
