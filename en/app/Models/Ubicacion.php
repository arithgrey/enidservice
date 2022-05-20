<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    function ppfp()
    {
        return $this->belongsTo(ProyectoPersonaFormaPago::class, 'id_recibo');
    }
    function user()
    {

        return $this->belongsTo(User::class, 'id_usuario');
    }
}
