<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorServicio extends Model
{
    use HasFactory;
    function servicio()
    {
        return $this->belongsTo(Servicio::class);

    }

    function usuario()
    {
        return $this->belongsTo(User::class);

    }
}
