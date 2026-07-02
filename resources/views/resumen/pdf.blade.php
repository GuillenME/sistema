<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tarjeta de Audiencia</title>


    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #000;
        }

        .header {
            margin-bottom: 20px;
        }

        .juzgado {
            font-size: 18px;
            color: #B37A4A;
            text-align: right;
            line-height: 1.4;
        }

        .titulo {
            font-size: 13px;
            font-weight: bold;
            margin-top: 10px;
        }

        .causa {
            margin-top: 8px;
            font-weight: bold;
        }

        .seccion {
            margin-top: 12px;
            text-align: justify;
        }

        .campo {
            font-weight: bold;
        }

        .contenido {
            margin-top: 8px;
            text-align: justify;
        }

        .firma {
            margin-top: 60px;
            text-align: center;
        }

        .linea {
            border-top: 1px solid #000;
            width: 250px;
            margin: 0 auto;
            margin-bottom: 5px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            font-size: 10px;
        }
    </style>

</head>

<body>


    <div class="header">

        <table width="100%">
            <tr>

                <td width="50%">
                    <img src="{{ public_path('img/logop.jpg') }}" style="height:100px;">
                </td>

                <td width="50%" align="right">
                    <div class="juzgado">
                        JUZGADO DE CONTROL DEL<br>
                        DISTRITO JUDICIAL DE OCOSINGO.
                    </div>
                </td>

            </tr>
        </table>

        <img src="{{ public_path('img/lineas.jpg') }}" style="width:100%; margin-top:10px;">

    </div>

    <div class="seccion">

        <p>

            SIENDO LAS
            <strong>{{ optional($resumen->hora_inicio)->format('H:i') }}</strong>
            DEL DÍA
            <strong>{{ strtoupper($resumen->audiencia->fecha->translatedFormat('d \d\e F \d\e Y')) }}</strong>,
            DAMOS INICIO A LA AUDIENCIA
            <strong>{{ strtoupper($resumen->audiencia->tipoAudiencia->tipo) }}</strong>,
            DENTRO DE LA CAUSA PENAL
            <strong>{{ $resumen->audiencia->causa }}</strong>,
            EN CONTRA DE
            <strong>{{ strtoupper($imputados) }}</strong>,
            POR SU PROBABLE INTERVENCIÓN DEL HECHO QUE LA LEY SEÑALA COMO DELITO DE
            <strong>{{ strtoupper($resumen->audiencia->delito->delito ?? '') }}</strong>,
            COMETIDO EN AGRAVIO DE
            <strong>{{ strtoupper($resumen->victima) }}</strong>,
            QUE SERÁ DIRIGIDA POR EL JUEZ DE CONTROL
            <strong>{{ strtoupper(trim(($resumen->audiencia->juez->nombre ?? '') . ' ' . ($resumen->audiencia->juez->apellidos ?? ''))) }}</strong>.

        </p>
    </div>

    <div class="contenido">


        <p>

            <strong>IMPUTADO:</strong>

            {{ strtoupper($imputados) }},

            por su probable intervención del hecho que la Ley señala como delito de

            {{ strtoupper($resumen->audiencia->delito->delito ?? '') }}
            ,

            cometido en agravio de

            <strong>{{ strtoupper($resumen->victima) }}</strong>,

        </p>

    </div>

    <div class="contenido">
        <span class="campo">DEFENSA:</span>
        {{ $resumen->defensa }}
    </div>

    <div class="contenido">
        <span class="campo">FISCALÍA:</span>
        {{ $resumen->fiscalia }}
    </div>

    <div class="contenido">
        <span class="campo">AUXILIAR:</span>
        {{ $resumen->auxiliar }}
    </div>

    <div class="contenido">
        <span class="campo">VÍCTIMA:</span>
        {{ $resumen->victima }}
    </div>
    <br>
    <div class="contenido">
        <span class="campo">HECHOS OCURRIDOS:</span><br><br>
        {{ $resumen->hechos_ocurridos }}
    </div>
    <br>
    <div class="contenido">
        <span class="campo">OBSERVACIONES:</span><br><br>
        {{ $resumen->observaciones }}
    </div>
    <br>
    <div class="contenido">
        <span class="campo">MEDIDA:</span><br><br>
        {{ $resumen->medida }}
    </div>
    <br>
    <div class="contenido">
        <span class="campo">HORA DE INICIO:</span>
        {{ optional($resumen->hora_inicio)->format('H:i') }}
        &nbsp;&nbsp;&nbsp;&nbsp;

        <span class="campo">HORA DE CONCLUSIÓN:</span>
        {{ optional($resumen->hora_final)->format('H:i') }}
    </div>



    <div class="footer">
        Documento generado el {{ now()->format('d/m/Y') }}
    </div>


</body>

</html>
