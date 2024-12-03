<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Tabla que corresponde en la base de datos (si no coincide con el plural del nombre del modelo)
    protected $table = 'categorias'; // Asegúrate que esta tabla sea la correcta

    // Los campos que pueden ser llenados mediante asignación masiva
    protected $fillable = [
        'name', 
        'descripcion',
    ];

    // Si quieres que las fechas se gestionen automáticamente (created_at, updated_at)
    public $timestamps = true;

    // Si 'descripcion' es un campo largo y deseas que se gestione como un texto largo (si se usa en la base de datos como TEXT)
    protected $casts = [
        'descripcion' => 'string',
    ];
}
