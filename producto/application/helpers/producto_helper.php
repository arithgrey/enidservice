<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_tipo_entrega($data)
    {
        $orden_pedido =  $data["orden_pedido"];
        $id_servicio =  $data["id_servicio"];
        $r[] = br(3);
        $r[] = d(h("SELECCIONA TU TIPO DE ENTREGA", 3, "text-center"), "col-lg-4 col-lg-offset-4 mb-5", 1);
        $r[] = btw(
            mensajeria($id_servicio, $orden_pedido)
            ,
            punto_entrega($id_servicio, $orden_pedido)
            ,

            8, 1, 1
        );

        $r[] = d(
            pre_pedido(
                $data["url_imagen_servicio"],
                $orden_pedido,
                $data["plan"],
                $data["extension_dominio"],
                $data["ciclo_facturacion"],
                $data["is_servicio"],
                $data["q2"],
                $data["num_ciclos"],
                $id_servicio,
                $data["carro_compras"],
                $data["id_carro_compras"]
            )
            ,
            2,
            1,
            1
        );
        $r[] = br(4);
        return append($r);

    }

    function no_encontrado()
    {
        $l = [
            "- Revisa la " . strong("ortografía de la palabra."),
            "- Utiliza palabras " . strong("más simples o menos palabras."),
            "- Navega por categorías"
        ];
        return d(d(d(h("No hay productos que coincidan con tu búsqueda.", 3) . ul($l)), "caption"), "container");
    }

    function render_producto($data)
    {
        $inf_servicio = $data["info_servicio"];
        $imgs = $data["imgs"];
        $in_session = $data["in_session"];
        $proceso_compra = $data["proceso_compra"];
        $tiempo_entrega = $data["tiempo_entrega"];
        $usuario = $data["usuario"];
        $desc_web = $data["desc_web"];
        $q2 = $data["q2"];
        $is_mobile = $data["is_mobile"];
        $id_publicador = $data["id_publicador"];
        $s = $inf_servicio["servicio"];
        $id_servicio = pr($s, "id_servicio");
        $nombre = pr($s, "nombre_servicio");
        $es_servicio = pr($s, "flag_servicio");
        $es_nuevo = pr($s, "flag_nuevo");
        $url_yt = pr($s, "url_vide_youtube");
        $existencia = pr($s, "existencia");
        $color = pr($s, "color");
        $precio = pr($s, "precio");
        $id_ciclo_facturacion = pr($s, "id_ciclo_facturacion");
        $entregas_en_casa = pr($s, "entregas_en_casa");
        $tel_visible = pr($s, "telefono_visible");
        $nombre = substr(strtoupper($nombre), 0, 70);
        $boton_editar = editar(pr($s, "id_usuario"), $data["id_usuario"], $in_session, $id_servicio, $data["id_perfil"]);
        $imagenes = img_lateral($imgs, $nombre, $url_yt);

        $c[] =
            d(
                btw(

                    d($imagenes["preview"], "thumbs padding_10 bg_black")
                    ,
                    d(d($imagenes["imagenes_contenido"], "tab-content"), "big")
                    ,
                    ""
                    ,
                    1
                ), "col-lg-6 left-col contenedor_izquierdo");


        $c[] = central(
            $proceso_compra,
            $tiempo_entrega,
            $color,
            $es_servicio,
            $es_nuevo,
            $usuario,
            $id_publicador,
            $tel_visible,
            $is_mobile,
            0
        );


        $r[] = append($c);



        if ($es_servicio < 1):
            $nombre_producto = d(h($nombre, 1, "text-justify  strong "), "top_50 bottom_30");
            if ($existencia > 0):

                $x[] = venta_producto(
                    $nombre,
                    $boton_editar,
                    $nombre_producto,
                    $es_servicio,
                    $existencia,
                    $id_servicio,
                    $in_session,
                    $q2,
                    $precio,
                    $id_ciclo_facturacion,
                    $data["tallas"],
                    $entregas_en_casa,
                    $proceso_compra,
                    $tel_visible,
                    $usuario,
                    pr($s, "venta_mayoreo"),
                    pr($s, "deseado"),
                    $id_publicador,
                    $is_mobile);


            else:

                $x[] = no_visible($nombre_producto, $precio, $existencia, $es_servicio,/* */ $id_servicio);

            endif;

        else:

            $f[] = d(h(substr(strtoupper($nombre), 0, 70), 2), "top_50");
            $f[] = h(
                text_servicio(
                    $es_servicio,
                    $precio,
                    $id_ciclo_facturacion
                ),
                3,
                'card-title pricing-card-title '
            );

            $f[] = frm_compra($es_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion);
            $x[] = d(append($f));

        endif;

        $r[] = d(append($x), "col-lg-3  ");
        $response[] = addNRow(d(append($r), "product-detail contenedor_info_producto mt-5 col-lg-12"));
        $response[] = addNRow(d("", "place_valoraciones" ) , "top_100");
        $response[] = addNRow(d(d("","place_tambien_podria_interezar top_100") , 8,1));
        $response[] = addNRow(d(desc_servicio(pr($s, "descripcion"), $es_servicio, $url_yt, $is_mobile),8,1));
        $response[] = input_hidden(["class" => "qservicio", "value" => $nombre]);
        $response[] = input_hidden(["name" => "servicio", "class" => "servicio", "value" => $id_servicio]);
        $response[] = input_hidden(["name" => "desde_valoracion", "value" => $data["desde_valoracion"], "class" => 'desde_valoracion']);
        return d(append($response), "top_30");


    }

    function no_visible($nombre, $precio, $existencia, $es_servicio, $id_servicio)
    {

        $r[] = d($nombre, "card-header");
        $r[] = disponibilidad($precio, $existencia, $es_servicio,  $id_servicio);
        return d(append($r), "card box-shadow");

    }

    function disponibilidad($precio, $existencia, $es_servicio,  $id_servicio)
    {

        $r[] = heading($precio . "MXN" . text_diponibilidad($existencia, $es_servicio),
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

    function ventas_efectivas($deseado)
    {

        return ($deseado > 0) ? d($deseado . " VENTAS EN LOS ÚLTIMOS 2 MESES", "top_50 ") : "";

    }

    function venta_producto($nombre_servicio,
                            $boton_editar,
                            $nombre_producto,
                            $es_servicio, $existencia,
                            $id_servicio, $in_session, $q2,
                            $precio, $id_ciclo_facturacion,
                            $tallas,

                            $entregas_en_casa,
                            $proceso_compra,
                            $tel_visible,
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
        $r[] = h(text_servicio($es_servicio, $precio, $id_ciclo_facturacion), 3);
        $r[] = frm_compra($es_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion);
        $r[] = $tallas;
        $r[] = text_diponibilidad($existencia, $es_servicio);
        $r[] = ventas_efectivas($deseado);
        $r[] = inf_vendedor($nombre_servicio, $entregas_en_casa, $es_servicio, $proceso_compra, $tel_visible, $in_session, $usuario);
        $r[] = d(precio_mayoreo($es_servicio, $venta_mayoreo), 1);
        $r[] = d(formas_pago(), 1);
        $r[] = d(agregar_lista_deseos(0, $in_session), "top_30 bottom_30  l_deseos padding_10 white");
        $r[] = d(solicitud_inf($id_servicio, $es_servicio),"top_20 bottom_20 text-right");

        return append($r);

    }

    function frm_compra($es_servicio, $existencia, $id_servicio, $in_session, $q2)
    {

        $response = "";
        if ($es_servicio < 1):

            $response = ($existencia > 0) ? get_frm($id_servicio, $es_servicio, $existencia, $in_session, $q2) : $response;

        else:

            $response = frm_servicio($id_servicio);

        endif;
        return $response;
    }

    function mensajeria($id_servicio, $orden_pedido)
    {

        $r[] = d(icon('fa fa-truck fa-3x'));
        $r[] = d(h("MENSAJERÍA", 4), "title");
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

    function central($proceso_compra,
                     $tiempo_entrega, $color, $es_servicio,
                     $es_nuevo, $usuario, $id_publicador,
                      $tel_visible, $es_mobile, $pos)
    {




        $r[] = nombre_vendedor($proceso_compra, $usuario, $id_publicador);
        if ($proceso_compra == 1) {
            $r[] = tiempo_entrega(0, $tiempo_entrega);
        }
        $r[] = tb_colores($color, $es_servicio);
        $r[] = get_tipo_articulo($es_nuevo, $es_servicio);

        $r[] = tiempo_entrega($proceso_compra, $tiempo_entrega);
        if ($tel_visible > 0 && $es_servicio > 0) {


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
        $r[] = social($proceso_compra, 1);
        $r[] = place("solid_1 bottom_100 top_15");

        $response = [];
        if (($pos < 1 && $es_mobile < 1) || ($pos > 0 && $es_mobile > 0)) {

            $response[] = d(d(append($r),
                [
                    "class" => " d-flex flex-column justify-content-between h_450",

                ], 1), 3);

        }

        return append($response);


    }


    function get_frm($id_servicio, $es_servicio, $existencia, $in_session, $q2)
    {

        $url = "../producto/?producto=" . $id_servicio . "&pre=1";
        $r[] = '<form action="' . $url . '" id="AddToCartForm" method="POST" >';
        $r[] = form_hidden([
            "plan" => $id_servicio,
            "extension_dominio" => "",
            "ciclo_facturacion" => "",
            "is_servicio" => $es_servicio,
            "q2" => $q2
        ]);
        $r[] = ajustar(
            d("PIEZAS", "text_piezas"),
            select_cantidad_compra($es_servicio, $existencia)


        );

        $r[] = btn("COMPRAR",
            [

                'class' => "top_50 shadow"
            ],
            1,
            1);
        $r[] = form_close();
        $r[] = br(3);
        return d(append($r), "contenedor_form");


    }

    function frm_servicio($id_servicio)
    {

        $r[] = '<form action="../procesar/?w=1" method="POST" >';
        $r[] = form_hidden(["id_servicio" => $id_servicio, "es_servicio" => 1]);
        $r[] = btn(
            "COTIZAR ",
            [
                'class' => "top_30 shadow bottom_30"

            ],
            1,
            1);
        $r[] = form_close();
        return d(append($r), "contenedor_form");


    }
    function max_compra($es_servicio, $existencia)
    {

        return ($es_servicio == 1) ? 100 : $existencia;

    }

    if (!function_exists('url_post')) {
        function url_post($id_servicio)
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

            return strip_tags(implode(",", $array));
        }
    }
    if (!function_exists('select_cantidad_compra')) {
        function select_cantidad_compra($es_servicio, $existencia)
        {

            $config = [
                "name" => "num_ciclos",
                "class" => "telefono_info_contacto form-control",
                "id" => "num_ciclos"
            ];

            $select[] = "<select " . add_attributes($config) . ">";
            for ($a = 1; $a < max_compra($es_servicio, $existencia); $a++) {

                $select[] = "<option value=" . $a . ">" . $a . "</option>";
            }
            $select[] = "</select>";
            return append($select);
        }
    }
    if (!function_exists('get_text_costo_envio')) {
        function get_text_costo_envio($es_servicio, $param)
        {

            return ($es_servicio == 0 && es_data($param) && array_key_exists("text_envio", $param)) ? $param["text_envio"]["cliente"] : "";

        }
    }
    if (!function_exists('desc_servicio')) {
        function desc_servicio($descripcion, $es_servicio, $url_vide_youtube, $is_mobile)
        {


            $r = [];
            if (strlen(trim(strip_tags($descripcion))) > 10) {

                $r[] =  ajustar( valida_url_youtube($url_vide_youtube, $is_mobile) ,$descripcion, 8 , "top_100");

            }
            return append($r);


        }

    }
    if (!function_exists('contacto_cliente')) {
        function contacto_cliente($nombre_producto, $proceso_compra, $tel_visible, $in_session, $usuario)
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
                $response = d(a_enid($inf, "https://wa.me/" . $usr["tel_lada"] . $tel . "?text=Hola me puedes dar precio sobre tu " . $nombre_producto), 1);
            }
            return $response;


        }
    }
    if (!function_exists('entrega_en_casa')) {

        function entrega_en_casa($entregas_en_casa, $es_servicio)
        {

            $response = "";
            if ($entregas_en_casa == 1) {

                $text = ($es_servicio == 1) ?
                    "EL VENDEDOR TAMBIÉN BRINDA ATENCIÓN EN SU NEGOCIO" :
                    "PUEDES COMPRAR EN EL NEGOCIO DEL VENDEDOR";
                $response = text_icon("fa fa-check-circle", $text);

            }

            return $response;
        }

    }
    if (!function_exists('crea_nombre_publicador_info')) {
        function crea_nombre_publicador_info($usuario, $id_usuario)
        {

            $response = [];
            if (es_data($usuario)) {

                $nombre = $usuario[0]["nombre"];
                $response[] = br(3);
                $response[] = a_enid(
                    ajustar("VENDIDO POR ", span($nombre, "nombre_vendedor underline text-right"), 6),

                    [
                        "href" => path_enid("search", "/?q3=" . $id_usuario . "&vendedor=" . $nombre),
                        'class' => 'informacion_vendedor_descripcion  black '
                    ]
                );
            }

            return append($response);

        }
    }
    if (!function_exists('get_tipo_articulo')) {
        function get_tipo_articulo($es_nuevo, $es_servicio)
        {


            return ($es_servicio == 0 && $es_nuevo == 0) ? d(li('ARTÍCULO USADO'), 1) : "";

        }
    }
    if (!function_exists('precio_mayoreo')) {
        function precio_mayoreo($es_servicio, $venta_mayoreo)
        {



            $r[] =($es_servicio == 0 && $venta_mayoreo == 1) ? text_icon('fa fa-check-circle', "VENTAS MAYORISTAS ") : "";
            $r[] = d(text_icon('fa fa-check-circle', "COMPRAS CONTRA ENTREGA"));
            return append($r);


        }
    }

    if (!function_exists('formas_pago')) {
        function formas_pago()
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


    if (!function_exists('tb_colores')) {

        function tb_colores
        ($text_color, $es_servicio)
        {


            $response = "";
            if (!is_null($text_color)) {
                $final = "";
                if ($es_servicio == 0) {
                    $arreglo_colores = explode(",", $text_color);
                    $num_colores = count($arreglo_colores);
                    $info_title = (count($arreglo_colores) > 0) ? (($num_colores > 1) ? "COLORES DISPONIBLES" : "COLOR DISPONIBLE") : "";

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
                        $final .= d($info_title, ' letter-spacing-5 bottom_10');
                        $final .= $info;
                        $final = d($final, 'contenedor_informacion_colores');

                    }
                    $response = d($final, 1);
                }

            }
            return $response;


        }

    }
    if (!function_exists('text_diponibilidad')) {
        function text_diponibilidad($existencia, $es_servicio)
        {
            if ($es_servicio == 0 && $existencia > 0) {
                $text = d(d("APRESÚRATE! SOLO HAY 2 EN EXISTENCIA ", "mt-3 bottom_20 f14"), 'text-center text-en-existencia');
                return $text;
            }
        }
    }
    if (!function_exists('editar')) {
        function editar($usuario_servicio, $id_usuario, $in_session, $id_servicio, $id_perfil)
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
    if (!function_exists('text_servicio')) {
        function text_servicio($es_servicio, $precio_unidad, $id_ciclo_facturacion)
        {


            if ($es_servicio == 1) {

                $response = ($id_ciclo_facturacion != 9 && $precio_unidad > 0) ? add_text($precio_unidad, "MXN") : "";

            } else {

                $response = ($precio_unidad > 0) ? $precio_unidad . "MXN" : "A CONVENIR";
            }

            return $response;
        }

    }
    if (!function_exists('img_lateral')) {
        function img_lateral($param, $nombre_servicio, $url_youtube = "")
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

                $preview[] = d(
                    img(
                        [
                            'src' => $url,
                            'alt' => $nombre_servicio,
                            'class' => 'imagen-producto border border padding_5 top_10 bg_white shadow  rounded hover_padding'
                        ]
                    ),
                    [
                        'id' => $z,
                        'data-toggle' => 'tab',
                        'class' => ' preview_enid cursor_pointer' . $extra_class,
                        'href' => "#imagen_tab_" . $z

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
                        "id" => "imagen_tab_" . $z,
                        "class" => "tab-pane fade zoom " . $extra_class_contenido . " "
                    ]
                );

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


                $url = iframe([
                    "width" => '100%',
                    "height" => ($is_mobile == 0) ? "500px" : "400px",
                    "src" => $url_youtube,
                    "frameborder" => '0',
                    "allow" => 'autoplay'

                ]);
            }
            return $url;
        }
    }


    if (!function_exists('solicitud_inf')) {
        function solicitud_inf($id_servicio, $es_servicio)
        {


            $r = [];
            if ($es_servicio < 1) {

                $r[] =
                    a_enid(
                        "MÁS INFORMACIÓN"
                        ,
                        [

                            "href" => path_enid("pregunta_search", $id_servicio),
                            "class" => "black"

                        ]


                    );
            }

            return append($r);

        }
    }
    if (!function_exists('agregar_lista_deseos')) {

        function agregar_lista_deseos($proceso_compra, $in_session)
        {

            if ($proceso_compra == 0) {

                $btn = a_enid(d(
                    text_icon("fa fa-gift fa-x2", "AGREGAR A TU LISTA DE DESEOS ")

                    , 1
                ),
                    [
                        'class' => 'agregar_a_lista white',
                        'href' => path_enid("login")
                    ]
                );

                if ($in_session == 1) {
                    $btn = d(
                        d(
                            text_icon("fa fa-gift", "AGREGAR A TU LISTA DE DESEOS"),

                            "agregar_a_lista_deseos white"
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
    if (!function_exists('tiempo_entrega')) {
        function tiempo_entrega($proceso_compra, $tiempo_entrega)
        {

            return ($proceso_compra == 0) ? d($tiempo_entrega, 1) : "";
        }
    }
    if (!function_exists('nombre_vendedor')) {
        function nombre_vendedor($proceso_compra, $usuario, $id_vendedor)
        {

            return ($proceso_compra == 0) ? d(crea_nombre_publicador_info($usuario, $id_vendedor), 1) : "";

        }
    }
    if (!function_exists('inf_vendedor')) {

        function inf_vendedor($nombre_producto, $entregas_en_casa, $es_servicio, $proceso_compra, $tel_visible, $in_session, $usuario)
        {

            $r[] = d(entrega_en_casa($entregas_en_casa, $es_servicio));
            $r[] = contacto_cliente($nombre_producto, $proceso_compra, $tel_visible, $in_session, $usuario);
            return d(append($r), 1);

        }
    }

    function punto_entrega($id_servicio, $orden_pedido)
    {

        $r[] = d(img(["src" => "../img_tema/linea_metro/metro.jpg", "class" => "icono_metro"]));
        $r[] = d(h("UN PUNTO MEDIO", 4), "title");
        $r[] = d(d("PAGO CONTRA ENTREGA "), "text");
        $response = d(append($r), "shadow  align-items-center box-part text-center border mh-selector d-flex flex-column justify-content-center");
        return d($response, [
            "class" => "col-lg-6 cursor_pointer",
            "onclick" => "carga_opcion_entrega(1, " . $id_servicio . "  ,  " . $orden_pedido . " );"
        ]);

    }

    function pre_pedido($url_imagen_servicio, $orden_pedido, $plan, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $id_servicio, $carro_compras, $id_carro_compras)
    {

        $r = [];

        if ($orden_pedido > 0) {


            $r[] = frm_pre_pedido($plan, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $carro_compras, $id_carro_compras);
            $r[] = frm_pre_contact($plan, $num_ciclos, $carro_compras, $id_carro_compras);
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
    function frm_pre_pedido($plan, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $carro_compras, $id_carro_compras)
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

    function frm_pre_contact($plan, $num_ciclos, $carro_compras, $id_carro_compras)
    {


        $r[] = '<form class="frm_pre_contact" action="../contact/?w=1" method="POST">';
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
    /*
     * if (!function_exists('text_periodo_compra')) {
        function text_periodo_compra($es_servicio)
        {

            return ($es_servicio == 0) ? "Piezas" : "";

        }
    }
    */
}