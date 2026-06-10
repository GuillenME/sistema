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

class AudienciaController extends Controller
{
    public function index()
    {
        $audiencias = Audiencia::with([
            'delito',
            'tipoAudiencia',
            'juez',
            'traductor',
            'psicologo',
            'sala',
            'imputados',
            'creador',
        ])->orderByDesc('fecha')->paginate(15);

        return view('audiencias.index', compact('audiencias'));
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
            'causa' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'modalidad' => 'required|in:Presencial,Virtual,Híbrida',
            'delitos_id' => 'required|exists:delitos,id',
            'tipo_audiencia_id' => 'required|exists:tipo_audiencia,id',
            'juez_id' => 'required|exists:juez,id',
            'traductor_id' => 'nullable|exists:traductor,id',
            'psicologo_id' => 'nullable|exists:psicologo,id',
            'salas_id' => 'required|exists:salas,id',
            'imputados' => 'nullable|array',
            'imputados.*' => 'exists:imputados,id',
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
            'causa' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'modalidad' => 'required|in:Presencial,Virtual,Híbrida',

            'delitos_id' => 'required|exists:delitos,id',
            'tipo_audiencia_id' => 'required|exists:tipo_audiencia,id',
            'juez_id' => 'required|exists:juez,id',
            'traductor_id' => 'nullable|exists:traductor,id',
            'psicologo_id' => 'nullable|exists:psicologo,id',
            'salas_id' => 'required|exists:salas,id',
            'imputados' => 'nullable|array',
            'imputados.*' => 'exists:imputados,id',
        ]);

        $imputados = $data['imputados'] ?? [];
        unset($data['imputados']);

        $audiencia->update($data);
        $audiencia->imputados()->sync($imputados);

        return redirect()
            ->route('audiencias.show', $audiencia)
            ->with('success', 'Audiencia actualizada correctamente.');
    }

    public function destroy(Audiencia $audiencia)
    {
        $audiencia->delete();

        return redirect()
            ->route('audiencias.index')
            ->with('success', 'Audiencia eliminada correctamente.');
    }
}
