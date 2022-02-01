<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $fillable = [ 
        'user_id', 
        'comentario', 
        'calificacion', 
        'recomendaria', 
        'titulo', 
        'email', 
        'nombre', 
        'id_servicio' 
    ];


    public function getExcerptAttribute()
    {
        return substr($this->titulo, 0, 100);
    }

    public function getFechaRegistroAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
    

}
