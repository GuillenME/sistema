@extends('layouts.app')

@section('title', 'Psicólogos')

@section('content')
    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Catálogo</div>
                <h1 class="page-title">Psicólogos</h1>
                <p class="page-subtitle">Consulta y administra los psicólogos registrados.</p>
            </div>
            <a href="{{ route('psicologos.create') }}" class="btn-primary">Nuevo psicólogo</a>
        </div>

        @if($psicologos->count() > 0)
            <div class="panel table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Nombre</th>
                            <th style="width: 260px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($psicologos as $psicologo)
                            <tr>
                                <td><strong>#{{ $psicologo->id }}</strong></td>
                                <td>
                                    <span class="text-strong">
                                        {{ $psicologo->nombre }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('psicologos.show', $psicologo) }}" class="btn-info btn-sm">Ver</a>

                                        <a href="{{ route('psicologos.edit', $psicologo) }}" class="btn-secondary btn-sm">
                                            Editar
                                        </a>

                                        <form action="{{ route('psicologos.destroy', $psicologo) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Desea eliminar este psicólogo?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-danger btn-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $psicologos->links() }}
            </div>
        @else
            <div class="panel empty-state">
                <div class="empty-state-mark"></div>

                <h3>No hay psicólogos registrados</h3>

                <p style="margin: 10px 0 24px;">
                    Comienza agregando un nuevo psicólogo al sistema.
                </p>

                <a href="{{ route('psicologos.create') }}" class="btn-primary">
                    Crear primer psicólogo
                </a>
            </div>
        @endif
    </div>
@endsection