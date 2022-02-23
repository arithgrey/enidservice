<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    
    function valida_tiempo_entrega($servicio, $tiempo)
    {

        $muestra_fecha_disponible = pr($servicio, 'muestra_fecha_disponible');
        $fecha_disponible = pr($servicio, 'fecha_disponible');
        $fecha_disponible_stock = new DateTime($fecha_disponible);

        $fecha = horario_enid();
        $hoy = $fecha->format('H:i:s');
        $es_proxima_fecha = ($fecha_disponible_stock > $fecha);

        $text = "Realiza tu pedido antes de las 6 PM y tenlo hoy mismo!";
        $mas_un_dia = "Realiza tu pedido y tenlo mañana mismo!";
        $str = ($hoy < 18) ? $text : $mas_un_dia;

        $text_proxima_fecha = d(_text_(
            "Ups! lo tendremos disponible el",
            format_fecha($fecha_disponible),
            'Pero ... no te preocupes puedes agendar ya mismo tu entrega'
        ), 'bg-warning strong p-1');


        $str = ($muestra_fecha_disponible > 0 && $es_proxima_fecha) ? $text_proxima_fecha : $str;
        $response[] = d(_titulo($str, 5), 'mt-5 text-center');

        return append($response);
    }


    function descripcion($servicio)
    {

        $response  = '';
        if (es_data($servicio)) {
            
            $nombre_servicio = pr($servicio, "nombre_servicio");
            $descripcion = pr($servicio, "descripcion");        
            $text = _text_($nombre_servicio, $descripcion);            
        }
        return $response;
    }

    function render_tipo_entrega($data)
    {

        $orden_pedido = $data["orden_pedido"];
        $id_servicio = $data["id_servicio"];

        $seccion_tipo_entrega = _text_(
            h("SELECCIONA TU TIPO DE ENTREGA", 3, 'white')
            ,
            punto_entrega($id_servicio, $orden_pedido)
            ,
            mensajeria($id_servicio, $orden_pedido)
        );

        $seccion_entrega = pre_pedido(
            $data["url_imagen_servicio"],
            $orden_pedido,
            $id_servicio,
            $data["ciclo_facturacion"],
            $data["is_servicio"],
            $data["q2"],
            $data["num_ciclos"],
            $data["carro_compras"],
            $data["id_carro_compras"]
        );

        $r[] = flex(
            $seccion_tipo_entrega,
            $seccion_entrega,

            "d-lg-flex col-lg-8 col-lg-offset-2 mb-5 justify-content-between align-items-center p-md-0"
            ,
            "col-lg-4 p-3 azul_contraste_deporte",
            "col-lg-8 mt-sm-5 text-center"
        );
        return d($r, 'mt-5 w-100');


    }


    function render_producto($data)
    {

        $inf_servicio = $data["info_servicio"];
        $imgs = $data["imgs"];
        $in_session = $data["in_session"];
        $proceso_compra = $data["proceso_compra"];
        $tiempo_entrega = $data["tiempo_entrega"];
        $q2 = $data["q2"];
        $is_mobile = $data["is_mobile"];
        $id_publicador = $data["id_publicador"];
        $s = $inf_servicio["servicio"];
        $s['in_session'] = $in_session;
        $id_servicio = pr($s, "id_servicio");
        $nombre = pr($s, "nombre_servicio");
        $es_servicio = pr($s, "flag_servicio");
        $existencia = pr($s, "existencia");
        $precio = pr($s, "precio");
        $id_ciclo_facturacion = pr($s, "id_ciclo_facturacion");
        $nombre = substr(strtoupper($nombre), 0, 70);
        $id_usuario = pr($s, "id_usuario");
        $boton_editar = editar(
            $id_usuario, $data["id_usuario"], $in_session, $id_servicio, $data["id_perfil"]);

        $imagenes = img_lateral($imgs, $nombre, $is_mobile);

        $clases = " align-self-center mx-auto col-lg-2 d-none d-lg-block d-xl-block 
            d-md-block d-xl-none aviso_comision pt-3 pb-3";
        $clases_imagenes =
            " tab-content col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 
            col-lg-6 col-lg-offset-3 align-self-center";

        $r[] = btw(
            d($imagenes["preview"], $clases),
            d($imagenes["imagenes_contenido"], $clases_imagenes),
            "d-flex col-lg-9 mb-5"
        );

        $r[] = d($imagenes["preview_mb"], "d-none d-sm-block d-md-none d-flex mt-5 row azul_deporte");
        $titulo = substr(strtoupper($nombre), 0, 70);

        if ($es_servicio < 1):

            $nombre_producto = _titulo($titulo);
            $x[] = venta_producto(
                $data,
                $nombre_producto,
                $es_servicio,
                $existencia,
                $id_servicio,
                $in_session,
                $q2,
                $precio,
                $id_ciclo_facturacion,
                $data["tallas"],
                $proceso_compra,
                $id_publicador,
                $is_mobile,
                $tiempo_entrega
            );


        else:


            $x[] = seccion_form_compra(
                $titulo, $es_servicio, $precio, $id_ciclo_facturacion, $data, $s, $existencia,
                $id_servicio, $q2, $tiempo_entrega, $proceso_compra);

        endif;

        $r[] = d($x, "col-xs-12 col-sm-12 col-md-3");
        $producto = append($r);
        $interes_re_venta = 
        interes_re_venta($s, $proceso_compra, $data, $imagenes, $in_session, $nombre, $id_servicio);
        $recompensa = recompensa($data);
        $data_response[] = d($producto, 12);
        $data_response[] = d($boton_editar, 12);        
        $data_response[] = d($recompensa, 12);
        $data_response[] = d($interes_re_venta, 12);

        return append($data_response);


    }

    function seccion_form_compra(
        $titulo, $es_servicio, $precio, $id_ciclo_facturacion, $data,
        $s, $existencia, $id_servicio, $q2, $tiempo_entrega, $proceso_compra)
    {

        $response[] = _titulo($titulo);
        $str_servicio = text_servicio(
            $es_servicio,
            $precio,
            $id_ciclo_facturacion,
            $data
        );

        if (strlen($str_servicio) > 0) {
            $response[] = h($str_servicio, 3, 'card-title pricing-card-title ');
        }

        $response[] = frm_compra(
            $s,
            $es_servicio,
            $existencia,
            $id_servicio,
            $q2,
            $tiempo_entrega,
            $proceso_compra
        );
        return $response;

    }

    function interes_re_venta($s, $proceso_compra, $data, $imagenes, $in_session, $nombre, $id_servicio)
    {
        $descripcion = flex(
            "DESCRIPCIÓN",
            "DETALLES",
            "flex-row mt-5 mb-5 cursor_pointer",
            "border_enid text-center p-3 w-100 strong black descripcion_producto cursor_pointer",
            "border text-center p-3 w-100 strong black descripcion_detallada cursor_pointer");

        $response[] = d($descripcion, "col-lg-10 col-lg-offset-1 mt-5  ");
        $response[] = d(desc_servicio($s, $proceso_compra, $data, $imagenes, $in_session), 10, 1);
        $response[] = d("", "place_valoraciones mt-5 col-sm-10 col-sm-offset-1");
        $interes = h("TAMBIÉN PODRÍA INTERESARTE", 2, " mt-5");
        $response[] = d($interes, "col-lg-10 col-lg-offset-1 mt-5 text_sugerencias d-none ");
        $response[] = d(d("", "place_tambien_podria_interezar bottom_100"), 10, 1);
        $response[] = hiddens(["class" => "qservicio", "value" => $nombre]);
        $response[] = hiddens(["name" => "servicio", "class" => "servicio", "value" => $id_servicio]);
        $response[] = hiddens(
            [
                "name" => "desde_valoracion",
                "value" => $data["desde_valoracion"],
                "class" => 'desde_valoracion'
            ]
        );
        return $response;
    }

    function venta_producto(
        $data,
        $nombre_producto,
        $es_servicio,
        $existencia,
        $id_servicio,
        $in_session,
        $q2,
        $precio,
        $id_ciclo_facturacion,
        $tallas,
        $proceso_compra,
        $id_publicador,
        $es_mobile,
        $tiempo_entrega
    )
    {

        $place_valoraciones = d("",
            [
                'class' => 'valoracion_persona_principal valoracion_persona'
            ]
        );

        $link_valoraciones = a_enid($place_valoraciones,
            [
                'class' => 'lee_valoraciones ',
                'href' => path_enid('search_q3', $id_publicador)
            ]
        );

        $r[] = d($link_valoraciones);
        $r[] = ($es_mobile > 0) ? "" : $nombre_producto;
        $r[] = text_servicio($es_servicio, $precio, $id_ciclo_facturacion, $data);


        $r[] = frm_compra(
            $data,
            $es_servicio,
            $existencia,
            $id_servicio,
            $q2,
            $tiempo_entrega,
            $proceso_compra);

        $r[] = $tallas;

        return append($r);

    }

    function frm_compra($data, $es_servicio, $existencia, $id_servicio, $q2, $tiempo_entrega, $proceso_compra)
    {

        $response = "";
        if ($es_servicio < 1):

            $response = ($existencia > 0) ?
                get_frm(
                    $data,
                    $id_servicio,
                    $es_servicio,
                    $existencia,
                    $q2,
                    $tiempo_entrega
                ) : $response;

        else:

            $response = frm_servicio($id_servicio);

        endif;
        return $response;
    }

    function mensajeria($id_servicio, $orden_pedido)
    {

        $r[] = d(icon('fa fa-truck fa-3x black'));
        $r[] = h("MENSAJERÍA", 4, "strong black");
        $r[] = d("lo llevamos a tu domicilio", "text text-uppercase black");

        return d($r,
            [
                "class" => "cursor_pointer p-4 mt-5 bg-light mb-5 mh-selector d-flex flex-column justify-content-center selector_entrega ",
                "onclick" => "carga_opcion_entrega(2, " . $id_servicio . " , " . $orden_pedido . " );"
            ]
        );

    }


    function ganancia_comisionista($data)
    {

        $in_session = prm_def($data, 'in_session');
        $id_perfil = prm_def($data, 'id_perfil');
        $es_comisionista = ($in_session && in_array($id_perfil, [6, 3]));

        $response = [];
        $servicio = $data['info_servicio']['servicio'];

        $response[] = utilidad_en_servicio($data, $servicio,1, 'mb-2 text-right');

        if ($es_comisionista) {

            $porcentaje_comision = pr($servicio, 'comision');
            $precio = pr($servicio, 'precio');
            $comision = comision_porcentaje($precio, $porcentaje_comision);

            $text_comisionn = strong(money($comision), 'white f14');
            $text = _text_('gana', $text_comisionn, 'al verderlo!');
            $class = 'aviso_comision mb-2 white text-uppercase border shadow text-right p-2 mb-5';
            $response[] = d($text, $class);
        }
        return append($response);

    }

    function get_frm($data, $id_servicio, $es_servicio, $existencia, $q2, $tiempo_entrega)
    {


        $response = [];
        $en_session = $data["in_session"];
        $tipo = (is_mobile()) ? 2 : 4;
        $r[] = ganancia_comisionista($data);
        $r[] = flex(
            _titulo("PIEZAS", $tipo),
            select_cantidad_compra($es_servicio, $existencia)
            , _between
        );
        $r[] = $tiempo_entrega;
        $r[] = agregar_lista_deseos($data, $en_session, $id_servicio);
        $response[] = d($r, "contenedor_form");
        return append($response);

    }

    function frm_servicio($id_servicio)
    {

        $ext = (prm_def($_GET, "debug")) ? "&debug=1" : "";
        $url = "../procesar/?w=1" . $ext;
        $r[] = '<form action="' . $url . '" method="POST" >';
        $r[] = form_hidden(["id_servicio" => $id_servicio, "es_servicio" => 1]);
        $r[] = btn(text_icon("fa fa fa-long-arrow-right", "COTIZAR ", [], 0));
        $r[] = form_close();
        return d(append($r), "contenedor_form mt-5");

    }


    function url_post($id_servicio)
    {
        return _text("http://enidservices.com/", _web, "/img_tema/productos/" . $id_servicio);
    }

    function costruye_meta_keyword($servicio)
    {

        if (es_data($servicio)) {


            $servicio = $servicio[0];
            $meta_usuario = $servicio["metakeyword_usuario"];
            $array = explode(",", $servicio["metakeyword"]);
            $array[] = $servicio["nombre_servicio"];
            $array[] = $servicio["descripcion"];
            $array[] = " precio ";
            if (strlen(trim($meta_usuario)) > 0) {

                $array[] = $meta_usuario;
            }

            return strip_tags(implode(",", $array));
        }

    }


    function desc_servicio($servicio, $proceso_compra, $data, $imgs, $in_session)
    {


        $usuario = $data["usuario"];
        $id_publicador = $data["id_publicador"];
        $descripcion = pr($servicio, "descripcion");
        $nombre = pr($servicio, "nombre_servicio");
        $color = pr($servicio, "color");
        $es_servicio = pr($servicio, "flag_servicio");
        $es_nuevo = pr($servicio, "flag_nuevo");
        $marca = pr($servicio, "marca");
        $dimension = pr($servicio, "dimension");
        $peso = pr($servicio, "peso");
        $capacidad = pr($servicio, "capacidad");
        $servicio_materiales = $data["servicio_materiales"];

        $z[] = d(_titulo($nombre), "mb-4");

        if (strlen($descripcion) > 5) {

            $z[] = d($descripcion, 'mt-4 mb-4');
        }

        $z[] = nombre_vendedor($proceso_compra, $usuario, $id_publicador);
        $z[] = get_tipo_articulo($es_nuevo, $es_servicio);

        $z[] = validador_atributo($marca, 'Marca');
        $z[] = validador_atributo($dimension, 'Dimensiones');
        if ($peso > 0) {
            $z[] = validador_atributo($peso, 'Peso', 'KG');
        }

        if ($capacidad > 0) {
            $z[] = validador_atributo($capacidad, 'Capacidad', "KG");
        }

        $z[] = valida_materiales($servicio_materiales);
        $z[] = d(social($proceso_compra, 1), "iconos_social mb-5");
        $z[] = d(tb_colores($color, $es_servicio), 12);
        $yt = pr($servicio, "url_vide_youtube");

        $z[] = d(
            format_link("Nuestros clientes",
                [
                    "href" => path_enid("clientes"),
                    "target" => "_black"
                ]
            ), 'col-md-12 mt-5');
        $r = [];


        $i = pre_youtube($imgs, $yt);
        $izquierdo = ($i["es_imagen"] > 0) ? "col-lg-7 p-0 " : "col-lg-6 col-sm-12 p-0";
        $derecha = ($i["es_imagen"] > 0) ? "col-lg-5 " : "col-lg-6 col-sm-12 p-0 mt-5 mt-md-0";
        $flex = ($i["es_imagen"] > 0) ? "align-items-center" : ["d-lg-flex "];

        $contenido_descripcion = append($z);
        $imagen = $i["img"];
        $r[] = flex(
            $contenido_descripcion,
            $imagen,
            $flex,
            $izquierdo,
            $derecha
        );

        return append($r);


    }

    function valida_materiales($servicio_materiales)
    {

        $response = [];
        if (es_data($servicio_materiales)) {
            foreach ($servicio_materiales as $row) {

                $response[] = create_solo_tag(
                    $row,
                    "material_servicio_tag text-uppercase bg_white",
                    "id_material",
                    "nombre"
                );
            }
        }

        return append($response);

    }

    function validador_atributo($atributo, $texto, $extra = '')
    {

        $response = '';
        if (strlen($atributo) > 0) {

            $response = d(_text_(strong($texto), $atributo, $extra));
        }
        return $response;
    }

    function crea_nombre_publicador_info($usuario, $id_usuario)
    {

        $response = [];
        if (es_data($usuario)) {

            $nombre = $usuario[0]["nombre"];

            $response[] = a_enid(
                add_text("POR ", u($nombre)),

                [
                    "href" => path_enid("search", "/?q3=" . $id_usuario . "&vendedor=" . $nombre),
                    "class" => "black strong text-uppercase",
                    "target" => "_black"
                ]
            );
        }

        return append($response);


    }

    function get_tipo_articulo($es_nuevo, $es_servicio)
    {

        return ($es_servicio == 0 && $es_nuevo == 0) ? d('ARTÍCULO USADO') : "";

    }


    function tb_colores($text_color, $es_servicio)
    {

        $colores_disponibles = 0;
        $contenido = "";
        if (!is_null($text_color)) {
            $final = "";
            if ($es_servicio == 0) {
                $arreglo_colores = explode(",", $text_color);
                $info = "";
                $v = 0;
                for ($z = 0; $z < count($arreglo_colores); $z++) {
                    $color = $arreglo_colores[$z];
                    $style = "background:$color;height:40px; ";
                    $info .= d("", ["style" => $style, "class" => "col-sm-4 col-md-4 col-lg-4 col-xl-4"]);
                    $v++;
                    $colores_disponibles++;
                }
                if ($v > 0) {
                    $final = $info;
                }
                $contenido = $final;
            }
        }

        if ($colores_disponibles > 0) {

            $tipo = (is_mobile()) ? 3 : 5;
            $response[] = d(_titulo('colores disponibles', $tipo), 'text-right text-md-left mb-4 mb-md-0');

        }
        $response[] = d($contenido, "mt-4");
        return append($response);
    }


    function editar($usuario_servicio, $id_usuario, $in_session, $id_servicio, $id_perfil)
    {

        $response = "";
        if ($in_session == 1) {

            $editar = a_enid(
                text_icon('fa fa-pencil', "EDITAR"),
                [
                    "href" => path_enid("editar_producto", $id_servicio),
                    "class" => "black strong  p-3 col-lg-2"
                ]
            );
            $texto_editar = d($editar, 13);
            $editar_button = d($texto_editar, ' mr-5 col-lg-12 text-right border-bottom');

            $response = ($id_usuario == $usuario_servicio) ? $editar_button : "";
        }
        return $response;
    }

    function recompensa($data)
    {
        $recompensa = $data["recompensa"];
        $response[] = "";
        $id_servicio_recompesa = 0;

        $es_recompensa = es_data($recompensa);
        
        if (es_administrador($data)) {
            $response[] = agregar_oferta($data);
        }


        if ($es_recompensa) {

            $texto = "Compra en conjunto y obten recompensas ";
            $response[] = d($texto, ["class" => "mt-5 h4 text-uppercase black font-weight-bold"]);
            foreach ($recompensa as $row) {


                $id_servicio = $row["id_servicio"];
                $id_servicio_recompesa = $id_servicio;
                $id_servicio_conjunto = $row["id_servicio_conjunto"];
                $url_img_servicio = $row["url_img_servicio"];
                $url_img_servicio_conjunto = $row["url_img_servicio_conjunto"];
                $id_recompensa = $row["id_recompensa"];
                $precio_servicio = $row["precio"];
                $precio_conjunto = $row["precio_conjunto"];

                $texto_total = total_recompensa($row);
                $imagen_servicio = imagen_recompensa($url_img_servicio, $id_servicio);
                $imagen_servicio_conjunto =
                    imagen_recompensa_conjunto($url_img_servicio_conjunto, $id_servicio_conjunto);

                $agregar_a_carrito = anexar_carro_compra(
                    $id_servicio,
                    $id_recompensa, 
                    $data["in_session"] , 
                    $data,
                    $precio_servicio, 
                    $precio_conjunto,
                    $row
                );

                $clase_imagen = 'col-xs-4';

                $promocion = [
                    d($imagen_servicio, $clase_imagen),
                    d("+"),
                    d($imagen_servicio_conjunto, $clase_imagen),
                    d($texto_total, _text_($clase_imagen))
                ];

                $seccion_fotos = d($promocion, _text_('d-flex', _between));
                $clase_flex = _text_(_between, "row");
                $clase_izquierda = "col-xs-8";
                $clase_derecha = "col-xs-4 p-0";
                $seccion_fotos_compra = flex(
                    $seccion_fotos, $agregar_a_carrito, $clase_flex, $clase_izquierda, $clase_derecha);

                $extra = is_mobile() ? "border-bottom" : "";
                $response[] = d($seccion_fotos_compra, _text_("row mt-5", $extra));


            }

            $ofertas = count($recompensa);
            if ($ofertas > 1) {

                $path = path_enid("recompensas", $id_servicio_recompesa);
                $link = a_enid(
                    "Ver más ofertas",
                    [
                        "class" => "text-secondary",
                        "href" => $path
                    ],
                    0);

                $response[] = d(d($link, "col-xs-12 text-right"), "row mt-2");
            }

        }


        return d($response, 'col-xs-12 col-sm-12 col-md-12 col-lg-7');


    }

    function agregar_oferta($data){

        $servicio = $data["info_servicio"]["servicio"];
        $id_servicio = pr($servicio, "id_servicio");


        $path = path_enid("recompensas", $id_servicio);
        $link = format_link(
                    "+ Agregar oferta",
                    [                        
                        "href" => $path,
                        "class" => "col-md-3"
                    ]
                );


                return d($link,13);
                


    }
    function anexar_carro_compra(
        $id_servicio, $id_recompensa, 
        $antecedentes, $data, $precio_servicio, 
        $precio_servicio_conjunto, $row){


        $editar_oferta = ''; 
        $texto_comisiones = ''; 
        $texto_utilidad = ''; 
        $texto_editar_ganancias = '';
        $descuento = $row["descuento"];
        if (es_administrador($data)) {
            
            $path = path_enid("recompensas", $id_servicio);
            $editar_oferta = a_enid(
                    icon(_editar_icon),
                    [                        
                        "href" => $path,                        
                    ]);

        }

        
        $texto_comisiones = 
        ganancia_vendedor($data, $precio_servicio, $precio_servicio_conjunto, $descuento);

        
        if (es_administrador($data)) {

            $texto_utilidad = utilidad_venta_conjunta($data, $row, 1);            
            
        }
        

        $texto_editar_ganancias = flex( $texto_comisiones, $editar_oferta, 'flex-column');

        $texto_editar_ganancias = es_administrador_o_vendedor($data) ? $texto_editar_ganancias : '';

        $agregar_a_carrito =  d("Agregar al carrito",
            [
                "class" => "cursor_pointer p-1 bottom_carro_compra_recompensa white border text-center",
                "id" => $id_recompensa, 
                "antecedente_compra" => $antecedentes
            ]
        );

        $elementos = [$agregar_a_carrito, $texto_utilidad, $texto_editar_ganancias ];
        return flex($elementos, 'flex-column');
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

    function imagen_recompensa($url_img_servicio, $id_servicio)
    {

        $link_servicio = path_enid("producto", $id_servicio);
        return img(
            [
                'src' => $url_img_servicio,
                'class' => 'w-100',
                'href' => $link_servicio,
                'onClick'=>'log_operaciones_externas(22)'
            ]
        );


    }

    function imagen_recompensa_conjunto($url_img_servicio_conjunto, $id_servicio_conjunto)
    {

        $link_servicio_conjunto = path_enid("producto", $id_servicio_conjunto);
        $imagen_servicio_conjunto = img(
            [
                'src' => $url_img_servicio_conjunto,
                'class' => 'w-100',
                'onClick'=>'log_operaciones_externas(22)'
            ]
        );
        return a_enid($imagen_servicio_conjunto,
            [
                "href" => $link_servicio_conjunto,
                "target" => "_blank"
            ]
        );


    }


    function texto_tipo_comision($data, $precio_unidad)
    {

        $servicio = $data["info_servicio"]["servicio"];
        $descuento_especial = pr($servicio, "descuento_especial");
        $precio_menos_descuento = ($precio_unidad - $descuento_especial);
        $usuario = $data["usuario"];
        $es_premium = es_premium($data, $usuario);
        $texto_precio_base = ($precio_unidad > 0) ? _text($precio_unidad, "MXN") : "A CONVENIR";

        $texto_premium = "";
        if ($es_premium) {

            $texto = d(del($texto_precio_base), "f11 text-secondary");
            $texto_precio = money($precio_menos_descuento);
            /*
            $texto_premium = flex(
                $texto_precio,
                "Puedes venderlo a este precio por ser premium",
                " black w-100 flex-column mt-1",
                "f16",
                "text-muted "
            );
            */
            $response = flex($texto, $texto_premium, "flex-column mb-3 mt-3");

        } else {


            $in_session = $data["in_session"];
            $texto = d($texto_precio_base, "f16 black");

            if ($in_session && $descuento_especial > 0) {

                $texto_precio = money($precio_menos_descuento);
                /*
                $texto_premium = flex(
                    del($texto_precio),
                    "Puedes venderlo a este precio aumentando tus ventas semanales",
                    "black w-100 flex-column mt-1",
                    "fp9",
                    "text-muted fp8"
                );
                */

                $response = flex($texto, $texto_premium, "flex-column mb-3 mt-3");

            } else {

                $response = d($texto, "flex-column mb-3 mt-3");

            }

        }
        return $response;
    }

    function text_servicio($es_servicio, $precio_unidad, $id_ciclo_facturacion, $data)
    {

        if ($es_servicio == 1) {

            $response = ($id_ciclo_facturacion != 9 && $precio_unidad > 0) ?
                add_text($precio_unidad, "MXNs") : "";


        } else {

            $response = texto_tipo_comision($data, $precio_unidad);

        }

        return $response;
    }


    function img_lateral($param, $nombre_servicio, $is_mobile)
    {

        $preview = [];
        $imgs_grandes = [];
        $preview_mb = [];
        $z = 0;

        foreach ($param as $row) {

            $url = get_url_servicio($row["nombre_imagen"], 1);
            $extra_class = "";
            $extra_class_contenido = '';

            if ($z < 1) {
                $extra_class = ' active ';
                $extra_class_contenido = ' in active ';
            }


            $preview[] =
                img(
                    [
                        'src' => $url,
                        'alt' => $nombre_servicio,
                        'class' => 'col-lg-8 mt-2 border cursor_pointer col-lg-offset-2 bg_white ' . $extra_class,
                        'id' => $z,
                        'data-toggle' => 'tab',
                        'href' => "#imagen_tab_" . $z
                    ]
                );

            $preview_mb[] = img(
                [
                    'src' => $url,
                    'alt' => $nombre_servicio,
                    'class' => 'col-xs-3 col-sm-3 mt-2 border mh_50 mah_50 mr-1 mb-1' . $extra_class,
                    'id' => $z,
                    'data-toggle' => 'tab',
                    'href' => _text("#imagen_tab_", $z)
                ]

            );


            $ext = ($is_mobile < 1) ? " mh_450 " : "";

            $imgs_grandes[] =
                img(
                    [
                        'src' => $url,
                        "class" => " w-100 tab-pane fade zoom" . $ext . " " . $extra_class_contenido,
                        "id" => "imagen_tab_" . $z,

                    ]
                );

            $z++;

        }


        $principal = "";

        if (es_data($param)) {

            $principal = (count($param) > 1) ? $param[1]["nombre_imagen"] : $param[0]["nombre_imagen"];
        }


        $response = [
            "preview" => append($preview),
            "preview_mb" => append($preview_mb),
            "num_imagenes" => count($param),
            "imagenes_contenido" => append($imgs_grandes),
            "principal" => get_url_servicio($principal, 1)
        ];
        return $response;

    }

    function pre_youtube($imgs, $youtube)
    {


        $f = 1;
        $response = img(
            [
                'src' => $imgs["principal"]
            ]
        );


        if (strlen($youtube) > 5) {


            $response = iframe(
                [
                    "height" => (is_mobile() == 0) ? "500px" : "400px",
                    "src" => $youtube,
                    "frameborder" => '0',
                    "allow" => 'autoplay',
                    "class" => "w-100"
                ]
            );
            $f = 0;
        }
        return [
            "img" => $response,
            "es_imagen" => $f
        ];

    }


    function agregar_lista_deseos($data, $in_session, $id_servicio)
    {


        if ($in_session > 0) {

            $response[] = d(format_link(
                d("Agrégalo al Carrito", 'border'),
                [
                    "id" => 'agregar_a_lista_deseos_add',
                    "class" => "agregar_a_lista_deseos l_deseos"
                ]
            ), 'se_agregara');


            $response[] = d(format_link('Se agregó!', [], 0), 'se_agrego d-none');


        } else {

            $response[] = format_link(

                d(
                    "Lo deseo"
                    , 'agregar_a_lista border l_deseos'
                ),
                [
                    'class' => 'agregar_deseos_sin_antecedente',
                    'id' => $id_servicio
                ]

            );


        }
        //$response[] = formas_acionales_compra($data);
        return append($response);


    }

    function formas_acionales_compra($data)
    {

        $servicio = $data["info_servicio"]["servicio"];
        $link_amazon = pr($servicio, "link_amazon");
        $link_ml = pr($servicio, "link_ml");

        $len_amazon = ((strlen($link_amazon)) > 0);
        $len_ml = ((strlen($link_ml)) > 0);

        $response = [];

        if ($len_amazon || $len_ml) {

            $response[] = d("Más opciones de compra", "text-secondary mt-3 text-right cursor_pointer col-md-12 texto_externo_compra");
            if ($len_amazon) {

                $path = path_enid("img_logo_amazon");
                $imagen = a_enid(img(["src" => $path]),
                    [
                        "href" => $link_amazon,
                        "target" => "_black",
                        "class" => "click_amazon_link"
                    ]
                );
                $response[] = d($imagen, "text-right cursor_pointer col-md-12 link_externo_compra d-none mt-5");
            }

            if ($len_ml) {

                $path = path_enid("img_logo_ml");
                $imagen = a_enid(img(["src" => $path]),
                    [
                        "href" => $link_ml,
                        "target" => "_black",
                        "class" => "click_ml_link"
                    ]
                );
                $response[] = d($imagen, "text-right cursor_pointer col-md-12 link_externo_compra d-none");
            }
        }

        return d($response, 13);

    }

    function nombre_vendedor($proceso_compra, $usuario, $id_vendedor)
    {

        return ($proceso_compra == 0) ? d(crea_nombre_publicador_info($usuario, $id_vendedor), "mt-2") : "";

    }

    function punto_entrega($id_servicio, $orden_pedido)
    {

        $r[] = d(img(["src" => "../img_tema/linea_metro/metro.jpg", "class" => "icono_metro"]));
        $r[] = h("PUNTO MEDIO", 4, "strong");
        $r[] = d(d("PAGO CONTRA ENTREGA ", 'black'), "text");
        return d($r,
            [
                "class" => " cursor_pointer p-4 bg-light mh-selector d-flex flex-column justify-content-center selector_entrega mt-5",
                "onclick" => "carga_opcion_entrega(1, " . $id_servicio . " , " . $orden_pedido . " );"
            ]
        );

    }

    function pre_pedido($url_imagen_servicio, $orden_pedido,
                        $id_servicio,
                        $ciclo_facturacion, $is_servicio,
                        $q2, $num_ciclos,
                        $carro_compras, $id_carro_compras)
    {

        $r = [];

        if ($orden_pedido > 0) {

            $r[] =
                img(
                    [
                        "src" => $url_imagen_servicio
                    ]

                );
            $r[] = frm_pre_pedido($id_servicio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $carro_compras, $id_carro_compras);
            $r[] = frm_pre_contact($id_servicio, $num_ciclos, $carro_compras, $id_carro_compras);
            $r[] = form_pre_puntos_medios($id_servicio, $num_ciclos, $carro_compras, $id_carro_compras);

        }

        return append($r);

    }

    function frm_pre_pedido($id_servicio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $carro_compras, $id_carro_compras)
    {

        $r[] = '<form class="form_pre_pedido d-none" action="../procesar/?w=1" method="POST">';
        $r[] = hiddens(["class" => "id_servicio", "name" => "id_servicio", "value" => $id_servicio]);
        $r[] = hiddens(["class" => "ciclo_facturacion", "name" => "ciclo_facturacion", "value" => $ciclo_facturacion]);
        $r[] = hiddens(["class" => "is_servicio", "name" => "is_servicio", "value" => $is_servicio]);
        $r[] = hiddens(["class" => "q2", "name" => "q2", "value" => $q2]);
        $r[] = hiddens(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = hiddens(["class" => "carro_compras", "name" => "carro_compras", "value" => $carro_compras]);
        $r[] = hiddens(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = form_close();
        return append($r);

    }

    function frm_pre_contact($id_servicio, $num_ciclos, $carro_compras, $id_carro_compras)
    {


        $r[] = '<form class="frm_pre_contact d-none" action="../contact/?w=1" method="POST">';
        $r[] = hiddens(["class" => "servicio", "name" => "servicio", "value" => $id_servicio]);
        $r[] = hiddens(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = hiddens(["class" => "carro_compras", "name" => "carro_compras", "value" => $carro_compras]);
        $r[] = hiddens(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = form_close();
        return append($r);

    }

    function form_pre_puntos_medios($id_servicio, $num_ciclos, $carro_compras, $id_carro_compras)
    {

        $ext = prm_def($_GET, "debug") ? "&debug=1" : "";
        $url = "../puntos_medios/?producto=" . $id_servicio . $ext;
        $r[] = '<form class="form_pre_puntos_medios d-none" action="' . $url . '" method="POST">';
        $r[] = hiddens([
            "class" => "servicio",
            "name" => "servicio",
            "value" => $id_servicio
        ]);
        $r[] = hiddens([
            "class" => "id_servicio",
            "name" => "id_servicio",
            "value" => $id_servicio
        ]);

        $r[] = hiddens([
            "class" => "num_ciclos",
            "name" => "num_ciclos",
            "value" => $num_ciclos
        ]);


        $r[] = hiddens(["class" => "carro_compras", "name" => "carro_compras", "value" => $carro_compras]);
        $r[] = hiddens(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = form_close();
        return append($r);

    }

}