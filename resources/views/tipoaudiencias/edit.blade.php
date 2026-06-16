@extends('layouts.app')

@section('title', 'Editar tipo de audiencia')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar tipo de audiencia</h1>
            <p class="form-subtitle">Actualiza la informacion del tipo de audiencia #{{ $tipoaudiencia->id }}.</p>

            <form action="{{ route('tipoaudiencias.update', $tipoaudiencia) }}" method="POST" class="form-grid">
                @csrf
                @method('PUT')

                <div class="form-group full">
                    <label for="tipo">Nombre del tipo de audiencia *</label>
                    <input type="text" id="tipo" name="tipo" placeholder="Ej: Inicial" value="{{ old('tipo', $tipoaudiencia->tipo) }}" required>
                    @error('tipo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar cambios</button>
                    <a href="{{ route('tipoaudiencias.show', $tipoaudiencia) }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
