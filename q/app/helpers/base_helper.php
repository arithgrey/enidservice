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
        if(!str_len($string,0)){

            return "";
        }
        $tags = explode(",", $string);
        $response = [];
        foreach ($tags as $row) {

            $response[] = d(
                text_icon('fa fa-times white', $row),
                [
                    "class" => 'tag_servicio tag_en_producto col-md-2',
                    "id" => $row,
                    "onclick" => "eliminar_tag('" . $row . "' ,  '" . $id_servicio . "' );",
                ]
            );
        }

        return d($response,12);


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

            $texto = _text_("tu", $tipo_promocion, "será visible hasta que incluyas algunas imágenes");
            $response = d(_titulo($texto ), 'mt-5 mt-md-2 mb-5 py-5 py-md-1');
        }
        return $response;
    }

    function descartar_promocion($num_images, $id_servicio, $id_perfil)
    {


        return ($num_images < 1 || $id_perfil != 20) ?
            d(terminar('descartar_promocion', $id_servicio),'mt-5') : '';


    }

}
