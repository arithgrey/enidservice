<?php

namespace App\Http\Livewire;
use App\Models\Valoracion;
use Livewire\Component;


class ValoracionesListado extends Component
{
    public function render()
    {
        return view('livewire.valoraciones-listado',
            [
                'valoraciones' => Valoracion::latest()->paginate()
            ]
        );
    }
}