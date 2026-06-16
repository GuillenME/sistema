@extends('layouts.app')

@section('title', 'Crear Juez')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Nuevo juez</h1>
            <p class="form-subtitle">Registra la informacion del juez.</p>

            <form action="{{ route('jueces.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos *</label>
                    <input type="text" id="apellidos" name="apellidos" placeholder="Ej: Garcia Lopez" value="{{ old('apellidos') }}" required>
                    @error('apellidos')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="lugar">Lugar</label>
                    <input type="text" id="lugar" name="lugar" placeholder="Ej: Ocosingo" value="{{ old('lugar') }}">
                    @error('lugar')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Crear juez</button>
                    <a href="{{ route('jueces.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
