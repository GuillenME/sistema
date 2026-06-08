<?php

namespace App\Http\Controllers;

use App\Models\Audiencia;
use App\Models\Delito;
use App\Models\Juez;
use App\Models\Psicologo;
use App\Models\Sala;
use App\Models\TipoAudiencia;
use App\Models\Traductor;
use Illuminate\Http\Request;

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

        return view('audiencias.create', compact(
            'jueces',
            'tipoAudiencias',
            'delitos',
            'traductores',
            'psicologos',
            'salas'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'causa' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'delitos_id' => 'required|exists:delitos,id',
            'tipo_audiencia_id' => 'required|exists:tipo_audiencia,id',
            'juez_id' => 'required|exists:juez,id',
            'traductor_id' => 'nullable|exists:traductor,id',
            'psicologo_id' => 'nullable|exists:psicologo,id',
            'salas_id' => 'required|exists:salas,id',
        ]);

        Audiencia::create($data);

        return redirect()->route('audiencias.index')->with('success', 'Audiencia guardada correctamente.');
    }
}
