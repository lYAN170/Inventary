<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Persona;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClienteController extends Controller
{
    /**
     * Mostrar la lista de clientes.
     */
    public function index()
    {
        $clientes = Cliente::with('persona')->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar el formulario para crear un nuevo cliente.
     */
    public function create()
    {
        $personas = Persona::whereNotIn('id', Cliente::pluck('persona_id'))->get();
        return view('clientes.create', compact('personas'));
    }

    /**
     * Almacenar nuevos clientes en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'clientes' => 'required|array|min:1',
            'clientes.*.persona_id' => 'required|exists:personas,id|unique:clientes,persona_id',
        ]);

        foreach ($request->clientes as $clienteData) {
            Cliente::create([
                'persona_id' => $clienteData['persona_id'],
            ]);
        }

        return response()->json([
            'message' => 'Clientes guardados exitosamente.',
        ]);
    }

    /**
     * Mostrar los detalles de un cliente específico.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostrar el formulario para editar un cliente existente.
     */
    public function edit(Cliente $cliente)
    {
        $personas = Persona::whereNotIn('id', Cliente::pluck('persona_id'))->orWhere('id', $cliente->persona_id)->get();
        return view('clientes.edit', compact('cliente', 'personas'));
    }

    /**
     * Actualizar los datos de un cliente en la base de datos.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id|unique:clientes,persona_id,' . $cliente->id,
        ]);

        $cliente->update([
            'persona_id' => $request->persona_id,
        ]);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Eliminar un cliente de la base de datos.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
