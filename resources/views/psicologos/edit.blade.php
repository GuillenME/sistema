@extends('layouts.app')

@section('title', 'Editar Psicólogo')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar psicólogo</h1>

            <p class="form-subtitle">
                Actualiza la información del psicólogo #{{ $psicologo->id }}.
            </p>

            <form action="{{ route('psicologos.update', $psicologo) }}"
                  method="POST"
                  class="form-grid">
                @csrf
                @method('PUT')

                <div class="form-group full">
                    <label for="nombre">Nombre *</label>

                    <input type="text"
                           id="nombre"
                           name="nombre"
                           value="{{ old('nombre', $psicologo->nombre) }}"
                           required>

                    @error('nombre')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        Guardar cambios
                    </button>

                    <a href="{{ route('psicologos.show', $psicologo) }}"
                       class="btn-cancel">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection