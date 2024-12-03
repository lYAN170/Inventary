<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    public function documento(){
        return $this->belongsTo(Documento::class);
    }

    public function proveedor(){
        return $this->hasOne(Proveedor::class);
    }
    public function cliente(){
        return $this->hasOne(Cliente::class);
    }

    


    public function personas()
    {
        return $this->hasMany(Persona::class);
    }

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'contacto',
        'direccion',
        'telefono',
        'email',
        'tipo_persona',
        'estado',
        'tipo_documento', 
        'documento_id',
        'documento_entidad',
        'numero_documento', 
    ];
}
