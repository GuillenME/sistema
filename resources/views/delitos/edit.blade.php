@extends('layouts.app')

@section('title', 'Editar Delito')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar delito</h1>
            <p class="form-subtitle">Actualiza la informacion del delito #{{ $delito->id }}.</p>

            <form action="{{ route('delitos.update', $delito) }}" method="POST" class="form-grid">
                @csrf
                @method('PUT')

                <div class="form-group full">
                    <label for="delito">Nombre del delito *</label>
                    <input type="text" id="delito" name="delito" placeholder="Ej: Robo a mano armada" value="{{ old('delito', $delito->delito) }}" required>
                    @error('delito')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar cambios</button>
                    <a href="{{ route('delitos.show', $delito) }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
