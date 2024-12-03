<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Iniciar las reglas comunes
        $rules = [
            'nombres' => 'required|string|max:80',
            'apellido_paterno' => 'required|string|max:80',
            'apellido_materno' => 'nullable|string|max:80',
            'sexo' => 'required|string|max:10',
            'contacto' => 'nullable|string|max:80',
            'direccion' => 'required|string|max:80',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:80|unique:personas,email,' . $this->route('persona'),  // Excluir el correo del modelo actual si se está actualizando
            'tipo_persona' => 'required|string|max:20',
            'estado' => 'required|boolean',
            'documento_id' => 'required|exists:documentos,id',
            'documento_entidad' => 'nullable|string|max:80',
        ];

        // Condiciones para el campo numero_documento dependiendo de si es POST o PUT
        if ($this->isMethod('post')) {
            // Para POST (crear), el numero_documento es requerido y único
            $rules['numero_documento'] = 'required|max:20|unique:personas,numero_documento';
        } elseif ($this->isMethod('put')) {
            // Para PUT (actualizar), el numero_documento es requerido pero no único, se excluye el actual
            $rules['numero_documento'] = 'required|max:20|unique:personas,numero_documento,' . $this->route('persona');
        }

        return $rules;
    }
}
