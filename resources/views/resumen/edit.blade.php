@extends('layouts.app')

@section('title', 'Editar Resumen')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar resumen</h1>
            <p class="form-subtitle">Actualiza la informacion del resumen #{{ $resumen->id }}.</p>

            <form action="{{ route('resumen.update', $resumen) }}" method="POST" class="form-grid">
                @csrf
                @method('PUT')

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
                            <option value="{{ $audiencia->id }}"
                                {{ old('audiencias_id', $resumen->audiencias_id) == $audiencia->id ? 'selected' : '' }}>
                                #{{ $audiencia->id }} - {{ optional($audiencia->fecha)->format('Y-m-d') }} -
                                {{ $audiencia->causa }}
                            </option>
                        @endforeach
                    </select>
                    @error('audiencias_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="hora_inicio">Hora inicio</label>
                    <input type="time" id="hora_inicio" name="hora_inicio"
                        value="{{ old('hora_inicio', optional($resumen->hora_inicio)->format('H:i')) }}">
                    @error('hora_inicio')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hora_final">Hora final</label>
                    <input type="time" id="hora_final" name="hora_final"
                        value="{{ old('hora_final', optional($resumen->hora_final)->format('H:i')) }}">
                    @error('hora_final')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="defensa">Defensa</label>
                    <input type="text" id="defensa" name="defensa" value="{{ old('defensa', $resumen->defensa) }}"
                        maxlength="255">
                    @error('defensa')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fiscalia">Fiscalia</label>
                    <input type="text" id="fiscalia" name="fiscalia" value="{{ old('fiscalia', $resumen->fiscalia) }}"
                        maxlength="255">
                    @error('fiscalia')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="auxiliar">Auxiliar de sala</label>
                    <input type="text" id="auxiliar" name="auxiliar" value="{{ old('auxiliar', $resumen->auxiliar) }}"
                        maxlength="255">
                    @error('auxiliar')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="victima">Victima(s)</label>
                    <input type="text" id="victima" name="victima" value="{{ old('victima', $resumen->victima) }}"
                        maxlength="255">
                    @error('victima')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="plazo">Plazo de investigación</label>
                    <input type="number" id="plazo" name="plazo" min="1"
                        value="{{ old('plazo', $resumen->plazo) }}">
                    @error('plazo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="medida">Medida cautelar</label>
                    <input type="text" id="medida" name="medida" value="{{ old('medida', $resumen->medida) }}"
                        maxlength="255">
                    @error('medida')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group full">
                    <label for="hechos_ocurridos">Resumen de los hechos</label>
                    <textarea id="hechos_ocurridos" name="hechos_ocurridos" rows="6">{{ old('hechos_ocurridos', $resumen->hechos_ocurridos) }}</textarea>

                    @error('hechos_ocurridos')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group full">
                    <label for="observaciones">Observaciones / Incidencias</label>
                    <textarea id="observaciones" name="observaciones" rows="5">{{ old('observaciones', $resumen->observaciones) }}</textarea>

                    @error('observaciones')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar cambios</button>
                    <a href="{{ route('resumen.show', $resumen) }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
