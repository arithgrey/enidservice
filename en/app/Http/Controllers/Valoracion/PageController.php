<?php

namespace App\Http\Controllers\Valoracion;

use Inertia\Inertia;
use App\Http\Controllers\Controller;


class PageController extends Controller
{

    public function encuesta()
    {
        return Inertia::render('Valoraciones/Encuesta');
    }
    /*
    public function listado()
    {

        return view('valoraciones.listado');
    }
    public function valoracion(Valoracion $valoracion)
    {

        return view('valoraciones.detalle', ['valoracion' => $valoracion]);
    }
    */
}
