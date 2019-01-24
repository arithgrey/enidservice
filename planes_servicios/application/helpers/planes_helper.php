<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

    if ( ! function_exists('valida_action'))
    {
        function valida_action($param , $key ){

            $action =0;
            if ( get_param_def($param , $key) !== 0 ) {
                $action = $param[$key];
                switch ($action) {
                    case 'nuevo':
                      $action = 1;
                      break;
                    case 'vender':
                      $action = 1;
                      break;
                    case 'lista':
                      $action = 0;
                      break;
                    case 'editar':
                      $action = 2;
                      break;
                   default:
                     break;
                 }
            }
            return $action;
        }
    }
    if ( ! function_exists('valida_active_tab'))
    {
        function valida_active_tab($seccion , $valor_actual , $considera_segundo =0 ){
            $response =  " active ";
            if ($considera_segundo == 0 ) {
                $response = ($seccion ==  $valor_actual) ? " active ": "";
            }
            return $response;
        }
    }
    if ( ! function_exists('get_menu'))
    {
        function get_menu($is_mobile , $action){
            if ($is_mobile == 0 ){
                $list = [
                    li(
                        anchor_enid(
                            icon('fa fa-cart-plus') . " VENDER PRODUCTOS ",
                            [
                                "href" => "../planes_servicios/?action=nuevo",
                                "class" => "agregar_servicio btn_agregar_servicios"
                            ]
                        ),
                        ["class" => valida_active_tab('nuevo', $action) . " li_menu "]
                    ),

                    li(
                        anchor_enid(
                            icon("fa fa-shopping-cart")." TUS ARTÍCULOS EN VENTA",
                            [
                                'data-toggle'     =>   "tab"    ,
                                'class'           =>    "black  btn_serv",
                                'href'            =>    "#tab_servicios"
                            ]
                        ),
                        ["class"    =>  'li_menu li_menu_servicio btn_servicios '.valida_active_tab('lista' , $action)]
                    )
                ];
                return ul($list, ["class"=>"nav tabs contenedor_menu_enid_service_lateral"]);
            }else{

                $list = [
                    li(
                        anchor_enid(
                        "" ,
                        [
                            "href"      =>  "../planes_servicios/?action=nuevo" ,
                            "class"     =>  "agregar_servicio btn_agregar_servicios"
                        ]
                        ),
                        ["class"=>valida_active_tab('nuevo' , $action)]
                    ),

                    li(anchor_enid(
                        "",
                        [
                            'data-toggle'     =>   "tab"    ,
                            'class'           =>    "black  btn_serv",
                            'href'            =>    "#tab_servicios"
                        ]
                    ),
                        ["class"    =>  "li_menu li_menu_servicio btn_servicios ".valida_active_tab('lista' , $action) ]
                    )

                ];
                return ul($list , ["class"=>"nav tabs contenedor_menu_enid_service_lateral"]);

            }
        }
    }

}