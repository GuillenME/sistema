<?php

namespace App\Http\Controllers;

use App\Models\Audiencia;
use App\Models\Delito;
use App\Models\Imputado;
use App\Models\Juez;
use App\Models\Psicologo;
use App\Models\Sala;
use App\Models\TipoAudiencia;
use App\Models\Traductor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class AudienciaController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $audiencias = Audiencia::with([
            'delito',
            'tipoAudiencia',
            'juez',
            'traductor',
            'psicologo',
            'sala',
            'imputados',
            'creador',
        ])
            ->when($buscar, function ($query) use ($buscar) {
                $query->where('causa', 'like', "%{$buscar}%")
                    ->orWhereHas('juez', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('delito', function ($q) use ($buscar) {
                        $q->where('delito', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('imputados', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellidos', 'like', "%{$buscar}%");
                    });
            })
            ->orderByRaw("
                CASE
                    WHEN fecha >= CURDATE() THEN 0
                    ELSE 1
                END
            ")
            ->orderBy('fecha')
            ->orderBy('hora')
            ->paginate(8)
            ->withQueryString();


        return view('audiencias.index', compact('audiencias', 'buscar'));
    }

    public function create()
    {
        $jueces = Juez::orderBy('nombre')->get();
        $tipoAudiencias = TipoAudiencia::orderBy('tipo')->get();
        $delitos = Delito::orderBy('delito')->get();
        $traductores = Traductor::orderBy('nombres')->get();
        $psicologos = Psicologo::orderBy('nombre')->get();
        $salas = Sala::orderBy('sala')->get();
        $imputados = Imputado::orderBy('apellidos')->orderBy('nombre')->get();

        return view('audiencias.create', compact(
            'jueces',
            'tipoAudiencias',
            'delitos',
            'traductores',
            'psicologos',
            'salas',
            'imputados'
        ));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'causa' => [
                'required',
            ],

            'fecha' => 'required|date',
            'hora' => 'required',
            'modalidad' => 'required|in:Presencial,Virtual',
            'delitos_id' => 'required|exists:delitos,id',
            'tipo_audiencia_id' => 'required|exists:tipo_audiencia,id',
            'juez_id' => 'required|exists:juez,id',
            'traductor_id' => 'nullable|exists:traductor,id',
            'psicologo_id' => 'nullable|exists:psicologo,id',
            'salas_id' => 'required|exists:salas,id',
            'imputados' => 'required|array|min:1',
            'imputados.*' => 'required|exists:imputados,id',

        ]);

        $imputados = $data['imputados'] ?? [];
        unset($data['imputados']);

        $data['creado_por'] = Auth::id();

        $audiencia = Audiencia::create($data);
        $audiencia->imputados()->sync($imputados);

        return redirect()->route('audiencias.index')->with('success', 'Audiencia guardada correctamente.');
    }

    public function show(Audiencia $audiencia)
    {
        $audiencia->load([
            'delito',
            'tipoAudiencia',
            'juez',
            'traductor',
            'psicologo',
            'sala',
            'imputados',
            'creador'
        ]);

        return view('audiencias.show', compact('audiencia'));
    }

    public function edit(Audiencia $audiencia)
    {
        $jueces = Juez::orderBy('nombre')->get();
        $tipoAudiencias = TipoAudiencia::orderBy('tipo')->get();
        $delitos = Delito::orderBy('delito')->get();
        $traductores = Traductor::orderBy('nombres')->get();
        $psicologos = Psicologo::orderBy('nombre')->get();
        $salas = Sala::orderBy('sala')->get();
        $imputados = Imputado::orderBy('apellidos')->orderBy('nombre')->get();

        return view(
            'audiencias.edit',
            compact(
                'audiencia',
                'jueces',
                'tipoAudiencias',
                'delitos',
                'traductores',
                'psicologos',
                'salas',
                'imputados'
            )
        );
    }


    public function update(Request $request, Audiencia $audiencia)
    {
        $data = $request->validate([
            'causa' => [
                'required',
            ],
            'fecha' => 'required|date',
            'hora' => 'required',
            'modalidad' => 'required|in:Presencial,Virtual,Híbrida',

            'delitos_id' => 'required|exists:delitos,id',
            'tipo_audiencia_id' => 'required|exists:tipo_audiencia,id',
            'juez_id' => 'required|exists:juez,id',
            'traductor_id' => 'nullable|exists:traductor,id',
            'psicologo_id' => 'nullable|exists:psicologo,id',
            'salas_id' => 'required|exists:salas,id',
            'imputados' => 'required|array|min:1',
            'imputados.*' => 'required|exists:imputados,id',
        ]);

        $imputados = $data['imputados'] ?? [];
        unset($data['imputados']);

        $audiencia->update($data);
        $audiencia->imputados()->sync($imputados);

        return redirect()
            ->route('audiencias.index')
            ->with('success', 'Audiencia actualizada correctamente.');
    }

    public function diferir(Audiencia $audiencia)
    {
        if (($audiencia->estado ?? 'Programada') !== 'Programada') {
            return redirect()
                ->route('audiencias.index')
                ->with('error', 'Solo es posible diferir audiencias programadas.');
        }

        $fechaLimite = Carbon::parse($audiencia->fecha)->addDays(2)->endOfDay();

        if (now()->gt($fechaLimite)) {
            return redirect()
                ->route('audiencias.index')
                ->with('error', 'Ya no es posible diferir esta audiencia.');
        }

        $audiencia->update([
            'estado' => 'Diferida',
        ]);

        return redirect()
            ->route('audiencias.index')
            ->with('success', 'Audiencia diferida correctamente.');
    }

    public function destroy(Audiencia $audiencia)
    {
        $audiencia->delete();

        return redirect()
            ->route('audiencias.index')
            ->with('success', 'Audiencia eliminada correctamente.');
    }

    public function report(Request $request)
    {
        $filters = $this->validatedReportFilters($request);
        $audiencias = $this->buildReportQuery($filters)
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        $tipoAudiencias = TipoAudiencia::orderBy('tipo')->get();
        $jueces = Juez::orderBy('nombre')->get();

        return view('audiencias.report', compact(
            'audiencias',
            'filters',
            'tipoAudiencias',
            'jueces'
        ));
    }

    public function exportReport(Request $request): StreamedResponse
    {
        $filters = $this->validatedReportFilters($request);
        $audiencias = $this->buildReportQuery($filters)
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        $filename = 'reporte-audiencias-' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($audiencias) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, [
                'ID',
                'Causa',
                'Fecha',
                'Hora',
                'Delito',
                'Tipo',
                'Imputados',
                'Sala',
                'Modalidad',
                'Juez',
                'Traductor',
                'Psicologo',
                'Agendo',
                'Estado',
            ]);

            foreach ($audiencias as $audiencia) {
                fputcsv($handle, $this->reportRow($audiencia));
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function printReport(Request $request)
    {
        $filters = $this->validatedReportFilters($request);
        $audiencias = $this->buildReportQuery($filters)
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        return view('audiencias.report-print', compact('audiencias', 'filters'));
    }

    private function validatedReportFilters(Request $request): array
    {
        return $request->validate([
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date',
            'estado' => 'nullable|string|max:45',
            'tipo_audiencia_id' => 'nullable|exists:tipo_audiencia,id',
            'juez_id' => 'nullable|exists:juez,id',
            'modalidad' => 'nullable|in:Presencial,Virtual,Híbrida',
        ]);
    }

    private function buildReportQuery(array $filters)
    {
        $query = Audiencia::with($this->reportRelations());

        if (! empty($filters['fecha_desde'])) {
            $query->whereDate('fecha', '>=', $filters['fecha_desde']);
        }

        if (! empty($filters['fecha_hasta'])) {
            $query->whereDate('fecha', '<=', $filters['fecha_hasta']);
        }

        if (! empty($filters['estado'])) {
            $query->where('estado', $filters['estado']);
        }

        if (! empty($filters['tipo_audiencia_id'])) {
            $query->where('tipo_audiencia_id', $filters['tipo_audiencia_id']);
        }

        if (! empty($filters['juez_id'])) {
            $query->where('juez_id', $filters['juez_id']);
        }

        if (! empty($filters['modalidad'])) {
            $query->where('modalidad', $filters['modalidad']);
        }

        return $query;
    }

    private function reportRelations(): array
    {
        return [
            'delito',
            'tipoAudiencia',
            'juez',
            'traductor',
            'psicologo',
            'sala',
            'imputados',
            'creador',
        ];
    }

    private function reportRow(Audiencia $audiencia): array
    {
        $imputados = $audiencia->imputados->map(function ($imputado) {
            return trim($imputado->nombre . ' ' . $imputado->apellidos);
        })->implode(', ');

        return [
            $audiencia->id,
            $audiencia->causa,
            optional($audiencia->fecha)->format('Y-m-d') ?? '-',
            optional($audiencia->hora)->format('H:i') ?? $audiencia->hora ?? '-',
            optional($audiencia->delito)->delito ?? '-',
            optional($audiencia->tipoAudiencia)->tipo ?? '-',
            $imputados ?: '-',
            optional($audiencia->sala)->sala ?? '-',
            $audiencia->modalidad ?? '-',
            optional($audiencia->juez)->nombre ?? '-',
            optional($audiencia->traductor)->nombres
                ? optional($audiencia->traductor)->nombres .
                (optional($audiencia->traductor)->lengua
                    ? ' - ' . optional($audiencia->traductor)->lengua
                    : '')
                : '-',
            optional($audiencia->psicologo)->nombre ?? '-',
            optional($audiencia->creador)->nombre ?? '-',
            $audiencia->estado ?? 'Programada',
        ];
    }

    public function reagendar(Audiencia $audiencia)
    {
        $audiencia->load('imputados');

        $jueces = Juez::orderBy('nombre')->get();
        $tipoAudiencias = TipoAudiencia::orderBy('tipo')->get();
        $delitos = Delito::orderBy('delito')->get();
        $traductores = Traductor::orderBy('nombres')->get();
        $psicologos = Psicologo::orderBy('nombre')->get();
        $salas = Sala::orderBy('sala')->get();
        $imputados = Imputado::orderBy('apellidos')
            ->orderBy('nombre')
            ->get();

        return view('audiencias.create', compact(
            'audiencia',
            'jueces',
            'tipoAudiencias',
            'delitos',
            'traductores',
            'psicologos',
            'salas',
            'imputados'
        ));
        
    }
}
