<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render($data)
    {

        $response[] = d(navegacion_lead($data), 4);
        $response[] = d(listado_leads($data), 8);
        return d($response, 10, 1);
    }
    function listado_leads($data){
        
        
        $response[] = d($data["formulario_busqueda_ordenes_compra"],12);
        $response[] = d($data["eventos_pendientes"],12);
        $response[] = d($data["leads"],12);
        return d($response,13);
    }
    
    function navegacion_lead($data)
    {
        $response = [];
        if (es_administrador($data)) {            

            $response[] = d(format_link(
                text_icon(_text_(_money_icon,'white'), "Dasboards"),
                [

                    "href" => path_enid("reporte_enid"),
                    "class" => "text-uppercase black mt-2",
                ]
            ), 12);


            $response[] = d(format_link(
                text_icon(_text_(_money_icon), "Noticias"),
                [
    
                    "href" => path_enid("busqueda"),
                    "class" => "text-uppercase black mt-2",
                ]
            ,0),12);
    
            $response[] = d(format_link(
                text_icon(_money_icon, "pedidos"),
                [
                    "id" => "btn_servicios",
                    "href" => path_enid("pedidos"),
                    "class" => "text-uppercase black  mt-2 dispositivos",
                ],
                0
            ),12);

        }
        return $response;
    }
}
