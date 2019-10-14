<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {
    function valida_active($num, $num_tab)
    {
        return ($num == $num_tab) ? ' class="active" ' : "";

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
                            "onclick" => "eliminar_tag('".$row."' ,  '".$id_servicio."' );",
                    ]
            );
        }

        return append($response);
    }

    function valida_existencia_imagenes($num_images)
    {
        return ($num_images > 0) ? "" : " display:none; ";
    }

    function text_agregar_telefono($has_phone, $telefono_visible)
    {

        $accion = a_enid('INDICA TU NÚMERO TELEFÓNICO',
                path_enid("administracion_cuenta"));
        $link = ($has_phone < 1) ? $accion : "";

        return d($link, "p-0 col-lg-1 top_30");

    }

    function valida_text_imagenes($tipo_promocion, $num_images)
    {

        $tipo_promocion = strtoupper($tipo_promocion);
        if ($num_images == 0) {

            $ayuda = _text(
                    "MUESTRA IMAGENES SOBRE TU ", $tipo_promocion, " A TUS CLIENTES");
            $text[] = h(
                    $ayuda
                    ,
                    5
                    ,
                    'mensaje_imagenes_visible white shadow padding_10 black_enid_background'
                    ,
                    1
            );

            $incentivo = _text("TU ", $tipo_promocion,
                    " NO SERÁ VISIBLE HASTA QUE INCLUYAS ALGUNAS IMÁGENES");
            $text[] = d(
                    $incentivo
                    ,
                    "notificacion_publicar_imagenes top_40 bottom_40"
                    ,
                    1);

            return append($text);
        }
    }

    function valida_descartar_promocion($num_images, $id_servicio, $id_perfil)
    {

        $response = ($num_images < 1 || $id_perfil != 20) ?

                a_enid(
                        "DESCARTAR PROMOCIÓN",
                        [
                                "class" => 'descartar_promocion border descartar_promocion padding_10 text-right top_30 bottom_50',
                                "id" => $id_servicio,
                        ]
                ) : "";

        return $response;
    }

}
