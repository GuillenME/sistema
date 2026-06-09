@extends('layouts.app')

@section('title', 'Crear tipo de audiencia')

@push('styles')
<style>
    .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .form-header { margin-bottom: 32px; }
    .form-title { font-size: 1.875rem; font-weight: 800; color: #111827; margin-bottom: 8px; }
    .form-subtitle { color: #6b7280; }
    .form-group { margin-bottom: 24px; }
    label { display: block; font-weight: 700; color: #374151; margin-bottom: 8px; font-size: 0.95rem; }
    input[type="text"] { width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: border-color 0.2s; font-family: inherit; }
    input[type="text"]:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
    .form-error { color: #dc2626; font-size: 0.875rem; margin-top: 6px; }
    .form-actions { display: flex; gap: 12px; margin-top: 32px; }
    .btn-submit { background: #4f46e5; color: white; padding: 14px 28px; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.2s; }
    .btn-submit:hover { background: #3730a3; }
    .btn-cancel { background: #e5e7eb; color: #374151; padding: 14px 28px; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.2s; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-cancel:hover { background: #d1d5db; }
</style>
@endpush

@section('content')
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">Nuevo tipo de audiencia</h1>
            <p class="form-subtitle">Completa los campos para agregar un nuevo tipo de audiencia al sistema</p>
        </div>

        <form action="{{ route('tipoaudiencias.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="tipo">Nombre del tipo de audiencia *</label>
                <input
                    type="text"
                    id="tipo"
                    name="tipo"
                    placeholder="Ej: Inicial"
                    value="{{ old('tipo') }}"
                    required
                >
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
@endsection
