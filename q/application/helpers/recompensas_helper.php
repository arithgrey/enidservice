<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function editar_recompensas($recompensa)
    {
     
        $response[] = "";
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
                

                $text_precio_servicio = money($precio_servicio);
                $clase_extra = _text_(_between, "mt-5");
                $imagen_precio = flex(
                    $imagen_servicio, $text_precio_servicio, _between , 8, 4);


                $texto_precio_conjunto = money($precio_conjunto);

                $imagen_precio_conjnto = flex(
                    $imagen_servicio_conjunto, $texto_precio_conjunto,$clase_extra , 8, 4);



                
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

    

    function totales($row)
    {
        $precio_servicio = $row["precio"];
        $precio_conjunto = $row["precio_conjunto"];
        $descuento = $row["descuento"];
        $id_recompensa = $row["id_recompensa"];

        $total = ($precio_conjunto + $precio_servicio) - $descuento;
        $total_sin_descuento = ($precio_conjunto + $precio_servicio);
        $total_sin_descuento = ($descuento > 0) ? del(money($total_sin_descuento)) : '';
        $por_cobrar = money($total);
        $clase_extra = _text_(_between, "mt-2");
        
        $totales = flex("Total", $total_sin_descuento, $clase_extra, "strong col-sm-8", 4);
        $total_en_promo = flex(
            "Total aplicando promoción", $por_cobrar,$clase_extra, "strong col-sm-8",  4);
        $descuento_aplicado = 
        flex("Descuento aplicando", money($descuento),$clase_extra, "strong col-sm-8",  4);

        $input = form_descuento($descuento, $id_recompensa);

        $elementos = [
            d($totales),            
            d($total_en_promo),
            d($descuento_aplicado),
            d($input)
        ];

        return d($elementos, 'd-flex flex-column');

    }
    function form_descuento($descuento, $id_recompensa)
    {

        $r[] = form_open("", ["class" => "form_descuento mt-5 col-lg-12"]);
        $r[] = input_frm('', 'Descuento',
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
        return append($r);
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
    

}
