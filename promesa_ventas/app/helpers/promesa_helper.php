<?php

use App\View\Components\titulo;

 if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data, $param)
    {

        
        $form[] = form_open("",["class" => "promesa_venta_form mt-5 row"]);
        $form[] = input_frm('mt-5 col-md-12 col-xs-12 mb-5', "¿ventas totales esperadas?",
            [
                "type" => "number",
                "required" => true,
                "class" => "meta",
                "name" => "meta",
                "id" => "meta",
                "value" => 0
            ]
        );
          
        $inicio = date("Y-m-d");
        $fin = date("Y-m-d");
    
        $form[] = input_frm(
            'col-xs-6 mt-5',
            "Fecha inicio",
            [
                "name" => 'fecha_inicio',
                "class" => "input_busqueda_inicio",
                "id" => 'datetimepicker4',
                "value" => $inicio,
                "type" => "date",
            ]
        );
    
        $form[] = input_frm(
            'col-xs-6 mt-5',
            "Fecha término",
            [
                "name" => 'fecha_termino',
                "class" => "input_busqueda_termino",
                "id" => 'datetimepicker5',
                "value" => $fin,
                "type" => "date",
            ]
    
        );
        $form[] = hiddens(["name" => "id_servicio" , "value" => $param["servicio"]]);

        $form[] = d(btn("Agregar meta", ["class" => "mt-5"]),12);        
        $form[] = form_close();

        $response[] = d(_titulo("¿Cuantas ventas esperas en las próximas fechas?",3),12);        
        $response[] = d(hr());
        $response[] = append($form);
        $response[] = d(place("simulacion_gastos_utilidad col-xs-12"), "mt-5 row");
        

        return d($response, 8,1);

    }

    
}
