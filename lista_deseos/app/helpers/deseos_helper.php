<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_deseos($data)
    {

        $r[] = d(menu(), 2);
        $r[] = d(list_clasificaciones($data), 10);

        $link = format_link(
            "Explorar artículos",
            ["href" => path_enid("home")]
        );


        $r[] = d($link, "mt-5 mb-5 col-md-4 col-md-offset-4");
        $r[] = d(slider_preferencias(), 12);


        return append($r);
    }

    function slider_preferencias()
    {

        $r[] = ul(
            [
                li(format_temporadas(), "single-slide slide-2 active"),
                li(format_images_preferencias(), "single-slide slide-3"),
                li(format_images(), "single-slide slide-4"),

            ],
            "slides"
        );

        $r[] = btw(

            d(img(
                [
                    "src" => "../img_tema/preferencias/up-arrow.png"
                ]
            ), "slide-nav-up"),
            d(img(
                [
                    "src" => "../img_tema/preferencias/up-arrow.png"
                ]
            ), "slide-nav-down"),
            "slider-nav"
        );

        return  d(append($r), ["id" => "slider"]);
    }


    function productos_deseados($data, $productos, $externo = 0)
    {


        return format_productos_deseados($data, $productos, $externo);
    }

    function format_temporadas()
    {
        return _text(
            d("Apparel", "slide-label"),

            d(
                img(
                    [
                        "src" => "../img_tema/preferencias/preferencias-1.jpg",
                        "class" => "from-left"
                    ]
                ),
                "slide-image animate"
            ),

            d(
                temporada(),
                "slide-content"
            )
        );
    }

    function format_images_preferencias()
    {

        return _text(
            d("Bags", "slide-label"),
            d(
                img(
                    [

                        "src" => "../img_tema/preferencias/preferencias-2.jpg",
                        "class" => "from-left"
                    ]
                ),
                "slide-image animate"
            ),
            d(
                format_slide_accesorios(),
                "slide-content"
            )
        );
    }

    function format_images()
    {

        $r[] = d("Diferentes estilos", "slide-label");
        $r[] = d(
            img(
                [
                    "src" => "../img_tema/preferencias/preferencias-4.jpg",
                    "class" => "from-left",
                    "alt" => "image-3"
                ]
            ),
            "slide-image animate"
        );


        $str = _text(
            d(
                h("Encuentra entre múltiples opciones", 3, "from-bottom"),
                "animate"
            ),
            p("Para Dama y Caballero"),
            h(
                "Mira las opciones",
                3,
                [
                    "class" => "shop-now",
                    "href" => "../search"
                ],
                1
            )
        );

        $r[] = d($str, "slide-content");

        return append($r);
    }


    function list_clasificaciones($data)
    {
        $is_mobile = $data["is_mobile"];
        $preferencias = $data["preferencias"];
        $tmp = $data["tmp"];

        $r = [];
        if ($is_mobile == 1) {
            $r[] = $tmp;
        }
        $r[] = '<div class="row">';

        $t = 0;
        $z = 0;
        foreach ($preferencias as $row) :

            if ($z == 0) :

                $r[] = '<div class="col-lg-4">';

            endif;
            $r[] = format_clasificaciones($row);
            $z++;
            if ($z == 9) :
                $r[] = '</div>';
                $z = 0;
            endif;
            $t++;
            if ($r == 26) :
                $r[] = '</div>';
            endif;
        endforeach;

        $r[] = '</div>';

        if ($is_mobile == 1) {
            $r[] = $tmp;
        }
        return append($r);
    }

    function sin_productos()
    {

        $r[] = busqueda_error();
        $r[] = h("UPS! AÚN NO HAZ AGREGADO PRODUCTOS A TU LISTA", 3);
        $r[] = a_enid(btn(
            "Explorar ahora!",
            [

                "class" => "mt-5"

            ]
        ), path_enid("home"));
        return d($r, 'col-sm-4 col-sm-offset-4 mt-5  mt-md-3 text-center');
    }

    function format_productos_deseados($data, $productos_deseados, $externo)
    {



        $response[] = d(lista_deseo($productos_deseados, $externo), "col-xs-12 col-md-8 border-right border-secondary");
        $response[] = d(seccion_procesar_pago($data, $productos_deseados), "col-xs-12 col-md-4");

        return d(d(d($response,13), 10, 1), "row mt-3");
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
        $response[] = _titulo(_text_("Subtotal ", _text('(', $total_articulo, 'productos)')), 5,_text_('fp9', $extra));
        $total_en_descuento = descuento_recompensa($data);

        if ($es_premium && $total_en_descuento < 1) {

            $total_menos_descuento = ($subtotal - $total_descuento);
            $response[] = d(_text_(del(money($subtotal)), "Total"), "mt-4 text-muted");
            $response[] = d(_text_("-", money($total_descuento), "Descuento premium"), "text-muted");
            $response[] = d(money($total_menos_descuento), _text_($extra, "display-4"));
            
        } else {

            $response = formato_subtotal($response, $data, $subtotal);
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
    function formato_subtotal($response, $data, $subtotal)
    {

        $total_en_descuento = descuento_recompensa($data);
        $extra = is_mobile() ? 'white':'black';
        if ($total_en_descuento > 0) {

            $nuevo_total = $subtotal - $total_en_descuento;
            $response[] =  d(del(money($subtotal), "display-6 red_enid"));
            $response[] =  d(money($nuevo_total), _text_("display-6", $extra));
        } else {
            
            $response[] =  d(money($subtotal), _text_("display-5 strong ml-3", $extra));
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


            $seleccionar_todo = input(
                [
                    "type" => "checkbox",
                    "class" => "cobro_monto_mayor",
                    "id" => "cobro_monto_mayor"
                ]
            );


            $extra = ($es_administrador_o_vendedor) ? "" : "d-none";
            $extra_mb = (is_mobile()) ? "white" : "black strong";

            $seccion_cobro_externo[] = flex(
                $seleccionar_todo,
                "¿Cobrasté algún monto mayor?",
                _text_("mt-5 text-uppercase border-bottom cobro_texto", $extra_mb),
                "mr-3"
            );

            $seccion_cobro_externo[] = hiddens(["class" => "cobro_visible", "value" => 0]);
            $seccion_cobro_externo[] = input_frm(
                "",
                "",

                [
                    "name" => "cobro_secundario",
                    "id" => "cobro_secundario",
                    "type" => "float",
                    "class" => _text_("cobro_secundario d-none"),
                    "value" => 0
                ]
            );

            $response[] = d($seccion_cobro_externo, $extra);

            $response[] = hiddens(["class" => "carro_compras_total", "value" => $subtotal]);
            $response[] = hiddens(["class" => "carro_compras", "name" => "es_carro_compras", "value" => 1]);
            $response[] = hiddens(["class" => "es_sorteo", "name" => "es_sorteo", "value" => $es_sorteo]);

            $boton_agendar_pedido = btn(
                "Continuar",
                [
                    "class" => "pb-3 p-2 strong col 
                    text-uppercase registro_google format_action format_google shadow d-block"
                ]
            );

            $extra_envio = (is_mobile()) ? '':'mt-5 ';
            $response[] = d($boton_agendar_pedido, _text_('seccion_enviar_orden bg-white',$extra_envio));
            
            if(!is_mobile()){
                $response[] = d("Llevamos tus artículos a tu domicilio y pagas a tu entrega!", 'text-right mt-5 f13 mb-5 strong black');
            }
            
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

    function format_slide_accesorios()
    {

        $r[] = d(d("Accesorios", "product-type from-bottom"), "animate");
        $r[] = d(h("Lo que usas en viajes", 2, "from-bottom"), "animate");
        $r[] = h("Explorar tienda", 3, ["class" => "shop-now", "href" => path_enid("search")]);
        return append($r);
    }

    function temporada()
    {

        $r[] = d(d("Nueva temporada", "product-type from-bottom"), "animate");
        $r[] = d(h("ENCUENTRA", 2, "from-bottom"), "animate");
        $r[] = d(h("ROPA PARA CADA OCACIÓN", 2, "from-bottom"), "animate");
        $r[] = h("EXPLORAR TIENDA", 2, "from-bottom");
        return append($r);
    }

    function format_preferencias()
    {

        $text = _text(
            h("TUS PREFERENCIAS E INTERESES"),
            p("CUÉNTANOS TUS INTERESES PARA  MEJORAR TU EXPERIENCIA")
        );

        return d($text, 4);
    }


    function format_clasificaciones($row)
    {

        $extra = (array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ?
            "selected_clasificacion" : "";
        $preferencia_ = _text("preferencia_", $row['id_clasificacion']);

        $class = _text(
            'list-preferencias item_preferencias ',
            $preferencia_,
            ' ',
            $extra,
            ' '
        );
        $config = [
            'class' => $class,
            'id' => $row['id_clasificacion']
        ];

        $extraIcon = (array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ? icon("fa fa-check-circle-o ") : "";
        $clasificacion = d(append([$extraIcon, $row["nombre_clasificacion"]]), $config);
        return d($clasificacion, 1);
    }


    function menu()
    {
        $preferencias = a_enid(
            "TUS PREFERENCIAS E INTERESES",
            [
                "id" => "mis_ventas",
                "href" => "?q=preferencias",
                "class" => 'btn_mis_ventas'
            ]
        );

        $deseos
            = a_enid(
                "TU LISTA DE ARTÍCULOS DESEADOS",
                [
                    "id" => "mis_compras",
                    "href" => "../lista_deseos",
                    "class" => 'btn_cobranza mis_compras'
                ]
            );

        return ul([$preferencias, $deseos]);
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
            $config = ["href" => $url_servicio, "target" => "_black"];
            $imagen = a_enid(img($row["url_img_servicio"]), $config);
            $text_precio = $precio * $articulos;
            $text_precio_alto = $precio_alto * $articulos;

            $seleccionar_envio = input(
                [
                    "type" => "checkbox",
                    "class" => "mx-auto my-auto seleccion_producto_carro_compra",
                    "checked" => "checked",
                    "value" => $id,
                    "total" => $text_precio

                ]
            );

            $seccion_imagen_seleccion_envio =
                flex($seleccionar_envio, $imagen, _between_start, 'mr-5');
            $r[] = d($seccion_imagen_seleccion_envio, "col-sm-3");
            $x = [];

            $nombre_servicio = $row["nombre_servicio"];
            $link = a_enid(
                $nombre_servicio,
                [
                    "href" => $url_servicio,
                    "target" => "_blank",
                    "class" => "black"
                ]
            );
            $x[] = h($link, 4);



            if ($numero_boleto < 1) {
                $x[] = str_repeat(icon("fa fa-star"), 5);
                $texto_deseo = _text_($row["deseado"], " veces comprado");
                $x[] = d($texto_deseo, "label-rating");


                $selector =
                    select_cantidad_compra(
                        0,
                        10,
                        $articulos,
                        'cantidad_articulos_deseados',
                        $id
                    );
                $x[] = d($selector, 'col-lg-6 p-0');
            } else {

                $x[] = cuerpo_boleto($numero_boleto);
            }

            $tipo = ($externo < 1) ? "cancela_productos('{$id}');" : "cancela_productos_deseados('{$id}');";
            $eliminar = d(
                "Eliminar",
                [
                    "class" => "cursor_pointer hover_black",
                    "onclick" => $tipo
                ]
            );

            $r[] = d($x, 6);
            $z = [];
            $z[] = h(money($text_precio), 4, 'strong');

            if ($precio_alto > $precio) {
                $z[] = h(del(money($text_precio_alto)), 5, ' red_enid');
            }

            $z[] = d($eliminar, "text-primary text-center");

            $es_servicio = $row["flag_servicio"];
            $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
            $z[] = formulario_orden_compra_deseo_cliente($id, $id_producto, 1, $articulos, $es_servicio, $id_ciclo_facturacion);

            $r[] = d($z, 'col-lg-3 text-center');
            $response[] = d($r, 'col-md-12 mb-5');
            $response[] = d('', 'col-md-12 mt-5 mb-5 border-bottom');
        }

        
      

        $data_response[] = d(d(_titulo("Estos son los artículos que haz agregado a tu lista de compras!"),12), 'row');                
        $data_response[] = hr();
        $data_response[] = d($response, 'row');
        return d($data_response, "col-xs-12");
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
                "class" => "",

            ]
        );
    }
}
