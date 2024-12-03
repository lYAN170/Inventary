<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Persona;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Mostrar la lista de proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::with('persona')->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Mostrar el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        // Personas que no están ya asociadas como proveedores
        $personas = Persona::whereNotIn('id', Proveedor::pluck('persona_id'))->get();
        return view('proveedores.create', compact('personas'));
    }

    /**
     * Almacenar nuevos proveedores en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'proveedores' => 'required|array|min:1',
            'proveedores.*.persona_id' => 'required|exists:personas,id|unique:proveedores,persona_id',
        ]);

        // Registrar cada proveedor en la base de datos
        foreach ($request->proveedores as $proveedorData) {
            Proveedor::create([
                'persona_id' => $proveedorData['persona_id'],
            ]);
        }

        return response()->json([
            'message' => 'Proveedores guardados exitosamente.',
        ]);
    }

    /**
     * Mostrar los detalles de un proveedor específico.
     */
    public function show(Proveedor $proveedor)
    {
        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Mostrar el formulario para editar un proveedor existente.
     */
    public function edit(Proveedor $proveedor)
    {
        // Personas disponibles para editar (incluir la persona actual del proveedor)
        $personas = Persona::whereNotIn('id', Proveedor::pluck('persona_id'))->orWhere('id', $proveedor->persona_id)->get();
        return view('proveedores.edit', compact('proveedor', 'personas'));
    }

    /**
     * Actualizar los datos de un proveedor en la base de datos.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id|unique:proveedores,persona_id,' . $proveedor->id,
        ]);

        $proveedor->update([
            'persona_id' => $request->persona_id,
        ]);

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Eliminar un proveedor de la base de datos.
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
