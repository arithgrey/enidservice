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

    function formatG($param, $nombre_servicio, $is_mobile)
    {

        $preview = [];
        $imgs_grandes = [];
        $preview_mb = [];
        $imagenes_format = [];
        $z = 0;

        foreach ($param as $row) {

            $url = get_url_servicio($row["nombre_imagen"], 1);
            $extra_class = "";
            $extra_class_contenido = '';

            if ($z < 1) {
                $extra_class = ' active ';
                $extra_class_contenido = ' in active ';
            }


            $preview[] =
                img(
                    [
                        'src' => $url,
                        'alt' => $nombre_servicio,
                        'class' => 'col-lg-8 mt-2 border cursor_pointer col-lg-offset-2 bg_white ' . $extra_class,
                        'id' => $z,
                        'data-toggle' => 'tab',
                        'href' => "#imagen_tab_" . $z
                    ]
                );

            $preview_mb[] = img(
                [
                    'src' => $url,
                    'alt' => $nombre_servicio,
                    'class' => 'col-xs-3 col-sm-3 mt-2 border mh_50 mah_50 mr-1 mb-1' . $extra_class,
                    'id' => $z,
                    'data-toggle' => 'tab',
                    'href' => _text("#imagen_tab_", $z)
                ]

            );


            $ext = ($is_mobile < 1) ? " mh_450 " : "";

            $imgs_grandes[] =
                img(
                    [
                        'src' => $url,
                        "class" => " w-100 tab-pane fade zoom img-zoom mh_sm_460" . $ext . " " . $extra_class_contenido,
                        "id" => "imagen_tab_" . $z,

                    ]
                );

            $imagenes_format[] = img(
                [
                    'src' => $url,
                    "class" => "mt-1 zoom img-zoom col-xs-12 col-md-6",                    
                ]
                );


            $z++;

        }
        


        $principal = "";

        if (es_data($param)) {

            $principal = (count($param) > 1) ? $param[1]["nombre_imagen"] : $param[0]["nombre_imagen"];
        }

        $clases = " align-self-center mx-auto col-md-2 d-none d-lg-block d-xl-block 
            d-md-block d-xl-none aviso_comision pt-3 pb-3";
        $clases_imagenes =
            " tab-content col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 
            col-md-6 col-md-offset-3 align-self-center image-container";

        $galeri = btw(
            d($preview, $clases),
            d($imgs_grandes, ["class" => $clases_imagenes, "id" => "container"]),
            'row'
        );
        $galeria_preview = d($preview_mb, "d-none d-sm-block d-md-none d-flex mt-5 row azul_deporte");
        
        $galeria = append([$galeri, $galeria_preview]);
        
        if($z > 1){
            $galeria = append($imagenes_format);
        }
        return [
            "preview" => append($preview),
            "preview_mb" => append($preview_mb),
            "num_imagenes" => count($param),
            "imagenes_contenido" => append($imgs_grandes),
            "principal" => get_url_servicio($principal, 1),
            "galeria" => $galeria,

        ];
    }
    
    function url_imagen_servicios(array $servicios, $key = "id_servicio", $index = 'url_img_servicio')
    {


        $imagenes = $this->imagenes_por_servicios($servicios, $key);

        $lista_servicios = [];

        foreach ($servicios as $servicio) {

            $id_servicio = $servicio[$key];

            $path = search_bi_array($imagenes, "id_servicio", $id_servicio, "nombre_imagen");
            $servicio[$index] = get_url_servicio($path, 1);
            $lista_servicios[] = $servicio;
        }
        return $lista_servicios;
    }

    function formato_servicio(array $servicios, $id_nicho = 0, $id_servicio_actual = 0)
    {

        $imagenes = $this->imagenes_por_servicios($servicios);

        $lista_servicios = [];

        foreach ($servicios as $servicio) {
            $id_servicio = $servicio["id_servicio"];
            if (
                $id_nicho === $servicio["id_nicho"]
                && $id_servicio_actual != $id_servicio
                || $id_nicho == 0
            ) {

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
