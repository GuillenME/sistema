<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de audiencias</title>
    <style>
        :root {
            --wine: #6B0F15;
            --earth: #593F26;
            --gold: #C79A59;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: var(--earth);
            margin: 24px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 3px solid var(--gold);
        }

        .report-header h1 {
            color: var(--wine);
            margin: 0 0 8px;
            font-size: 1.6rem;
        }

        .report-meta {
            font-size: 0.92rem;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: var(--earth);
            color: #fff;
        }

        tr:nth-child(even) td {
            background: #faf6f0;
        }

        .toolbar {
            margin-bottom: 18px;
        }

        .toolbar button {
            background: var(--wine);
            color: #fff;
            border: 0;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
        }

        @media print {
            .toolbar {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="toolbar">
        <button type="button" onclick="window.print()">Imprimir / Guardar PDF</button>
    </div>

    <div class="report-header">
        <h1>Agenda JCTE Ocosingo 2026</h1>
        <div class="report-meta">
            <strong>Reporte de audiencias</strong><br>
            Generado: {{ now()->format('d/m/Y H:i') }}<br>
            Total: {{ $audiencias->count() }} audiencia(s)
        </div>
    </div>

    @php
        $filterLabels = [];

        if (!empty($filters['fecha_desde'])) {
            $filterLabels[] = 'Desde: ' . $filters['fecha_desde'];
        }

        if (!empty($filters['fecha_hasta'])) {
            $filterLabels[] = 'Hasta: ' . $filters['fecha_hasta'];
        }

        if (!empty($filters['estado'])) {
            $filterLabels[] = 'Estado: ' . $filters['estado'];
        }

        if (!empty($filters['modalidad'])) {
            $filterLabels[] = 'Modalidad: ' . $filters['modalidad'];
        }
    @endphp

    @if (count($filterLabels) > 0)
        <p><strong>Filtros:</strong> {{ implode(' | ', $filterLabels) }}</p>
    @endif

    @if ($audiencias->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Causa</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Delito</th>
                    <th>Tipo</th>
                    <th>Imputados</th>
                    <th>Sala</th>
                    <th>Modalidad</th>
                    <th>Juez</th>
                    <th>Traductor</th>
                    <th>Psicólogo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($audiencias as $audiencia)
                    <tr>
                        <td>{{ $audiencia->id }}</td>
                        <td>{{ $audiencia->causa }}</td>
                        <td>{{ optional($audiencia->fecha)->format('Y-m-d') ?? '-' }}</td>
                        <td>{{ optional($audiencia->hora)->format('H:i') ?? ($audiencia->hora ?? '-') }}</td>
                        <td>{{ optional($audiencia->delito)->delito ?? '-' }}</td>
                        <td>{{ optional($audiencia->tipoAudiencia)->tipo ?? '-' }}</td>
                        <td>
                            {{ $audiencia->imputados->map(function ($imputado) {
                                    return trim($imputado->nombre . ' ' . $imputado->apellidos);
                                })->implode(', ') ?:
                                '-' }}
                        </td>
                        <td>{{ optional($audiencia->sala)->sala ?? '-' }}</td>
                        <td>{{ $audiencia->modalidad ?? '-' }}</td>
                        <td>{{ optional($audiencia->juez)->nombre ?? '-' }}</td>
                        <td>
                            @if ($audiencia->traductor)
                                {{ $audiencia->traductor->nombres }}
                                @if ($audiencia->traductor->lengua)
                                    - {{ $audiencia->traductor->lengua }}
                                @endif
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ optional($audiencia->psicologo)->nombre ?? '-' }}</td>
                        <td>{{ $audiencia->estado ?? 'Programada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay audiencias con los filtros seleccionados.</p>
    @endif
</body>

</html>
