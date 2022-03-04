<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoValoracion extends Model
{
    use HasFactory;

    public function valoracions()
    {

        $this->hasMany(Valoracion::class);

    }

}
