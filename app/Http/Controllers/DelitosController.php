<?php

namespace App\Http\Controllers;

use App\Models\Delito;
use App\Models\Imputado;
use Illuminate\Http\Request;

class DelitosController extends Controller
{
    /**
     * Display a listing of the delitos.
     */
    public function index()
    {
        $delitos = Delito::paginate(10);
        return view('delitos.index', compact('delitos'));
    }

    /**
     * Show the form for creating a new delito.
     */
    public function create()
    {
        return view('delitos.create');
    }

    /**
     * Store a newly created delito in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'delito' => 'required|string|unique:delitos|max:255',
        ]);

        Delito::create($validated);

        return redirect()->route('delitos.index')->with('success', 'Delito creado exitosamente');
    }

    /**
     * Display the specified delito.
     */
    public function show(Delito $delito)
    {
        return view('delitos.show', compact('delito'));
    }

    /**
     * Show the form for editing the specified delito.
     */
    public function edit(Delito $delito)
    {
        return view('delitos.edit', compact('delito'));
    }

    /**
     * Update the specified delito in storage.
     */
    public function update(Request $request, Delito $delito)
    {
        $validated = $request->validate([
            'delito' => 'required|string|max:255|unique:delitos,delito,' . $delito->id,
        ]);

        $delito->update($validated);

        return redirect()->route('delitos.show', $delito)->with('success', 'Delito actualizado exitosamente');
    }

    /**
     * Remove the specified delito from storage.
     */
    public function destroy(Delito $delito)
    {
        $delito->delete();
        return redirect()->route('delitos.index')->with('success', 'Delito eliminado exitosamente');
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'delito' => 'required|string|unique:delitos,delito|max:255',
        ]);

        $delito = Delito::create([
            'delito' => $request->delito,
        ]);

        return response()->json($delito);
    }
}
