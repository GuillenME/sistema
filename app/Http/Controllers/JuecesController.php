<?php

namespace App\Http\Controllers;

use App\Models\Juez;
use Illuminate\Http\Request;

class JuecesController extends Controller
{
    /**
     * Display a listing of the jueces.
     */
    public function index()
    {
        $jueces = Juez::paginate(10);
        return view('jueces.index', compact('jueces'));
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
