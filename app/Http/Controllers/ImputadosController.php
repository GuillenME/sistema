<?php

namespace App\Http\Controllers;

use App\Models\Delito;
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
                    ->orWhere('apellidos', 'like', "%{$buscar}%")
                    ->orWhere('causa', 'like', "%{$buscar}%")
                    ->orWhereHas('delito', fn ($delitoQuery) => $delitoQuery->where('delito', 'like', "%{$buscar}%"));
            })
            ->orderBy('apellidos')
            ->orderBy('nombre')
            ->paginate(10)
            ->appends(['buscar' => $buscar]);

        return view('imputados.index', compact('imputados', 'buscar'));
    }

    public function create()
    {
        $delitos = Delito::orderBy('delito')->get();

        return view('imputados.create', compact('delitos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'max:45',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],

            'apellidos' => [
                'required',
                'max:45',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],

            'fecha_registro' => 'required|date',

            'causa' => [
                'nullable',
                
            ],

            'delitos_id' => 'nullable|exists:delitos,id',

        ], [
            'nombre.regex' => 'El nombre solo puede contener letras.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras.',
            
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
        $delitos = Delito::orderBy('delito')->get();

        return view('imputados.edit', compact('imputado', 'delitos'));
    }

    public function update(Request $request, Imputado $imputado)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'max:45',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],

            'apellidos' => [
                'required',
                'max:45',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],

            'fecha_registro' => 'required|date',

            'causa' => [
                'nullable',
                
            ],

            'delitos_id' => 'nullable|exists:delitos,id',

        ], [
            'nombre.regex' => 'El nombre solo puede contener letras.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras.',
           
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
            'nombre' => [
                'required',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],

            'apellidos' => [
                'required',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
            ],

            'causa' => [
                'nullable',
               
            ],

            'delitos_id' => 'nullable|exists:delitos,id',

        ], [
            'nombre.regex' => 'El nombre solo puede contener letras.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras.',
            
        ]);

        $imputado = Imputado::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,

            'fecha_registro' => now(),

            'causa' => $request->causa,
            'delitos_id' => $request->delitos_id,
        ]);

        return response()->json($imputado);
    }
}
