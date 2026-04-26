<?php

namespace App\Http\Controllers;

use App\Services\CasoService;
use Illuminate\Http\Request;

class CasoController extends Controller
{
    public function __construct(private CasoService $casoService) {}

    public function index()
    {
        $casos = $this->casoService->listar();
        return view('casos.index', compact('casos'));
    }

    public function create()
    {
        return view('casos.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'           => 'required|string|max:255',
            'tipo'             => 'required|in:persona,familia',
            'descripcion'      => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'telefono'         => 'nullable|string|max:20',
            'direccion'        => 'nullable|string|max:255',
            'estado'           => 'nullable|in:activo,cerrado,pendiente',
        ]);

        $caso = $this->casoService->crear($datos);
        return redirect()->route('casos.show', $caso)->with('success', 'Caso creado correctamente.');
    }

    public function show(int $id)
    {
        $caso = $this->casoService->obtener($id);
        return view('casos.show', compact('caso'));
    }

    public function edit(int $id)
    {
        $caso = $this->casoService->obtener($id);
        return view('casos.edit', compact('caso'));
    }

    public function update(Request $request, int $id)
    {
        $datos = $request->validate([
            'nombre'           => 'required|string|max:255',
            'tipo'             => 'required|in:persona,familia',
            'descripcion'      => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'telefono'         => 'nullable|string|max:20',
            'direccion'        => 'nullable|string|max:255',
            'estado'           => 'required|in:activo,cerrado,pendiente',
        ]);

        $this->casoService->actualizar($id, $datos);
        return redirect()->route('casos.show', $id)->with('success', 'Caso actualizado correctamente.');
    }

    public function destroy(int $id)
    {
        $this->casoService->eliminar($id);
        return redirect()->route('casos.index')->with('success', 'Caso eliminado correctamente.');
    }
}

