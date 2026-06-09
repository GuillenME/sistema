@extends('layouts.app')

@section('title', 'Crear Delito')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Nuevo delito</h1>
            <p class="form-subtitle">Registra el nombre del delito.</p>

            <form action="{{ route('delitos.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="form-group full">
                    <label for="delito">Nombre del delito *</label>
                    <input type="text" id="delito" name="delito" placeholder="Ej: Robo a mano armada" value="{{ old('delito') }}" required>
                    @error('delito')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Crear delito</button>
                    <a href="{{ route('delitos.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
