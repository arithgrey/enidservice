<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivoListaNegra extends Model
{
    use HasFactory;

    public function listas_negras()
    {

        return $this->hasMany(ListaNegra::class);
    }

}
