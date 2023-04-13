<?php

namespace Enid\AccionesSeguimiento;

class Clientes
{

    function __construct()
    {
    }
    function formatoListado($acciones_seguimiento)
    {

        if (!es_data($acciones_seguimiento)) {
            return [];
        }
        $fichas = [];
        foreach ($acciones_seguimiento  as $row) {

            $id = $row["id"];
            $id_usuario = $row["id_usuario"];
            $id_accion_seguimiento = $row["id_accion_seguimiento"];
            $fecha_registro      = $row["fecha_registro"];
            $comentario = $row["comentario"];
            $status = $row["status"];
            $accion = $row["accion"];
            $ayuda_accion = $row["ayuda_accion"];

            $texto_accion = flex(icon(_check_icon),$accion,'','mr-2');
            $tarjeta = [];
            $tarjeta[] = d($texto_accion, 'mt-5 strong f11 col-xs-12');
            $tarjeta[] = d(span($ayuda_accion), "col-xs-12 mt-4 mb-4 ");
            
            
            
            $texto_accion = flex(icon(_mas_opciones_bajo_icon),"Comentario del cliente",'','mr-2');
            $tarjeta[] = d($texto_accion, 'mt-5 strong f11 col-xs-12');
            
            $tarjeta[] = d(d($comentario,'bg_gray p-2'), ["class" => 'mt-4 col-xs-12']);        
            $tarjeta[] = d(span(format_fecha($fecha_registro,1),'fp9'), "col-xs-12 mt-4 mb-4 text-right");

            $fichas[] = d($tarjeta,'mt-5 borde_black p-3');
        }
        return d($fichas,13);
    }
}
