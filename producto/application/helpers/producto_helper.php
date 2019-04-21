<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_no_visible($nombre_producto, $precio, $existencia, $flag_servicio, $url_ml, $id_servicio)
    {

        $r[] = div($nombre_producto, ["class" => "card-header"]);
        $r[] = get_format_disponibilidad($precio, $existencia, $flag_servicio, $url_ml, $id_servicio);
        return div(append_data($r), ["class" => "card box-shadow"]);

    }

    function get_format_disponibilidad($precio, $existencia, $flag_servicio, $url_ml, $id_servicio)
    {

        $r[] = heading($precio . "MXN" . get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml),
            1,
            ["class" => "card-title pricing-card-title"]
        );

        $r[] = ul([
            "Artículo temporalmente agotado",
            anchor_enid(
                "Preguntar cuando estará disponible",
                ["href" => "../pregunta/?tag=" . $id_servicio . "&disponible=1"],
                1,
                1
            )

        ],
            ["class" => "list-unstyled mt-3 mb-4"]);
        return append_data($r);

    }

    function get_format_ventas_efectivas($deseado)
    {


        $text =
            ($deseado > 0) ? div($deseado . " VENTAS EN LOS ÚLTIMOS 2 MESES", ["class" => "top_50 "]) : "";
        return $text;


    }

    function get_format_venta_producto($boton_editar, $estrellas, $nombre_producto, $nuevo_nombre_servicio,
                                       $flag_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion, $tallas, $texto_en_existencia, $entregas_en_casa, $proceso_compra,
                                       $telefono_visible, $usuario, $venta_mayoreo, $deseado)
    {

        $r[] = $boton_editar;

        $r[] = $nombre_producto;
        $r[] = $estrellas;
        $r[] = heading_enid($nuevo_nombre_servicio, 3);
        $r[] = validate_form_compra($flag_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion);
        $r[] = $tallas;
        $r[] = get_format_ventas_efectivas($deseado);
        $r[] = $texto_en_existencia;

        $r[] = get_info_vendedor($entregas_en_casa, $flag_servicio, $proceso_compra, $telefono_visible, $in_session, $usuario);

        $r[] = div(valida_informacion_precio_mayoreo($flag_servicio, $venta_mayoreo), 1);

        return append_data($r);

    }

    function validate_form_compra($flag_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion)
    {

        $response = "";
        if ($flag_servicio == 0):
            if ($existencia > 0):
                $response = get_form_compra($id_servicio, $flag_servicio, $existencia, $in_session, $q2);
            endif;
        else:
            if ($precio > 0 && $id_ciclo_facturacion != 9): ;
                $response = get_form_compra($id_servicio, $flag_servicio, $existencia, $in_session, $q2);
            endif;
        endif;
        return $response;
    }

    function get_format_eleccion_contra_entrega($id_servicio,$orden_pedido)
    {

        $r[] = div(img(["src" => "..//img_tema/linea_metro/metro.jpg", "class" => "icono_metro"]));
        $r[] = div(heading_enid("PAGO CONTRA ENTREGA", 3), ["class" => "title"]);
        $r[] = div(div("UN PUNTO MEDIO "), ["class" => "text"]);
        $response = div(append_data($r), ["class" => "shadow  align-items-center box-part text-center border mh-selector d-flex flex-column justify-content-center"]);
        return div($response, [
            "class" => "col-lg-6 cursor_pointer",
            "onclick" => "carga_opcion_entrega(1, " . $id_servicio . "  ,  " . $orden_pedido . " );"
        ]);

    }

    function get_format_eleccion_mensajeria($id_servicio, $orden_pedido)
    {

        $r[] = div(icon('fa fa-truck fa-3x'));
        $r[] = div(heading_enid("POR MENSAJERÍA", 3), ["class" => "title"]);
        $r[] = div("QUE LLEGUE A TU CASA U OFICINA", ["class" => "text"]);
        $response = div(append_data($r), ["class" => " shadow align-items-center box-part text-center border mh-selector d-flex flex-column justify-content-center"]);
        $response = div($response, [
            "class" => "col-lg-6 cursor_pointer",
            "onclick" => "carga_opcion_entrega(2, " . $id_servicio . "  ,  " . $orden_pedido . " );"
        ]);
        return $response;


    }

    function get_contenedor_central($proceso_compra, $id_servicio, $tiempo_entrega, $color, $flag_servicio, $flag_nuevo, $usuario, $id_publicador, $url_actual, $desc_web)
    {


        $url_facebook = get_url_facebook($url_actual);
        $url_twitter = get_url_twitter($url_actual, $desc_web);
        $url_pinterest = get_url_pinterest($url_actual, $desc_web);
        $url_tumblr = get_url_tumblr($url_actual, $desc_web);


        $r[] = get_solicitud_informacion($proceso_compra, $id_servicio);

        if ($proceso_compra == 1) {
            $r[] = get_tiempo_entrega(0, $tiempo_entrega);
        }

        $r[] = creta_tabla_colores($color, $flag_servicio);
        $r[] = get_tipo_articulo($flag_nuevo, $flag_servicio);
        $r[] = get_nombre_vendedor($proceso_compra, $usuario, $id_publicador);
        $r[] = get_tiempo_entrega($proceso_compra, $tiempo_entrega);
        $r[] = get_social($url_actual, $url_facebook, $url_twitter, $url_pinterest, $url_tumblr, $proceso_compra);
        $r[] = get_tienda_vendedor($proceso_compra, $id_publicador);
        $r[] = place("", ["style" => "border: solid 1px"]);

        return div(append_data($r),
            [
                "class" => " d-flex flex-column justify-content-between ",
                "style" => "height: 450px;"
            ], 1);

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
        $response = div(append_data($r));
        return $response;


    }

    function form_pre_pedido_contact($plan, $num_ciclos, $carro_compras, $id_carro_compras)
    {


        $r[] = '<form class="form_pre_pedido_contact" action="../contact/?w=1" method="POST">';
        $r[] = input_hidden(["class" => "servicio", "name" => "servicio", "value" => $plan]);
        $r[] = input_hidden(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["class" => "carro_compras", "name" => "carro_compras", "value" => $carro_compras]);
        $r[] = input_hidden(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = form_close();
        return append_data($r);

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
        return append_data($r);

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

        return append_data($r);

    }


    function get_social($url_actual, $url_facebook, $url_twitter, $url_pinterest, $url_tumblr, $proceso_compra)
    {

        $response = "";
        if ($proceso_compra < 1) {


            $r[] = anchor_enid("", [
                "href" => $url_facebook,
                "target" => "_black",
                "class" => "fa fa-facebook black"
            ]);

            $r[] = anchor_enid("", [
                "href" => "https://www.instagram.com/enid_service/",
                "class" => "fa fa-instagram  black",
                "title" => "Tumblr"
            ]);

            $r[] = anchor_enid("",
                [
                    "class" => "fa fa-twitter black",
                    "title" => "Tweet",
                    "target" => "_black",
                    "data-size" => "large",
                    "href" => $url_twitter,
                ]);
            $r[] = anchor_enid("", [
                "href" => $url_pinterest,
                "class" => "fa fa-pinterest-p black",
                "title" => "Pin it"
            ]);

            $r[] = anchor_enid("", [
                "href" => $url_tumblr,
                "class" => "fa fa-tumblr black",
                "title" => "Tumblr"
            ]);


            //$r[] = mailto("ventas@enidservice.com", icon("fa fa-envelope-open black"));

            $social = append_data($r);
            $response = div($social, ["class" => "contenedor_social display_flex_enid mt-5"]);
        }
        return div($response, 1);

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
        $r[] = get_btw(div("PIEZAS", ["class" => "text_piezas mr-3"]), select_cantidad_compra($flag_servicio, $existencia), "display_flex_enid");

        $r[] = guardar("ORDENAR ",
            [
                'id' => 'AddToCart',
                'class' => "top_30"
            ],
            1,
            1);
        $r[] = form_close();
        $r[] = div(agregar_lista_deseos(0, $in_session), ["class" => "top_30"]);
        return div(append_data($r), ["class" => "contenedor_form"]);


    }

    function valida_maximo_compra($flag_servicio, $existencia)
    {

        if ($flag_servicio == 1) {
            return 100;
        } else {
            return $existencia;
        }
    }

    if (!function_exists('get_url_imagen_post')) {
        function get_url_imagen_post($id_servicio)
        {
            return "http://enidservice.com/inicio/imgs/index.php/enid/imagen_servicio/" . $id_servicio . "/";
        }
    }
    if (!function_exists('costruye_meta_keyword')) {
        function costruye_meta_keyword($servicio)
        {

            $metakeyword = $servicio["metakeyword"];
            $metakeyword_usuario = $servicio["metakeyword_usuario"];
            $nombre_servicio = $servicio["nombre_servicio"];
            $descripcion = $servicio["descripcion"];


            $array = explode(",", $metakeyword);
            array_push($array, $nombre_servicio);
            array_push($array, $descripcion);
            array_push($array, " precio ");
            if (strlen(trim($metakeyword_usuario)) > 0) {
                array_push($array, $metakeyword_usuario);
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

            $select = "<select " . add_attributes($config) . ">";

            for ($a = 1; $a < valida_maximo_compra($flag_servicio, $existencia); $a++) {

                $select .= "<option value=" . $a . ">" . $a . "</option>";
            }
            $select .= "</select>";
            return $select;
        }
    }
    if (!function_exists('get_text_periodo_compra')) {
        function get_text_periodo_compra($flag_servicio)
        {
            if ($flag_servicio == 0) {
                return "Piezas";
            }
        }
    }

    if (!function_exists('get_text_costo_envio')) {
        function get_text_costo_envio($flag_servicio, $param)
        {

            if ($flag_servicio == 0) {
                return $param["text_envio"]["cliente"];
            }
        }
    }
    if (!function_exists('get_descripcion_servicio')) {
        function get_descripcion_servicio($descripcion, $flag_servicio, $url_vide_youtube, $is_mobile)
        {

            $servicio = ($flag_servicio == 1) ? "SOBRE EL SERVICIO" : "SOBRE EL PRODUCTO";
            $r = [];
            if (strlen(trim(strip_tags($descripcion))) > 10) {

                $r[] = div("", ["id" => "video"], 1);
                $x[] = heading_enid($servicio, 3, ["class" => 'titulo_sobre_el_producto letter-spacing-10']);
                $x[] = div(strip_tags($descripcion), ["class" => "mt-5"]);

                $text = div(append_data($x),
                    [
                        "class" => "d-flex flex-column justify-content-center sobre_el_producto"
                    ]
                );
                $r[] = div($text, 6);
                $r[] = div(valida_url_youtube($url_vide_youtube, $is_mobile), 6);

            }
            $response = append_data($r);
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
                    $inf .= div(icon("fa fa-phone") . $contacto);
                }
                if ($ftel2 == 1) {
                    $lada = (strlen($usr["lada_negocio"]) > 0) ? "(" . $usr["lada_negocio"] . ")" : "";
                    $inf .= div(icon('fa fa-phone') . $lada . $tel2);
                }
                $response = div($inf, 1);
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

                $response = icon("fa fa-check-circle") . $text;
            }
            return $response;
        }

    }
    if (!function_exists('crea_nombre_publicador_info')) {
        function crea_nombre_publicador_info($usuario, $id_usuario)
        {

            $nombre = $usuario[0]["nombre"];
            $tienda = '../search/?q3=' . $id_usuario . '&vendedor=' . $nombre;
            $a = anchor_enid(
                "VENDIDO POR " . span($nombre, ["class" => "nombre_vendedor underline "]),
                [
                    "href" => $tienda,
                    'class' => 'informacion_vendedor_descripcion text-justify black '
                ]);

            return $a;

        }
    }
    if (!function_exists('get_tipo_articulo')) {
        function get_tipo_articulo($flag_nuevo, $flag_servicio)
        {

            $usado = div(li('- ARTÍCULO USADO'), 1);
            $text = ($flag_servicio == 0 && $flag_nuevo == 0) ? $usado : "";
            return $text;
        }
    }
    if (!function_exists('valida_informacion_precio_mayoreo')) {
        function valida_informacion_precio_mayoreo($flag_servicio, $venta_mayoreo)
        {

            $text = ($flag_servicio == 0 && $venta_mayoreo == 1) ? icon('fa fa-check-circle') . "VENTAS MAYORISTAS " : "";
            $r[] = div($text, ["class" => "strong"]);
            $r[] = div(icon('fa fa-check-circle') . "COMPRAS CONTRA ENTREGA");
            return append_data($r);


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
                        $info .= div("", ["style" => $style, "class" => "col-lg-4"]);
                        $v++;
                    }
                    if ($v > 0) {

                        $final = "";
                        $final .= div($info_title, ["class" => 'informacion_colores_disponibles letter-spacing-10']);
                        $final .= $info;
                        $final = div($final, ['class' => 'contenedor_informacion_colores']);

                    }
                    $response = div($final, 1);
                }

            }
            return $response;


        }

    }
    if (!function_exists('get_text_diponibilidad_articulo')) {
        function get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml = '')
        {
            if ($flag_servicio == 0 && $existencia > 0) {
                $text = div("APRESÚRATE! SOLO HAY 2 EN EXISTENCIA ", ["class" => "mt-3 bottom_20 text_existencia"]);
                $text = div($text, ['class' => 'text-en-existencia']);
                if (strlen($url_ml) > 10) {
                    $text .= anchor_enid(icon('fa fa-check-circle') . "ADQUIÉRELO EN MERCADO LIBRE", ["href" => $url_ml, "class" => "black "]);
                }
                return $text;
            }
        }
    }
    if (!function_exists('valida_editar_servicio')) {
        function valida_editar_servicio($usuario_servicio, $id_usuario, $in_session, $id_servicio)
        {

            $editar = "";
            if ($in_session == 1) {
                $href = "../planes_servicios/?action=editar&servicio=" . $id_servicio;
                $editar_button = div(anchor_enid(icon('fa fa-pencil') . "EDITAR", ["href" => $href]), ["class" => 'a_enid_black_sm editar_button']);
                $editar = ($id_usuario == $usuario_servicio) ? $editar_button : "";
            }
            return $editar;
        }
    }
    if (!function_exists('valida_text_servicio')) {
        function valida_text_servicio($flag_servicio, $precio_unidad, $id_ciclo_facturacion)
        {

            $response = "";
            if ($flag_servicio == 1) {

                $response = ($id_ciclo_facturacion != 9 && $precio_unidad > 0) ? $precio_unidad . "MXN" : "A CONVENIR";

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


                $preview[] = div(img([
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

                $imgs_grandes[] = div(img([
                    'src' => $url,
                    "class" => "imagen_producto_completa"
                ]),
                    [
                        "id" => $producto_tab_s,
                        "class" => "tab-pane fade zoom " . $extra_class_contenido . " "
                    ]);

                $z++;

            }
            $response["preview"] = append_data($preview);
            $response["num_imagenes"] = count($param);
            $response["imagenes_contenido"] = append_data($imgs_grandes);
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
    if (!function_exists('get_info_producto')) {
        function get_info_producto($q2)
        {

            $id_producto = 0;
            if (isset($q2) && $q2 != null) {
                $id_producto = $q2;
            }
            return $id_producto;
        }
    }
    if (!function_exists('get_tienda_vendedor')) {
        function get_tienda_vendedor($proceso_compra, $id_vendedor)
        {

            $response = "";
            if ($proceso_compra == 0) {

                $response = anchor_enid(
                    "Ir a la tienda del vendedor",
                    [
                        'href' => "../search/?q3=" . $id_vendedor,
                        'class' => "a_enid_black d-block"
                    ]
                );
                $response = div($response, 1);

            }
            return $response;
        }

    }
    if (!function_exists('get_solicitud_informacion')) {
        function get_solicitud_informacion($proceso_compra, $id_servicio)
        {


            return
                anchor_enid(
                    div("SOLICITAR INFORMACIÓN", ['class' => 'black_enid_background white padding_10'], 1),
                    [
                        "href" => "../pregunta?tag=" . $id_servicio
                    ]);

        }
    }
    if (!function_exists('agregar_lista_deseos')) {

        function agregar_lista_deseos($proceso_compra, $in_session)
        {

            if ($proceso_compra == 0) {

                $btn = anchor_enid(div("AGREGAR A TU LISTA DE DESEOS " . icon("fa fa-gift fa-x2"),
                    ["class" => "a_enid_black"], 1),
                    [
                        'class' => 'agregar_a_lista',
                        'href' => "../login/"
                    ]
                );

                if ($in_session == 1) {
                    $btn = div(div(
                        "AGREGAR A TU LISTA DE DESEOS" . icon('fa fa-gift'),
                        ["class" => "a_enid_black agregar_a_lista_deseos"]
                        , 1
                    ),
                        ["id" => 'agregar_a_lista_deseos_add']
                    );

                }
                return $btn;

            }
        }
    }
    if (!function_exists('get_tiempo_entrega')) {
        function get_tiempo_entrega($proceso_compra, $tiempo_entrega)
        {

            return ($proceso_compra == 0) ? div($tiempo_entrega, 1) : "";
        }
    }
    if (!function_exists('get_nombre_vendedor')) {
        function get_nombre_vendedor($proceso_compra, $usuario, $id_vendedor)
        {

            $response = ($proceso_compra == 0) ? div(crea_nombre_publicador_info($usuario, $id_vendedor), 1) : "";

            return $response;


        }
    }
    if (!function_exists('get_info_vendedor')) {

        function get_info_vendedor($entregas_en_casa, $flag_servicio, $proceso_compra, $telefono_visible, $in_session, $usuario)
        {

            $r[] = div(get_entrega_en_casa($entregas_en_casa, $flag_servicio));
            $r[] = get_contacto_cliente($proceso_compra, $telefono_visible, $in_session, $usuario);
            return div(append_data($r), 1);

        }
    }


}