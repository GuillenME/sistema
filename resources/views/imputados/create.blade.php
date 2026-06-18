@extends('layouts.app')

@section('title', 'Crear Imputado')
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
            <h1 class="form-title">Nuevo imputado</h1>
            <p class="form-subtitle">Registra la informacion del imputado.</p>

            <form action="{{ route('imputados.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                        value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos *</label>
                    <input type="text" id="apellidos" name="apellidos" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
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

                    <input type="text" id="causa" name="causa" pattern="\d+\/\d{4}" placeholder="Ej: 23/2026"
                        value="{{ old('causa') }}">
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
    <script>
        $(document).ready(function() {
            $('#delitos_id').select2({
                placeholder: 'Buscar delito',
                allowClear: true,
                width: '100%'
            });

        });
    </script>
    <script>
        function soloLetras(id) {

            document.getElementById(id).addEventListener('input', function() {

                this.value = this.value.replace(
                    /[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g,
                    ''
                );

            });

        }

        soloLetras('nombre');
        soloLetras('apellidos');

        document.getElementById('causa').addEventListener('input', function() {

            let valor = this.value;

            valor = valor.replace(/[^0-9/]/g, '');

            let partes = valor.split('/');

            if (partes.length > 2) {
                valor = partes[0] + '/' + partes.slice(1).join('');
            }

            this.value = valor;

        });
    </script>
@endsection
