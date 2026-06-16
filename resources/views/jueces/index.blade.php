@extends('layouts.app')

@section('title', 'Jueces')

@section('content')
    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Catalogo</div>
                <h1 class="page-title">Jueces</h1>
                <p class="page-subtitle">Consulta y administra los jueces registrados en el sistema.</p>
            </div>
            <a href="{{ route('jueces.create') }}" class="btn-primary">Nuevo juez</a>
        </div>

        @if($jueces->count() > 0)
            <div class="panel table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Lugar</th>
                            <th style="width: 260px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jueces as $juez)
                            <tr>
                                <td><strong>#{{ $juez->id }}</strong></td>
                                <td><span class="text-strong">{{ $juez->nombre }}</span></td>
                                <td><span class="text-muted">{{ $juez->apellidos }}</span></td>
                                <td><span class="text-muted">{{ $juez->lugar ?? '-' }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('jueces.show', $juez) }}" class="btn-info btn-sm">Ver</a>
                                        <a href="{{ route('jueces.edit', $juez) }}" class="btn-secondary btn-sm">Editar</a>
                                        <form action="{{ route('jueces.destroy', $juez) }}" method="POST" onsubmit="return confirm('Desea eliminar este juez?');">
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
                {{ $jueces->links() }}
            </div>
        @else
            <div class="panel empty-state">
                <div class="empty-state-mark"></div>
                <h3>No hay jueces registrados</h3>
                <p style="margin: 10px 0 24px;">Comienza agregando un nuevo juez al sistema.</p>
                <a href="{{ route('jueces.create') }}" class="btn-primary">Crear primer juez</a>
            </div>
        @endif
    </div>
@endsection
