@extends('layouts.app')

@section('title', 'Crear Audiencia')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Nueva audiencia</h1>
            <p class="form-subtitle">Completa la informacion para registrar la audiencia.</p>

            <form action="{{ route('audiencias.store') }}" method="POST" class="form-grid">
                @csrf

                @if ($errors->any())
                    <div class="error-box">
                        <strong>Corrige los errores:</strong>
                        <ul style="margin-top: 10px; list-style: disc; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group full">
                    <label for="causa">Causa</label>
                    <input type="text" id="causa" name="causa" placeholder="Ej: Audiencia preliminar" value="{{ old('causa') }}" required>
                </div>

                <div class="form-group">
                    <label for="tipo_audiencia_id">Tipo de audiencia</label>
                    <select id="tipo_audiencia_id" name="tipo_audiencia_id" required>
                        <option value="">Selecciona</option>
                        @foreach($tipoAudiencias as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('tipo_audiencia_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->tipo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="delitos_id">Delito</label>
                    <select id="delitos_id" name="delitos_id" required>
                        <option value="">Selecciona</option>
                        @foreach($delitos as $delito)
                            <option value="{{ $delito->id }}" {{ old('delitos_id') == $delito->id ? 'selected' : '' }}>{{ $delito->delito }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="juez_id">Juez</label>
                    <select id="juez_id" name="juez_id" required>
                        <option value="">Selecciona</option>
                        @foreach($jueces as $juez)
                            <option value="{{ $juez->id }}" {{ old('juez_id') == $juez->id ? 'selected' : '' }}>{{ $juez->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="salas_id">Sala</label>
                    <select id="salas_id" name="salas_id" required>
                        <option value="">Selecciona</option>
                        @foreach($salas as $sala)
                            <option value="{{ $sala->id }}" {{ old('salas_id') == $sala->id ? 'selected' : '' }}>{{ $sala->sala }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="traductor_id">Traductor</label>
                    <select id="traductor_id" name="traductor_id">
                        <option value="">Ninguno</option>
                        @foreach($traductores as $traductor)
                            <option value="{{ $traductor->id }}" {{ old('traductor_id') == $traductor->id ? 'selected' : '' }}>{{ $traductor->nombres }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="psicologo_id">Psicologo</label>
                    <select id="psicologo_id" name="psicologo_id">
                        <option value="">Ninguno</option>
                        @foreach($psicologos as $psicologo)
                            <option value="{{ $psicologo->id }}" {{ old('psicologo_id') == $psicologo->id ? 'selected' : '' }}>{{ $psicologo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                </div>

                <div class="form-group">
                    <label for="hora">Hora</label>
                    <input type="time" id="hora" name="hora" value="{{ old('hora') }}" required>
                </div>

                <div class="form-actions">
                    <button class="btn-submit" type="submit">Guardar audiencia</button>
                    <a class="btn-cancel" href="{{ route('audiencias.index') }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
