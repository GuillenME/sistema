<?php

namespace App\Http\Controllers;

use App\Models\Audiencia;
use App\Models\Resumen;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumenController extends Controller
{
    public function index()
    {
        $resumenes = Resumen::with([
            'audiencia.delito',
            'audiencia.tipoAudiencia',
            'audiencia.imputados',
        ])
            ->orderByDesc('id')
            ->paginate(15);

        return view('resumen.index', compact('resumenes'));
    }

    public function create()
    {
        $audiencias = $this->audienciasForSelect();

        return view('resumen.create', compact('audiencias'));
    }

    public function store(Request $request)
    {
        $data = $this->validateResumen($request);
        if (!empty($data['plazo'])) {

            $audiencia = Audiencia::findOrFail($data['audiencias_id']);

            $data['fecha_vencimiento'] = Carbon::parse($audiencia->fecha)
                ->addDays($data['plazo']);
        }
        Resumen::create($data);

        return redirect()
            ->route('resumen.index')
            ->with('success', 'Resumen guardado correctamente.');
    }

    public function show(Resumen $resumen)
    {
        $resumen->load([
            'audiencia.delito',
            'audiencia.tipoAudiencia',
            'audiencia.juez',
            'audiencia.sala',
            'audiencia.imputados',
        ]);

        return view('resumen.show', compact('resumen'));
    }
    public function exportPdf(Resumen $resumen)
    {
        $resumen->load([
            'audiencia.delito',
            'audiencia.tipoAudiencia',
            'audiencia.juez',
            'audiencia.sala',
            'audiencia.imputados',
        ]);
        $imputados = $resumen->audiencia->imputados
            ->map(function ($i) {
                return trim(($i->nombre ?? '') . ' ' . ($i->apellidos ?? ''));
            })
            ->implode(', ');
        $pdf = Pdf::loadView('resumen.pdf', compact('resumen', 'imputados'));

        return $pdf->download('Resumen_' . $resumen->id . '.pdf');
    }

    public function edit(Resumen $resumen)
    {
        $audiencias = $this->audienciasForSelect();

        return view('resumen.edit', compact('resumen', 'audiencias'));
    }

    public function update(Request $request, Resumen $resumen)
    {
        $data = $this->validateResumen($request);

        if (!empty($data['plazo'])) {

            $audiencia = Audiencia::findOrFail($data['audiencias_id']);

            $data['fecha_vencimiento'] = Carbon::parse($audiencia->fecha)
                ->addDays($data['plazo']);
        }

        $resumen->update($data);

        return redirect()
            ->route('resumen.show', $resumen)
            ->with('success', 'Resumen actualizado correctamente.');
    }

    public function destroy(Resumen $resumen)
    {
        $resumen->delete();

        return redirect()
            ->route('resumen.index')
            ->with('success', 'Resumen eliminado correctamente.');
    }

    private function validateResumen(Request $request)
    {
        return $request->validate([
            'audiencias_id' => 'required|exists:audiencias,id',
            'hora_inicio' => 'required|nullable|date_format:H:i',
            'hora_final' => 'required|nullable|date_format:H:i',
            'defensa' => 'required|nullable|string|max:45',
            'fiscalia' => 'required|nullable|string|max:45',
            'auxiliar' => 'required|nullable|string|max:45',
            'victima' => 'required|nullable|string|max:45',
            'plazo' => 'nullable|integer|min:1|max:3650',
            'hechos_ocurridos' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'medida' => 'nullable|string|max:45',
        ]);
    }

    private function audienciasForSelect()
    {
        return Audiencia::with(['imputados', 'tipoAudiencia'])
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->get();
    }
}
