<?php

namespace App\Http\Controllers;

use App\Services\CasoService;
use App\Services\GraficoService;
use Illuminate\Http\Request;

class GraficoController extends Controller
{
    public function __construct(
        private CasoService $casoService,
        private GraficoService $graficoService
    ) {}

    public function show(int $casoId, string $tipo)
    {
        if ($tipo === 'mapa_social') {
            $tipo = 'mapa_redes';
        }
        $tiposValidos = ['genograma', 'mapa_redes', 'ecomapa'];
        abort_unless(in_array($tipo, $tiposValidos), 404);

        $caso    = $this->casoService->obtener($casoId);
        $grafico = $this->graficoService->obtenerOCrear($casoId, $tipo);

        return view("graficos.{$tipo}", compact('caso', 'grafico'));
    }

    public function guardar(Request $request, int $casoId, string $tipo)
    {
        if ($tipo === 'mapa_social') {
            $tipo = 'mapa_redes';
        }
        $tiposValidos = ['genograma', 'mapa_redes', 'ecomapa'];
        abort_unless(in_array($tipo, $tiposValidos), 404);

        $this->casoService->obtener($casoId); // verifica propiedad

        $datos = $request->validate([
            'datos' => 'required|array',
        ]);

        $grafico = $this->graficoService->guardar($casoId, $tipo, $datos['datos']);

        return response()->json(['success' => true, 'grafico' => $grafico]);
    }
}

