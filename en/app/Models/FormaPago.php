<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    use HasFactory;

    public function ppfps()
    {

        return $this->hasMany(ProyectoPersonaFormaPago::class);
    }

}
