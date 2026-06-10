@extends('layouts.app')

@section('title', 'Editar Traductor')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar traductor</h1>
            <p class="form-subtitle">Actualiza la informacion del traductor #{{ $traductor->id }}.</p>

            <form action="{{ route('traductores.update', $traductor) }}" method="POST" class="form-grid">
                @csrf
                @method('PUT')

                <div class="form-group full">
                    <label for="nombres">Nombre *</label>
                    <input type="text"
                           id="nombres"
                           name="nombres"
                           value="{{ old('nombres', $traductor->nombres) }}"
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
                           value="{{ old('lengua', $traductor->lengua) }}"
                           required>

                    @error('lengua')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar cambios</button>
                    <a href="{{ route('traductores.show', $traductor) }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
