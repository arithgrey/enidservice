<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'cobro_secundario',
    ];

    function orden_comentarios()
    {
        return $this->hasMany(OrdenComentario::class);
    }
    function productos_ordenes_compra(){

        return $this->hasMany(ProductoOrdenCompra::class);
    }
}
