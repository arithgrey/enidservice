<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

 

    function productos_deseados($data, $productos_deseados)
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
        //$response[] = _titulo(_text_("Subtotal ", _text('(', $total_articulo, 'productos)')), 5,_text_('fp9', $extra));
        
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
            $response[] =  hiddens(["class" => "comision_venta", "value" => $comision_venta]);
        }


        $extra = is_mobile() ? 'fixed-bottom bg_black borde_black' : 'position-fixed';
    
        return d($response, $extra);
    }

    function valida_envio_descuento($data)
    {

        $recompensas = $data["recompensas"];
        $config =
            [
                "name" => "recompensas[]",
                "value" => 0,
                "type" => "checkbox",
                "class" => _text("recompensa_", 0)
            ];
        $inputs[] = hiddens($config);

        if (es_data($recompensas)) {

            $descuentos = array_column($recompensas, "descuento");
            $total_descuento = array_sum($descuentos);

            if ($total_descuento > 0) {


                foreach ($recompensas as $row) {

                    $id_recompensa = $row["id_recompensa"];
                    $config =
                        [
                            "name" => "recompensas[]",
                            "value" => $id_recompensa,
                            "type" => "checkbox",
                            "class" => _text("recompensa_", $id_recompensa)
                        ];

                    $inputs[] = hiddens($config);
                }
            }
        }

        return $inputs;
    }
    function formato_subtotal($data, $subtotal)
    {
        $response = [];
        $total_en_descuento = descuento_recompensa($data);
        $extra = is_mobile() ? 'white':'black';
        if ($total_en_descuento > 0) {

            $nuevo_total = $subtotal - $total_en_descuento;
            $response[] =  d(del(money($subtotal), "display-6 red_enid"));
            $response[] =  d(money($nuevo_total), _text_("display-6", $extra));
        } else {
            

            $text = d(money($subtotal), _text_("display-5 strong ml-3", $extra));
            $extra  = is_mobile() ? 'white': ''; 
            $total_descuento_intento_conversion = porcentaje($subtotal , 10);
            


            $precio_descuento_conversion = $subtotal - $total_descuento_intento_conversion;
            $precio_descuento_conversion = d(money($precio_descuento_conversion), _text_("display-5 strong ml-3", $extra));
            $precios_intento_conversion = flex(
                del(money($subtotal)) , 
                $precio_descuento_conversion,
                'flex-column',
                _text_($extra, 'ml-3'));

            $response[] =  d(flex(
                $precios_intento_conversion,
                'Pagarás al recibir tu pedido',
                'flex-column mb-2 mt-2',
                '',
                _text_($extra, 'ml-3')),
                'total_con_descuento_conversion d-none');

            $response[] =  d(flex($text,'Pagarás al recibir tu pedido','flex-column mb-2 mt-2','',_text_($extra, 'ml-3')),'total_sin_descuento');
            
        }

        return $response;
    }
    function descuento_recompensa($data)
    {

        $recompensas = $data["recompensas"];
        $descuentos = array_column($recompensas, "descuento");
        return array_sum($descuentos);
    }

    function form_procesar_carro_compras($data, $inputs, $inputs_recompensa, $subtotal, $es_sorteo)
    {


        $es_recien_creado = ($data["in_session"] && $data["recien_creado"]);

        if (!$es_recien_creado && !es_cliente($data)) {

            $es_administrador_o_vendedor = es_administrador_o_vendedor($data);

            $response[] = '<form class="form_pre_pedido" action="../procesar/?w=1" method="POST">';
            $response[] = append($inputs);
            $response[] = append($inputs_recompensa);


           
            $extra = ($es_administrador_o_vendedor) ? "" : "d-none";
   
            

            $seccion_cobro_externo[] = hiddens(["class" => "cobro_visible", "value" => 0]);
            $seccion_cobro_externo[] = d(input_frm(
                "",
                "",

                [
                    "name" => "cobro_secundario",
                    "id" => "cobro_secundario",
                    "type" => "float",
                    "class" => _text_("cobro_secundario d-none"),
                    "value" => 0
                ]
                ),'d-none');

            $response[] = d($seccion_cobro_externo, $extra);

            $response[] = hiddens(["class" => "carro_compras_total", "value" => $subtotal]);
            $response[] = hiddens(["class" => "carro_compras", "name" => "es_carro_compras", "value" => 1]);
            $response[] = hiddens(["class" => "es_sorteo", "name" => "es_sorteo", "value" => $es_sorteo]);

            $boton_agendar_pedido = btn(
                _text_(icon('fa fa-space-shuttle white'),"Continuar"),
                [
                    "class" => "pb-3 p-2 strong col 
                    text-uppercase registro_google format_action format_google shadow d-block"
                ]
            );

            $extra_envio = (is_mobile()) ? '':'mt-5 ';
            $response[] = d($boton_agendar_pedido, _text_('seccion_enviar_orden bg-white',$extra_envio));                   
            
            $response[] = form_close();
            return d($response);
        } else {


            $response[] = '<form class="form_segunda_compra" action="" method="POST">';
            $response[] = append($inputs);
            $response[] = append($inputs_recompensa);

            $response[] = hiddens(["class" => "carro_compras_total", "value" => $subtotal]);
            $response[] = hiddens(["class" => "carro_compras", "name" => "es_carro_compras", "value" => 1]);
            $response[] = hiddens(["class" => "tipo_entrega", "name" => "tipo_entrega", "value" => 2]);
            $response[] = hiddens([
                "class" => "usuario_referencia",
                "name" => "usuario_referencia",
                "value" => $data["id_usuario"]
            ]);
            $response[] = hiddens(["class" => "id_usuario", "name" => "id_usuario", "value" => $data["id_usuario"]]);
            $response[] = hiddens(["class" => "es_sorteo", "name" => "es_sorteo", "value" => $es_sorteo]);


            $response[] = d(btn("Enviar orden", ["class" => "mt-5 pb-3 p-2 strong col 
            text-uppercase registro_google format_action format_google shadow d-block"]), 'seccion_enviar_orden');
            $response[] = d("Llevamos tus artículos a tu domicilio y pagas a tu entrega!", 'text-right mt-5 f13 mb-5 strong black');
            $response[] = form_close();
            return d($response, 'mb-5');
        }
    }


    function lista_deseo($productos_deseados, $externo)
    {

        $response = [];

        foreach ($productos_deseados as $row) {


            $id = ($externo > 0) ? $row["id_usuario_deseo_compra"] : $row["id"];
            $id_producto = $row["id_servicio"];
            $precio = $row["precio"];
            $precio_alto = $row["precio_alto"];
            $articulos = $row["articulos"];            
            $numero_boleto = $row["numero_boleto"];


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
                

            if ($numero_boleto < 1) {
                $selector = select_cantidad_compra(
                    0,
                    11,
                    $articulos,
                    'cantidad_articulos_deseados',
                    $id
                );

                $x[] = str_repeat(icon("fa fa-star"), 5);
                $texto_deseo = _text_(span($row["deseado"],'strong'), "clientes han recomendado este artículo!");
                $x[] = d($texto_deseo, "label-rating mb-5 mt-2 black");

                
                
                $x[] = d($selector, 'col-lg-4 p-0 d-none d-md-block');
                

                $texto_selector = flex("Cantidad:", $selector,"align-items-end" ,'strong mr-3');
                $x[] = d(flex(money($text_precio),$texto_selector, _text_(_between),'align-self-end strong'),'d-block d-md-none');

            } else {

                $x[] = cuerpo_boleto($numero_boleto);
            }

            $tipo = ($externo < 1) ? "cancela_productos('{$id}');" : "cancela_productos_deseados('{$id}');";
            $eliminar = d(
                icon(_eliminar_icon),
                [
                    "class" => "cursor_pointer hover_black mb-5 ",
                    "onclick" => $tipo
                ]
            );

            $r[] = d($x,'col-xs-7');
            $z = [];            
            $z[] = h(money($text_precio), 4, 'strong');

            if ($precio_alto > $precio) {
                $z[] = h(del(money($text_precio_alto)), 5, ' red_enid');
            }

            

            $es_servicio = $row["flag_servicio"];
            $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
            $z[] = formulario_orden_compra_deseo_cliente($id, $id_producto, 1, $articulos, $es_servicio, $id_ciclo_facturacion);

            $r[] = d($z, 'col-sm-2 col-xs-12 text-right d-none d-md-block ');

            $response[] = d($eliminar, "text-primary text-right col-xs-12");
            $response[] = d($r, 'col-md-12 mb-5 p-0');
            $response[] = d('', 'col-md-12 mt-5 mb-5 border_black');
        }

        
      
        $titulo = _titulo("TU CARRITO");

        $data_response[] = d(d(flex( icon("fa fa-shopping-bag fa-2x mr-1"),$titulo)), 'row mb-3');                
        $data_response[] = d(
            d('Los artículos en tu carrito no están reservados. 
            Termina el proceso de compra ahora para hacerte con ellos.'),13);
        $data_response[] = hr();
        $data_response[] = hiddens(["class" => "en_carro", "value"=> 99]);
        $data_response[] = d($response, 'row');
        return d(d($data_response, "col-xs-12"),13);
    }
    function cuerpo_boleto($numero_boleto)
    {

        $icono = icon(_text_('fa fa-ticket fa-2x white'));



        $extra = "blue_bg white borde_green numero_boleto";

        $curpo_boleto = d(flex(
            $numero_boleto,
            $icono,
            _text_(_between, 'p-1', $extra),
            "align-self-center"
        ), 13);

        return  flex("Boleto número", $curpo_boleto, _between, 'black borde_end', 'col-xs-4');
    }
    function formulario_orden_compra_deseo_cliente($id, $id_servicio, $q2, $num_ciclos, $es_servicio, $id_ciclo_facturacion)
    {

        $r[] = hiddens(["class" => "id_servicio", "name" => "id_servicio", "value" => $id_servicio]);
        $r[] = hiddens(["class" => "ciclo_facturacion", "name" => "ciclo_facturacion", "value" => $id_ciclo_facturacion]);
        $r[] = hiddens(["class" => "is_servicio", "name" => "is_servicio", "value" => $es_servicio]);
        $r[] = hiddens(["class" => "q2", "name" => "q2", "value" => $q2]);
        $r[] = hiddens(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = hiddens(["class" => "carro_compras", "name" => "carro_compras", "value" => 1]);
        $r[] = hiddens(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id]);

        return append($r);
    }


    function busqueda_error()
    {

        return img(
            [
                "src" => "https://media.giphy.com/media/VTXzh4qtahZS/giphy.gif",
                "class" => "mt-3",

            ]
        );
    }
    function sin_productos()
    {
        $r[] = h("UPS! AÚN NO HAZ AGREGADO PRODUCTOS A TU LISTA", 4);
        


        $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke-width="1.5" 
        stroke="currentColor" 
        class="w-6 h-6 black">
        <path stroke-linecap="round" 
        stroke-linejoin="round" 
        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
      </svg>
      ');
        $paso[]  = d('1', 'strong f2');
        $paso[]  = d('Elige tus artículos de tu interés', 'f11 black');
    
        $response[] = d($paso, 'col-xs-3 text-center mt-5');
    
        /**/
        $paso_2[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 black">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
      </svg>  
      ');
        $paso_2[]  = d('2', 'strong f2');
        $paso_2[]  = d('Nos dices donde te los llevamos', 'f11 black');
    
        $response[] = d($paso_2, 'col-xs-3 text-center mt-5');
    
        /*----------- */
    
        $paso_3[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 black">
         <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
       </svg>
       
       ');
        $paso_3[]  = d('3', 'strong f2');
        $paso_3[]  = d('Te marcamos ya que estemos de camino', 'f11 black');
    
        $response[] = d($paso_3, 'col-xs-3 text-center mt-5');
    
    
    
    
        /**/
    
        $paso_4[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" 
         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="black w-6 h-6">
         <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
       </svg>   
       ');
        $paso_4[]  = d('4', 'strong f2');
        $paso_4[]  = d('Compras al recibir tu pedido!', 'f11 black');
    
        $response[] = d($paso_4, 'col-xs-3 text-center mt-5');
    
        $contenido[] =  d($response, 'row mb-5');
    
    

        $r[] = append($response);
        $r[] = hiddens(["class" => "en_carro", "value" => 0]);
        $r[] = d(busqueda_error());
        $r[] = format_link(
            "Mira nuestros productos!",
            [

                "class" => "mt-5 mb-5",
                "href" => path_enid("home")

            ]
            ,2);
        
        return d($r, 'col-sm-4 col-sm-offset-4  text-center');
    }

}
