<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Valoracion extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'comentario',
        'calificacion',
        'recomendaria',
        'titulo',
        'email',
        'nombre',
        'id_servicio',
        'status'

    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'titulo'
            ]
        ];
    }

    public function getExcerptAttribute()
    {
        return substr($this->titulo, 0, 10);
    }

    public function getFechaRegistroAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
