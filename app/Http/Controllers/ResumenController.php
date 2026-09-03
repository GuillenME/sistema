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
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $resumenes = Resumen::with([
            'audiencia.delito',
            'audiencia.tipoAudiencia',
            'audiencia.imputados',
        ])
            ->when($buscar, function ($query, $buscar) {
                $query->where('defensa', 'like', "%{$buscar}%")
                    ->orWhere('fiscalia', 'like', "%{$buscar}%")
                    ->orWhere('medida', 'like', "%{$buscar}%")
                    ->orWhereHas('audiencia', function ($audienciaQuery) use ($buscar) {
                        $audienciaQuery->where('causa', 'like', "%{$buscar}%")
                            ->orWhereHas('tipoAudiencia', fn ($tipoQuery) => $tipoQuery->where('tipo', 'like', "%{$buscar}%"))
                            ->orWhereHas('imputados', function ($imputadoQuery) use ($buscar) {
                                $imputadoQuery->where('nombre', 'like', "%{$buscar}%")
                                    ->orWhere('apellidos', 'like', "%{$buscar}%");
                            });
                    });
            })
            ->orderByDesc('id')
            ->paginate(8)
            ->withQueryString();

        return view('resumen.index', compact('resumenes', 'buscar'));
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
        $phpWord->setDefaultFontName('DejaVu Sans');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginLeft'   => 800,
            'marginRight'  => 800,
            'marginTop'    => 600,
            'marginBottom' => 600,
        ]);

        $titleStyle = ['bold' => false, 'size' => 18, 'color' => 'B37A4A'];
        $bold = ['bold' => true, 'size' => 11];
        $normal = ['size' => 11];
        $justify = ['alignment' => Jc::BOTH, 'spaceAfter' => 120];
        $contentParagraph = ['alignment' => Jc::BOTH, 'spaceAfter' => 160];

        $header = $section->addTable(['width' => 100 * 50, 'unit' => 'pct']);
        $header->addRow();

        $logoCell = $header->addCell(5000);
        $logoCell->addImage(public_path('img/logop.jpg'), [
            'height' => 100,
        ]);

        $titleCell = $header->addCell(5000);
        $titleCell->addText('JUZGADO DE CONTROL DEL', $titleStyle, ['alignment' => Jc::RIGHT]);
        $titleCell->addText('DISTRITO JUDICIAL DE OCOSINGO.', $titleStyle, ['alignment' => Jc::RIGHT]);

        $section->addImage(public_path('img/lineas.jpg'), [
            'width' => 500,
            'alignment' => Jc::CENTER,
        ]);

        $fecha = optional($resumen->audiencia->fecha)->translatedFormat('d \d\e F \d\e Y');
        $horaInicio = optional($resumen->hora_inicio)->format('H:i') ?? '';
        $horaFinal = optional($resumen->hora_final)->format('H:i') ?? '';
        $tipoAudiencia = $resumen->audiencia->tipoAudiencia->tipo ?? '';
        $causa = $resumen->audiencia->causa ?? '';
        $delito = $resumen->audiencia->delito->delito ?? '';
        $victima = $resumen->victima ?? '';

        $juez = trim(
            ($resumen->audiencia->juez->nombre ?? '') . ' ' .
                ($resumen->audiencia->juez->apellidos ?? '')
        );

        $section->addTextBreak();

        $intro = $section->addTextRun($justify);
        $intro->addText('SIENDO LAS ', $normal);
        $intro->addText($horaInicio, $bold);
        $intro->addText(' DEL DÍA ', $normal);
        $intro->addText($this->wordUpper($fecha), $bold);
        $intro->addText(', DAMOS INICIO A LA AUDIENCIA ', $normal);
        $intro->addText($this->wordUpper($tipoAudiencia), $bold);
        $intro->addText(', DENTRO DE LA CAUSA PENAL ', $normal);
        $intro->addText($causa, $bold);
        $intro->addText(', EN CONTRA DE ', $normal);
        $intro->addText($this->wordUpper($imputados), $bold);
        $intro->addText(', POR SU PROBABLE INTERVENCIÓN DEL HECHO QUE LA LEY SEÑALA COMO DELITO DE ', $normal);
        $intro->addText($this->wordUpper($delito), $bold);
        $intro->addText(', COMETIDO EN AGRAVIO DE ', $normal);
        $intro->addText($this->wordUpper($victima), $bold);
        $intro->addText(', QUE SERÁ DIRIGIDA POR EL JUEZ DE CONTROL ', $normal);
        $intro->addText($this->wordUpper($juez), $bold);
        $intro->addText('.', $normal);

        $imputadoText = $section->addTextRun($contentParagraph);
        $imputadoText->addText('IMPUTADO: ', $bold);
        $imputadoText->addText($this->wordUpper($imputados) . ', por su probable intervención del hecho que la Ley señala como delito de ', $normal);
        $imputadoText->addText($this->wordUpper($delito), $normal);
        $imputadoText->addText(', cometido en agravio de ', $normal);
        $imputadoText->addText($this->wordUpper($victima), $bold);
        $imputadoText->addText(',', $normal);

        $this->addWordLabelLine($section, 'DEFENSA:', $resumen->defensa, $bold, $normal);
        $this->addWordLabelLine($section, 'FISCALÍA:', $resumen->fiscalia, $bold, $normal);
        $this->addWordLabelLine($section, 'AUXILIAR:', $resumen->auxiliar, $bold, $normal);
        $this->addWordLabelLine($section, 'VÍCTIMA(S):', $victima, $bold, $normal);

        $section->addTextBreak(1);

        $section->addText('HECHOS OCURRIDOS:', $bold);
        $section->addText($resumen->hechos_ocurridos ?? '', $normal, $contentParagraph);

        $section->addTextBreak(1);

        $section->addText('OBSERVACIONES:', $bold);
        $section->addText($resumen->observaciones ?? '', $normal, $contentParagraph);

        $section->addTextBreak(1);

        $section->addText('MEDIDA CAUTELAR:', $bold);
        $section->addText($resumen->medida ?? '', $normal, $contentParagraph);

        $section->addTextBreak(1);

        $horas = $section->addTextRun(['spaceAfter' => 120]);
        $horas->addText('HORA DE INICIO: ', $bold);
        $horas->addText($horaInicio, $normal);
        $horas->addText('        HORA DE CONCLUSIÓN: ', $bold);
        $horas->addText($horaFinal, $normal);

        $section->addTextBreak(2);

        $section->addText(
            "Documento generado el " . now()->format('d/m/Y'),
            ['size' => 9],
            ['alignment' => Jc::RIGHT]
        );

        $fileName = 'Resumen_' . $resumen->id . '.docx';
        $tempFile = storage_path("app/temp/$fileName");

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

    private function addWordLabelLine($section, string $label, ?string $value, array $labelStyle, array $valueStyle): void
    {
        $line = $section->addTextRun(['spaceAfter' => 80]);
        $line->addText($label . ' ', $labelStyle);
        $line->addText($value ?? '', $valueStyle);
    }

    private function wordUpper(?string $value): string
    {
        $value = $value ?? '';

        if (function_exists('mb_strtoupper')) {
            return mb_strtoupper($value, 'UTF-8');
        }

        return strtoupper($value);
    }
}
