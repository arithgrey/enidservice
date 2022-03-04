<?php

namespace App\Http\Controllers\Valoracion;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\TipoValoracion;

class PageController extends Controller
{

    public function encuesta($id)
    {


        return Inertia::render('Valoraciones/Encuesta',
        [
            'id' => $id,
            'tipos_valoraciones' => TipoValoracion::get()
        ]);
    }
}
