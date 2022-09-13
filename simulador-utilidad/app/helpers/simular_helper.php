<?php

use App\View\Components\titulo;

 if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        
        $form[] = form_open("",["class" => "utilidad_form mt-5 row"]);

        $form[] = input_frm('mt-5 col-md-6 col-xs-12 mt-3', "¿Precio en que vendes tu artículo?",
            [
                "type" => "number",
                "required" => true,
                "class" => "precio",
                "name" => "precio",
                "id" => "precio",
                "value" => 0
            ]
        );

        $form[] = input_frm('mt-5 col-md-6 col-xs-12 mt-3', "¿Cuanto te cuesta cada uno?",
            [
                "type" => "number",
                "required" => true,
                "class" => "costo",
                "name" => "costo",
                "id" => "costo",
                "value" => 0
            ]
        );

        $form[] = input_frm('mt-5 col-md-6 col-xs-12 mt-3', "¿Cuanto inviertes en 
        promoción para la venta de cada uno?",
            [
                "type" => "number",
                "required" => true,
                "class" => "venta",
                "name" => "venta",
                "id" => "venta",
                "value" => 0
            ]
        );

        $form[] = input_frm('mt-5 col-md-6 col-xs-12 mt-3', "¿Cuanto gastas en la entrega del artículo a tu cliente?",
            [
                "type" => "number",
                "required" => true,
                "class" => "entrega",
                "name" => "entrega",
                "id" => "entrega",
                "value" => 0
            ]
        );
        $form[] = input_frm('mt-5 col-md-6 col-xs-12 mt-3', "¿Otro gasto que no estemos considerando? (no es obligatorio)",
            [
                "type" => "number",
                "required" => true,
                "class" => "otro",
                "name" => "otro",
                "id" => "otro",
                "value" => 0
            ]
        );

        $form[] = input_frm('mt-5 col-md-6 col-xs-12', "¿Cuantos de estos artículos vendes por día?",
        [
            "type" => "number",
            "required" => true,
            "class" => "cantidad_venta",
            "name" => "cantidad_venta",
            "id" => "cantidad_venta",
            "value" => 1
        ]
    );


        $form[] = d(btn("Calcular", ["class" => "mt-5"]),12);
        

        $form[] = form_close();

        $response[] = d(_titulo("Simula las ganancias que tendrás de acuerdo a las ventas de tus artículos",3),12);
        $response[] = d(d("¿Estás iniciando tu negocio quieres saber cuanto debes vender para lograr tus objetivos? checa esta herramienta"),12);
        $response[] = d(hr());
        $response[] = append($form);
        $response[] = d(place("simulacion_gastos_utilidad col-xs-12"), "mt-5 row");
        

        return d($response, 8,1);

    }

    
}
