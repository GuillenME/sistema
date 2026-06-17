<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Resumen {{ $resumen->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #ccc;
            padding: 8px;
            vertical-align: top;
        }

        .titulo {
            width: 30%;
            font-weight: bold;
            background: #f3f3f3;
        }
    </style>
</head>

<body>

    <h1>Resumen de Audiencia</h1>

    <table>
        <tr>
            <td class="titulo">Causa</td>
            <td>{{ $resumen->audiencia->causa }}</td>
        </tr>

        <tr>
            <td class="titulo">Fecha</td>
            <td>{{ $resumen->audiencia->fecha->format('d/m/Y') }}</td>
        </tr>

        <tr>
            <td class="titulo">Tipo de audiencia</td>
            <td>{{ $resumen->audiencia->tipoAudiencia->tipo ?? '-' }}</td>
        </tr>

        <tr>
            <td class="titulo">Juez</td>
            <td>{{ $resumen->audiencia->juez->nombre ?? '-' }}</td>
        </tr>

        <tr>
            <td class="titulo">Imputados</td>
            <td>
                @foreach ($resumen->audiencia->imputados as $imputado)
                    {{ $imputado->nombre }} {{ $imputado->apellidos }}<br>
                @endforeach
            </td>
        </tr>

        <tr>
            <td class="titulo">Hora inicio</td>
            <td>{{ optional($resumen->hora_inicio)->format('H:i') ?? '-' }}</td>
        </tr>

        <tr>
            <td class="titulo">Hora final</td>
            <td>{{ optional($resumen->hora_final)->format('H:i') ?? '-' }}</td>
        </tr>S

        <tr>
            <td class="titulo">Defensa</td>
            <td>{{ $resumen->defensa }}</td>
        </tr>

        <tr>
            <td class="titulo">Fiscalía</td>
            <td>{{ $resumen->fiscalia }}</td>
        </tr>

        <tr>
            <td class="titulo">Auxiliar</td>
            <td>{{ $resumen->auxiliar }}</td>
        </tr>

        <tr>
            <td class="titulo">Víctima</td>
            <td>{{ $resumen->victima }}</td>
        </tr>

        <tr>
            <td class="titulo">Hechos ocurridos</td>
            <td>{{ $resumen->hechos_ocurridos }}</td>
        </tr>

        <tr>
            <td class="titulo">Observaciones</td>
            <td>{{ $resumen->observaciones }}</td>
        </tr>

        <tr>
            <td class="titulo">Medida</td>
            <td>{{ $resumen->medida }}</td>
        </tr>
    </table>

</body>

</html>
