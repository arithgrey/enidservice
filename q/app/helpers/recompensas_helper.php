<?php

use App\View\Components\titulo;

 if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function editar_recompensas($recompensa)
    {
     
        
        if (es_data($recompensa)) {
            
            
            foreach ($recompensa as $row) {

                $id_servicio = $row["id_servicio"];
                $id_servicio_conjunto = $row["id_servicio_conjunto"];
                $url_img_servicio = $row["url_img_servicio"];
                $url_img_servicio_conjunto = $row["url_img_servicio_conjunto"];                
                $id_recompensa = $row["id_recompensa"];
                
                $precio_servicio = $row["precio"];
                $precio_conjunto = $row["precio_conjunto"];
                $descuento = $row["descuento"];


                $texto_totales = totales($row);
                $imagen_servicio = servicio_dominante($url_img_servicio, $id_servicio);
                $imagen_servicio_conjunto = servicio_propuesta(
                    $url_img_servicio_conjunto, $id_servicio_conjunto);
                

                $text_precio_servicio = _text_('Precio',money($precio_servicio));
                $input_costo = input_costo($id_servicio, $row);
                $textos_costos = flex($text_precio_servicio, $input_costo, _text_('flex-column'),'mb-5 strong f11');

                $clase_extra = _text_(_between, "mt-5");
                $imagen_precio = flex(
                    $imagen_servicio, $textos_costos, _between , 5, 7);

                /**/
                $text_precio_servicio_conjunto = _text_('Precio',money($precio_conjunto));
                $input_costo_conjunto = input_costo_conjunto($id_servicio_conjunto, $row);

                $texto_precio_conjunto = flex($text_precio_servicio_conjunto, $input_costo_conjunto, _text_('flex-column'),'mb-5 strong f11');

                $imagen_precio_conjnto = flex(
                    $imagen_servicio_conjunto, $texto_precio_conjunto,$clase_extra , 5, 7);


    
                $promocion = [
                    d($imagen_precio),                    
                    d($imagen_precio_conjnto),
                    d($texto_totales)

                ];


                $seccion_fotos = d($promocion, 'd-flex flex-column');
                $clase_flex = _text_(_between, "row");
                
                $seccion_fotos_compra = flex($seccion_fotos, "", $clase_flex);

                $extra = is_mobile() ? "border-bottom" : "";
                $response[] = d($seccion_fotos_compra, _text_("row mt-5", $extra));


            }
            
        }
        return d($response, 'col-xs-12 col-sm-12 col-md-10 col-md-offset-1');

    }

    function input_costo($id_servicio, $row)
    {
        
        $servicio = $row["servicio"];        
        $costo  =  pr($servicio, "costo");    

        $icono = icon(_text_(_editar_icon,'editar_costo_servicio'));
        $r[] = d(_text_("Costo", money($costo), $icono ),'texto_editar_costo_servicio');
        $r[] = form_open("", ["class" => "form_costo d-none"]);
        $r[] = input_frm('', 'Costo',
            [
                "id" => "costo",
                "name" => "costo",
                "placeholder" => "costo",
                "class" => "input_costo costo",
                "required" => "",
                "type" => "float",
                "value" => $costo,                
            ]

        );
        $r[] = hiddens(["name" => "id_servicio", "value" => $id_servicio]);
        $r[] = form_close();
        return d($r);


    }

    function input_costo_conjunto($id_servicio, $row)
    {
        
        $servicio = $row["servicio_conjunto"];        
        $costo  =  pr($servicio, "costo");    

        $icono = icon(_text_(_editar_icon,'editar_costo_servicio_conjunto'));
        $r[] = d(_text_("Costo", money($costo), $icono ),'texto_editar_costo_servicio_conjunto');
        $r[] = form_open("", ["class" => "form_costo_conjunto d-none"]);
        $r[] = input_frm('', 'Costo',
            [
                "id" => "costo",
                "name" => "costo",
                "placeholder" => "costo",
                "class" => "input_costo_conjunto costo_conjunto",
                "required" => "",
                "type" => "float",
                "value" => $costo,                
            ]

        );
        $r[] = hiddens(["name" => "id_servicio", "value" => $id_servicio]);
        $r[] = form_close();
        return d($r);


    }

    function totales($row)
    {
        $precio_servicio = $row["precio"];
        $precio_conjunto = $row["precio_conjunto"];
        $descuento = $row["descuento"];
        $id_recompensa = $row["id_recompensa"];

        /*producto 1*/
        $servicio = $row["servicio"];
        $precio  =  pr($servicio, "precio");
        $costo  =  pr($servicio, "costo");
        $porcentaje_comision = pr($servicio, "comision");
        $comision = comision_porcentaje($precio , $porcentaje_comision);


        $margen = ($precio - $costo);

        
        /*producto 2*/
        $producto_conjunto = $row["servicio_conjunto"];
        $precio_producto_conjunto  =  pr($producto_conjunto, "precio");
        $costo_producto_conjunto  =  pr($producto_conjunto, "costo");
        $porcentaje_comision_conjunto = pr($producto_conjunto, "comision");
        $comision_conjunto = comision_porcentaje($precio_producto_conjunto ,$porcentaje_comision_conjunto);
        $margen_producto_conjunto = ($precio_producto_conjunto - $costo_producto_conjunto);


        $servicio_conjunto = $row["servicio_conjunto"];

        $utilidad_venta_conjunta = $margen + $margen_producto_conjunto;
        $utilidad_aplicando_descuento = ($margen + $margen_producto_conjunto) - $descuento;
        $utilidad_aplicando_descuento_comision = 
        $utilidad_aplicando_descuento - ($utilidad_aplicando_descuento * .10);


        

        $total = ($precio_conjunto + $precio_servicio) - $descuento;
        $pago_por_venta = comision_porcentaje($total , 10);
        $total_sin_descuento = ($precio_conjunto + $precio_servicio);
        $total_sin_descuento_aplicado = ($descuento > 0) ? del(money($total_sin_descuento)) : '';
        $por_cobrar = money($total);
        $clase_extra = _text_(_between, "border-bottom mt-3");
        
        $ganancias_reales = $utilidad_aplicando_descuento - $pago_por_venta;
        $ganancias_reales_menos_entrega =  $ganancias_reales - 100;

        $totales = flex(
            "Total", $total_sin_descuento_aplicado, $clase_extra, "strong col-sm-8", 4);
        $total_en_promo = flex(
            "Total aplicando promoción", $por_cobrar, $clase_extra, "strong display-6 col-sm-8",  "col-sm-4 black display-6");

        

        $texto_margen = flex(
            "Utilidad en el primer producto", money($margen), $clase_extra, "strong col-sm-8 mt-4",  "col-sm-4");
            

        $texto_margen_producto_conjunto = flex(
            "Utilidad en el segundo producto", money($margen_producto_conjunto), $clase_extra, "strong col-sm-8",  "col-sm-4");

        /**
        $texto_comision_venta = flex(
            "Comision por venta", money($comision), $clase_extra, "strong col-sm-8 mt-4",  "col-sm-4");
            $texto_comision_venta_conjunto = flex(
            "Comision por venta segundo producto", 
            money($comision_conjunto), $clase_extra, "strong col-sm-8",  "col-sm-4");
            **/

        $texto_pago_por_venta = flex(
            "Pago por venta", money($pago_por_venta), $clase_extra, "strong col-sm-8 strong f12",  "col-sm-4 f12");
            




        


        $texto_utilidad_venta_conjunta = flex(
            "Utilidad Neta", money($utilidad_venta_conjunta), $clase_extra, "strong col-sm-8 f12",  "col-sm-4 f12");

        $texto_utilidad_venta_conjunta_aplica_descuento = flex(
            "Aplicando descuento", 
            d(money($utilidad_aplicando_descuento),'utilidad_descuento display-7 blue_enid strong mt-5'), 
            $clase_extra, "strong col-sm-8",  "col-sm-4");


        $texto_utilidad_venta_conjunta_aplica_descuento_comision = flex(
            "Aplicando descuento y pago de comisión", 
            d(money($ganancias_reales),
                'utilidad_descuento_comision display-6 blue_enid strong'), 
            $clase_extra, "strong col-sm-8",  "col-sm-4");



        $texto_utilidad_venta_conjunta_aplica_descuento_comision_entrega = flex(
            "Utilidad pagando entrega", 
            d(money($ganancias_reales_menos_entrega),
                'utilidad_descuento_comision_entrega display-6 blue_enid strong'), 
            $clase_extra, "strong col-sm-8",  "col-sm-4");


    

        $descuento_aplicado = flex(
            "Descuento aplicando", money($descuento),$clase_extra, "strong col-sm-8",  4);

        $input = form_descuento($descuento, $id_recompensa);
        

        $elementos = [
            d($totales),                        
            d($descuento_aplicado),
            d(d("Utilidad", 'black display-6 col-sm-12 mt-5')),
            d($texto_margen),            
            d($texto_margen_producto_conjunto),
            d($texto_utilidad_venta_conjunta),
            d(d("Comisiones", 'black display-6 col-sm-12 mt-5')),            
            d($texto_pago_por_venta),
            d(d("Utilidad al vender en promoción", 'black display-6 col-sm-12 mt-5')),
            
            d($texto_utilidad_venta_conjunta_aplica_descuento),
            d($texto_utilidad_venta_conjunta_aplica_descuento_comision),
            d($texto_utilidad_venta_conjunta_aplica_descuento_comision_entrega),
            d($total_en_promo),            
            d($input),
            d(precio_final_al_aplicar_descuento()),          
            hiddens(["class" => "total_sin_descuento", "value"=> $total_sin_descuento]),
            hiddens(["class" => "total_utilidad", "value"=> $utilidad_venta_conjunta]),
            hiddens(["class" => "pago_por_venta", "value"=> $pago_por_venta]),
            hiddens(["class" => "total_utilidad_entrega", "value"=> $ganancias_reales_menos_entrega])

            
            
        ];

        return d($elementos, 'd-flex flex-column');

    }

    function precio_final_al_aplicar_descuento(){

        $texto_descuento_aplicado = d("", "texto_descuento_aplicado");
        $aplicado = flex(
            "Precio final al aplicar descuento", 
            $texto_descuento_aplicado ,
            _text_("display-6 black", _between),
            "",
            "precio_final_con_descuento_input"
        );
        return d($aplicado,12);


    }
        
    function form_descuento($descuento, $id_recompensa)
    {

        $r[] = form_open("", ["class" => "form_descuento"]);
        $r[] = input_frm('', 'Quiero aplicando este descuento',
            [
                "id" => "descuento",
                "name" => "descuento",
                "placeholder" => "Descuento aplicando",
                "class" => "descuento",
                "required" => "",
                "type" => "float",
                "value" => $descuento,                
            ]

        );
        $r[] = hiddens(["name" => "id", "value" => $id_recompensa]);

        $r[] = form_close();
        return d($r,'border border-secondary seccion_aplicar_descuento top_50 col-lg-12');
    }

    function servicio_dominante($url_img_servicio, $id_servicio)
    {
        $link_servicio = path_enid("producto", $id_servicio);

        $imagen = img(
            [
                'src' => $url_img_servicio,
                'class' => 'w-100',
                'href' => $link_servicio
            ]
        );
        return a_enid($imagen,
            [

                'href' => $link_servicio,
                "target" => "_blank"
            ]
        );


    }

    function servicio_propuesta($url_img_servicio_conjunto, $id_servicio_conjunto)
    {

        $link_servicio_conjunto = path_enid("producto", $id_servicio_conjunto);
        $imagen_servicio_conjunto = img(
            [
                'src' => $url_img_servicio_conjunto,
                'class' => 'w-100',
            ]
        );
        return a_enid($imagen_servicio_conjunto,
            [
                "href" => $link_servicio_conjunto,
                "target" => "_blank"
            ]
        );


    }

    function total_recompensa($row)
    {

        $precio_servicio = $row["precio"];
        $precio_conjunto = $row["precio_conjunto"];
        $descuento = $row["descuento"];

        $total = ($precio_conjunto + $precio_servicio) - $descuento;
        $total_sin_descuento = ($precio_conjunto + $precio_servicio);

        $total_sin_descuento = ($descuento > 0) ? del(money($total_sin_descuento), 'fp9') : '';


        $por_cobrar = money($total);
        $elementos = [
            d("Total", 'strong'),
            d($total_sin_descuento),
            d($por_cobrar, 'red_enid strong'),
        ];

        return d($elementos, "d-flex flex-column");
    }
    /*Sugerencias aleatorias para la sección principal*/
    function sugerencias($recompensa, $antecedente_compra){
                
        $response = [];
        
        if (es_data($recompensa)) {
            
            $response[] = d(_titulo("COMPRA EN CONJUNTO Y OBTEN DESCUENTOS", 4), "row mt-5");
            foreach ($recompensa as $row) {

                $id_servicio = $row["id_servicio"];
                $id_servicio_conjunto = $row["id_servicio_conjunto"];
                $url_img_servicio = $row["url_img_servicio"];
                $url_img_servicio_conjunto = $row["url_img_servicio_conjunto"];                                
                $id_recompensa = $row["id_recompensa"];


                $texto_totales = total_recompensa($row);
                $imagen_servicio = servicio_dominante($url_img_servicio, $id_servicio);
                $imagen_servicio_conjunto = servicio_propuesta($url_img_servicio_conjunto, $id_servicio_conjunto);
                $editar_compra = editar_comprar($id_recompensa, $antecedente_compra);

                $clase_imagen = 'col-xs-4';
                $promocion = [
                    d($imagen_servicio, $clase_imagen),
                    d("+"),
                    d($imagen_servicio_conjunto, $clase_imagen),
                    d($texto_totales, $clase_imagen)
                ];

                $seccion_fotos = d($promocion, _text_('d-flex', _between));
                $clase_flex = _text_(_between, "row");
                $clase_izquierda = "col-xs-9";
                $clase_derecha = "col-xs-3 p-0";
                $seccion_fotos_compra = flex(
                    $seccion_fotos, $editar_compra, $clase_flex, $clase_izquierda, $clase_derecha);

                $extra = is_mobile() ? "border-bottom" : "";
                $response[] = d($seccion_fotos_compra, _text_("row mt-5", $extra));


            }
            
            $link_promos = format_link("Más promociones",["href" => path_enid("promociones")]);
            $response[] = d($link_promos, "row mt-5");
                            
        }
        
        return d($response);


    }
    function editar_comprar($id_recompensa, $antecedente_compra = 0)
    {

        
        $agregar_a_carrito =  d("Agregar al carrito",
            [

                "class" => "cursor_pointer p-1 bottom_carro_compra_recompensa white border text-center",
                "id" => $id_recompensa, 
                "antecedente_compra" => $antecedente_compra
            ]
        );


        return flex("", $agregar_a_carrito, _text_("flex-column"));


    }

}
