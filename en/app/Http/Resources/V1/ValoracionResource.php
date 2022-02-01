<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ValoracionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id'=> $this->user_id,
            'slug'=> $this->slug,
            'comentario'=> $this->comentario,
            'calificacion'=> $this->calificacion,
            'recomendaria'=> $this->recomendaria,
            'titulo'=> $this->titulo,
            'email'=> $this->email,
            'nombre'=> $this->nombre,
            'id_servicio'=> $this->id_servicio,
            'excerpt' => $this->excerpt,
            'fecha_registro' => $this->fecha_registro
        ];
    }
}
