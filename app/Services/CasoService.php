<?php

namespace App\Services;

use App\Models\Caso;
use Illuminate\Support\Facades\Auth;

class CasoService
{
    public function listar()
    {
        return Caso::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
    }

    public function crear(array $datos): Caso
    {
        return Caso::create([
            'user_id'          => Auth::id(),
            'nombre'           => $datos['nombre'],
            'tipo'             => $datos['tipo'],
            'descripcion'      => $datos['descripcion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            'telefono'         => $datos['telefono'] ?? null,
            'direccion'        => $datos['direccion'] ?? null,
            'estado'           => $datos['estado'] ?? 'activo',
        ]);
    }

    public function obtener(int $id): Caso
    {
        return Caso::where('user_id', Auth::id())->findOrFail($id);
    }

    public function actualizar(int $id, array $datos): Caso
    {
        $caso = $this->obtener($id);
        $caso->update([
            'nombre'           => $datos['nombre'],
            'tipo'             => $datos['tipo'],
            'descripcion'      => $datos['descripcion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            'telefono'         => $datos['telefono'] ?? null,
            'direccion'        => $datos['direccion'] ?? null,
            'estado'           => $datos['estado'] ?? $caso->estado,
        ]);
        return $caso->fresh();
    }

    public function eliminar(int $id): void
    {
        $this->obtener($id)->delete();
    }
}
