@extends('layouts.app')

@section('title', 'Editar Juez')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar juez</h1>
            <p class="form-subtitle">Actualiza la informacion del juez #{{ $juez->id }}.</p>

            <form action="{{ route('jueces.update', $juez) }}" method="POST" class="form-grid">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan" value="{{ old('nombre', $juez->nombre) }}" required>
                    @error('nombre')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos *</label>
                    <input type="text" id="apellidos" name="apellidos" placeholder="Ej: Garcia Lopez" value="{{ old('apellidos', $juez->apellidos) }}" required>
                    @error('apellidos')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="lugar">Lugar</label>
                    <input type="text" id="lugar" name="lugar" placeholder="Ej: Ocosingo" value="{{ old('lugar', $juez->lugar) }}">
                    @error('lugar')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar cambios</button>
                    <a href="{{ route('jueces.show', $juez) }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
