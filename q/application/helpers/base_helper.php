<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
    function valida_active($num, $num_tab)
    {
        $response = ($num == $num_tab) ? ' class="active" ' : "";
        return $response;
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
            $link = anchor_enid($text_lista, ['href' => $href]);
            $r[] = div($link, 4);
        }
        return append_data($r);
    }

    function create_meta_tags($string, $id_servicio)
    {

        $tags = explode(",", $string);
        $lista_tags = "";
        foreach ($tags as $row) {

            $icon = icon('fa fa-times');
            $lista_tags .= div($icon . $row,
                [
                    "class" => 'tag_servicio btn btn-primary btn-sm',
                    "id" => $row,
                    "onclick" => "eliminar_tag('" . $row . "' ,  '" . $id_servicio . "' );"

                ]);

        }
        return $lista_tags;
    }

    function valida_active_pane($num, $num_tab)
    {

        $response = ($num == $num_tab) ? ' active ' : "";
        return $response;

    }

    function valida_existencia_imagenes($num_images)
    {
        return ($num_images > 0) ? "" : " display:none; ";
    }

    function text_agregar_telefono($has_phone, $telefono_visible)
    {

        $link = "";
        if ($has_phone == 0) {

            $link = anchor_enid('INDICA TU NÚMERO TELEFÓNICO', ['href' => '../administracion_cuenta/']);

        }
        return div(div($link,1), "top_30");
    }

    function valida_activo_ventas_mayoreo($estado_actual, $ventas_mayoreo)
    {

        $response = ($estado_actual == $ventas_mayoreo) ? " button_enid_eleccion_active" : "";
        return $response;

    }


    function valida_activo_vista_telefono($valor, $valor_usuario)
    {

        $v = ($valor == $valor_usuario) ? "button_enid_eleccion_active" : "";
        return $v;
    }

    function valida_activo_entregas_en_casa($valor, $valor_usuario)
    {

        $response = ($valor == $valor_usuario) ? "button_enid_eleccion_active" : "";
        return $response;

    }

    function valida_text_imagenes($tipo_promocion, $num_images)
    {

        $tipo_promocion = strtoupper($tipo_promocion);
        if ($num_images == 0) {



            $text[] = heading_enid(
                "MUESTRA IMAGENES SOBRE TU " . $tipo_promocion . " A TUS CLIENTES"
                ,
                5
                ,
                'mensaje_imagenes_visible white shadow padding_10 black_enid_background'
                ,
                1
            );


            $text[] = div(
                "TU " . $tipo_promocion . " NO SERÁ VISIBLE HASTA QUE INCLUYAS ALGUNAS IMÁGENES"

                ,
                "notificacion_publicar_imagenes top_40 bottom_40"
                ,
                1);

            return append_data($text);
        }
    }

    function valida_descartar_promocion($num_images, $id_servicio)
    {

        $response = ($num_images == 0) ? div(anchor_enid("DESCARTAR PROMOCIÓN", ["class" => 'descartar_promocion border descartar_promocion padding_10 ', "id" => $id_servicio]), ["class" => "text-right top_30 bottom_50"]) : "";
        return $response;
    }

}
