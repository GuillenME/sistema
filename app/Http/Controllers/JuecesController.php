<?php

namespace App\Http\Controllers;

use App\Models\Juez;
use Illuminate\Http\Request;

class JuecesController extends Controller
{
    /**
     * Display a listing of the jueces.
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $jueces = Juez::when($buscar, function ($query, $buscar) {
            $query->where('nombre', 'like', "%{$buscar}%")
                ->orWhere('apellidos', 'like', "%{$buscar}%")
                ->orWhere('lugar', 'like', "%{$buscar}%");
        })->orderBy('apellidos')->orderBy('nombre')->paginate(10)->withQueryString();

        return view('jueces.index', compact('jueces', 'buscar'));
    }

    /**
     * Show the form for creating a new juez.
     */
    public function create()
    {
        return view('jueces.create');
    }

    /**
     * Store a newly created juez in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'lugar' => 'nullable|string|max:255',
        ]);

        Juez::create($validated);

        return redirect()->route('jueces.index')->with('success', 'Juez creado exitosamente');
    }

    /**
     * Display the specified juez.
     */
    public function show(Juez $juez)
    {
        return view('jueces.show', compact('juez'));
    }

    /**
     * Show the form for editing the specified juez.
     */
    public function edit(Juez $juez)
    {
        return view('jueces.edit', compact('juez'));
    }

    /**
     * Update the specified juez in storage.
     */
    public function update(Request $request, Juez $juez)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'lugar' => 'nullable|string|max:255',
        ]);

        $juez->update($validated);

        return redirect()->route('jueces.show', $juez)->with('success', 'Juez actualizado exitosamente');
    }

    /**
     * Remove the specified juez from storage.
     */
    public function destroy(Juez $juez)
    {
        $juez->delete();
        return redirect()->route('jueces.index')->with('success', 'Juez eliminado exitosamente');
    }
}
