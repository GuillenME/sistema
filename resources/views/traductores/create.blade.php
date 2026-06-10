@extends('layouts.app')

@section('title', 'Crear Traductor')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Nuevo traductor</h1>
            <p class="form-subtitle">Registra un nuevo traductor.</p>

            <form action="{{ route('traductores.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="form-group full">
                    <label for="nombres">Nombre *</label>
                    <input type="text"
                           id="nombres"
                           name="nombres"
                           value="{{ old('nombres') }}"
                           placeholder="Ej: Juan Perez Lopez"
                           required>

                    @error('nombres')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="lengua">Lengua *</label>
                    <input type="text"
                           id="lengua"
                           name="lengua"
                           value="{{ old('lengua') }}"
                           placeholder="Ej: Tseltal"
                           required>

                    @error('lengua')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Crear traductor</button>
                    <a href="{{ route('traductores.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
