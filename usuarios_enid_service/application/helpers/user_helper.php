<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if(!function_exists('invierte_date_time')){

        if ( ! function_exists('get_menu'))
        {
            function get_menu($in_session){

                $config["id"]           = 'tab_equipo_enid_service';
                $config["data-toggle"]  = 'tab';
                $config["class"]        = 'black strong tab_equipo_enid_service';
                $config["href"] =  "#tab1";

                $l1 = li(anchor_enid(icon("fa fa-space-shuttle").'EQUIPO  ENID  SERVICE' , $config));

                $config["id"]       = 'tab_afiliados';
                $config["class"]    = 'black strong tab_afiliados btn_ventas_mes_usuario';
                $config["href"]     = "#tab_productividad_ventas";

                $l2 = li(anchor_enid(icon("fa fa-handshake-o")."AFILIADOS". place("place_num_productividad"), $config));


                $config["id"]= 'tab_perfiles';
                $config["class"] = 'black strong perfiles_permisos';
                $config["href"] ="#tab_perfiles_permisos";

                $l3 = li(anchor_enid(icon("fa fa-unlock-alt")."PERFILES / PERMISOS ", $config));


                $config3["id"]      = 'agregar_categorias';
                $config3["class"]   = 'black strong tab_agregar_categorias';
                $config3["data-toggle"]  = 'tab';
                $config3["href"] ="#tab_agregar_categorias";

                $l4     = li(anchor_enid(icon("fa fa-circle"). "CATEGORÍAS / SERVICIOS" , $config3));


                $config4["id"]= 'agregar_tallas_menu';
                $config4["class"] = 'black strong agregar_tallas';
                $config4["data-toggle"]  = 'tab';
                $config4["href"] ="#agregar_tallas";


                $l5  = li(anchor_enid(icon("fa fa-percent")."TALLAS",$config4));
                $list   = [$l1 , $l2, $l3. $l4 , $l5];

                return ul($list, ["class"=>"nav tabs"]);

            }
        }


}