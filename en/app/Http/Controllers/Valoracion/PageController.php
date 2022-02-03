<?php

namespace App\Http\Controllers\Valoracion;
use App\Models\Valoracion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
 
    public function encuesta()
    {

        return view('valoraciones.encuesta');
        
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
