@extends('layouts.app')

@section('title', 'Crear Audiencia')

@push('styles')
    .container { max-width: 900px; margin: 32px auto; padding: 0 24px; }
    .page-title { margin-bottom: 22px; }
    .page-title h1 { font-size: 2rem; margin-bottom: 8px; }
    .page-title p { color: #4b5563; }
    .panel { background: #fff; border: 1px solid #e5e7eb; border-radius: 28px; padding: 26px; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06); }
    .form-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-group label { font-weight: 700; color: #374151; }
    .form-group input,
    .form-group select,
    .form-group textarea { width: 100%; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 16px; font-size: 0.95rem; }
    .form-full { grid-column: span 2; display: flex; justify-content: flex-end; }
    .btn-submit { background: #4f46e5; color: white; border: none; padding: 14px 24px; border-radius: 16px; font-size: 1rem; font-weight: 700; cursor: pointer; }
    .back-link { display: inline-block; margin-top: 18px; color: #4b5563; text-decoration: none; }
    .back-link:hover { text-decoration: underline; }
    .footer { margin-top: 24px; color: #6b7280; }
    @media (max-width: 760px) { .form-row { grid-template-columns: 1fr; } .form-full { justify-content: stretch; } }
@endpush

@section('content')
    <div class="container">
        <div class="page-title">
            <h1>Crear nueva audiencia</h1>
            <p>Formulario provisional para registrar una audiencia. Ajusta los campos según tu modelo real.</p>
        </div>

        <div class="panel">
            <form action="{{ route('audiencias.store') }}" method="POST" class="form-row">
                @csrf

                @if ($errors->any())
                    <div class="form-group" style="grid-column: span 2; background: #fef2f2; color: #b91c1c; padding: 16px; border-radius: 16px; border: 1px solid #fecaca;">
                        <strong>Corrige los errores:</strong>
                        <ul style="margin-top: 10px; list-style: disc; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="causa">Causa</label>
                    <input type="text" id="causa" name="causa" placeholder="Ej. Audiencia preliminar" value="{{ old('causa') }}" required>
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
                    <label for="traductor_id">Traductor</label>
                    <select id="traductor_id" name="traductor_id">
                        <option value="">Ninguno</option>
                        @foreach($traductores as $traductor)
                            <option value="{{ $traductor->id }}" {{ old('traductor_id') == $traductor->id ? 'selected' : '' }}>{{ $traductor->nombres }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="psicologo_id">Psicólogo</label>
                    <select id="psicologo_id" name="psicologo_id">
                        <option value="">Ninguno</option>
                        @foreach($psicologos as $psicologo)
                            <option value="{{ $psicologo->id }}" {{ old('psicologo_id') == $psicologo->id ? 'selected' : '' }}>{{ $psicologo->nombre }}</option>
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
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                </div>

                <div class="form-group">
                    <label for="hora">Hora</label>
                    <input type="time" id="hora" name="hora" value="{{ old('hora') }}" required>
                </div>

                <div class="form-full">
                    <button class="btn-submit" type="submit">Guardar audiencia</button>
                </div>
            </form>
        </div>

        <a class="back-link" href="{{ route('audiencias.index') }}">← Volver al listado de audiencias</a>
    </div>
@endsection
