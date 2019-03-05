<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
    if (!function_exists('crea_repo_categorias_destacadas')) {
        function get_formar_recomendacion($usuario,$resumen_recomendacion,$paginacion,$resumen_valoraciones_vendedor)
        {

            $r[] =  heading_enid("RESEÑAS Y VALORACIONES SOBRE", 1) ;
            $r[] =  br() ;
            $r[] =  anchor_enid(
                icon('fa fa-shopping-cart') . get_campo($usuario, "nombre"),
                [

                    "href" => "../search/?q3=" . get_campo($usuario, "id_usuario"),
                    "class" => 'go-usuario top_20 cursor_pointer'
                ],
                1,
                0) ;
            $r[] =  div($resumen_recomendacion, 1) ;
            $r[] =  div($paginacion, 1) ;
            $r[] =  div($resumen_valoraciones_vendedor, 1) ;
            $r[] =  div($paginacion, 1) ;

            return append_data($r);
        }
    }

}