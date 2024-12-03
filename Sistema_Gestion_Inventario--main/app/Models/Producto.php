<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'nombre',
        'Descripcion',

        'precio',
        'image',
        'categoria_id',
        'marca_id',
        'slug',
        'detalles_adicionales',
        'descuento',
        'status',
        'fecha_creacion',
    ];
    public function compras()
    {
        return $this->belongsToMany(Compra::class)->withTimestamps()
            ->withPivot('cantidad', 'precio_compra', 'precio_venta');
    }
    public function ventas()
    {
        return $this->belongsToMany(Venta::class)->withTimestamps()
            ->withPivot('cantidad', 'precio_venta', 'descuento');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];
}
