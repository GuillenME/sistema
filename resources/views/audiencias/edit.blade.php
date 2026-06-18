@extends('layouts.app')

@section('title', 'Editar Audiencia')

@push('styles')
    .imputados-panel {
    border: 1px solid var(--copper);
    border-radius: 8px;
    padding: 14px;
    display: grid;
    gap: 12px;
    }

    .imputados-mode {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    }

    .imputados-mode label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 40px;
    padding: 8px 12px;
    border: 1px solid var(--gold);
    border-radius: 8px;
    background: var(--white);
    color: var(--earth);
    cursor: pointer;
    }

    .imputados-list {
    max-height: 210px;
    overflow-y: auto;
    border: 1px solid var(--gold);
    border-radius: 8px;
    background: var(--white);
    }

    .imputado-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-bottom: 1px solid rgba(199, 154, 89, 0.45);
    font-weight: 700;
    cursor: pointer;
    }

    .imputado-option:last-child {
    border-bottom: 0;
    }

    .imputado-option:hover {
    background: rgba(199, 154, 89, 0.14);
    }

    .imputado-option input {
    width: 18px;
    height: 18px;
    accent-color: var(--wine);
    }

    .imputados-help {
    color: var(--earth);
    font-size: 0.92rem;
    font-weight: 700;
    }
@endpush

@section('content')
    @php
        $selectedImputados = old('imputados', $audiencia->imputados->pluck('id')->all());
        $imputadosMode = count($selectedImputados) > 1 ? 'multiple' : 'single';
    @endphp

    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar audiencia</h1>
            <p class="form-subtitle">Actualiza la informacion de la audiencia #{{ $audiencia->id }}.</p>

            <form action="{{ route('audiencias.update', $audiencia) }}" method="POST" class="form-grid">
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
                    <label for="causa">Causa *</label>
                    <input type="text" id="causa" name="causa" pattern="\d+\/\d{4}"
                        value="{{ old('causa', $audiencia->causa) }}" required>
                    @error('causa')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tipo_audiencia_id">Tipo de audiencia *</label>
                    <select id="tipo_audiencia_id" name="tipo_audiencia_id" required>
                        <option value="">Selecciona</option>
                        @foreach ($tipoAudiencias as $tipo)
                            <option value="{{ $tipo->id }}"
                                {{ old('tipo_audiencia_id', $audiencia->tipo_audiencia_id) == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->tipo }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_audiencia_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="delitos_id">Delito *</label>
                    <select id="delitos_id" name="delitos_id" required>
                        <option value="">Selecciona</option>
                        @foreach ($delitos as $delito)
                            <option value="{{ $delito->id }}"
                                {{ old('delitos_id', $audiencia->delitos_id) == $delito->id ? 'selected' : '' }}>
                                {{ $delito->delito }}
                            </option>
                        @endforeach
                    </select>
                    @error('delitos_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="juez_id">Juez *</label>
                    <select id="juez_id" name="juez_id" required>
                        <option value="">Selecciona</option>
                        @foreach ($jueces as $juez)
                            <option value="{{ $juez->id }}"
                                {{ old('juez_id', $audiencia->juez_id) == $juez->id ? 'selected' : '' }}>
                                {{ $juez->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('juez_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="salas_id">Sala *</label>
                    <select id="salas_id" name="salas_id" required>
                        <option value="">Selecciona</option>
                        @foreach ($salas as $sala)
                            <option value="{{ $sala->id }}"
                                {{ old('salas_id', $audiencia->salas_id) == $sala->id ? 'selected' : '' }}>
                                {{ $sala->sala }}
                            </option>
                        @endforeach
                    </select>
                    @error('salas_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full" data-imputados-picker>
                    <label>Imputados</label>

                    <div class="imputados-panel">
                        <div class="imputados-mode" role="group" aria-label="Cantidad de imputados">
                            <label>
                                <input type="radio" name="imputados_modo" value="single"
                                    {{ $imputadosMode === 'single' ? 'checked' : '' }}>
                                Un imputado
                            </label>
                            <label>
                                <input type="radio" name="imputados_modo" value="multiple"
                                    {{ $imputadosMode === 'multiple' ? 'checked' : '' }}>
                                Mas de uno
                            </label>
                        </div>

                        <input type="text" data-imputados-search placeholder="Buscar imputado por nombre o apellidos"
                            autocomplete="off">

                        <div class="imputados-list">
                            @foreach ($imputados as $imputado)
                                @php $fullName = trim($imputado->nombre . ' ' . $imputado->apellidos); @endphp
                                <label class="imputado-option" data-imputado-option
                                    data-search="{{ strtolower($fullName) }}">
                                    <input type="checkbox" name="imputados[]" value="{{ $imputado->id }}"
                                        {{ in_array($imputado->id, $selectedImputados) ? 'checked' : '' }}>
                                    <span>{{ $fullName }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="imputados-help" data-imputados-help>Selecciona el imputado de la lista.</div>
                    </div>

                    @error('imputados')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    @error('imputados.*')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="traductor_id">Traductor</label>
                    <select id="traductor_id" name="traductor_id">
                        <option value="">Ninguno</option>
                        @foreach ($traductores as $traductor)
                            <option value="{{ $traductor->id }}"
                                {{ old('traductor_id', $audiencia->traductor_id) == $traductor->id ? 'selected' : '' }}>
                                {{ $traductor->lengua }} - {{ $traductor->nombres }}
                            </option>
                        @endforeach
                    </select>
                    @error('traductor_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="psicologo_id">Psicologo</label>
                    <select id="psicologo_id" name="psicologo_id">
                        <option value="">Ninguno</option>
                        @foreach ($psicologos as $psicologo)
                            <option value="{{ $psicologo->id }}"
                                {{ old('psicologo_id', $audiencia->psicologo_id) == $psicologo->id ? 'selected' : '' }}>
                                {{ $psicologo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('psicologo_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="modalidad">Modalidad *</label>
                    <select id="modalidad" name="modalidad" required>
                        <option value="">Selecciona</option>
                        <option value="Presencial"
                            {{ old('modalidad', $audiencia->modalidad) == 'Presencial' ? 'selected' : '' }}>Presencial
                        </option>
                        <option value="Virtual"
                            {{ old('modalidad', $audiencia->modalidad) == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                    </select>
                    @error('modalidad')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha *</label>
                    <input type="date" id="fecha" name="fecha"
                        value="{{ old('fecha', optional($audiencia->fecha)->format('Y-m-d')) }}" required>
                    @error('fecha')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hora">Hora *</label>
                    <input type="time" id="hora" name="hora"
                        value="{{ old('hora', optional($audiencia->hora)->format('H:i')) }}" required>
                    @error('hora')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Guardar cambios</button>
                    <a href="{{ route('audiencias.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-imputados-picker]').forEach(function(picker) {
            var search = picker.querySelector('[data-imputados-search]');
            var options = Array.prototype.slice.call(picker.querySelectorAll('[data-imputado-option]'));
            var checks = Array.prototype.slice.call(picker.querySelectorAll('input[name="imputados[]"]'));
            var modeInputs = Array.prototype.slice.call(picker.querySelectorAll('input[name="imputados_modo"]'));
            var help = picker.querySelector('[data-imputados-help]');

            function currentMode() {
                var selected = modeInputs.find(function(input) {
                    return input.checked;
                });
                return selected ? selected.value : 'single';
            }

            function updateHelp() {
                var selectedCount = checks.filter(function(input) {
                    return input.checked;
                }).length;
                help.textContent = currentMode() === 'single' ?
                    (selectedCount ? 'Hay 1 imputado seleccionado.' : 'Selecciona el imputado de la lista.') :
                    (selectedCount ? 'Hay ' + selectedCount + ' imputados seleccionados.' :
                        'Selecciona todos los imputados que correspondan.');
            }

            modeInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    if (input.value === 'single') {
                        var firstChecked = checks.find(function(check) {
                            return check.checked;
                        });
                        checks.forEach(function(check) {
                            check.checked = check === firstChecked;
                        });
                    }
                    updateHelp();
                });
            });

            checks.forEach(function(check) {
                check.addEventListener('change', function() {
                    if (currentMode() === 'single' && check.checked) {
                        checks.forEach(function(other) {
                            other.checked = other === check;
                        });
                    }
                    updateHelp();
                });
            });

            search.addEventListener('input', function() {
                var term = search.value.trim().toLowerCase();
                options.forEach(function(option) {
                    option.style.display = option.dataset.search.indexOf(term) !== -1 ? '' : 'none';
                });
            });

            updateHelp();
        });
    </script>
    <script>
        document.getElementById('causa').addEventListener('input', function() {

            let valor = this.value;

            // Solo números y diagonal
            valor = valor.replace(/[^0-9/]/g, '');

            // Solo una diagonal
            let partes = valor.split('/');
            if (partes.length > 2) {
                valor = partes[0] + '/' + partes.slice(1).join('');
            }

            this.value = valor;
        });
    </script>
@endsection
