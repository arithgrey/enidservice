<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicloFacturacion extends Model
{
    use HasFactory;

    public function servicios(){

        return $this->hasMany(Servicio::class);
    }
    public function ppfps(){

        return $this->hasMany(ProyectoPersonaFormaPago::class);
    }



}
