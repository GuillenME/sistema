<?php

namespace App\Http\Controllers;

use App\Models\Imputado;
use Illuminate\Http\Request;

class ImputadosController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $imputados = Imputado::withCount('audiencias')
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('apellidos', 'like', "%{$buscar}%");
            })
            ->orderBy('apellidos')
            ->orderBy('nombre')
            ->paginate(10)
            ->appends(['buscar' => $buscar]);

        return view('imputados.index', compact('imputados', 'buscar'));
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
            'fecha_registro' => 'required|date',
        ]);

        Imputado::create($validated);

        return redirect()->route('imputados.index')->with('success', 'Imputado creado exitosamente');
    }

    public function show(Imputado $imputado)
    {
        $imputado->load([
            'audiencias' => function ($q) {
                $q->with(['delito', 'juez', 'tipoAudiencia'])
                    ->orderByDesc('fecha');
            }
        ]);

        $ultimaAudiencia = $imputado->audiencias->first();

        return view(
            'imputados.show',
            compact('imputado', 'ultimaAudiencia')
        );
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
            'fecha_registro' => 'required|date',
        ]);
        $imputado->update($validated);

        return redirect()->route('imputados.show', $imputado)->with('success', 'Imputado actualizado exitosamente');
    }

    public function destroy(Imputado $imputado)
    {
        $imputado->delete();

        return redirect()->route('imputados.index')->with('success', 'Imputado eliminado exitosamente');
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
        ]);

        $imputado = Imputado::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
        ]);

        return response()->json($imputado);
    }
}
