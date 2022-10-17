<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoRepublica extends Model
{
    use HasFactory;

    public function delegaciones()
    {

        return $this->hasMany(Delegacion::class);
    }
}
