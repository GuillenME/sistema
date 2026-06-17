@extends('layouts.app')

@section('title', 'Crear Imputado')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Nuevo imputado</h1>
            <p class="form-subtitle">Registra la informacion del imputado.</p>

            <form action="{{ route('imputados.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan" value="{{ old('nombre') }}"
                        required>
                    @error('nombre')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos *</label>
                    <input type="text" id="apellidos" name="apellidos" placeholder="Ej: Garcia Lopez"
                        value="{{ old('apellidos') }}" required>
                    @error('apellidos')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_registro">Fecha de registro *</label>

                    <input type="date" id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro') }}"
                        required>

                    @error('fecha_registro')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="causa">Número de causa</label>

                    <input type="text" id="causa" name="causa" value="{{ old('causa') }}">
                </div>
                <div class="form-group">
                    <label for="delitos_id">Delito</label>

                    <select name="delitos_id" id="delitos_id">
                        <option value="">Seleccione</option>

                        @foreach ($delitos as $delito)
                            <option value="{{ $delito->id }}" {{ old('delitos_id') == $delito->id ? 'selected' : '' }}>
                                {{ $delito->delito }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Crear imputado</button>
                    <a href="{{ route('imputados.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
