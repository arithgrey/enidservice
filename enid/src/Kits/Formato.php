<?php

namespace Enid\Kits;

use Enid\ServicioImagen\Format as FormatImgServicio;

class Formato

{
    private $servicio_imagen;
    function __construct()
    {

        $this->servicio_imagen = new FormatImgServicio();

    }

    function listado($kits_servicios)
    {
        $kits_servicios = $this->servicio_imagen->url_imagen_servicios($kits_servicios);
        $ids_kits = array_unique(array_column($kits_servicios,"id_kit"));
        $response = [];
        foreach($ids_kits as  $row){

            $response[] = d($row) ;
        }
        return append($response);
        
    }
}
