<?php

namespace Enid\ServicioImagen;

use Enid\Api\Api as Api;

class Format
{

    private $api;
    function __construct()
    {
        $this->api = new Api();
    }

    function url_imagen_servicios(array $servicios, $key = "id_servicio", $index = 'url_img_servicio')
    {

        
        $imagenes = $this->imagenes_por_servicios($servicios, $key );
        
        $lista_servicios = [];

        foreach ($servicios as $servicio) {

            $id_servicio = $servicio[$key];

            $path = search_bi_array($imagenes, "id_servicio", $id_servicio, "nombre_imagen");
            $servicio[$index] = get_url_servicio($path, 1); 
            $lista_servicios[] = $servicio;           

        }
        return $lista_servicios;
    }    

    function formato_servicio(array $servicios, $id_nicho = 0 , $id_servicio_actual = 0 )
    {

        $imagenes = $this->imagenes_por_servicios($servicios);

        $lista_servicios = [];

        foreach ($servicios as $servicio) {
            $id_servicio = $servicio["id_servicio"];
            if($id_nicho === $servicio["id_nicho"] && $id_servicio_actual != $id_servicio ){
                
                $path = search_bi_array($imagenes, "id_servicio", $id_servicio, "nombre_imagen");
                $servicio["url_img_servicio"] = get_url_servicio($path, 1);
                $servicio["in_session"] = 0;
                $servicio["id_usuario_actual"] = 0;
                $lista_servicios[] = create_vista($servicio);

    
            }

        }
        return $lista_servicios;
    }    

    function imagenes_por_servicios($servicios, $key = 'id_servicio')
    {

        $ids = array_column($servicios, $key);
        return $this->api("imagen_servicio/ids/", ["ids" => $ids]);
    }
    function api($api, $q = [], $format = 'json', $type = 'GET', $debug = 0, $externo = 0, $b = "")
    {
        return $this->api->api($api, $q, $format, $type, $debug, $externo, $b);
    }
}
