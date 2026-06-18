@extends('layouts.app')

@section('title', 'Crear Resumen')
@push('styles')
    .select2-container--default .select2-selection--single {
    height: 42px;
    border: 1px solid var(--gold);
    border-radius: 8px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 42px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 42px;
    }
@endpush
@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Nuevo resumen</h1>
            <p class="form-subtitle">Registra la informacion final de una audiencia.</p>

            <form action="{{ route('resumen.store') }}" method="POST" class="form-grid">
                @csrf

                @if ($errors->any())
                    <div class="error-box">
                        <strong>Corrige los errores:</strong>
                        <ul style="margin-top:10px; list-style:disc; padding-left:20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group full">
                    <label for="audiencias_id">Audiencia *</label>
                    <select id="audiencias_id" name="audiencias_id" required>
                        <option value="">Selecciona</option>
                        @foreach ($audiencias as $audiencia)
                            @php
                                $imputados = $audiencia->imputados
                                    ->map(function ($imputado) {
                                        return trim($imputado->nombre . ' ' . $imputado->apellidos);
                                    })
                                    ->implode(', ');
                            @endphp
                            <option value="{{ $audiencia->id }}"
                                {{ old('audiencias_id') == $audiencia->id ? 'selected' : '' }}>
                                #{{ $audiencia->id }} - {{ optional($audiencia->fecha)->format('Y-m-d') }} -
                                {{ $audiencia->causa }}{{ $imputados ? ' - ' . $imputados : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('audiencias_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="hora_inicio">Hora inicio</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio') }}">
                    @error('hora_inicio')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="hora_final">Hora final</label>
                    <input type="time" id="hora_final" name="hora_final" value="{{ old('hora_final') }}">
                    @error('hora_final')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="defensa">Defensa</label>
                    <input type="text" id="defensa" name="defensa" value="{{ old('defensa') }}" maxlength="45">
                    @error('defensa')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fiscalia">Fiscalia</label>
                    <input type="text" id="fiscalia" name="fiscalia" value="{{ old('fiscalia') }}" maxlength="45">
                    @error('fiscalia')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="auxiliar">Auxiliar de sala</label>
                    <input type="text" id="auxiliar" name="auxiliar" value="{{ old('auxiliar') }}" maxlength="45">
                    @error('auxiliar')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="victima">Victima(s)</label>
                    <input type="text" id="victima" name="victima" value="{{ old('victima') }}" maxlength="45">
                    @error('victima')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="plazo">Plazo de investigación</label>
                    <input type="number" id="plazo" name="plazo" min="1" value="{{ old('plazo') }}">
                    @error('plazo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="medida">Medida cautelar</label>
                    <input type="text" id="medida" name="medida" value="{{ old('medida') }}" maxlength="45">
                    <small>Ingrese el plazo en días.</small>
                    @error('medida')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group full">
                    <label for="hechos_ocurridos">Resumen de los hechos</label>
                    <textarea id="hechos_ocurridos" name="hechos_ocurridos" rows="6"
                        placeholder="Describe los hechos ocurridos durante la audiencia...">{{ old('hechos_ocurridos') }}</textarea>

                    @error('hechos_ocurridos')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group full">
                    <label for="observaciones">Observaciones / Incidencias</label>
                    <textarea id="observaciones" name="observaciones" rows="5"
                        placeholder="Ingrese observaciones o incidencias de la audiencia...">{{ old('observaciones') }}</textarea>

                    @error('observaciones')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar resumen</button>
                    <a href="{{ route('resumen.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#audiencias_id').select2({
                placeholder: 'Buscar audiencia',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
