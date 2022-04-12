<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;
    function orden_comentarios()
    {
        return $this->hasMany(OrdenComentario::class);
    }
}
