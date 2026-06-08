@extends('layouts.app')

@section('title', 'Audiencias')

@push('styles')
    .container { max-width: 1200px; margin: 32px auto; padding: 0 24px; }
    .page-title { margin-bottom: 22px; }
    .page-title h1 { font-size: 2rem; margin-bottom: 8px; }
    .page-title p { color: #4b5563; }
    .panel { background: #fff; border: 1px solid #e5e7eb; border-radius: 28px; padding: 26px; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06); }
    .btn-primary { display: inline-block; background: #4f46e5; color: #fff; padding: 12px 20px; border-radius: 14px; text-decoration: none; font-weight: 700; }
    .table-wrapper { overflow-x: auto; margin-top: 18px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 16px 14px; text-align: left; border-bottom: 1px solid #e5e7eb; }
    th { color: #4f46e5; text-transform: uppercase; letter-spacing: 0.08em; font-size: 0.8rem; }
    td { color: #111827; }
    .badge { display: inline-flex; padding: 8px 12px; border-radius: 999px; font-size: 0.85rem; font-weight: 700; color: #1f2937; }
    .badge-info { background: #eef2ff; }
    .badge-success { background: #dcfce7; }
    .badge-warning { background: #fef3c7; }
@endpush

@section('content')
    <div class="container">
        <div class="page-title">
            <h1>Audiencias</h1>
            <p>Lista de audiencias.</p>
        </div>

        <div class="panel">
            @if(in_array(Auth::user()->role->tipo, ['admin', 'oficinista']))
                <a href="{{ route('audiencias.create') }}" class="btn-primary">Crear nueva audiencia</a>
            @endif

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Causa</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Delito</th>
                            <th>Tipo de audiencia</th>
                            <th>Juez</th>
                            <th>Traductor</th>
                            <th>Psicólogo</th>
                            <th>Sala</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audiencias as $audiencia)
                            <tr>
                                <td>{{ $audiencia->id }}</td>
                                <td>{{ $audiencia->causa }}</td>
                                <td>{{ optional($audiencia->fecha)->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ optional($audiencia->hora)->format('H:i') ?? $audiencia->hora ?? '-' }}</td>
                                <td>{{ optional($audiencia->delito)->delito ?? '-' }}</td>
                                <td>{{ optional($audiencia->tipoAudiencia)->tipo ?? '-' }}</td>
                                <td>{{ optional($audiencia->juez)->nombre ?? '-' }}</td>
                                <td>{{ optional($audiencia->traductor)->nombres ?? '-' }}</td>
                                <td>{{ optional($audiencia->psicologo)->nombre ?? '-' }}</td>
                                <td>{{ optional($audiencia->sala)->sala ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">No hay audiencias registradas aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $audiencias->links() ?? '' }}
            </div>
        </div>
    </div>
@endsection
