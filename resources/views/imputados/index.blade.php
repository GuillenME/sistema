@extends('layouts.app')

@section('title', 'Imputados')

@push('styles')
    <style>
        .search-card {
            background: #fff;
            border: 1px solid var(--gold);
            padding: 18px;
            box-shadow: 0 8px 20px rgba(89, 63, 38, 0.08);
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-input {
            width: 350px !important;
            max-width: 100%;
            height: 42px;
            padding: 0 14px !important;
            border: 1px solid var(--copper) !important;
            border-radius: 8px;
            font-size: 14px;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--gold) !important;
            box-shadow: 0 0 0 3px rgba(199, 154, 89, .2);
        }

        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input {
                width: 100% !important;
            }
        }
    </style>
@endpush
@section('content')
    @php $userRole = Auth::user()->role->tipo ?? ''; @endphp

    <div class="page-shell">
        <div class="page-header">
            <div>
                <div class="page-kicker">Catalogo</div>
                <h1 class="page-title">Imputados</h1>
                <p class="page-subtitle">Consulta y administra los imputados registrados.</p>
            </div>
            <a href="{{ route('imputados.create') }}" class="btn-primary">Nuevo imputado</a>
        </div>
        <div class="search-card">
            <form method="GET" action="{{ route('imputados.index') }}" class="search-form">

                <input type="text" name="buscar" value="{{ request('buscar') }}"
                    placeholder="🔍 Buscar por nombre o apellidos..." class="search-input">

                <button type="submit" class="btn-primary">
                    Buscar
                </button>

                @if (request('buscar'))
                    <a href="{{ route('imputados.index') }}" class="btn-secondary">
                        Limpiar
                    </a>
                @endif

            </form>
        </div>
        @if ($imputados->count() > 0)
            <div class="panel table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Fecha Registro</th>
                            <th>Audiencias</th>
                            <th style="width: 260px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imputados as $imputado)
                            <tr>
                                <td><strong>#{{ $imputado->id }}</strong></td>
                                <td><span class="text-strong">{{ $imputado->nombre }}</span></td>
                                <td><span class="text-muted">{{ $imputado->apellidos }}</span></td>
                                <td>
                                    {{ $imputado->fecha_registro ? \Carbon\Carbon::parse($imputado->fecha_registro)->format('d/m/Y') : 'Sin fecha' }}
                                </td>

                                <td><span class="badge">{{ $imputado->audiencias_count }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('imputados.show', $imputado) }}" class="btn-info btn-sm">Ver</a>
                                        @if ($userRole === 'admin')
                                            <a href="{{ route('imputados.edit', $imputado) }}"
                                                class="btn-secondary btn-sm">Editar</a>

                                            <form action="{{ route('imputados.destroy', $imputado) }}" method="POST"
                                                onsubmit="return confirm('Desea eliminar este imputado?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $imputados->links() }}
            </div>
        @else
            <div class="panel empty-state">
                <div class="empty-state-mark"></div>
                <h3>No hay imputados registrados</h3>
                <p style="margin: 10px 0 24px;">Comienza agregando un nuevo imputado al sistema.</p>
                <a href="{{ route('imputados.create') }}" class="btn-primary">Crear primer imputado</a>
            </div>
        @endif
    </div>
@endsection
