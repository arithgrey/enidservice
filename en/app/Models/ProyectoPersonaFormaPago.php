<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoPersonaFormaPago extends Model
{
    use HasFactory;
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
