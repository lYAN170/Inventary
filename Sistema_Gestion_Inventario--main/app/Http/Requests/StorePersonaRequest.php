<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * Obtiene las reglas de validación que se aplicarán a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombres' => 'required|string|max:80',
            'apellido_paterno' => 'required|string|max:80',
            'apellido_materno' => 'required|string|max:80',
            'sexo' => 'required|string|max:10',
            'contacto' => 'required|string|max:80',
            'direccion' => 'required|string|max:80',
            'telefono' => 'required|string|max:15',
            'email' => 'required|email|unique:personas,email',
            'tipo_persona' => 'required|string|max:20',
            'estado' => 'required|boolean',
            'documento_id' => 'required|exists:documentos,id',
            'documento_entidad' => 'required|string|max:80',
        ];
    }

    /**
     * Obtiene los mensajes personalizados de validación.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombres.required' => 'El nombre es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'documento_id.exists' => 'El documento seleccionado no existe.',
        ];
    }
}
