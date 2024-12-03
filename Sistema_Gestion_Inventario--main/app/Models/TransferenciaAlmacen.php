<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferenciaAlmacen extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'transferencias_almacenes';

    /**
     * Los atributos que son asignables.
     */
    protected $fillable = [
        'producto_id',
        'almacen_origen_id',
        'almacen_destino_id',
        'cantidad',
        'fecha_transferencia',
    ];

    /**
     * Relación con el modelo Producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Relación con el modelo Almacen (origen).
     */
    public function almacenOrigen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_origen_id');
    }

    /**
     * Relación con el modelo Almacen (destino).
     */
    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class, 'almacen_destino_id');
    }
}
