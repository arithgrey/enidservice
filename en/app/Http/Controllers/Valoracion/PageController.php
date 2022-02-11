<?php

namespace App\Http\Controllers\Valoracion;

use App\Models\Valoracion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function encuesta($id_servicio)
    {

        return view('valoraciones.encuesta', ['id_servicio' => $id_servicio]);
    }
    public function listado()
    {

        return view('valoraciones.listado');
    }
    public function valoracion(Valoracion $valoracion)
    {

        return view('valoraciones.detalle', ['valoracion' => $valoracion]);
    }
}
