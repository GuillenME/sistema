@extends('layouts.app')

@section('title', 'Traductores')

@section('content')
    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Catalogo</div>
                <h1 class="page-title">Traductores</h1>
                <p class="page-subtitle">Consulta y administra los traductores registrados.</p>
            </div>
            <a href="{{ route('traductores.create') }}" class="btn-primary">Nuevo traductor</a>
        </div>

        <x-search-form :action="route('traductores.index')" placeholder="Buscar por nombre o lengua..." />

        @if($traductores->count() > 0)
            <div class="panel table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Nombre</th>
                            <th>Lengua</th>
                            <th style="width: 260px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($traductores as $traductor)
                            <tr>
                                <td><strong>#{{ $traductor->id }}</strong></td>
                                <td><span class="text-strong">{{ $traductor->nombres }}</span></td>
                                <td>{{ $traductor->lengua }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('traductores.show', $traductor) }}" class="btn-info btn-sm">Ver</a>
                                        <a href="{{ route('traductores.edit', $traductor) }}" class="btn-secondary btn-sm">Editar</a>

                                        <form action="{{ route('traductores.destroy', $traductor) }}"
                                              method="POST"
                                              onsubmit="return confirm('Desea eliminar este traductor?');">
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
                {{ $traductores->links() }}
            </div>
        @else
            <div class="panel empty-state">
                <div class="empty-state-mark"></div>
                <h3>No hay traductores registrados</h3>
                <p style="margin: 10px 0 24px;">Comienza agregando un nuevo traductor al sistema.</p>
                <a href="{{ route('traductores.create') }}" class="btn-primary">Crear primer traductor</a>
            </div>
        @endif
    </div>
@endsection
