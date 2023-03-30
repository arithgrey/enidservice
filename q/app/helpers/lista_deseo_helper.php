<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function productos($data, $productos, $externo = 0)
    {
        
        return format_productos_deseados($data, $productos, $externo);
    }
    function format_productos_deseados($data, $productos_deseados, $externo)
    {
        
        $response[] = d(lista_deseo($productos_deseados, $externo), "col-xs-12 ");        

        return d($response,'row mt-5');
    }
    function lista_deseo($productos_deseados, $externo)
    {

        $response = [];

        foreach ($productos_deseados as $row) {
            
            $id_producto = $row["id_servicio"];
            $precio = $row["precio"];
            $precio_alto = ($row["precio_alto"] > $precio ) ?  $row["precio_alto"] : ($precio + porcentaje($precio,16));
            $articulos = $row["articulos"];            
            


            $r = [];
            $url_servicio = get_url_servicio($id_producto);
            $config = ["href" => $url_servicio];
            $imagen = a_enid(img($row["url_img_servicio"]), $config);
            $text_precio = $precio * $articulos;
            $text_precio_alto = $precio_alto * $articulos;


            $seccion_imagen_seleccion_envio =
                flex("", $imagen, _between_start);
            $r[] = d($seccion_imagen_seleccion_envio, "col-xs-5 col-sm-3 p-0");
            $x = [];

            $nombre_servicio = $row["nombre_servicio"];
            $link = a_enid(
                $nombre_servicio,
                [
                    "href" => $url_servicio,                    
                    "class" => "black"
                ]
            );
            $x[] = h($link, 4,["class" => "mb-5"]);
                            
            
            $r[] = d($x,'col-xs-7');
            $z = [];            
            $z[] = h(money($text_precio), 4, 'strong');

            if ($precio_alto > $precio) {
                $z[] = h(del(money($text_precio_alto)), 5, ' red_enid');
            }
        

            $r[] = d($z, 'col-sm-2 text-right d-md-block ');
            
            $response[] = d($r, 'col-md-12 mb-5 p-0');
            $response[] = d(format_link("Ver carrito",["href" => path_enid("lista_deseos")]),"col-xs-12 mt-5");
            $response[] = d(format_link("Sigue comprando",["class" => "sigue_comprando_trigger"],0),"col-xs-12 mt-2 mb-5");
            
            
        }
    
        $data_response[] = d($response, 'row');
        return d(d($data_response, "col-xs-12"),13);
    }
    function seccion_procesar_pago($data, $productos_deseados)
    {

        $subtotal = 0;
        $total_articulo = 0;
        $inputs = [];
        $es_premium = 0;



        if (array_key_exists("usuario", $data)) {

            $usuario = $data["usuario"];
            $es_premium = es_premium($data, $usuario);
        }

        $total_descuento = 0;

        $es_sorteo = 0;
        foreach ($productos_deseados as $row) {

            $descuento_especial = $row["descuento_especial"];
            $articulos = $row["articulos"];
            $precios = $row["precio"];
            $total_articulo = ($total_articulo + $articulos);
            $total = ($articulos * $precios);
            $subtotal = ($subtotal + $total);
            $id = $row["id"];
            $total_descuento_articulo = ($descuento_especial * $articulos);
            $total_descuento = ($total_descuento + $total_descuento_articulo);

            if ($row["numero_boleto"] > 0) {
                $es_sorteo++;
            }
            $config =
                [
                    "name" => "producto_carro_compra[]",
                    "value" => $id,
                    "type" => "checkbox",
                    "class" => _text("producto_", $id)
                ];
            $inputs[] = hiddens($config);
        }

        $extra = is_mobile() ? 'white':'black';
        
        
        $total_en_descuento = descuento_recompensa($data);

        if ($es_premium && $total_en_descuento < 1) {

            $total_menos_descuento = ($subtotal - $total_descuento);
            $response[] = d(_text_(del(money($subtotal)), "Total"), "mt-4 text-muted");
            $response[] = d(_text_("-", money($total_descuento), "Descuento premium"), "text-muted");
            $response[] = d(money($total_menos_descuento), _text_($extra, "display-4"));
            
        } else {

            $response = formato_subtotal($data, $subtotal);
        }

        $inputs_recompensa = valida_envio_descuento($data);

        $response[] = form_procesar_carro_compras($data, $inputs, $inputs_recompensa,  $subtotal, $es_sorteo);


        if (es_administrador_o_vendedor($data)) {

            
            $comision_venta = comisiones_por_productos_deseados($productos_deseados);

            $extra_color_money = (is_mobile()) ? 'white font-weight-bold':'strong';
            $textos = _text_("Cuando se entrege el pedido ganarás", d(money($comision_venta), _text_($extra_color_money, 'texto_comision_venta')));
            $extra_color = (is_mobile()) ? 'f11 mt-1 text-right white mr-5':'display-6 mt-5 text-right text-uppercase p-2 black strong borde_green';
            $response[] =  d($textos, $extra_color);
            $response[] =  hiddens(["class" => "comision_venta", "value" => $comision_venta]);
        }


        $extra = is_mobile() ? 'fixed-bottom bg_black borde_black' : 'position-fixed';
    
        return d($response, $extra);
    }

}