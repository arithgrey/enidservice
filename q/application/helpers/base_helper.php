<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {
    function valida_active($num, $num_tab)
    {

        return ($num == $num_tab) ? 1 : 0;
    }

    function lista_categorias($categorias)
    {

        $r = [];
        foreach ($categorias as $row) {

            $str = _text("(", $row["faqs"], ")");
            $link = add_text("?categoria=", $row["id_categoria"]);
            $r[] = a_enid(_text($row["nombre_categoria"], $str), $link);
        }

        return append($r);
    }

    function create_meta_tags($string, $id_servicio)
    {

        $tags = explode(",", $string);
        $response = [];
        foreach ($tags as $row) {

            $response[] = d(
                text_icon('fa fa-times', $row),
                [
                    "class" => 'tag_servicio btn btn-primary btn-sm',
                    "id" => $row,
                    "onclick" => "eliminar_tag('" . $row . "' ,  '" . $id_servicio . "' );",
                ]
            );
        }

        return append($response);
    }

    function valida_existencia_imagenes($num_images)
    {
        return ($num_images > 0) ? "" : " display:none; ";
    }

    function text_agregar_telefono($has_phone)
    {

        $accion = a_enid(
            'INDICA TU NÚMERO TELEFÓNICO',
            path_enid("administracion_cuenta")
        );
        $link = ($has_phone < 1) ? $accion : "";

        return d($link, "p-0 col-lg-1 top_30");

    }

    function valida_text_imagenes($tipo_promocion, $num_images)
    {

        $response = "";
        if ($num_images < 1) {

            $response = _text(
                "TU ", $tipo_promocion, " ",
                "SERÁ VISIBLE HASTA QUE INCLUYAS ALGUNAS IMÁGENES"
            );
        }
        return $response;
    }

    function descartar_promocion($num_images, $id_servicio, $id_perfil)
    {

        $response = ($num_images < 1 || $id_perfil != 20) ?

            a_enid(
                "DESCARTAR PROMOCIÓN",
                [
                    "class" => 'descartar_promocion border padding_10 text-right top_30 bottom_50',
                    "id" => $id_servicio,
                ]
            ) : "";

        return $response;
    }

}
