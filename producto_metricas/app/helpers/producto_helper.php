<?php

use App\View\Components\titulo;

 if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_producto($data)
    {

        $inf_servicio = $data["info_servicio"];
        $imgs = $data["imgs"];
        $in_session = $data["in_session"];
        $is_mobile = $data["is_mobile"];
        $s = $inf_servicio["servicio"];
        $s['in_session'] = $in_session;
        $nombre = pr($s, "nombre_servicio");
        $precio = pr($s, "precio");
        $id_servicio = pr($s, "id_servicio");
        $nombre = substr(strtoupper($nombre), 0, 70);
        $imagenes = img_lateral($imgs, $nombre, $is_mobile, $id_servicio);

        $clases = " align-self-center mx-auto col-lg-2 d-none d-lg-block d-xl-block 
            d-md-block d-xl-none aviso_comision pt-3 pb-3";
        $clases_imagenes =
            " tab-content col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 
            col-lg-6 col-lg-offset-3 align-self-center";

        $r[] = btw(
            d($imagenes["preview"], $clases),
            d($imagenes["imagenes_contenido"], $clases_imagenes)

        );

        $titulo = substr(strtoupper($nombre), 0, 200);
        $nombre_producto = _titulo($titulo, 2);
        $metricas[] = metricas_producto(
            $data,
            $nombre_producto,
            $precio, 
            $id_servicio
        );

        $data_response[] = d($r, 'col-sm-12 mt-5 mb-5');
        $pagina_producto[] =  d($data_response, 6);
        $pagina_producto[] =  d($metricas, 'col-sm-6 border-left border-dark');
        

        return append($pagina_producto);
    }

    function metricas_producto($data, $nombre_producto, $precio, $id_servicio)
    {

        $response[] = $nombre_producto;
        $response[] = texto_tipo_comision($data, $precio);
        $response[] = ganancia_comisionista($data);
        $response[] = _titulo("Métricas");
        $response[] = seccion_vistas($data);
        $response[] = format_accesos($id_servicio);


        return d($response);
    }
    function seccion_vistas($data)
    {
        $servicio = $data["info_servicio"]["servicio"][0];
        $vistas = $servicio["vista"];
        $deseado = $servicio["deseado"];
        $valoracion = $servicio["valoracion"];

        $texto = _text_(icon('fa fa fa-eye'), "Vistas del producto",  _titulo($vistas,2));
        $texto_comprado = _text_(icon('fa fa-gift'), "Lo han comprado", _titulo($deseado), 'veces');
        $texto_valoracion = _text_(icon('fa fa-star'), "Valoraciones", _titulo($valoracion,2));

        $response[] =  d($texto_comprado, 'border-bottom border-secondary mt-3 p-1 mb-2');
        $response[] =  d($texto, 'border-bottom border-secondary mt-3 p-1 mb-2');
        $response[] =  d($texto_valoracion, 'border-bottom border-secondary mt-3 p-1 mb-2');
        return append($response);
    }
    function ganancia_comisionista($data)
    {

        $in_session = prm_def($data, 'in_session');
        $id_perfil = prm_def($data, 'id_perfil');
        $es_comisionista = ($in_session && in_array($id_perfil, [6, 3]));

        $response = [];
        $servicio = $data['info_servicio']['servicio'];

        $response[] = utilidad_en_servicio($data, $servicio, 1, 'mb-2 text-right');

        if ($es_comisionista) {

            $porcentaje_comision = pr($servicio, 'comision');
            $precio = pr($servicio, 'precio');
            $comision = comision_porcentaje($precio, $porcentaje_comision);

            $text_comisionn = strong(money($comision), 'white f12');
            $text = _text_('gana', $text_comisionn, 'al verderlo!');
            $class = 'aviso_comision mb-2 white text-uppercase border shadow p-2 mb-5';
            $response[] = d($text, $class);
        }
        return append($response);
    }


    function texto_tipo_comision($data, $precio_unidad)
    {

        $servicio = $data["info_servicio"]["servicio"];
        $descuento_especial = pr($servicio, "descuento_especial");
        $usuario = $data["usuario"];
        $es_premium = es_premium($data, $usuario);
        $texto_precio_base = ($precio_unidad > 0) ? _text($precio_unidad, "MXN") : "A CONVENIR";

        $texto_premium = "";
        if ($es_premium) {

            $texto = d(del($texto_precio_base), "f11 text-secondary");
            $response = flex($texto, $texto_premium, "flex-column mb-3 mt-3");
        } else {


            $in_session = $data["in_session"];
            $texto = d($texto_precio_base, "f16 black");

            if ($in_session && $descuento_especial > 0) {


                $response = flex($texto, $texto_premium, "flex-column mb-3 mt-3");
            } else {

                $response = d($texto, "flex-column mb-3 mt-3");
            }
        }
        return $response;
    }

    function img_lateral($param, $nombre_servicio, $is_mobile, $id_servicio)
    {

        $preview = [];
        $imgs_grandes = [];
        $preview_mb = [];
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
                a_enid(img(
                    [
                        'src' => $url,
                        "class" => " w-100 tab-pane fade zoom img-zoom" . $ext . " " . $extra_class_contenido,
                        "id" => "imagen_tab_" . $z,

                    ]
                ), ['href' => path_enid("producto",$id_servicio)]);

            $z++;
        }


        $principal = "";

        if (es_data($param)) {

            $principal = (count($param) > 1) ? $param[1]["nombre_imagen"] : $param[0]["nombre_imagen"];
        }


        $response = [
            "preview" => append($preview),
            "preview_mb" => append($preview_mb),
            "num_imagenes" => count($param),
            "imagenes_contenido" => append($imgs_grandes),
            "principal" => get_url_servicio($principal, 1)
        ];
        return $response;
    }

    function format_accesos($id_servicio)
    {
        $form = base_busqueda_form('ACCESOS POR PÁGINA', $id_servicio, 
            'form_busqueda_accesos_pagina', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_accesos_pagina",
            ]
        );


    }
    function base_busqueda_form(
        $titulo_seccion, $id_servicio , $clase_form, $place, $fecha_inicio = 0, $fecha_termino = 0){


        $r[] = h($titulo_seccion, 3, "mb-5 h5 text-uppercase strong");
        $r[] = form_open("", ["class" => $clase_form]);
        $r[] = frm_fecha_busqueda($fecha_inicio, $fecha_termino);
        $r[] = hiddens(["name"=> "id_servicio", "value" => $id_servicio]);
        $r[] = form_close();
        $r[] = place(_text_($place, "mt-5"));

        return append($r);
    }

    

}
