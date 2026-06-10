@extends('layouts.app')

@section('title', 'Traductor: ' . $traductor->nombres)

@section('content')
    <div class="detail-container">
        <div class="detail-card">

            <h1 class="detail-title">{{ $traductor->nombres }}</h1>
            <p class="detail-id">ID: #{{ $traductor->id }}</p>

            <div class="detail-field">
                <div class="detail-label">Nombre</div>
                <div class="detail-value">{{ $traductor->nombres }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Lengua</div>
                <div class="detail-value">{{ $traductor->lengua }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Estado</div>
                <span class="badge">Activo</span>
            </div>

            <div class="detail-actions">
                <a href="{{ route('traductores.edit', $traductor) }}" class="btn-edit">Editar</a>

                <form action="{{ route('traductores.destroy', $traductor) }}"
                      method="POST"
                      onsubmit="return confirm('Desea eliminar este traductor? Esta accion no se puede deshacer.');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-delete">Eliminar</button>
                </form>

                <a href="{{ route('traductores.index') }}" class="btn-back">Volver</a>
            </div>

        </div>
    </div>
@endsection
