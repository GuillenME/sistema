<?php

namespace App\Http\Controllers;

use App\Models\Audiencia;
use App\Models\Resumen;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class ResumenController extends Controller
{
    public function index()
    {
        $resumenes = Resumen::with([
            'audiencia.delito',
            'audiencia.tipoAudiencia',
            'audiencia.imputados',
        ])
            ->orderByDesc('id')
            ->paginate(8);

        return view('resumen.index', compact('resumenes'));
    }

    public function create()
    {
        $audiencias = $this->audienciasForSelect();

        return view('resumen.create', compact('audiencias'));
    }

    public function store(Request $request)
    {
        $data = $this->validateResumen($request);
        if (!empty($data['plazo'])) {

            $audiencia = Audiencia::findOrFail($data['audiencias_id']);

            $data['fecha_vencimiento'] = Carbon::parse($audiencia->fecha)
                ->addDays($data['plazo']);
        }
        Resumen::create($data);

        return redirect()
            ->route('resumen.index')
            ->with('success', 'Resumen guardado correctamente.');
    }

    public function show(Resumen $resumen)
    {
        $resumen->load([
            'audiencia.delito',
            'audiencia.tipoAudiencia',
            'audiencia.juez',
            'audiencia.sala',
            'audiencia.imputados',
        ]);

        return view('resumen.show', compact('resumen'));
    }
    public function exportPdf(Resumen $resumen)
    {
        $resumen->load([
            'audiencia.delito',
            'audiencia.tipoAudiencia',
            'audiencia.juez',
            'audiencia.sala',
            'audiencia.imputados',
        ]);
        $imputados = $resumen->audiencia->imputados
            ->map(function ($i) {
                return trim(($i->nombre ?? '') . ' ' . ($i->apellidos ?? ''));
            })
            ->implode(', ');
        $pdf = Pdf::loadView('resumen.pdf', compact('resumen', 'imputados'));

        return $pdf->download('Resumen_' . $resumen->id . '.pdf');
    }

    public function edit(Resumen $resumen)
    {
        $audiencias = $this->audienciasForSelect();

        return view('resumen.edit', compact('resumen', 'audiencias'));
    }

    public function update(Request $request, Resumen $resumen)
    {
        $data = $this->validateResumen($request);

        if (!empty($data['plazo'])) {

            $audiencia = Audiencia::findOrFail($data['audiencias_id']);

            $data['fecha_vencimiento'] = Carbon::parse($audiencia->fecha)
                ->addDays($data['plazo']);
        }

        $resumen->update($data);

        return redirect()
            ->route('resumen.show', $resumen)
            ->with('success', 'Resumen actualizado correctamente.');
    }

    public function destroy(Resumen $resumen)
    {
        if (auth()->user()->role->tipo !== 'admin') {
            abort(403, 'No tienes permiso para eliminar.');
        }

        $resumen->delete();

        return redirect()->route('resumen.index')
            ->with('success', 'Resumen eliminado correctamente');
    }

    private function validateResumen(Request $request)
    {
        return $request->validate([
            'audiencias_id' => 'required|exists:audiencias,id',
            'hora_inicio' => 'required|nullable|date_format:H:i',
            'hora_final' => 'required|nullable|date_format:H:i',
            'defensa' => 'required|nullable|string|max:255',
            'fiscalia' => 'required|nullable|string|max:255',
            'auxiliar' => 'required|nullable|string|max:255',
            'victima' => 'required|nullable|string|max:255',
            'plazo' => 'nullable|integer|min:1|max:3650',
            'hechos_ocurridos' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'medida' => 'nullable|string|max:255',
        ]);
    }

    private function audienciasForSelect()
    {
        return Audiencia::with(['imputados', 'tipoAudiencia'])
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->get();
    }

    public function exportWord(Resumen $resumen)
    {
        $resumen->load([
            'audiencia.delito',
            'audiencia.tipoAudiencia',
            'audiencia.juez',
            'audiencia.sala',
            'audiencia.imputados',
        ]);

        $imputados = $resumen->audiencia->imputados
            ->map(fn($i) => trim(($i->nombre ?? '') . ' ' . ($i->apellidos ?? '')))
            ->implode(', ');

        $phpWord = new PhpWord();

        // Estilos base
        $section = $phpWord->addSection([
            'marginLeft'   => 800,
            'marginRight'  => 800,
            'marginTop'    => 600,
            'marginBottom' => 600,
        ]);

        $titleStyle = ['bold' => true, 'size' => 14];
        $bold = ['bold' => true];
        $normal = ['size' => 11];

        // =========================
        // LOGO + TITULO
        // =========================
        $section->addImage(public_path('img/logop.jpg'), [
            'height' => 80,
            'alignment' => Jc::LEFT,
        ]);

        $section->addText(
            "JUZGADO DE CONTROL DEL\nDISTRITO JUDICIAL DE OCOSINGO",
            $titleStyle,
            ['alignment' => Jc::RIGHT]
        );

        $section->addText(str_repeat('-', 90));

        // =========================
        // ENCABEZADO PRINCIPAL
        // =========================
        $fecha = optional($resumen->audiencia->fecha)->translatedFormat('d \d\e F \d\e Y');

        $section->addText(
            "SIENDO LAS " . ($resumen->hora_inicio ?? '') .
                " DEL DÍA " . strtoupper($fecha)
        );

        $section->addText(
            "DAMOS INICIO A LA AUDIENCIA " . strtoupper($resumen->audiencia->tipoAudiencia->tipo ?? '')
        );

        $section->addText(
            "DENTRO DE LA CAUSA PENAL " . ($resumen->audiencia->causa ?? '')
        );

        $section->addText(
            "EN CONTRA DE " . strtoupper($imputados)
        );

        $section->addText(
            "POR EL DELITO DE " . strtoupper($resumen->audiencia->delito->delito ?? '')
        );

        $section->addText(
            "COMETIDO EN AGRAVIO DE " . strtoupper($resumen->victima)
        );

        $juez = trim(
            ($resumen->audiencia->juez->nombre ?? '') . ' ' .
                ($resumen->audiencia->juez->apellidos ?? '')
        );

        $section->addText(
            "DIRIGIDA POR EL JUEZ DE CONTROL " . strtoupper($juez)
        );

        $section->addTextBreak(1);

        // =========================
        // PARTES PROCESALES
        // =========================
        $section->addText("DEFENSA: " . $resumen->defensa, $normal);
        $section->addText("FISCALÍA: " . $resumen->fiscalia, $normal);
        $section->addText("AUXILIAR: " . $resumen->auxiliar, $normal);
        $section->addText("VÍCTIMA: " . $resumen->victima, $normal);

        $section->addTextBreak(1);

        // =========================
        // HECHOS
        // =========================
        $section->addText("HECHOS OCURRIDOS", $bold);
        $section->addText($resumen->hechos_ocurridos ?? '', $normal);

        $section->addTextBreak(1);

        // =========================
        // OBSERVACIONES
        // =========================
        $section->addText("OBSERVACIONES", $bold);
        $section->addText($resumen->observaciones ?? '', $normal);

        $section->addTextBreak(1);

        // =========================
        // MEDIDA
        // =========================
        $section->addText("MEDIDA", $bold);
        $section->addText($resumen->medida ?? '', $normal);

        $section->addTextBreak(1);

        // =========================
        // HORAS
        // =========================
        $section->addText(
            "HORA DE INICIO: " . ($resumen->hora_inicio ?? '') .
                "     HORA DE CONCLUSIÓN: " . ($resumen->hora_final ?? '')
        );

        $section->addTextBreak(2);

        // =========================
        // FOOTER SIMPLE
        // =========================
        $section->addText(
            "Documento generado el " . now()->format('d/m/Y'),
            ['size' => 9],
            ['alignment' => Jc::RIGHT]
        );

        // =========================
        // DESCARGA
        // =========================
        $fileName = 'Resumen_' . $resumen->id . '.docx';
        $tempFile = storage_path("app/temp/$fileName");

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
