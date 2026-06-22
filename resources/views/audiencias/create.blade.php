@extends('layouts.app')

@section('title', 'Crear Audiencia')

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

    .imputados-empty {
    padding: 14px;
    color: var(--earth);
    font-weight: 700;
    }
    .modal{
    display:none;
    position:fixed;
    inset:0;
    z-index:9999;
    background:rgba(0,0,0,.6);
    justify-content:center;
    align-items:center;
    backdrop-filter: blur(3px);
    }

    .modal-content{
    width:100%;
    max-width:500px;
    background:#fff;
    border-radius:12px;
    padding:24px;
    box-shadow:0 20px 40px rgba(0,0,0,.25);
    animation:modalShow .25s ease;
    }

    .modal-content h3{
    margin-bottom:20px;
    color:var(--wine);
    font-size:1.4rem;
    }

    .modal-content input{
    width:100%;
    padding:12px;
    border:1px solid var(--gold);
    border-radius:8px;
    margin-bottom:12px;
    }

    .modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
    }

    .modal-btn-save{
    background:var(--wine);
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    }

    .modal-btn-cancel{
    background:#ddd;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    }

    @keyframes modalShow{
    from{
    opacity:0;
    transform:translateY(-20px);
    }
    to{
    opacity:1;
    transform:translateY(0);
    }
    }

    .label-actions{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
    width:100%;
    }

    .label-actions label{
    margin:0;
    font-weight:600;
    }

    .btn-mini{
    border:none;
    background:var(--wine);
    color:white;
    padding:6px 12px;
    border-radius:6px;
    cursor:pointer;
    font-size:.85rem;
    }

    .imputados-mode{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    }

    .imputados-mode label{
    justify-content:center;
    }
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

    @php
        $selectedImputados = old('imputados', []);
        $imputadosMode = count($selectedImputados) > 1 ? 'multiple' : 'single';
    @endphp

    <div class="form-container">
        <div class="form-card">


            <h1 class="form-title">Nueva audiencia</h1>
            <p class="form-subtitle">
                Completa la información para registrar la audiencia.
            </p>

            <form action="{{ route('audiencias.store') }}" method="POST" class="form-grid">
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
                    <label for="causa">Causa *</label>

                    <input type="text" id="causa" name="causa" placeholder="Ej: 23/2026"
                        value="{{ old('causa') }}" required>

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
                                {{ old('tipo_audiencia_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->tipo }}
                            </option>
                        @endforeach
                    </select>

                    @error('tipo_audiencia_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="delitos_id">Delito *
                        <button type="button" id="btnNuevoDelito" class="btn-mini">
                            + Nuevo delito
                        </button>
                    </label>

                    <select id="delitos_id" name="delitos_id" required>
                        <option value="">Selecciona</option>

                        @foreach ($delitos as $delito)
                            <option value="{{ $delito->id }}" {{ old('delitos_id') == $delito->id ? 'selected' : '' }}>
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
                            <option value="{{ $juez->id }}" {{ old('juez_id') == $juez->id ? 'selected' : '' }}>
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
                            <option value="{{ $sala->id }}" {{ old('salas_id') == $sala->id ? 'selected' : '' }}>
                                {{ $sala->sala }}
                            </option>
                        @endforeach
                    </select>

                    @error('salas_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full" data-imputados-picker>
                    <label>Imputados
                        <button type="button" id="btnNuevoImputado" class="btn-mini">
                            + Nuevo imputado
                        </button>
                    </label>

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

                        <div class="imputados-list" data-imputados-list>
                            @forelse($imputados as $imputado)
                                @php $fullName = trim($imputado->nombre . ' ' . $imputado->apellidos); @endphp
                                <label class="imputado-option" data-imputado-option
                                    data-search="{{ Str::lower($fullName) }}">
                                    <input type="checkbox" name="imputados[]" value="{{ $imputado->id }}"
                                        {{ in_array($imputado->id, $selectedImputados) ? 'checked' : '' }}>
                                    <span>{{ $fullName }}</span>
                                </label>
                            @empty
                                <div class="imputados-empty">No hay imputados registrados.</div>
                            @endforelse
                        </div>

                        <div class="imputados-help" data-imputados-help>
                            Selecciona el imputado de la lista.
                        </div>
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
                                {{ old('traductor_id') == $traductor->id ? 'selected' : '' }}>
                                {{ $traductor->lengua }} - {{ $traductor->nombres }}
                            </option>
                        @endforeach
                    </select>

                    @error('traductor_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="psicologo_id">Psicólogo</label>

                    <select id="psicologo_id" name="psicologo_id">
                        <option value="">Ninguno</option>

                        @foreach ($psicologos as $psicologo)
                            <option value="{{ $psicologo->id }}"
                                {{ old('psicologo_id') == $psicologo->id ? 'selected' : '' }}>
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

                        <option value="Presencial" {{ old('modalidad') == 'Presencial' ? 'selected' : '' }}>
                            Presencial
                        </option>

                        <option value="Virtual" {{ old('modalidad') == 'Virtual' ? 'selected' : '' }}>
                            Virtual
                        </option>
                    </select>

                    @error('modalidad')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha *</label>

                    <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required>

                    @error('fecha')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hora">Hora *</label>

                    <input type="time" id="hora" name="hora" value="{{ old('hora') }}" required>

                    @error('hora')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        Guardar audiencia
                    </button>

                    <a href="{{ route('audiencias.index') }}" class="btn-cancel">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>


    </div>
    <div id="modalDelito" class="modal">
        <div class="modal-content">

            <h3>Nuevo delito</h3>

            <input type="text" id="nuevoDelito" placeholder="Nombre del delito">

            <div class="modal-actions">
                <button type="button" id="cerrarModalDelito" class="modal-btn-cancel">
                    Cancelar
                </button>

                <button type="button" id="guardarDelito" class="modal-btn-save">
                    Guardar
                </button>
            </div>

        </div>
    </div>
    <div id="modalImputado" class="modal">
        <div class="modal-content">

            <h3>Nuevo imputado</h3>

            <input type="text" id="nuevoNombre" placeholder="Nombre">

            <input type="text" id="nuevoApellido" placeholder="Apellidos">

            <div class="modal-actions">
                <button type="button" id="cerrarModalImputado" class="modal-btn-cancel">
                    Cancelar
                </button>

                <button type="button" id="guardarImputado" class="modal-btn-save">
                    Guardar
                </button>
            </div>

        </div>
    </div>
    <script>
        document.querySelectorAll('[data-imputados-picker]').forEach(function(picker) {

            var search = picker.querySelector('[data-imputados-search]');
            var options = Array.from(
                picker.querySelectorAll('[data-imputado-option]')
            );
            var modeInputs = Array.from(
                picker.querySelectorAll('input[name="imputados_modo"]')
            );
            var help = picker.querySelector('[data-imputados-help]');

            function currentMode() {
                var selected = modeInputs.find(function(input) {
                    return input.checked;
                });

                return selected ? selected.value : 'single';
            }

            function updateHelp() {

                var selectedCount = document.querySelectorAll(
                    'input[name="imputados[]"]:checked'
                ).length;

                if (!help) return;

                if (currentMode() === 'single') {

                    help.textContent =
                        selectedCount ?
                        'Hay 1 imputado seleccionado.' :
                        'Selecciona el imputado de la lista.';

                    return;
                }

                help.textContent =
                    selectedCount ?
                    'Hay ' + selectedCount + ' imputados seleccionados.' :
                    'Selecciona todos los imputados que correspondan.';
            }

            modeInputs.forEach(function(input) {

                input.addEventListener('change', function() {

                    if (input.value === 'single') {

                        const checks = document.querySelectorAll(
                            'input[name="imputados[]"]'
                        );

                        let firstChecked = null;

                        checks.forEach(function(check) {

                            if (check.checked && !firstChecked) {
                                firstChecked = check;
                            }

                        });

                        checks.forEach(function(check) {

                            check.checked = (check === firstChecked);

                        });
                    }

                    updateHelp();
                });

            });

            document.addEventListener('change', function(e) {

                if (!e.target.matches('input[name="imputados[]"]')) {
                    return;
                }

                const check = e.target;

                const checks = document.querySelectorAll(
                    'input[name="imputados[]"]'
                );

                if (currentMode() === 'single' && check.checked) {

                    checks.forEach(function(other) {

                        other.checked = (other === check);

                    });
                }

                const selectedCount = document.querySelectorAll(
                    'input[name="imputados[]"]:checked'
                ).length;

                if (selectedCount > 1) {

                    document.querySelector(
                        'input[name="imputados_modo"][value="multiple"]'
                    ).checked = true;
                }

                updateHelp();
            });

            if (search) {

                search.addEventListener('input', function() {

                    var term = search.value.trim().toLowerCase();

                    document
                        .querySelectorAll('[data-imputado-option]')
                        .forEach(function(option) {

                            option.style.display =
                                option.dataset.search.indexOf(term) !== -1 ?
                                '' :
                                'none';
                        });
                });
            }

            updateHelp();

        });
    </script>
    <script>
        document.getElementById('btnNuevoDelito')
            .addEventListener('click', function() {
                document.getElementById('modalDelito').style.display = 'flex';
            });
        document.getElementById('guardarDelito')
            .addEventListener('click', async function() {

                try {

                    const response = await fetch('{{ route('delitos.ajax.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        },
                        body: JSON.stringify({
                            delito: document.getElementById('nuevoDelito').value
                        })
                    });

                    if (!response.ok) {
                        console.log(await response.text());
                        alert('Error al guardar delito');
                        return;
                    }

                    const data = await response.json();

                    const option = new Option(
                        data.delito,
                        data.id,
                        true,
                        true
                    );

                    document.getElementById('delitos_id')
                        .appendChild(option);

                    document.getElementById('modalDelito').style.display = 'none';
                    document.getElementById('nuevoDelito').value = '';

                } catch (e) {
                    console.error(e);
                    alert('Error de conexión');
                }

            });
        document.getElementById('cerrarModalDelito')
            .addEventListener('click', function() {

                document.getElementById('modalDelito').style.display = 'none';

            });
    </script>
    <script>
        document
            .getElementById('btnNuevoImputado')
            .addEventListener('click', function() {

                document
                    .getElementById('modalImputado')
                    .style.display = 'flex';

            });

        document
            .getElementById('cerrarModalImputado')
            .addEventListener('click', function() {

                document
                    .getElementById('modalImputado')
                    .style.display = 'none';

            });
    </script>
    <script>
        document.getElementById('guardarImputado')
            .addEventListener('click', async function() {

                try {

                    const response = await fetch('{{ route('imputados.ajax.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            nombre: document.getElementById('nuevoNombre').value,
                            apellidos: document.getElementById('nuevoApellido').value,

                            causa: document.getElementById('causa').value || null,
                            delitos_id: document.getElementById('delitos_id').value || null
                        })
                    });

                    const data = await response.json().catch(() => null);

                    if (!response.ok) {
                        console.log(data);
                        alert('Error al guardar imputado');
                        return;
                    }

                    agregarImputadoLista(data);

                    document.getElementById('modalImputado').style.display = 'none';
                    document.getElementById('nuevoNombre').value = '';
                    document.getElementById('nuevoApellido').value = '';

                } catch (e) {
                    console.error(e);
                    alert('Error de conexión');
                }

            });
    </script>
    <script>
        function agregarImputadoLista(imputado) {

            const lista = document.querySelector('[data-imputados-list]');

            const nombreCompleto =
                imputado.nombre + ' ' + imputado.apellidos;

            const label = document.createElement('label');

            label.className = 'imputado-option';

            label.setAttribute(
                'data-imputado-option',
                ''
            );

            label.setAttribute(
                'data-search',
                nombreCompleto.toLowerCase()
            );

            label.innerHTML = `
        <input
            type="checkbox"
            name="imputados[]"
            value="${imputado.id}"
            checked>

        <span>${nombreCompleto}</span>
    `;

            lista.appendChild(label);

            const nuevoCheck = label.querySelector('input');

            const modoSingle = document.querySelector(
                'input[name="imputados_modo"]:checked'
            ).value === 'single';

            if (modoSingle) {

                document
                    .querySelectorAll('input[name="imputados[]"]')
                    .forEach(function(check) {

                        check.checked = (check === nuevoCheck);

                    });
            }

            const help = document.querySelector('[data-imputados-help]');

            const totalSeleccionados = document.querySelectorAll(
                'input[name="imputados[]"]:checked'
            ).length;

            if (help) {

                if (modoSingle) {

                    help.textContent =
                        'Hay 1 imputado seleccionado.';

                } else {

                    help.textContent =
                        'Hay ' + totalSeleccionados +
                        ' imputados seleccionados.';
                }
            }
        }
    </script>
    <script>
        $(document).ready(function() {

            $('#tipo_audiencia_id').select2({
                placeholder: 'Buscar tipo de audiencia',
                allowClear: true,
                width: '100%'
            });

            $('#delitos_id').select2({
                placeholder: 'Buscar delito',
                allowClear: true,
                width: '100%'
            });

        });
    </script>

@endsection
