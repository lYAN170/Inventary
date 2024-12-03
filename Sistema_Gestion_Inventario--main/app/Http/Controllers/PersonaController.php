<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Documento;
use Illuminate\Http\Request;
use App\Http\Requests\PersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;

class PersonaController extends Controller
{
    /**
     * Mostrar una lista de personas con paginación.
     */
    public function index()
    {
        // Obtenemos todas las personas junto con sus documentos relacionados
        $personas = Persona::with('documento')->paginate(10);

        // Obtenemos todos los documentos disponibles
        $documentos = Documento::all();

        return view('personas.index', compact('personas', 'documentos'));
    }

    /**
     * Mostrar el formulario para crear una nueva persona.
     */
    public function create()
    {
        // Obtener todos los documentos disponibles para el formulario
        $documentos = Documento::all();
        return view('personas.create', compact('documentos'));
    }

    /**
     * Guardar una nueva persona en la base de datos.
     */
    public function store(PersonaRequest $request)
    {
        // Validamos y creamos una nueva persona
        Persona::create($request->validated());

        return redirect()->route('admin.personas.index')->with('success', 'Persona creada correctamente.');
    }

    /**
     * Mostrar el formulario para editar una persona existente.
     */
    public function edit(Persona $persona)
    {
        // Obtenemos los documentos disponibles para el formulario de edición
        $documentos = Documento::all();
        return view('personas.edit', compact('persona', 'documentos'));
    }

    /**
     * Actualizar la información de una persona existente.
     */
    public function update(UpdatePersonaRequest $request, $id)
{
    // Encontrar a la persona por ID
    $persona = Persona::findOrFail($id);

    // Actualizar los datos de la persona con los datos validados
    $persona->update($request->validated());

    // Redirigir con un mensaje de éxito
    return redirect()->route('admin.personas.index')->with('success', 'Persona actualizada correctamente');
}

    /**
     * Eliminar una persona.
     */
    public function destroy(Persona $persona)
    {
        // Verificamos si la persona está asociada con un cliente
        //if ($persona->clientes()->exists()) {
          //  return redirect()->route('admin.personas.index')->with('error', 'No se puede eliminar la persona porque está asociada a un cliente.');
        //}

        // Si no está asociada a un cliente, eliminamos la persona
        $persona->delete();

        return redirect()->route('admin.personas.index')->with('success', 'Persona eliminada correctamente.');
    }
}