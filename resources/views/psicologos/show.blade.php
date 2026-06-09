@extends('layouts.app')

@section('title', 'Psicólogo: ' . $psicologo->nombre)

@section('content')
    <div class="detail-container">
        <div class="detail-card">

            <h1 class="detail-title">
                {{ $psicologo->nombre }}
            </h1>

            <p class="detail-id">
                ID: #{{ $psicologo->id }}
            </p>

            <div class="detail-field">
                <div class="detail-label">
                    Nombre
                </div>

                <div class="detail-value">
                    {{ $psicologo->nombre }}
                </div>
            </div>

            <div class="detail-field">
                <div class="detail-label">
                    Estado
                </div>

                <span class="badge">
                    Activo
                </span>
            </div>

            <div class="detail-actions">
                <a href="{{ route('psicologos.edit', $psicologo) }}"
                   class="btn-edit">
                    Editar
                </a>

                <form action="{{ route('psicologos.destroy', $psicologo) }}"
                      method="POST"
                      onsubmit="return confirm('¿Desea eliminar este psicólogo? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-delete">
                        Eliminar
                    </button>
                </form>

                <a href="{{ route('psicologos.index') }}"
                   class="btn-back">
                    Volver
                </a>
            </div>

        </div>
    </div>
@endsection