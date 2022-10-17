<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegacion extends Model
{
    use HasFactory;

    public function colonias()
    {

        return $this->hasMany(Colonia::class);
    }
    public function estado()
    {

        return $this->belongsTo(EstadoRepublica::class, 'id_estado');
    }
}
