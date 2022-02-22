<?php

namespace App\Http\Controllers\Valoracion;

use Inertia\Inertia;
use App\Http\Controllers\Controller;


class PageController extends Controller
{

    public function encuesta($id)
    {

        return Inertia::render('Valoraciones/Encuesta',
        [
            'id' => $id
        ]);
    }
}
