<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;

    function delegacion()
    {
        return $this->belongsTo(Delegacion::class, 'id_delegacion');
    }

}
