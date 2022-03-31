<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaNegra extends Model
{

    use HasFactory;

    public function motivo()
    {
        return $this->belongsTo(MotivoListaNegra::class, 'id_motivo');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

}
