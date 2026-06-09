@extends('layouts.app')

@section('title', 'Crear tipo de audiencia')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Nuevo tipo de audiencia</h1>
            <p class="form-subtitle">Registra el nombre del tipo de audiencia.</p>

            <form action="{{ route('tipoaudiencias.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="form-group full">
                    <label for="tipo">Nombre del tipo de audiencia *</label>
                    <input type="text" id="tipo" name="tipo" placeholder="Ej: Inicial" value="{{ old('tipo') }}" required>
                    @error('tipo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Crear tipo de audiencia</button>
                    <a href="{{ route('tipoaudiencias.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
