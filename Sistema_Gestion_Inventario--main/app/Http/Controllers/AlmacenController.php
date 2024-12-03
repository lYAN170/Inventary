<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $almacenes = Almacen::all();
        return view('almacenes.index', compact('almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('almacenes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
        ]);

        Almacen::create([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
        ]);

        return redirect()->route('admin.almacenes.index')->with('success', 'Almacén creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Almacen $almacen)
    {
        return view('almacenes.show', compact('almacen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Almacen $almacen)
{
    return view('almacenes.edit', compact('almacen'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
        ]);

        $almacen->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
        ]);

        return redirect()->route('admin.almacenes.index')->with('success', 'Almacén actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        try {
            $almacen->delete();
            return redirect()->route('admin.almacenes.index')->with('success', 'Almacén eliminado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('admin.almacenes.index')->with('error', 'No se pudo eliminar el almacén.');
        }
    }
}
