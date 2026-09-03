<?php

namespace App\Http\Controllers;

use App\Models\Psicologo;
use Illuminate\Http\Request;

class PsicologosController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $psicologos = Psicologo::when($buscar, fn ($query, $buscar) => $query->where('nombre', 'like', "%{$buscar}%"))
            ->orderBy('nombre')->paginate(10)->withQueryString();

        return view('psicologos.index', compact('psicologos', 'buscar'));
    }

    public function create()
    {
        return view('psicologos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Psicologo::create($validated);

        return redirect()->route('psicologos.index')->with('success', 'Psicologo creado exitosamente');
    }

    public function show(Psicologo $psicologo)
    {
        return view('psicologos.show', compact('psicologo'));
    }

    public function edit(Psicologo $psicologo)
    {
        return view('psicologos.edit', compact('psicologo'));
    }

    public function update(Request $request, Psicologo $psicologo)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $psicologo->update($validated);

        return redirect()->route('psicologos.show', $psicologo)->with('success', 'Psicologo actualizado exitosamente');
    }

    public function destroy(Psicologo $psicologo)
    {
        $psicologo->delete();
        return redirect()->route('psicologos.index')->with('success', 'Psicologo eliminado exitosamente');
    }
}
