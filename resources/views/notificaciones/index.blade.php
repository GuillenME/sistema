@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')

    <div class="detail-container">

        <div class="detail-card">

            <h1 class="detail-title">
                Notificaciones
            </h1>

            @forelse($notificaciones as $notificacion)
                <div class="detail-field">

                    <div class="detail-value">
                        {{ $notificacion->mensaje }}
                    </div>

                    <small>
                        {{ $notificacion->created_at }}
                    </small>

                    @if (!$notificacion->atendida)
                        <form action="{{ route('notificaciones.atender', $notificacion) }}" method="POST"
                            style="margin-top:10px;">
                            @csrf

                            <button type="submit" class="btn-submit">
                                ✓ Marcar como atendida
                            </button>

                        </form>
                    @else
                        <div style="margin-top:10px;">
                            <span class="badge">
                                Atendida
                            </span>
                        </div>
                    @endif

                </div>
            @empty

                <p>No hay notificaciones.</p>
            @endforelse

        </div>

    </div>

@endsection
