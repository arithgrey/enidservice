<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function format_recomendacion($data, $resumen_recomendacion, $resumen_valoraciones_vendedor)
    {

        $usuario = $data["usuario"];
        $paginacion = $data["paginacion"];
        $vendedor = get_campo($usuario, "nombre");
        $link = a_enid(
            $vendedor,
            [
                "href" => path_enid('search_q3', get_campo($usuario, "id_usuario")),
                "class" => "h2 strong mt-0 color_azul_fuerte cursor_pointer"
            ]
        );
        $str = add_text("VALORACIONES RELACIONADAS A ", $link);
        $r[] = h($str, 1, "h4 strong text-uppercase ");
        $r[] = d($resumen_recomendacion);
        $r[] = d($paginacion);
        $r[] = d($resumen_valoraciones_vendedor);
        $r[] = d($paginacion);

        return d(append($r), 6, 1);
    }


}