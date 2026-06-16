@extends('layouts.app')

@section('title', 'Crear Psicólogo')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Nuevo psicólogo</h1>
            <p class="form-subtitle">
                Registra un nuevo psicólogo.
            </p>

            <form action="{{ route('psicologos.store') }}"
                  method="POST"
                  class="form-grid">
                @csrf

                <div class="form-group full">
                    <label for="nombre">Nombre *</label>

                    <input type="text"
                           id="nombre"
                           name="nombre"
                           value="{{ old('nombre') }}"
                           placeholder="Ej: Juan Pérez López"
                           required>

                    @error('nombre')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        Crear psicólogo
                    </button>

                    <a href="{{ route('psicologos.index') }}"
                       class="btn-cancel">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection