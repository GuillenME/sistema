<?php

namespace App\Http\Controllers;

use App\Models\Audiencia;
use App\Models\Resumen;
use Illuminate\Http\Request;

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

    public function edit(Resumen $resumen)
    {
        $audiencias = $this->audienciasForSelect();

        return view('resumen.edit', compact('resumen', 'audiencias'));
    }

    public function update(Request $request, Resumen $resumen)
    {
        $data = $this->validateResumen($request);

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
            'hora_final' => 'nullable|date_format:H:i',
            'defensa' => 'nullable|string|max:45',
            'fiscalia' => 'nullable|string|max:45',
            'auxiliar' => 'nullable|string|max:45',
            'victima' => 'nullable|string|max:45',
            'plazo' => 'nullable|string|max:45',
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
