<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_producto($data)
    {


        $info_servicio = $data["info_servicio"];
        $imgs = $data["imgs"];
        $id_usuario = $data["id_usuario"];
        $in_session = $data["in_session"];
        $id_perfil = $data["id_perfil"];
        $proceso_compra = $data["proceso_compra"];
        $tiempo_entrega = $data["tiempo_entrega"];
        $usuario = $data["usuario"];
        $desc_web = $data["desc_web"];
        $q2 = $data["q2"];
        $tallas = $data["tallas"];
        $is_mobile = $data["is_mobile"];
        $desde_valoracion = $data["desde_valoracion"];
        $id_publicador = $data["id_publicador"];


        foreach ($info_servicio["servicio"] as $row) {

            $id_servicio = $row["id_servicio"];
            $nombre_servicio = $row["nombre_servicio"];
            $descripcion = $row["descripcion"];
            $flag_servicio = $row["flag_servicio"];
            $flag_nuevo = $row["flag_nuevo"];
            $url_vide_youtube = $row["url_vide_youtube"];
            $existencia = $row["existencia"];
            $color = $row["color"];
            $precio = $row["precio"];
            $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
            $entregas_en_casa = $row["entregas_en_casa"];
            $id_usuario_servicio = $row["id_usuario"];
            $telefono_visible = $row["telefono_visible"];
            $venta_mayoreo = $row["venta_mayoreo"];
            $url_ml = $row["url_ml"];
            $deseado = $row["deseado"];

        }

        $imagenes = construye_seccion_imagen_lateral($imgs, $nombre_servicio, $url_vide_youtube);
        $nombre_servicio = substr(strtoupper($nombre_servicio), 0, 70);
        $nombre_producto = d(h($nombre_servicio, 1, "text-justify nombre_producto_carrito strong "), "top_50 bottom_30");
        $boton_editar = valida_editar_servicio($id_usuario_servicio, $id_usuario, $in_session, $id_servicio, $id_perfil);


        $c[] =
            d(
                btw(

                    d($imagenes["preview"], "thumbs padding_10 bg_black" )
                    ,
                    d(d($imagenes["imagenes_contenido"], "tab-content"), "big")
                    ,
                    ""
                    ,
                    1
                ), "col-lg-6 left-col contenedor_izquierdo");


        $c[] = get_contenedor_central(
            $proceso_compra,
            $id_servicio,
            $tiempo_entrega,
            $color,
            $flag_servicio,
            $flag_nuevo,
            $usuario,
            $id_publicador,
            $desc_web,
            $telefono_visible,
            $is_mobile,
            0
        );


        $r[] = append($c);


        if ($flag_servicio < 1):
            if ($existencia > 0):

                $nuevo_nombre_servicio = valida_text_servicio($flag_servicio, $precio, $id_ciclo_facturacion);

                $x[] = get_format_venta_producto(
                    $boton_editar,
                    $nombre_producto,
                    $nuevo_nombre_servicio,
                    $flag_servicio,
                    $existencia,
                    $id_servicio,
                    $in_session,
                    $q2,
                    $precio,
                    $id_ciclo_facturacion,
                    $tallas,
                    $url_ml,
                    $entregas_en_casa,
                    $proceso_compra,
                    $telefono_visible,
                    $usuario,
                    $venta_mayoreo,
                    $deseado,
                    $id_publicador,
                    $is_mobile);

            else:
                $x[] = get_format_no_visible($nombre_producto, $precio, $existencia, $flag_servicio, $url_ml, $id_servicio);
            endif;

        else:

            $f[] = d(h(substr(strtoupper($nombre_servicio), 0, 70), 1), "card-header top_20");
            $f[] = h(
                valida_text_servicio(
                    $flag_servicio,
                    $precio,
                    $id_ciclo_facturacion
                ),
                3,
                'card-title pricing-card-title '
            );

            $f[] = validate_form_compra($flag_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion);
            $x[] = d(append($f));

        endif;

        $r[] = d(append($x), "col-lg-3  border shadow");
        $r[] = get_contenedor_central(
            $proceso_compra,
            $id_servicio,
            $tiempo_entrega,
            $color,
            $flag_servicio,
            $flag_nuevo,
            $usuario,
            $id_publicador,
            $desc_web,
            $telefono_visible,
            $is_mobile, 1
        );


        $response[] = addNRow(d(append($r), "product-detail contenedor_info_producto mt-5"));
        $response[] = hr("mr-50 mb-5");
        $response[] = place("place_valoraciones col-lg-12");
        $response[] = get_descripcion_servicio($descripcion, $flag_servicio, $url_vide_youtube, $is_mobile);
        $response[] = addNRow(d(place("place_tambien_podria_interezar"), 10, 1));
        $response[] = input_hidden(["class" => "qservicio", "value" => $nombre_servicio]);
        $response[] = input_hidden(["name" => "servicio", "class" => "servicio", "value" => $id_servicio]);
        $response[] = input_hidden(["name" => "desde_valoracion", "value" => $desde_valoracion, "class" => 'desde_valoracion']);
        return append($response);


    }

    function get_format_info_servicio($servicio, $ciclos)
    {


        $response = "";
        if (es_data($servicio)) {

            $servicio = $servicio[0];
            $id_ciclo_facturacion = $servicio["id_ciclo_facturacion"];
            $precio = $servicio["precio"];
            $id_servicio = $servicio["id_servicio"];
            $response = ($precio > 0 && $id_ciclo_facturacion == 9) ? btn(
                "Pedir más información",
                [
                    "class" => "bottom_30"
                ],
                1,
                1,
                1,
                path_enid("pregunta_search", $id_servicio . "&disponible=1")
            ) : "";

        }


        return $response;


    }

    function get_format_no_visible($nombre_producto, $precio, $existencia, $flag_servicio, $url_ml, $id_servicio)
    {

        $r[] = d($nombre_producto, "card-header");
        $r[] = get_format_disponibilidad($precio, $existencia, $flag_servicio, $url_ml, $id_servicio);
        return d(append($r), "card box-shadow");

    }

    function get_format_disponibilidad($precio, $existencia, $flag_servicio, $url_ml, $id_servicio)
    {

        $r[] = heading($precio . "MXN" . get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml),
            1,
            "card-title pricing-card-title"
        );

        $r[] = ul([
            "Artículo temporalmente agotado",
            a_enid(
                "Preguntar cuando estará disponible",
                [
                    path_enid("pregunta_search", $id_servicio . "&disponible=1")
                ],
                1,
                1
            )

        ],
            "list-unstyled mt-3 mb-4"
        );
        return append($r);

    }

    function get_format_ventas_efectivas($deseado)
    {

        return ($deseado > 0) ? d($deseado . " VENTAS EN LOS ÚLTIMOS 2 MESES", "top_50 ") : "";

    }

    function get_format_venta_producto($boton_editar, $nombre_producto,
                                       $nuevo_nombre_servicio,
                                       $flag_servicio, $existencia,
                                       $id_servicio, $in_session, $q2,
                                       $precio, $id_ciclo_facturacion,
                                       $tallas,
                                       $url_ml,
                                       $entregas_en_casa,
                                       $proceso_compra,
                                       $telefono_visible,
                                       $usuario,
                                       $venta_mayoreo,
                                       $deseado,
                                       $id_publicador,
                                       $es_mobile
    )
    {


        $r[] = $boton_editar;
        $r[] = ($es_mobile > 0) ? "" : $nombre_producto;
        $r[] = a_enid(d("", ['class' => 'valoracion_persona_principal valoracion_persona']), ['class' => 'lee_valoraciones text-right', 'href' => '../search/?q3=' . $id_publicador]);
        $r[] = h($nuevo_nombre_servicio, 3);
        $r[] = validate_form_compra($flag_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion);
        $r[] = $tallas;

        $r[] = get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml);
        $r[] = get_format_ventas_efectivas($deseado);
        $r[] = get_info_vendedor($entregas_en_casa, $flag_servicio, $proceso_compra, $telefono_visible, $in_session, $usuario);
        $r[] = d(valida_informacion_precio_mayoreo($flag_servicio, $venta_mayoreo), 1);
        $r[] = d(valida_formas_pago(), 1);
        $r[] = d(agregar_lista_deseos(0, $in_session), "top_20 bottom_20");

        return append($r);

    }

    function validate_form_compra($flag_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion)
    {

        $response = "";
        if ($flag_servicio < 1):

            $response = ($existencia > 0) ? get_form_compra($id_servicio, $flag_servicio, $existencia, $in_session, $q2) : $response;

        else:

            $response = get_form_compra_servicio($id_servicio);

        endif;
        return $response;
    }

    function get_format_eleccion_contra_entrega($id_servicio, $orden_pedido)
    {

        $r[] = d(img(["src" => "../img_tema/linea_metro/metro.jpg", "class" => "icono_metro"]));
        $r[] = d(h("PAGO CONTRA ENTREGA", 3), "title");
        $r[] = d(d("UN PUNTO MEDIO "), "text");
        $response = d(append($r), "shadow  align-items-center box-part text-center border mh-selector d-flex flex-column justify-content-center");
        return d($response, [
            "class" => "col-lg-6 cursor_pointer",
            "onclick" => "carga_opcion_entrega(1, " . $id_servicio . "  ,  " . $orden_pedido . " );"
        ]);

    }

    function get_format_eleccion_mensajeria($id_servicio, $orden_pedido)
    {

        $r[] = d(icon('fa fa-truck fa-3x'));
        $r[] = d(h("POR MENSAJERÍA", 3), "title");
        $r[] = d("QUE LLEGUE A TU CASA U OFICINA", "text");
        $response = d(append($r),
            " shadow align-items-center box-part text-center border mh-selector d-flex flex-column justify-content-center "
        );
        $response = d($response, [
            "class" => "col-lg-6 cursor_pointer",
            "onclick" => "carga_opcion_entrega(2, " . $id_servicio . "  ,  " . $orden_pedido . " );"
        ]);
        return $response;


    }

    function get_contenedor_central($proceso_compra, $id_servicio,
                                    $tiempo_entrega, $color, $flag_servicio,
                                    $flag_nuevo, $usuario, $id_publicador,
                                    $desc_web, $telefono_visible, $es_mobile, $pos)
    {


        $r[] = get_solicitud_informacion($proceso_compra, $id_servicio);

        if ($proceso_compra == 1) {
            $r[] = get_tiempo_entrega(0, $tiempo_entrega);
        }
        $r[] = creta_tabla_colores($color, $flag_servicio);
        $r[] = get_tipo_articulo($flag_nuevo, $flag_servicio);
        $r[] = get_nombre_vendedor($proceso_compra, $usuario, $id_publicador);
        $r[] = get_tiempo_entrega($proceso_compra, $tiempo_entrega);
        if ($telefono_visible > 0 && $flag_servicio > 0) {


            $phone = format_phone($usuario[0]["tel_contacto"]);
            $r[] = d(btw(
                d(
                    d("COMUNÍCATE!", "black")
                )
                ,
                d(h($phone, 6, "f11 black_blue "), "underline  hover letter-spacing-3")
                ,
                12
            ), 13);
        }
        $r[] = get_social($proceso_compra, $desc_web);
        $r[] = get_tienda_vendedor($proceso_compra, $id_publicador);
        $r[] = place("", ["style" => "border: solid 1px"]);

        $response = [];
        if (($pos < 1 && $es_mobile < 1) || ($pos > 0 && $es_mobile > 0)) {

            $response[] = d(d(append($r),
                [
                    "class" => " d-flex flex-column justify-content-between ",
                    "style" => "height: 450px;"
                ], 1), 3);

        }

        return append($response);


    }

    function get_seccion_pre_pedido($url_imagen_servicio, $orden_pedido, $plan, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $id_servicio, $carro_compras, $id_carro_compras)
    {

        $r = [];

        if ($orden_pedido > 0) {


            $r[] = get_form_pre_pedido($plan, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $carro_compras, $id_carro_compras);
            $r[] = form_pre_pedido_contact($plan, $num_ciclos, $carro_compras, $id_carro_compras);
            $r[] = form_pre_puntos_medios($plan, $num_ciclos, $carro_compras, $id_carro_compras);
            $r[] =
                img(
                    [
                        "src" => $url_imagen_servicio
                    ]

                );

        }

        return d(append($r));

    }

    function form_pre_pedido_contact($plan, $num_ciclos, $carro_compras, $id_carro_compras)
    {


        $r[] = '<form class="form_pre_pedido_contact" action="../contact/?w=1" method="POST">';
        $r[] = input_hidden(["class" => "servicio", "name" => "servicio", "value" => $plan]);
        $r[] = input_hidden(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["class" => "carro_compras", "name" => "carro_compras", "value" => $carro_compras]);
        $r[] = input_hidden(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = form_close();
        return append($r);

    }

    function form_pre_puntos_medios($plan, $num_ciclos, $carro_compras, $id_carro_compras)
    {

        $url = "../puntos_medios/?producto=" . $plan;
        $r[] = '<form class="form_pre_puntos_medios" action="' . $url . '"  method="POST">';
        $r[] = input_hidden([
            "class" => "servicio",
            "name" => "servicio",
            "value" => $plan
        ]);

        $r[] = input_hidden([
            "class" => "num_ciclos",
            "name" => "num_ciclos",
            "value" => $num_ciclos
        ]);


        $r[] = input_hidden(["class" => "carro_compras", "name" => "carro_compras", "value" => $carro_compras]);
        $r[] = input_hidden(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = form_close();
        return append($r);

    }

    function get_form_pre_pedido($plan, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $carro_compras, $id_carro_compras)
    {

        $r[] = '<form class="form_pre_pedido" action="../procesar/?w=1" method="POST">';
        $r[] = input_hidden(["class" => "plan", "name" => "plan", "value" => $plan]);
        $r[] = input_hidden(["class" => "extension_dominio", "name" => "extension_dominio", "value" => $extension_dominio]);
        $r[] = input_hidden(["class" => "ciclo_facturacion", "name" => "ciclo_facturacion", "value" => $ciclo_facturacion]);
        $r[] = input_hidden(["class" => "is_servicio", "name" => "is_servicio", "value" => $is_servicio]);
        $r[] = input_hidden(["class" => "q2", "name" => "q2", "value" => $q2]);
        $r[] = input_hidden(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["class" => "carro_compras", "name" => "carro_compras", "value" => $carro_compras]);
        $r[] = input_hidden(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = form_close();
        return append($r);

    }


    function get_form_compra($id_servicio, $flag_servicio, $existencia, $in_session, $q2)
    {

        $url = "../producto/?producto=" . $id_servicio . "&pre=1";
        $r[] = '<form action="' . $url . '" id="AddToCartForm" method="POST" >';
        $r[] = form_hidden([
            "plan" => $id_servicio,
            "extension_dominio" => "",
            "ciclo_facturacion" => "",
            "is_servicio" => $flag_servicio,
            "q2" => $q2
        ]);
        $r[] = btw(d("PIEZAS", "text_piezas mr-3"), select_cantidad_compra($flag_servicio, $existencia), "display_flex_enid");

        $r[] = btn("AGENDA TU ENTREGA",
            [

                'class' => "top_30 shadow",
                "style" => "background:#062548 !important;"
            ],
            1,
            1);
        $r[] = form_close();
        $r[] = br(3);
        //$r[] = d(agregar_lista_deseos(0, $in_session), "top_30");
        return d(append($r), "contenedor_form");


    }

    function get_form_compra_servicio($id_servicio)
    {

        $r[] = '<form action="../procesar/?w=1" method="POST" >';
        $r[] = form_hidden(["id_servicio" => $id_servicio, "es_servicio" => 1]);
        $r[] = btn(
            "COTIZAR ",
            [
                'class' => "top_30 shadow bottom_30",
                "style" => "background:#062548 !important;"

            ],
            1,
            1);
        $r[] = form_close();
        return d(append($r), "contenedor_form");


    }


    function valida_maximo_compra($flag_servicio, $existencia)
    {

        return ($flag_servicio == 1) ? 100 : $existencia;

    }

    if (!function_exists('get_url_imagen_post')) {
        function get_url_imagen_post($id_servicio)
        {
            return "http://enidservice.com/inicio/img_tema/productos/" . $id_servicio;
        }
    }
    if (!function_exists('costruye_meta_keyword')) {
        function costruye_meta_keyword($servicio)
        {


            $meta_usuario = $servicio["metakeyword_usuario"];
            $array = explode(",", $servicio["metakeyword"]);
            array_push($array, $servicio["nombre_servicio"]);
            array_push($array, $servicio["descripcion"]);
            array_push($array, " precio ");
            if (strlen(trim($meta_usuario)) > 0) {

                array_push($array, $meta_usuario);
            }
            $meta_keyword = implode(",", $array);
            return strip_tags($meta_keyword);
        }
    }
    if (!function_exists('select_cantidad_compra')) {
        function select_cantidad_compra($flag_servicio, $existencia)
        {

            $config = [
                "name" => "num_ciclos",
                "class" => "telefono_info_contacto form-control",
                "id" => "num_ciclos"
            ];

            $select[] = "<select " . add_attributes($config) . ">";
            for ($a = 1; $a < valida_maximo_compra($flag_servicio, $existencia); $a++) {

                $select[] = "<option value=" . $a . ">" . $a . "</option>";
            }
            $select[] = "</select>";
            return append($select);
        }
    }
    if (!function_exists('get_text_periodo_compra')) {
        function get_text_periodo_compra($flag_servicio)
        {

            return ($flag_servicio == 0) ? "Piezas" : "";

        }
    }

    if (!function_exists('get_text_costo_envio')) {
        function get_text_costo_envio($flag_servicio, $param)
        {

            return ($flag_servicio == 0 && es_data($param) && array_key_exists("text_envio", $param)) ? $param["text_envio"]["cliente"] : "";

        }
    }
    if (!function_exists('get_descripcion_servicio')) {
        function get_descripcion_servicio($descripcion, $flag_servicio, $url_vide_youtube, $is_mobile)
        {

            $servicio = ($flag_servicio == 1) ? "SOBRE EL SERVICIO" : "SOBRE EL PRODUCTO";
            $r = [];
            if (strlen(trim(strip_tags($descripcion))) > 10) {

                $r[] = d("", ["id" => "video"], 1);
                $x[] = h($servicio, 3, 'titulo_sobre_el_producto letter-spacing-10');
                $x[] = d($descripcion, "mt-5");
                $text = d(append($x), "d-flex flex-column justify-content-center sobre_el_producto");
                $r[] = d($text, 6);
                $r[] = d(valida_url_youtube($url_vide_youtube, $is_mobile), 6);

            }
            $response = append($r);
            return addNRow($response);

        }

    }
    if (!function_exists('get_contacto_cliente')) {
        function get_contacto_cliente($proceso_compra, $tel_visible, $in_session, $usuario)
        {

            $inf = "";
            $response = "";

            if ($tel_visible == 1 && $proceso_compra == 0) {

                $usr = $usuario[0];
                $ftel = 1;
                $ftel2 = 1;
                $tel = (strlen($usr["tel_contacto"]) > 4) ? $usr["tel_contacto"] : $ftel = 0;
                $tel2 = (strlen($usr["tel_contacto_alterno"]) > 4) ? $usr["tel_contacto_alterno"] : $ftel2 = 0;
                if ($ftel == 1) {

                    $lada = (strlen($usr["tel_lada"]) > 0) ? "(" . $usr["tel_lada"] . ")" : "";
                    $contacto = $lada . $tel;
                    $inf .= d(icon("fa fa-phone") . $contacto);
                }
                if ($ftel2 == 1) {
                    $lada = (strlen($usr["lada_negocio"]) > 0) ? "(" . $usr["lada_negocio"] . ")" : "";
                    $inf .= d(icon('fa fa-phone') . $lada . $tel2);
                }
                $response = d($inf, 1);
            }
            return $response;


        }
    }
    if (!function_exists('get_entrega_en_casa')) {

        function get_entrega_en_casa($entregas_en_casa, $flag_servicio)
        {

            $response = "";
            if ($entregas_en_casa == 1) {

                $text = ($flag_servicio == 1) ? "EL VENDEDOR TAMBIÉN BRINDA ATENCIÓN EN SU NEGOCIO" : "PUEDES COMPRAR EN EL NEGOCIO DEL VENDEDOR";
                $response = text_icon("fa fa-check-circle", $text);

            }

            return $response;
        }

    }
    if (!function_exists('crea_nombre_publicador_info')) {
        function crea_nombre_publicador_info($usuario, $id_usuario)
        {

            $response = "";
            if (es_data($usuario)) {

                $nombre = $usuario[0]["nombre"];

                $response = a_enid(
                    "VENDIDO POR " . span($nombre, "nombre_vendedor underline "),
                    [
                        "href" => path_enid("search", "/?q3=" . $id_usuario . "&vendedor=" . $nombre),
                        'class' => 'informacion_vendedor_descripcion text-justify black '
                    ]
                );
            }

            return $response;

        }
    }
    if (!function_exists('get_tipo_articulo')) {
        function get_tipo_articulo($flag_nuevo, $flag_servicio)
        {


            return ($flag_servicio == 0 && $flag_nuevo == 0) ? d(li('- ARTÍCULO USADO'), 1) : "";

        }
    }
    if (!function_exists('valida_informacion_precio_mayoreo')) {
        function valida_informacion_precio_mayoreo($flag_servicio, $venta_mayoreo)
        {


            $text = ($flag_servicio == 0 && $venta_mayoreo == 1) ? text_icon('fa fa-check-circle', "VENTAS MAYORISTAS ") : "";
            $r[] = d($text, "strong");
            $r[] = d(icon('fa fa-check-circle') . "COMPRAS CONTRA ENTREGA");
            return append($r);


        }
    }

    if (!function_exists('valida_formas_pago')) {
        function valida_formas_pago()
        {

            $r[] = d(icon("fa fa-shopping-cart") .
                a_enid(
                    "FORMAS PAGO",
                    [
                        "href" => path_enid("forma_pago"),
                        "class" => "black"
                    ]
                )
            );
            return append($r);


        }
    }


    if (!function_exists('creta_tabla_colores')) {

        function creta_tabla_colores($text_color, $flag_servicio)
        {


            $response = "";
            if (!is_null($text_color)) {
                $final = "";
                if ($flag_servicio == 0) {
                    $arreglo_colores = explode(",", $text_color);
                    $num_colores = count($arreglo_colores);
                    $info_title = "";

                    if (count($arreglo_colores) > 0) {
                        $info_title = ($num_colores > 1) ? "COLORES DISPONIBLES" : "COLOR DISPONIBLE";
                    }
                    $info = "";
                    $v = 0;
                    for ($z = 0; $z < count($arreglo_colores); $z++) {
                        $color = $arreglo_colores[$z];
                        $style = "background:$color;height:40px; ";
                        $info .= d("", ["style" => $style, "class" => "col-lg-4"]);
                        $v++;
                    }
                    if ($v > 0) {

                        $final = "";
                        $final .= d($info_title, 'informacion_colores_disponibles letter-spacing-10');
                        $final .= $info;
                        $final = d($final, 'contenedor_informacion_colores');

                    }
                    $response = d($final, 1);
                }

            }
            return $response;


        }

    }
    if (!function_exists('get_text_diponibilidad_articulo')) {
        function get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml = '')
        {
            if ($flag_servicio == 0 && $existencia > 0) {
                $text = d("APRESÚRATE! SOLO HAY 2 EN EXISTENCIA ", "mt-3 bottom_20 text_existencia");
                $text = d($text, 'text-en-existencia');
                if (strlen($url_ml) > 10) {
                    $text .= a_enid(
                        text_icon('fa fa-check-circle', "ADQUIÉRELO EN MERCADO LIBRE")
                        ,
                        [
                            "href" => $url_ml,
                            "class" => "black "
                        ]);
                }
                return $text;
            }
        }
    }
    if (!function_exists('valida_editar_servicio')) {
        function valida_editar_servicio($usuario_servicio, $id_usuario, $in_session, $id_servicio, $id_perfil)
        {

            $response = "";
            if ($in_session == 1) {
                $href = path_enid("editar_producto", $id_servicio);
                $editar_button = d(
                    a_enid(
                        text_icon('fa fa-pencil', "EDITAR"),
                        [
                            "href" => $href,
                            "class" => "white"
                        ]
                    ), 'a_enid_black_sm editar_button'
                );

                $response = ($id_usuario == $usuario_servicio || $id_perfil != 20) ? $editar_button : "";
            }
            return $response;
        }
    }
    if (!function_exists('valida_text_servicio')) {
        function valida_text_servicio($flag_servicio, $precio_unidad, $id_ciclo_facturacion)
        {


            if ($flag_servicio == 1) {

                $response = ($id_ciclo_facturacion != 9 && $precio_unidad > 0) ? add_text($precio_unidad, "MXN") : "";

            } else {

                $response = ($precio_unidad > 0) ? $precio_unidad . "MXN" : "A CONVENIR";
            }

            return $response;
        }

    }
    if (!function_exists('construye_seccion_imagen_lateral')) {
        function construye_seccion_imagen_lateral($param, $nombre_servicio, $url_youtube = "")
        {

            $preview = [];
            $imgs_grandes = [];
            $z = 0;
            foreach ($param as $row) {


                $url = get_url_servicio($row["nombre_imagen"], 1);
                $extra_class = "";
                $extra_class_contenido = '';

                if ($z < 1) {
                    $extra_class = ' active ';
                    $extra_class_contenido = ' in active ';
                }

                $producto_tab = "#imagen_tab_" . $z;
                $producto_tab_s = "imagen_tab_" . $z;


                $preview[] = d(
                    img(
                        [
                            'src' => $url,
                            'alt' => $nombre_servicio,
                            'class' => 'imagen-producto border border padding_5 top_10 bg_white shadow  rounded hover_padding'
                        ]),
                    [
                        'id' => $z,
                        'data-toggle' => 'tab',
                        'class' => ' preview_enid cursor_pointer' . $extra_class,
                        'href' => $producto_tab

                    ]
                );

                $imgs_grandes[] = d(
                    img(
                        [
                            'src' => $url,
                            "class" => "imagen_producto_completa"
                        ]
                    ),
                    [
                        "id" => $producto_tab_s,
                        "class" => "tab-pane fade zoom " . $extra_class_contenido . " "
                    ]);

                $z++;

            }

            $response = [
                "preview" => append($preview),
                "num_imagenes" => count($param),
                "imagenes_contenido" => append($imgs_grandes)
            ];
            return $response;

        }
    }
    if (!function_exists('valida_url_youtube')) {

        function valida_url_youtube($url_youtube, $is_mobile)
        {

            $url = "";
            if (strlen($url_youtube) > 5) {

                $height = ($is_mobile == 0) ? "600px" : "400px";
                $url = iframe([
                    "width" => '100%',
                    "height" => $height,
                    "src" => $url_youtube,
                    "frameborder" => '0',
                    "allow" => 'autoplay'

                ]);
            }
            return $url;
        }
    }
    if (!function_exists('get_tienda_vendedor')) {
        function get_tienda_vendedor($proceso_compra, $id_vendedor)
        {

            $response = "";
            if ($proceso_compra == 0) {

                $response = d(a_enid(
                    "Ir a la tienda del vendedor",
                    [
                        'href' => path_enid("search_q3", $id_vendedor),
                        'class' => "a_enid_black d-block"
                    ]
                ), 1);


            }

            return $response;
        }

    }
    if (!function_exists('get_solicitud_informacion')) {
        function get_solicitud_informacion($proceso_compra, $id_servicio)
        {


            return a_enid(d("SOLICITAR INFORMACIÓN", 'black_enid_background white padding_10', 1), path_enid("pregunta_search", $id_servicio));

        }
    }
    if (!function_exists('agregar_lista_deseos')) {

        function agregar_lista_deseos($proceso_compra, $in_session)
        {

            if ($proceso_compra == 0) {

                $btn = a_enid(d(
                    text_icon("fa fa-gift fa-x2", "AGREGAR A TU LISTA DE DESEOS ")
                    ,
                    "a_enid_black"
                    , 1
                ),
                    [
                        'class' => 'agregar_a_lista',
                        'href' => path_enid("login")
                    ]
                );

                if ($in_session == 1) {
                    $btn = d(
                        d(
                            text_icon("fa fa-gift", "AGREGAR A TU LISTA DE DESEOS"),

                            "a_enid_black agregar_a_lista_deseos"
                            , 1
                        ),
                        [
                            "id" => 'agregar_a_lista_deseos_add'
                        ]
                    );

                }
                return $btn;

            }
        }
    }
    if (!function_exists('get_tiempo_entrega')) {
        function get_tiempo_entrega($proceso_compra, $tiempo_entrega)
        {

            return ($proceso_compra == 0) ? d($tiempo_entrega, 1) : "";
        }
    }
    if (!function_exists('get_nombre_vendedor')) {
        function get_nombre_vendedor($proceso_compra, $usuario, $id_vendedor)
        {

            return ($proceso_compra == 0) ? d(crea_nombre_publicador_info($usuario, $id_vendedor), 1) : "";

        }
    }
    if (!function_exists('get_info_vendedor')) {

        function get_info_vendedor($entregas_en_casa, $flag_servicio, $proceso_compra, $telefono_visible, $in_session, $usuario)
        {

            $r[] = d(get_entrega_en_casa($entregas_en_casa, $flag_servicio));
            $r[] = get_contacto_cliente($proceso_compra, $telefono_visible, $in_session, $usuario);
            return d(append($r), 1);

        }
    }

}