@extends('layouts.app')

@section('title', 'Editar Imputado')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar imputado</h1>
            <p class="form-subtitle">Actualiza la informacion del imputado #{{ $imputado->id }}.</p>

            <form action="{{ route('imputados.update', $imputado) }}" method="POST" class="form-grid">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $imputado->nombre) }}" required>
                    @error('nombre')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos *</label>
                    <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos', $imputado->apellidos) }}" required>
                    @error('apellidos')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar cambios</button>
                    <a href="{{ route('imputados.show', $imputado) }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
