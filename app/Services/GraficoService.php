<?php

namespace App\Services;

use App\Models\Grafico;

class GraficoService
{
    public function obtenerOCrear(int $casoId, string $tipo): Grafico
    {
        return Grafico::firstOrCreate(
            ['caso_id' => $casoId, 'tipo' => $tipo],
            ['datos'   => null]
        );
    }

    public function guardar(int $casoId, string $tipo, array $datos): Grafico
    {
        $grafico = $this->obtenerOCrear($casoId, $tipo);
        $grafico->update(['datos' => $datos]);
        return $grafico->fresh();
    }

    public function obtener(int $casoId, string $tipo): ?Grafico
    {
        return Grafico::where('caso_id', $casoId)
            ->where('tipo', $tipo)
            ->first();
    }
}
