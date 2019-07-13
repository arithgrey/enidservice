<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
    function valida_active($num, $num_tab)
    {
        return  ($num == $num_tab) ? ' class="active" ' : "";

    }
    function lista_categorias($categorias)
    {

        $r = [];
        foreach ($categorias as $row) {

            $id_categoria = $row["id_categoria"];
            $nombre_categoria = $row["nombre_categoria"];
            $faqs = $row["faqs"];
            $href = "?categoria=" . $id_categoria;
            $text_lista = span($nombre_categoria . "(" . $faqs . ")");
            $link = anchor_enid($text_lista, $href);
            $r[] = d($link);
        }
        return append($r);
    }

    function create_meta_tags($string, $id_servicio)
    {

        $tags = explode(",", $string);
        $response = "";
        foreach ($tags as $row) {


            $response .= d(text_icon('fa fa-times', $row),
                [
                    "class" => 'tag_servicio btn btn-primary btn-sm',
                    "id" => $row,
                    "onclick" => "eliminar_tag('" . $row . "' ,  '" . $id_servicio . "' );"

                ]);

        }
        return $response;
    }

    function valida_existencia_imagenes($num_images)
    {
        return ($num_images > 0) ? "" : " display:none; ";
    }

    function text_agregar_telefono($has_phone, $telefono_visible)
    {

        $link =  ($has_phone == 0)  ? anchor_enid('INDICA TU NÚMERO TELEFÓNICO',  path_enid("administracion_cuenta") ) : "";
        return d(d($link, 1), "top_30");

    }
    function valida_text_imagenes($tipo_promocion, $num_images)
    {

        $tipo_promocion = strtoupper($tipo_promocion);
        if ($num_images == 0) {


            $text[] = h(
                "MUESTRA IMAGENES SOBRE TU " . $tipo_promocion . " A TUS CLIENTES"
                ,
                5
                ,
                'mensaje_imagenes_visible white shadow padding_10 black_enid_background'
                ,
                1
            );


            $text[] = d(
                "TU " . $tipo_promocion . " NO SERÁ VISIBLE HASTA QUE INCLUYAS ALGUNAS IMÁGENES"

                ,
                "notificacion_publicar_imagenes top_40 bottom_40"
                ,
                1);

            return append($text);
        }
    }

    function valida_descartar_promocion($num_images, $id_servicio, $id_perfil)
    {

        $response = ($num_images == 0 || $id_perfil != 20 && $id_perfil > 0) ?
            d(
                anchor_enid(
                    "DESCARTAR PROMOCIÓN",
                    [
                        "class" => 'descartar_promocion border descartar_promocion padding_10 ',
                        "id" => $id_servicio
                    ]
                ), "text-right top_30 bottom_50"
            ) : "";
        return $response;
    }

}
