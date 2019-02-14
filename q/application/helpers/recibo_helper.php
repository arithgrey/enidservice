<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_notificacion_solicitud_valoracion($usuario, $id_servicio)
    {

        $nombre = $usuario[0]["nombre"];
        $email  = $usuario[0]["email"];
        $asunto = "Hola  {$nombre} ¡Tu paquete ya se entregó! ";


        $url    = "https://enidservice.com/inicio/valoracion/?servicio=".$id_servicio;
        $img    = img_enid([], 1, 1) . heading_enid($text, 5);
        $text   = heading("¿Valorarías tu experiencia de compra en Enid Service?",3);
        $text  .= div("Nos encantará hacer todo lo necesario para que tu experiencia de compra sea la mejor").br();
        $text  .= div(anchor_enid("Déjanos tus comentarios aquí!" , ["href" => $url]));

        $cuerpo = append_data([$img, $text]);
        $sender = get_request_email($email, $asunto, $cuerpo);
        return $sender;

    }
    function get_saludo($cliente , $config_log , $id_recibo){

         $text   =      heading_enid("Buen día " . $cliente . ", Primeramente un cordial saludo. ",3);
         $text  .=      div("El presente mensaje es para informar que el servicio solicitado ahora (Nueva Compra) o previamente (Recordatorio de Renovación) tiene los siguientes detalles:");
         $text  .=      div("Detalles de Orden de Compra");
         $text  .=      div(img($config_log));
         $text  .=      heading_enid("#Recibo: " . $id_recibo);
         return $text;
    }
    function get_text_saldo_pendiente($resumen_pedido ,
                                      $num_ciclos_contratados, $flag_servicio, $id_ciclo_facturacion ,
                                      $text_envio_cliente_sistema , $primer_registro , $fecha_vencimiento ,
                                      $monto_a_pagar , $saldo_pendiente ){


        $resumen_pedido = ($resumen_pedido !== null ) ? $resumen_pedido : " ";
        $text  =    div("Concepto");
        $text .=    div($resumen_pedido);
        $text .=    valida_texto_periodos_contratados($num_ciclos_contratados, $flag_servicio, $id_ciclo_facturacion);
        $text .=    div("Precio " . $monto_a_pagar);
        $text .=    div($text_envio_cliente_sistema);
        $text .=    div("Ordén de compra {$primer_registro } Límite de pago  {$fecha_vencimiento} ");
        $text .=    div("Monto total pendiente");
        $text .=    heading_enid($saldo_pendiente . " Pesos Mexicanos" ,2);
        $text .=    hr();
        return $text;

    }
    function get_text_forma_pago($img_pago_oxxo , $url_pago_oxxo , $url_pago_paypal , $img_pago_paypal){

        $text  =    heading_enid("Formas de pago Enid Service", 2);
        $text .=    heading_enid("NINGÚN CARGO A TARJETA ES AUTOMÁTICO. SÓLO PUEDE SER PAGADO POR ACCIÓN DEL USUARIO " ,2);
        $text .=    div("1.- Podrás compra en línea de forma segura con tu con tu tarjeta bancaria (tarjeta de crédito o débito) a través de");
        $text .=    anchor($url_pago_paypal , "PayPal");
        $text .=    anchor($url_pago_paypal , img($img_pago_paypal) );
        $text .=    anchor($url_pago_paypal,"Comprar ahora!" );
        $text .=    hr();
        $text .=    div("2.- Aceptamos pagos en tiendas de autoservicio OXXO y transferencia bancaria en línea para bancos BBVA Bancomer",1);
        $text .=    anchor($url_pago_oxxo,heading_enid("OXXO" ,4));
        $text .=    anchor($url_pago_oxxo,"Imprimir órden de pago");
        $text .=    anchor($url_pago_oxxo,img($img_pago_oxxo ) );
        return $text;

    }
    function get_text_notificacion_pago($url_seguimiento_pago , $url_cancelacion ){

        $text  =    heading_enid("¿Ya realizaste tu pago?", 2);
        $text .=    div("Notifica tu pago para que podamos procesarlo");
        $text .=    anchor_enid("Dando click aquí", ["href" => $url_seguimiento_pago ]);
        return $text;

    }
    function create_resumen_pedidos($recibos, $lista_estados, $param)
    {

        $tipo_orden             = $param["tipo_orden"];
        $ops_tipo_orden         = ["", "fecha_registro", "fecha_entrega", "fecha_cancelacion", "fecha_pago", "fecha_contra_entrega"];
        $ops_tipo_orden_text    = ["", "FECHA REGISTRO", "FECHA ENTREGA", "FECHA CANCELACIÓN", "FECHA DE PAGO", "FECHA CONTRA ENTREGA"];

        $default = ["class" => "header_table_recibos"];
        $tb = "<hr class='top_20'><table class='table_enid_service top_20' ><thead>";
        $tb .= "<tr class='header_table'>";
        $tb .= get_th("ORDEN", $default);
        $tb .= get_th("", $default);
        $tb .= get_th("STATUS", $default);
        $tb .= get_th("TIPO ENTREGA", $default);
        $tb .= get_th("SALDO CUBIERTO", $default);
        $tb .= get_th("MONTO COMPRA", $default);
        $tb .= get_th($ops_tipo_orden_text[$tipo_orden], $default);
        $tb .= "</thead></tr><tbody>";
        foreach ($recibos as $row) {

            $recibo = $row["recibo"];
            $saldo_cubierto = $row["saldo_cubierto"];
            $fecha_registro = $row["fecha_registro"];
            $monto_a_pagar = $row["monto_a_pagar"];

            $num_ciclos_contratados = $row["num_ciclos_contratados"];
            $costo_envio_cliente = $row["costo_envio_cliente"];
            $monto_a_pagar = ($monto_a_pagar * $num_ciclos_contratados) + $costo_envio_cliente;
            $cancela_cliente = $row["cancela_cliente"];
            $se_cancela = $row["se_cancela"];
            $status = $row["status"];
            $fecha_contra_entrega = $row["fecha_contra_entrega"];
            $tipo_entrega = $row["tipo_entrega"];
            $fecha_entrega = $row["fecha_entrega"];

            $estado_compra = ($se_cancela == 1 || $cancela_cliente == 1) ? "CANCELACIÓN" : 0;
            $estado_compra =
                ($estado_compra == 0) ? get_text_status($lista_estados, $status) : $estado_compra;
            $tipo_entrega = ($tipo_entrega == 1) ? "PAGO CONTRA ENTREGA" : "MENSAJERÍA";


            $entrega = $row[$ops_tipo_orden[$tipo_orden]];


            $extra = ($status == 9) ? "entregado" : "";


            $tb .= "<tr id='" . $recibo . "' class='desglose_orden cursor_pointer " . $extra . "' >";

            $id_servicio = $row["id_servicio"];
            $url_img = "../imgs/index.php/enid/imagen_servicio/" . $id_servicio;
            $id_error = "imagen_" . $id_servicio;
            $img = img([
                "src" => $url_img,
                "id" => $id_error,
                "style" => "width:40px!important;height:40px!important;",
                'onerror' => "reloload_img( '" . $id_error . "','" . $url_img . "');"
            ]);
            $tb .= get_td($recibo);
            $tb .= get_td($img);
            $tb .= get_td($estado_compra);
            $tb .= get_td($tipo_entrega);
            $tb .= get_td($saldo_cubierto . "MXN");
            $tb .= get_td($monto_a_pagar . "MXN");
            $tb .= get_td($entrega);

            $tb .= "</tr>";

        }

        $tb .= "</tbody>";
        $tb .= "</table>";
        return $tb;
    }

    function get_text_status($lista, $estado_compra)
    {

        foreach ($lista as $row) {

            $id_estatus_enid_service = $row["id_estatus_enid_service"];
            if ($estado_compra == $id_estatus_enid_service) {
                return strtoupper($row["text_vendedor"]);
            }
        }
    }

    function get_link_paypal($saldo_pendiente)
    {

        if ($saldo_pendiente > 0) {
            /*Aplico la comisión del paypal 3**/
            $comision_paypal = porcentaje($saldo_pendiente, 3.7,2 , 0);
            $saldo = $saldo_pendiente + $comision_paypal;
            return "https://www.paypal.me/eniservice/" . $saldo;
        }
        return 0;

    }

    
    function get_link_saldo_enid($id_usuario, $id_recibo)
    {
        return "../movimientos/?q=transfer&action=8&operacion=" . $id_usuario . "&recibo=" . $id_recibo;
    }

    
    function get_link_oxxo($url_request, $saldo, $id_recibo, $id_usuario)
    {

        $url = $url_request . "orden_pago_oxxo/?q=" . $saldo . "&q2=" . $id_recibo . "&q3=" . $id_usuario;
        $url = ($saldo > 0 && $id_recibo > 0 && $id_usuario > 0) ? $url : "";
        return $url;

    }
    function get_saldo_pendiente($monto,
                                 $ciclos,
                                 $cubierto,
                                 $envio_cliente,
                                 $envio_sistema,
                                 $tipo_entrega)
    {


        $cubierto = ($cubierto < 0) ? 0 : $cubierto;
        $total = ($monto > 0 && $ciclos > 0) ? ($monto * $ciclos) - $cubierto : 0;
        $text_envio = "";
        $cargo_envio = 0;


        if ($tipo_entrega == 2 || $tipo_entrega == 4) {

            $text_envio = $envio_sistema["text_envio"]["cliente"];
            $cargo_envio = $envio_sistema["costo_envio_cliente"];


        } else {


            $text_envio = ($envio_cliente > 0) ?    "Cargos de entrega " . $envio_cliente . "MXN" : $envio_sistema["text_envio"]["cliente"];
            $cargo_envio = ($envio_cliente > 0) ? $envio_cliente : 0;

        }

        $total_mas_envio = $total + $cargo_envio;
        $response = [
            'saldo_pendiente' => $total,
            'text_envio' => $text_envio,
            'total_mas_envio' => $total_mas_envio
        ];
        return $response;

    }
    function crea_data_deuda_pendiente($param)
    {

        $data_complete["cuenta_correcta"] = 0;
        if (count($param) > 0) {

            $recibo = $param[0];
            $precio = $recibo["precio"];
            $num_ciclos_contratados = $recibo["num_ciclos_contratados"];
            $costo_envio_cliente = $recibo["costo_envio_cliente"];
            $saldo_pendiente =
                ($precio * $num_ciclos_contratados) + $costo_envio_cliente;
            $data_complete["saldo_pendiente"] = $saldo_pendiente;
            $data_complete["cuenta_correcta"] = 1;
            $data_complete["resumen"] = $recibo["resumen_pedido"];
            $data_complete["costo_envio_cliente"] = $recibo["costo_envio_cliente"];
            $data_complete["flag_envio_gratis"] = $recibo["flag_envio_gratis"];
            $data_complete["id_recibo"] = $recibo["id_proyecto_persona_forma_pago"];
            $data_complete["id_usuario"] = $recibo["id_usuario"];
            $data_complete["id_usuario_venta"] = $recibo["id_usuario_venta"];

        }
        return $data_complete;

    }

    function get_texto_saldo_pendiente($monto_a_liquidar, $monto_a_pagar, $modalidad_ventas)
    {

        $texto = "";
        if ($modalidad_ventas == 1) {

            if ($monto_a_liquidar > 0) {
                $text = div("MONTO DE LA COMPRA",
                        ["class" => 'text-saldo-pendiente']) .
                    div($monto_a_pagar . "MXN",
                        ["class" => "text-saldo-pendiente-monto"]);
            }
        } else {

            if ($monto_a_liquidar > 0) {

                $text = div("SALDO PENDIENTE", ["class" => 'text-saldo-pendiente']);
                $text .= div($monto_a_liquidar . "MXN", ["class" => "text-saldo-pendiente-monto"]);
            }

        }
        return div($texto, ["class" => 'contenedor-saldo-pendiente']);

    }

    function monto_pendiente_cliente($monto, $saldo_cubierto, $costo, $num_ciclos)
    {

        $total_deuda = $monto * $num_ciclos;
        return $total_deuda + $costo;
    }

    function evalua_acciones_modalidad_anteriores($num_acciones, $modalidad_ventas)
    {

        $text = "";
        if ($num_acciones > 0) {
            if ($modalidad_ventas == 1) {
                $text = ($num_acciones > 1) ? "MIRA TUS ÚLTIMAS $num_acciones  VENTAS" : "MIRA TUS ULTIMAS VENTAS";
            } else {
                $text = "MIRA TUS ÚLTIMAS COMPRAS";
            }
            $config = ["class" => "a_enid_black ver_mas_compras_o_ventas"];
            return anchor_enid($text, $config);
        }
        return $text;
    }

    function evalua_acciones_modalidad($en_proceso, $modalidad_ventas)
    {

        $text = "";
        $flag = 0;
        $simbolo = icon("fa  fa-fighter-jet");
        if ($modalidad_ventas == 0 && $en_proceso["num_pedidos"] > 0) {
            $flag++;
            $num = $en_proceso["num_pedidos"];
            $text = ($num > 1) ? $simbolo . " TUS " . $num . " PEDIDOS ESTÁN EN CAMINO " : $simbolo . " TU PEDIDO ESTÁ EN CAMINO ";
        }
        if ($modalidad_ventas == 1 && $en_proceso["num_pedidos"] > 0) {
            $flag++;
            $num = $en_proceso["num_pedidos"];
            $text = ($num > 1) ? $simbolo . " ENVIASTÉ $num PAQUETES QUE  ESTÁN POR LLEGAR A TU CLIENTE" : $simbolo . " TU ENVÍO ESTÁ EN CAMINO ";

        }

        $final = (strlen($text) > 10) ? div($text, ["class" => "alert alert-info text-center"]) : $text;
        return $final;

    }

    function get_total_articulos_promocion($modalidad, $total = 0)
    {

        $response =  "";
        if ($modalidad == 1) {

            $l = anchor_enid(
                icon("fa fa-cart-plus") . " Artículos en promoción" .$total,
                ["href" => '../planes_servicios/',
                    "class" => 'vender_mas_productos']
            );

            $l2 = anchor_enid(
                " Agregar",
                [
                    "href" => '../planes_servicios/?action=nuevo',
                    "class" => 'vender_mas_productos']
            );

            $response = div($l . $l2, 1);
        }
        return $response;
    }

    function evalua_texto_envios_compras($modalidad_ventas, $total, $tipo)
    {



        $text = "";

        switch ($tipo) {
            case 1:
                if ($modalidad_ventas == 1) {
                    $text = "DATE PRISA MANTÉN EXCELENTE REPUTACIÓN ENVIA TU ARTÍCULO EN VENTA DE FORMA PUNTUAL";

                    $text_2 = "
                Date prisa, 
                mantén una buena reputación enviando 
                tus  $total articulos vendidos de forma puntual";
                    $text = ($total == 1) ? $text : $text_2;

                }

                break;


            case 6:
                if ($modalidad_ventas == 0) {
                    $text = "DATE PRISA REALIZA TU COMPRA ANTES DE QUE OTRA PERSONA SE LLEVE TU 
                  PEDIDO!";
                }
                break;

            default:

                break;
        }

        $text = div($text ,  ['class' => 'alert alert-info' , 'style' => 'margin-top: 10px;background: #001541;color: white']);
        return $text;
    }

    function get_text_direccion_envio($id_recibo, $modalidad_ventas, $direccion_registrada, $estado_envio)
    {

        $texto = "";
        if ($modalidad_ventas == 0) {

            if ($direccion_registrada == 1) {
                switch ($estado_envio) {
                    case 0:
                        $texto = icon("fa fa-bus") . "A LA BREVEDAD EL VENDEDOR TE ENVIARÁ TU PEDIDO";
                        break;

                    default:
                        $texto = icon('fa fa-bus', ["id" => $id_recibo]) . "DIRECCIÓN DE ENVÍO";
                        break;
                }

            } else {
                $texto = icon('fa fa-bus ', ["id" => $id_recibo]) .
                    "¿DÓNDE ENVIAMOS TU PEDIDO?";
            }
        } else {

            if ($direccion_registrada == 1) {
                $texto = icon('fa fa-bus ', ["id" => $id_recibo]) . "VER DIRECCIÓN DE ENVÍO";
            }
        }

        return div($texto, ["class" => "btn_direccion_envio", "id" => $id_recibo]);
    }

    function get_estados_ventas($data, $indice, $modalidad_ventas)
    {

        $nueva_data = [];
        $estado_venta = "";
        foreach ($data as $row) {
            $id_estatus_enid_service = $row["id_estatus_enid_service"];
            if ($id_estatus_enid_service == $indice) {
                if ($modalidad_ventas == 1) {
                    $estado_venta = $row["text_vendedor"];
                } else {
                    $estado_venta = $row["text_cliente"];
                }
                break;
            }
        }
        return $estado_venta;
    }

    function carga_estado_compra($monto_por_liquidar, $id_recibo, $status, $status_enid_service, $vendedor = 0)
    {

        $extra_tab_pagos = 'href="#tab_renovar_servicio" data-toggle="tab" ';
        $estilos = "";
        $text = "";

        $text_icono = ($vendedor == 1) ?
            "DETALLES DE LA COMPRA " : icon('fa fa-credit-card-alt') . "DETALLES DE TU COMPRA ";

        $text = div($text_icono,
            [
                "class" => 'resumen_pagos_pendientes',
                "id" => $id_recibo,
                "href" => "#tab_renovar_servicio",
                "data-toggle" => "tab"
            ]);
        return div($text, ["class" => 'btn_comprar']);
    }
    function texto_costo_envio_info_publico($flag_envio_gratis, $costo_envio_cliente, $costo_envio_vendedor)
    {

        $data_complete = [];
        if ($flag_envio_gratis > 0) {

            $text = "ENTREGA GRATIS!";
            $data_complete["cliente"] = $text;
            $data_complete["cliente_solo_text"] = "ENTREGA GRATIS!";
            $data_complete["ventas_configuracion"] = "TU PRECIO YA INCLUYE EL ENVÍO";
        } else {
            $data_complete["ventas_configuracion"] = "EL CLIENTE PAGA SU ENVÍO, NO GASTA POR EL ENVÍO";
            $text = "MÁS " . $costo_envio_cliente . " MXN DE ENVÍO";
            $data_complete["cliente_solo_text"] = "MÁS ".$costo_envio_cliente ." MXN DE ENVÍO";
            $data_complete["cliente"] = $text;
        }
        return $data_complete;
    }

    function valida_texto_periodos_contratados($periodos, $flag_servicio, $id_ciclo_facturacion)
    {

        $text = "";
        if ($flag_servicio == 1) {

            $ciclos = [
                "",
                "Anualidad",
                "Mensualidad",
                "Semana",
                "Quincena",
                "",
                "Anualidad a 3 meses",
                "Anualidad a 6 meses",
                "A convenir"];

            $ciclos_largos = [
                "",
                "Anualidades",
                "Mensualidades",
                "Semanas",
                "Quincenas",
                "",
                "Anualidades a 3 meses",
                "Anualidades a 6 meses",
                "A convenir"];
            $text_ciclos = "";

            if ($periodos > 1) {
                $text_ciclos = $ciclos_largos[$id_ciclo_facturacion];
            } else {
                $text_ciclos = $ciclos[$id_ciclo_facturacion];
            }


            $text = "Ciclos contratados: " . $periodos . " " . $text_ciclos;
        } else {

            $text = ($periodos > 1) ? "Piezas " : "Pieza ";
            $text = heading_enid($periodos . " " . $text, 3);
        }
        return $text;
    }

    function get_text_modalidad($modalidad, $ordenes)
    {

        $text = ($modalidad == 1) ? "TUS VENTAS" : "TUS COMPRAS";
        if ($modalidad == 0 && $ordenes == 0) {
            return "";
        }
        return heading_enid($text, 2);
    }

    function get_mensaje_compra($modalidad, $num_ordenes)
    {

        /*Compras*/
        $response =  "";
        if ($modalidad == 0 && $num_ordenes == 0) {
            $f = div(img([
                    "src" => "../img_tema/tienda_en_linea/carrito_compra.jpg",
                    "class" => "img_invitacion_compra"
                ])
                ,
                ["class" => "img_center_compra"]
            );

            $f  = anchor_enid($final, ["href" => "../"]);
            $f .= anchor_enid(heading_enid("EXPLORAR TIENDA", 3, ["class" => "text-center text_explorar_tienda"]),
                [
                    "href" => "../"
                ]);
            $response =  $f;
        }
        return $response;
    }
    function format_direccion_envio($inf , $id_recibo , $recibo){
        $resumen  = "";
        $resumen .=  div(
            icon("fa fa-pencil" ,
                [
                    "class"			=> 	"btn_direccion_envio ",
                    "id" 			=> 	$id_recibo,
                    "href"			=> 	"#tab_mis_pagos",
                    "data-toggle"	=> 	"tab"
                ],
                1
            ),
            ["class" =>	"top_20"], 1);


        $envio =    "";
        $envio .= get_campo($inf , "direccion" );
        $envio .= get_campo($inf , "calle" );
        $envio .= get_campo($inf , "numero_exterior");
        $envio .= get_campo($inf , "numero_interior");
        $envio .= get_campo($inf , "entre_calles");
        $envio .= get_campo($inf , "cp");
        $envio .= get_campo($inf , "asentamiento");
        $envio .= get_campo($inf , "municipio");
        $envio .= get_campo($inf , "ciudad" );
        $envio .= get_campo($inf , "estado" );
        $resumen  .= div($envio , ["class"=>'texto_direccion_envio_pedido top_20' ]);

        $resumen .= div("¿Quíen más puede recibir tu pedido?");
        $resumen .= div(get_campo($inf , "nombre_receptor" ));
        $resumen .= div(get_campo($inf , "telefono_receptor" ));
        $text    =  div($resumen , ["class"=>"informacion_resumen_envio"] );

        return $text;
    }
    function agregar_direccion_envio($id_recibo){

        return div(
            icon("fa fa-bus")." Agrega la dirección de envío de tu pedido!",
            [
                "class"				=>
                    "btn_direccion_envio
								contenedor_agregar_direccion_envio_pedido
								a_enid_black cursor_pointer",
                "id"				=>	$id_recibo,
                "href"				=>	"#tab_mis_pagos",
                "data-toggle"		=>	"tab"
            ],
            1
        );

    }
    function format_concepto($id_recibo, $resumen_pedido , $num_ciclos_contratados ,
                                     $flag_servicio,$id_ciclo_facturacion ,
                                     $saldo_pendiente ,  $url_img_servicio ,$monto_a_pagar , $deuda){

        $concepto =  "";
        $concepto .= heading_enid("#Recibo: ".$id_recibo);
        $concepto .= div("Concepto");
        $concepto .= div($resumen_pedido);
        $concepto .= valida_texto_periodos_contratados($num_ciclos_contratados, $flag_servicio , $id_ciclo_facturacion);
        $concepto .= div("Precio $".$monto_a_pagar);
        $concepto .= div($deuda["text_envio"]);

        $text = div($concepto , ["style"=>"border-style: solid;padding: 10px;border-width: 1px;"]);

        $monto =   heading_enid("Monto total pendiente-", 3, 	['class' 	=> 'strong'] );
        $monto .=  heading_enid($saldo_pendiente ."MXN", 4 ,   	["class" => 'blue_enid strong'] );
        $monto .=  heading_enid("Pesos Mexicanos" , 4 , 		["class"=> 'strong']);

        $text .= div($monto , ["style"=>"border-style: solid;text-align: center;"]);
        $text .= div(img($url_img_servicio),  1);
        return div($text , ["class"=>"col-lg-4"]);

    }
    function get_format_punto_encuentro($data_complete , $recibo ){

        $p                  =   $data_complete["punto_encuentro"][0];
        $costo_envio        =   $p["costo_envio"];
        $tipo 		        = 	$p["tipo"];
        $color 		        = 	$p["color"];
        $nombre_estacion    = 	$p["nombre"];
        $lugar_entrega 		=   $p["lugar_entrega"];
        $numero 	        = 	"NÚMERO ".$p["numero"];


        $t  = heading_enid("LUGAR DE ENCUENTRO" , 3, ["class" => "top_20"]);
        $t .= div($tipo. " ". $nombre_estacion ." ". $numero." COLOR ". $color ,1);
        $t .= div("ESTACIÓN ".$lugar_entrega , ["class" => "strong"],1);
        $t .= br();
        $t .= div("HORARIO DE ENTREGA: " . $recibo["fecha_contra_entrega"]);
        $t .= br();
        $t .= div("Recuerda que previo a la entrega de tu producto, deberás realizar el pago de ".$costo_envio." pesos por concepto de gastos de envío" , ["class" => "contenedor_text_entrega"]);
        return $t;
    }
    function get_botones_seguimiento($id_recibo){

        $link_seguimiento 		=	"../pedidos/?seguimiento=".$id_recibo;
        $t =  guardar(
            "RASTREA TU PEDIDO".icon("fa fa-map-signs"),
            [
                "class" 	=> "top_20 text-left",
                "style" 	=> "border-style: solid!important;border-width: 2px!important;border-color: black!important;color: black !important;background: #f1f2f5 !important;"
            ],
            1,
            1,
            0,
            $link_seguimiento
        );


        $t .= div(
            anchor_enid('CANCELAR COMPRA',
                [
                    "class"		=> 	"cancelar_compra",
                    "id"		=> 	 $id_recibo,
                    "modalidad"	=> 	'0'
                ]
            ) ,
            ["class" => "top_20"],
            1);

        return $t;

    }
    function getPayButtons($id_recibo , $url_request,$saldo_pendiente,$id_usuario_venta){


        $url_pago_oxxo 			= 	get_link_oxxo($url_request,$saldo_pendiente,$id_recibo,$id_usuario_venta);
        $url_pago_paypal 		=	get_link_paypal($saldo_pendiente);
        $url_pago_saldo_enid 	= 	get_link_saldo_enid($id_usuario_venta , $id_recibo);

        $t = guardar(
            "PAGOS EN TIENDAS DE AUTOSERVICIO (OXXO)",
            [
                "class" 	=> "top_10 text-left",
                "onclick" 	=> "notifica_tipo_compra(4 ,  '".$id_recibo."');"

            ],
            1,
            1,
            0,
            $url_pago_oxxo
        );


        $t .= guardar(
            "A TRAVÉS DE PAYPAL" ,
            [
                "class" => "top_10 text-left" ,
                "recibo" 	=> $id_recibo ,
                "onclick" 	=> "notifica_tipo_compra(2 ,  '".$id_recibo."');"
            ],
            1,
            1,
            0,
            $url_pago_paypal
        );

        $t .= guardar(
            "SALDO  ENID SERVICE" ,
            [
                "class" => "top_10 text-left",
                "onclick" 	=> "notifica_tipo_compra(1 ,  '".$id_recibo."');"
            ],
            1,
            1,
            0,
            $url_pago_saldo_enid
        );

        return $t;

    }

    function get_vista_compras_efectivas($data , $status_enid_service){

        $response =  "";
        if($data["total"] > 0 ){

            $ordenes   =   $data["compras"];

            $listado   =   create_listado_compra_venta($ordenes , $status_enid_service, 1);
            $response  =  div($listado,1);
        }
        return $response;

    }
    function get_vista_cliente($data){

        $modalidad  =   $data["modalidad"];
        $ordenes    =   $data["ordenes"];
        $status     =   $data["status"];
        $status_enid_service    = $data["status_enid_service"];
        $en_proceso =   $data["en_proceso"];
        $anteriores =   $data["anteriores"];

        $t          =   get_text_modalidad($modalidad, $ordenes);
        $total      =   ($modalidad  < 1 ) ? count($ordenes) :  0;
        $t         .=   get_total_articulos_promocion($modalidad , $total);
        $t         .=   get_mensaje_compra($modalidad , $total);
        $t         .=   evalua_texto_envios_compras($modalidad , $total , $status);
        $t         .=   create_listado_compra_venta($ordenes , $status_enid_service, $modalidad);
        $t         .=   evalua_acciones_modalidad($en_proceso , $modalidad);
        $t         .=   evalua_acciones_modalidad_anteriores($anteriores , $modalidad);
        $t         .=   place("contenedor_ventas_compras_anteriores");
        return      div($t,1);
    }
    function create_listado_compra_venta($ordenes , $status_enid_service, $modalidad){

        $list = [];
        foreach($ordenes as $row){

                $id_recibo              =   $row["id_proyecto_persona_forma_pago"];
                $resumen_pedido         =   ($row["resumen_pedido"] !==  null ) ? $row["resumen_pedido"] : "";
                $id_servicio            =   $row["id_servicio"];
                $estado                 =   $row["status"];
                $monto_a_pagar          =   $row["monto_a_pagar"];
                $costo_envio_cliente    =   $row["costo_envio_cliente"];
                $saldo_cubierto         =   $row["saldo_cubierto"];
                //$direccion_registrada   =   $row["direccion_registrada"];
                $num_ciclos_contratados = $row["num_ciclos_contratados"];
                $estado_envio           =   $row["estado_envio"];
                $url_servicio           =  "../producto/?producto=".$id_servicio;
                $monto_a_liquidar       =     monto_pendiente_cliente(
                    $monto_a_pagar ,
                    $saldo_cubierto ,
                    $costo_envio_cliente,
                    $num_ciclos_contratados
                );

                $url_imagen_servicio    =   "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
                $url_imagen_error       =   '../img_tema/portafolio/producto.png';
                $lista_info_attr        =   " info_proyecto= '".$resumen_pedido."'  info_status =  '".$estado."' ";

                $id_error           =   "imagen_".$id_servicio;


                $t = div(
                        anchor_enid(
                            img([
                                "src"       =>  $url_imagen_servicio,
                                "onerror"   =>  "reloload_img( '".$id_error."','".$url_imagen_servicio."');",
                                "class"     =>  'imagen_articulo',
                                "id"        =>  $id_error
                            ]),
                            ["href"  => $url_servicio]
                        ),
                        ["class"=>"col-lg-3"]
                    );

                $t .=  div(div(
                            div(carga_estado_compra($monto_a_liquidar, $id_recibo, $estado , $status_enid_service, $modalidad), ["class"=>"btn_estado_cuenta"]
                            ),
                            ["class"=>"contenedor_articulo_text"]
                        )
                        ,["class" => "col-lg-9"]
                );

            $list[]     = div($t ,  ["class" => "contenedor_articulo"]);
        }
        return ul($list , ["class" => "row"]);
    }
}