<?php

namespace App\Http\Controllers;

use App\Models\Traductor;
use Illuminate\Http\Request;

class TraductorController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $traductores = Traductor::when($buscar, function ($query, $buscar) {
            $query->where('nombres', 'like', "%{$buscar}%")
                ->orWhere('lengua', 'like', "%{$buscar}%");
        })->orderBy('nombres')->paginate(10)->withQueryString();

        return view('traductores.index', compact('traductores', 'buscar'));
    }

    public function create()
    {
        return view('traductores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'lengua' => 'required|string|max:255',
        ]);

        Traductor::create($validated);

        return redirect()->route('traductores.index')->with('success', 'Traductor creado exitosamente');
    }

    public function show(Traductor $traductor)
    {
        return view('traductores.show', compact('traductor'));
    }

    public function edit(Traductor $traductor)
    {
        return view('traductores.edit', compact('traductor'));
    }

    public function update(Request $request, Traductor $traductor)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'lengua' => 'required|string|max:255',
        ]);

        $traductor->update($validated);

        return redirect()->route('traductores.show', $traductor)->with('success', 'Traductor actualizado exitosamente');
    }

    public function destroy(Traductor $traductor)
    {
        $traductor->delete();
        return redirect()->route('traductores.index')->with('success', 'Traductor eliminado exitosamente');
    }
}
