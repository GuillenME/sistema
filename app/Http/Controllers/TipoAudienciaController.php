<?php

namespace App\Http\Controllers;

use App\Models\TipoAudiencia;
use Illuminate\Http\Request;

class TipoAudienciaController extends Controller
{
    /**
     * Display a listing of the tipoaudiencias.
     */
    public function index()
    {
        $tipoaudiencias = TipoAudiencia::paginate(10);
        return view('tipoaudiencias.index', compact('tipoaudiencias'));
    }

    /**
     * Show the form for creating a new tipoaudiencia.
     */
    public function create()
    {
        return view('tipoaudiencias.create');
    }

    /**
     * Store a newly created tipoaudiencia in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255|unique:tipo_audiencia,tipo',
        ]);

        TipoAudiencia::create($validated);

        return redirect()->route('tipoaudiencias.index')->with('success', 'Tipo de audiencia creado exitosamente');
    }

    /**
     * Display the specified tipoaudiencia.
     */
    public function show(TipoAudiencia $tipoaudiencia)
    {
        return view('tipoaudiencias.show', compact('tipoaudiencia'));
    }

    /**
     * Show the form for editing the specified tipoaudiencia.
     */
    public function edit(TipoAudiencia $tipoaudiencia)
    {
        return view('tipoaudiencias.edit', compact('tipoaudiencia'));
    }

    /**
     * Update the specified tipoaudiencia in storage.
     */
    public function update(Request $request, TipoAudiencia $tipoaudiencia)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255|unique:tipo_audiencia,tipo,' . $tipoaudiencia->id,
        ]);

        $tipoaudiencia->update($validated);

        return redirect()->route('tipoaudiencias.show', $tipoaudiencia)->with('success', 'Tipo de audiencia actualizado exitosamente');
    }

    /**
     * Remove the specified tipoaudiencia from storage.
     */
    public function destroy(TipoAudiencia $tipoaudiencia)
    {
        $tipoaudiencia->delete();
        return redirect()->route('tipoaudiencias.index')->with('success', 'Tipo de audiencia eliminado exitosamente');
    }
}
