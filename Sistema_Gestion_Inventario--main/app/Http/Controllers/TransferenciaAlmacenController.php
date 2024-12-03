<?php

namespace App\Http\Controllers;

use App\Models\TransferenciaAlmacen;
use App\Models\Producto;
use App\Models\Almacen;
use Illuminate\Http\Request;

class TransferenciaAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transferencias = TransferenciaAlmacen::with(['producto', 'almacenOrigen', 'almacenDestino'])->get();
        return view('transferencias.index', compact('transferencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        $almacenes = Almacen::all();
        return view('transferencias.create', compact('productos', 'almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'almacen_origen_id' => 'required|exists:almacenes,id',
            'almacen_destino_id' => 'required|exists:almacenes,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        TransferenciaAlmacen::create([
            'producto_id' => $request->producto_id,
            'almacen_origen_id' => $request->almacen_origen_id,
            'almacen_destino_id' => $request->almacen_destino_id,
            'cantidad' => $request->cantidad,
            'fecha_transferencia' => now(),
        ]);

        return redirect()->route('admin.transferencias.index')
            ->with('success', 'Transferencia realizada con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransferenciaAlmacen $transferencia)
    {
        $productos = Producto::all();
        $almacenes = Almacen::all();
        return view('transferencias.edit', compact('transferencias', 'productos', 'almacenes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransferenciaAlmacen $transferencia)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'almacen_origen_id' => 'required|exists:almacenes,id',
            'almacen_destino_id' => 'required|exists:almacenes,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $transferencia->update([
            'producto_id' => $request->producto_id,
            'almacen_origen_id' => $request->almacen_origen_id,
            'almacen_destino_id' => $request->almacen_destino_id,
            'cantidad' => $request->cantidad,
            'fecha_transferencia' => now(),
        ]);

        return redirect()->route('admin.transferencias.index')
            ->with('success', 'Transferencia actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransferenciaAlmacen $transferencia)
    {
        $transferencia->delete();
        return redirect()->route('admin.transferencias.index')
            ->with('success', 'Transferencia eliminada con éxito.');
    }
}
