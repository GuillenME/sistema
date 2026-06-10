<?php

namespace App\Http\Controllers;

use App\Models\Imputado;
use Illuminate\Http\Request;

class ImputadosController extends Controller
{
    public function index()
    {
        $imputados = Imputado::withCount('audiencias')
            ->orderBy('apellidos')
            ->orderBy('nombre')
            ->paginate(10);

        return view('imputados.index', compact('imputados'));
    }

    public function create()
    {
        return view('imputados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:45',
            'apellidos' => 'required|string|max:45',
        ]);

        Imputado::create($validated);

        return redirect()->route('imputados.index')->with('success', 'Imputado creado exitosamente');
    }

    public function show(Imputado $imputado)
    {
        $imputado->load('audiencias');

        return view('imputados.show', compact('imputado'));
    }

    public function edit(Imputado $imputado)
    {
        return view('imputados.edit', compact('imputado'));
    }

    public function update(Request $request, Imputado $imputado)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:45',
            'apellidos' => 'required|string|max:45',
        ]);

        $imputado->update($validated);

        return redirect()->route('imputados.show', $imputado)->with('success', 'Imputado actualizado exitosamente');
    }

    public function destroy(Imputado $imputado)
    {
        $imputado->delete();

        return redirect()->route('imputados.index')->with('success', 'Imputado eliminado exitosamente');
    }
}
