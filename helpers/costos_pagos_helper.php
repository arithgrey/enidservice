<?php
 function create_vista($s, $agregar_servicio = 0, $es_recompensa = 0)
 {

     $id_servicio = $s["id_servicio"];
     $in_session = $s["in_session"];
     $id_perfil = (prm_def($s, "id_perfil") > 0) ? $s["id_perfil"] : 0;
     $img = formato_producto($es_recompensa, $s);

     if ($in_session > 0 && $es_recompensa < 1) {

         $response[] = $img;

         if ($agregar_servicio > 0) {

             $response[] = d(
                 agregar_servicio(
                     $in_session,
                     $id_servicio,
                     $s["id_usuario"],
                     $s["id_usuario_actual"],
                     $id_perfil
                 )
             );
         } else {

             $icono_editar = editar_servicio(
                 $s,
                 $in_session,
                 $id_servicio,
                 $id_perfil
             );

             $indicador = tiene_atributos($s);

             $response[] = d($icono_editar);
             $response[] = d($indicador);
         }


         $response = d(
             $response,
             "d-flex flex-column justify-content-center col-lg-3 mt-5 px-3"
         );
     } else {

         $class = "col-md-3 col-lg-2 col-xs-6 hps h_345 p-1 mh-auto top_50 bottom_50 border border-secondary";
         $response = d($img,  $class);
     }

     return $response;
 }
 function formato_producto($es_recompensa, $servicio)
    {
        $precio = $servicio["precio"];
        
        $precio_alto = ($servicio["precio_alto"] > $precio ) ?  $servicio["precio_alto"] : ($servicio["precio"] + porcentaje($servicio["precio"],16));

        $id_servicio = $servicio["id_servicio"];
        $es_sorteo = $servicio["es_sorteo"];

        $path_servicio =  ($es_sorteo < 1 ) ? get_url_servicio($id_servicio): path_enid("sorteo",$id_servicio) ;

        $formato_nicho = (es_decoracion_tematica($servicio)) ? 6: 1;
        $texto_precio_real = format_link(money($precio), ["href" => $path_servicio],$formato_nicho);

        $texto_descuento = "";
        if($precio_alto > $precio){
            $texto_descuento = d(del(money($precio_alto)), 'mt-1 red_enid');        
        }
        
        $texto_precio =  flex($texto_precio_real, $texto_descuento,'flex-column');
        
        $format_nombre = substr($servicio["nombre_servicio"], 0, 52);
        $nombre_con_enlace = a_enid($format_nombre, ["href" => $path_servicio,'class' => "black"]);

        $texto_nombre = d($nombre_con_enlace, "fp6 text-uppercase black mt-2");

        $tipo_deseo = "agregar_deseos_sin_antecedente";
        $tipo_deseo_agregado  =  "quitar_deseo_sin_antecedente";


        $clases = _text_($tipo_deseo,  _deseo_icon, "fa-2x");
        $clases_agregado = _text_($tipo_deseo_agregado,  _agregado_icon, "fa-2x borde_green");

        $icono_por_agregar = icon($clases, ["id" =>  $id_servicio, "title" => "Lo deseo", "onclick" => "log_operaciones_externas(27, $id_servicio)"]);
        $icono_agregado = icon($clases_agregado, ["id" =>  $id_servicio]);

        $extra_por_agregar = _text("por_agregar_", $id_servicio);
        $extra_agregados = _text("d-none agregado_", $id_servicio);
        $iconos = flex($icono_por_agregar, $icono_agregado, "flex-column", _text_("mr-2", $extra_por_agregar), $extra_agregados);


        $texto_nombre_carrito_compras = flex($iconos, $texto_nombre, "justify-content-between w-100 mt-1", "");
        $texto_precio_nombre = flex($texto_precio,  $texto_nombre_carrito_compras, "flex-column");


        $clases_imagen = ($es_recompensa > 0) ? "producto_en_recompensa servicio d-block mx-auto mt-3 mh_250 mh_sm_310 cursor_pointer " :
            "d-block mh_250 mh_sm_310 mx-auto mt-3 servicio";

        $img = a_enid(img(
            [
                'src' => $servicio["url_img_servicio"],
                'alt' => $servicio["metakeyword"],
                'class' => $clases_imagen,
                'id' => $id_servicio
            ]
        ), $path_servicio);

        if ($es_recompensa > 0) {

            $img = img(
                [
                    'src' => $servicio["url_img_servicio"],
                    'alt' => $servicio["metakeyword"],
                    'class' => $clases_imagen,
                    'id' => $id_servicio
                ]
            );
        }


        $link_afiliado_amazon = $servicio["link_afiliado_amazon"];
        $link_amazon_afiliado =  "";        
        if(str_len($link_afiliado_amazon, 5)){
            
            $link_amazon_afiliado = format_link("Comprame en Amazon!",
            [
             "href" => $link_afiliado_amazon,
             "class"    => "fp7"
            ], 3);
        }
        
        return d(
                    [
                        d($img),
                        d($texto_precio_nombre),
                        d($link_amazon_afiliado)
                    ],
                "flex-column mx-auto my-auto d-block p-1 mh-auto mt-5"
                );
}
function ticket_pago(&$deuda, $tipos_entrega, $format = 1)
{

    $subtotal = $deuda["subtotal"];
    $descuento_recompensa = $deuda["descuento_recompensa"];
    $tipo_entrega = ($deuda["tipo_entrega"] - 1);
    $format_envio = $deuda["format_envio"];
    $es_abono = $deuda["es_abono"];
    $abono_format_text = $deuda["abono_format_text"];
    $abono_format = $deuda["abono_format"];
    $saldo_pendiente = $deuda["saldo_pendiente"];
    $es_landing_secundario = $deuda["es_landing_secundario"];
    $saldo_pendiente = ($es_landing_secundario > 0) ? ($saldo_pendiente - 150 ) :  $saldo_pendiente;


    $saldo_pendiente_pago_contra_entrega = $deuda["saldo_pendiente_pago_contra_entrega"];
    $costo_envio_cliente = $deuda["costo_envio_cliente"];
    $response = [];

    switch ($format) {

        case 1:

            $espacio = 'justify-content-between mt-3 ';
            $response[] = hr('mb-4 border_big', 0);
            $response[] = flex(
                'Subtotal', money($subtotal), $espacio, 'subtotal_text', 'subtotal_money');

            if ($descuento_recompensa > 0) {
                $response[] = flex(
                'Descuento aplicado', 
                money($descuento_recompensa), 
                $espacio, 
                'subtotal_text red_enid', 'subtotal_money red_enid');
            }
            
            $response[] = flex(
                $tipos_entrega[$tipo_entrega]['texto_envio'], $format_envio, $espacio,
                'envio_text', 'envio_money text-uppercase');
            if ($es_abono) {
                $response[] = flex($abono_format_text, $abono_format, $espacio, 'abono_text', 'abono_money');
            }
            $response[] = hr('mt-4 border_big', 0);
            $response[] = flex('Total',
                money($saldo_pendiente), 'justify-content-between',
                'saldo_pendiente_text h3', 'strong h3 saldo_pendiente_money');
            $response[] = d_p($tipos_entrega[$tipo_entrega]['nombre_publico'], 'text-right h4 strong ');

            break;
        default:

            break;

    }

    return
        [
            'checkout' => d($response, 'checkout_resumen'),
            'saldo_pendiente' => $saldo_pendiente,
            'saldo_pendiente_pago_contra_entrega' => $saldo_pendiente_pago_contra_entrega,
            'tipo_entrega' => $tipo_entrega,
            'descuento_entrega' => $costo_envio_cliente

        ];


}

function es_orden_entregada($data = [], $restricciones = [])
{

    if (array_key_exists("productos_orden_compra", $data)) {

        $productos_orden_compra = $data["productos_orden_compra"];
        $restricciones = $data['restricciones']['orden_entregada'];
        $no_entregado = 0;

        foreach ($productos_orden_compra as $row) {

            $status = $row["status"];
            if (!in_array($status, $restricciones)) {
                $no_entregado++;
            }
        }

        $response = ($no_entregado < 1);

    } else {

        $restricciones_orden_entregada = ['orden_entregada'];
        $response = in_array($data["status"], $restricciones_orden_entregada);


    }
    return $response;


}

function es_orden_entregada_o_cancelada($productos_orden_compra, $data)
{

    $restricciones = $data['restricciones']['entregada_o_cancelada'];
    $no_entregada_cancelada = 0;

    foreach ($productos_orden_compra as $row) {

        $status = $row["status"];
        if (!in_array($status, $restricciones)) {
            $no_entregada_cancelada++;
        }
    }
    return ($no_entregada_cancelada < 1);


}

function es_orden_cancelada($data)
{

    if (array_key_exists("productos_orden_compra", $data)) {

        $productos_orden_compra = $data["productos_orden_compra"];
        $cancelada = 0;
        foreach ($productos_orden_compra as $row) {

            $cancela_cliente = $row["cancela_cliente"];
            $se_cancela = $row["se_cancela"];
            $status = $row["status"];
            $es_lista_negra = es_data($data['es_lista_negra']);
            $fue_lista_negra = es_data($data['usuario_lista_negra']);
            $por_status = ($status == 10 || $status == 19);
            if ($por_status || $cancela_cliente || $se_cancela || $es_lista_negra || $fue_lista_negra) {
                $cancelada++;
            }

        }

        return ($cancelada > 0);

    } else {

        $cancela_cliente = prm_def($data, "cancela_cliente");
        $se_cancela = prm_def($data, "se_cancela");
        $status = prm_def($data, "status");
        return ($status == 10 || $status == 19 || $cancela_cliente || $se_cancela);

    }

}

function es_orden_lista_negra($recibo)
{

    $es_lista_negra = (es_data($recibo) && pr($recibo, 'status') == 19);
    return (prm_def($recibo, 'status') == 19 || $es_lista_negra);
}

function es_contra_entrega_domicilio($productos_orden_compra, $format_fecha = 0, $si_no = 0)
{

    $response = "";
    foreach ($productos_orden_compra as $row) {

        $contra_entrega_domicilio = $row["contra_entrega_domicilio"];
        $tipo = $row["tipo_entrega"];
        $response = ($contra_entrega_domicilio && $tipo == 2);
        if ($response && $format_fecha > 0) {

            $fecha_contra_entrega = $row['fecha_contra_entrega'];
            $response = format_fecha($fecha_contra_entrega, 0);

        } else {

            if ($si_no !== 0) {
                $response = format_fecha($si_no, 1);
            }

        }

    }
    return $response;
}

function tiene_domilio($domicilios, $numero = 0)
{

    $domicilio_compra = "";
    $tiene_entrega = 0;


    $hay_domicilios = es_data($domicilios) && array_key_exists(0, $domicilios);
    if ($hay_domicilios && es_data($domicilios[0])) {

        $tiene_entrega++;

    } else {

        $str = text_icon(_close_icon, del("SIN DOMICILIO", _strong));
        $domicilio_compra = bloque($str);
    }

    return ($numero == 0) ? $domicilio_compra : $tiene_entrega;
}

function total_pago_pendiente($productos_orden_compra, $recompensa = 0)
{

    $subtotal = 0;
    $monto_pagado = 0;
    $tipo_entrega = 0;
    $tipo_entrega_por_producto = [];
    $costo_envio_cliente = 0;
    $costos_envio_cliente = [];
    $id_usuario_venta = 0;
    $descuento_aplicado = 0;
    $es_premium = 0;
    $es_descuento_landing_secundario = 0;
    foreach ($productos_orden_compra as $row) {

        $pagado = $row["saldo_cubierto"];
        $total = ($row["precio"] * $row["num_ciclos_contratados"]);
        $subtotal = ($subtotal + $total);
        $monto_pagado = ($monto_pagado + $pagado);
        $tipo_entrega = $row["tipo_entrega"];
        $tipo_entrega_por_producto[] = $tipo_entrega;
        $costo_envio_cliente = $row["costo_envio_cliente"];
        $costos_envio_cliente[] = $costo_envio_cliente;
        $id_usuario_venta = $row["id_usuario_venta"];
        $descuento_premium =  $row["descuento_premium"];        
        if ($descuento_premium > 0 ) {
            $es_premium ++;
        }

        $descuento_aplicado = ($descuento_aplicado + $descuento_premium);
        
        if($row["descuento_landing_secundario"] > 0 ){
            $es_descuento_landing_secundario = 1;
        }

    }

    $es_premium = ($es_premium > 0)? 1:0;
    $descuento_aplicado = ($recompensa > 0) ? $recompensa : $descuento_aplicado;

    $format_envio = ($costo_envio_cliente > 0) ? money($costo_envio_cliente) : 'gratis!';
    $espacio = 'justify-content-between mt-3 ';
    $abono_format_text = ($subtotal > 0) ? 'Abono' : '';
    $abono_format = ($monto_pagado > 0) ? _text('- ', money($monto_pagado)) : '';
    $es_abono = 0;
    $format_abonado = '';
    if ($monto_pagado > 0) {
        $es_abono++;
        $format_abonado = flex($abono_format_text, $abono_format, $espacio, 'abono_text', 'abono_money');
    }

    $saldo_pendiente = ($subtotal - $monto_pagado - $recompensa ) + $costo_envio_cliente;

    
    return [
        "subtotal" => $subtotal,
        "monto_pagado" => $monto_pagado,
        "tipo_entrega" => $tipo_entrega,
        "tipo_entrega_por_producto" => $tipo_entrega_por_producto,
        "format_envio" => $format_envio,
        "costos_envio_cliente" => $costos_envio_cliente,
        "costo_envio_cliente" => $costo_envio_cliente,
        "es_abono" => $es_abono,
        "abono_format" => $abono_format,
        "format_abono" => $format_abonado,
        "abono_format_text" => $abono_format_text,
        "saldo_pendiente" => $saldo_pendiente,
        "saldo_pendiente_pago_contra_entrega" => ($subtotal - $monto_pagado),
        "id_usuario_venta" => $id_usuario_venta,
        "descuento_aplicado" => $descuento_aplicado,
        "descuento_recompensa" => $recompensa,
        "es_premium" => $es_premium,
        "es_landing_secundario" => $es_descuento_landing_secundario

    ];
}


function comisiones_por_productos_deseados($servicios){

    $total = 0;
    foreach($servicios as $row ){

        $precio = $row["precio"];
        $comision = $row["comision"];
        $total = $total + comision_porcentaje($precio, $comision);

    }
    return $total;
}
function comision_porcentaje($precio, $porcentaje_comision){

    return ($precio * $porcentaje_comision) / 100;
}
function ganancia_vendedor($data, $precio_servicio, $precio_conjunto, $descuento)
{
    $texto_comisiones = '';
     if (es_administrador_o_vendedor($data)) {
            
            $total = ($precio_servicio + $precio_conjunto) - $descuento;
            
            $total_en_comisiones = comision_porcentaje($total , 10);
            $texto_ganancia= span(money($total_en_comisiones),'f11 strong white');
            $texto =  _text_('Ganarás',$texto_ganancia,'al venderlo');
            $texto_comisiones = d( $texto , ' fp8 white mt-5 blue_enid3 p-1');
    }

    return $texto_comisiones;

}

function utilidad_venta_conjunta($data, $row, $boton = 0)
{
    $response = '';
     if (es_administrador($data)) {
        
        $servicio = $row["servicio"]; 
        $servicio_conjunto = $row["servicio_conjunto"];     
        $descuento = $row["descuento"];

        $precio = pr($servicio , "precio");
        $costo = pr($servicio , "costo");

        $costo_conjunto = pr($servicio_conjunto , "costo");
        $precio_conjunto = pr($servicio_conjunto , "precio");

        $porcentaje_comision = pr($servicio, 'comision');
        $porcentaje_comision_conjunto = pr($servicio_conjunto, 'comision');

        $total = ($precio + $precio_conjunto) - $descuento;

        $utilidad = ($precio - $costo);
        $utilidad_2 = ($precio_conjunto - $costo_conjunto);

        $pago_comisiones = comision_porcentaje($total, 10);
        $response = ($utilidad + $utilidad_2) - $descuento - $pago_comisiones - 100;

        if ($boton > 0) {
         
         $response = d( _text_('Utilidad', money($response)) , 
            'border border-secondary mt-2 strong p-1');

        }
             
    }

    return $response;

}

function utilidad_en_servicio($data, $servicio, $boton = 0, $extra = '')
{

    $response = []; 

    if (es_administrador($data)) {
        

        $precio = pr($servicio , "precio");
        $precio_mayoreo = pr($servicio , "precio_mayoreo");
        $id_servicio = pr($servicio , "id_servicio");
        $costo_servicio = pr($servicio , "costo");
        
        $porcentaje_comision = pr($servicio, 'comision');
        $comision = comision_porcentaje($precio, $porcentaje_comision);
        $utilidad = ($precio - $costo_servicio);        
        $total = ($utilidad - $comision - 100);


        if ($boton > 0) {

            $seccion = d( _text_('Utilidad', money($total)) , 
            _text_('f11 border border-secondary mt-2 strong p-1', $extra));

            $costo = _text_('Costo', money($costo_servicio));
            $class = _text_('border border-secondary mt-2 strong p-1', $extra);

            $icono_editar = text_icon(_text_("costos_precios_servicio",_editar_icon), $costo,
                [                
                    "id" => $id_servicio
                ]);
            
            
            $seccion_costo = d($icono_editar, $class);
            $response[] = flex($seccion, $seccion_costo, 'flex-column');
            $response[] = gb_modal_costos($precio, $costo_servicio , $id_servicio, $precio_mayoreo);

        }

    }
    return append($response);

}

function get_costo_envio($recibos)
{

    $response = [];
    foreach ($recibos as $row) {
        $gratis = $row["flag_envio_gratis"];
        $tipo_entrega = $row['tipo_entrega'];

        if ($gratis > 0) {

            $response["costo_envio_cliente"] = 0;
            $response["costo_envio_vendedor"] = 100;
            $response["text_envio"] = texto_costo_envio_info_publico(
                $gratis,
                $response["costo_envio_cliente"],                
                $tipo_entrega
            );
        } else {

            $response["costo_envio_cliente"] = 100;
            $response["costo_envio_vendedor"] = 0;
            $response["text_envio"] = texto_costo_envio_info_publico(
                $gratis,
                $response["costo_envio_cliente"],                
                $tipo_entrega
            );
        }

    }

    return $response;
}

function texto_costo_envio_info_publico(
    $flag_envio_gratis, $costo_envio_cliente, $tipo_entrega)
{

    $text_envio = [
        '',
        ' MXN DE TU ENTREGA',
        ' MXN DE ENVÍO',
        ''
    ];

    return ($flag_envio_gratis > 0) ?
        [
            "cliente" => "ENTREGA GRATIS!",
            "cliente_solo_text" => "ENTREGA GRATIS!",
            "ventas_configuracion" => "TU PRECIO YA INCLUYE EL ENVÍO",
        ]
        :
        [
            "ventas_configuracion" => "EL CLIENTE PAGA SU ENVÍO, NO GASTA POR EL ENVÍO",
            "cliente_solo_text" => _text($costo_envio_cliente, $text_envio[$tipo_entrega]),
            "cliente" => _text($costo_envio_cliente, $text_envio[$tipo_entrega]),
        ];

}
