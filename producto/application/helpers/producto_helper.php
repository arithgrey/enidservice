<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

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
        $boton_editar = editar(pr($s, "id_usuario"), $data["id_usuario"], $in_session, $id_servicio, $data["id_perfil"]);
        $imagenes = img_lateral($imgs, $nombre, $is_mobile);


        $r[] = btw(

            d($imagenes["preview"], " align-self-center mx-auto col-lg-2 d-none d-lg-block d-xl-block d-md-block d-xl-none aviso_comision pt-3 pb-3"),
            d($imagenes["imagenes_contenido"], " tab-content col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 col-lg-6 col-lg-offset-3 align-self-center"),
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


            $f[] = _titulo($titulo);

            $str_servicio = text_servicio(
                $es_servicio,
                $precio,
                $id_ciclo_facturacion
            );

            if (strlen($str_servicio) > 0) {
                $f[] = h($str_servicio, 3, 'card-title pricing-card-title ');
            }


            $f[] = frm_compra(
                $s,
                $es_servicio,
                $existencia,
                $id_servicio,
                $q2,
                $tiempo_entrega,
                $proceso_compra
            );
            $x[] = d($f);

        endif;

        $r[] = d($x, 3);
        $producto = append($r);
        $response[] = d(flex("DESCRIPCIÓN", "DETALLES", "flex-row mt-5 mb-5 cursor_pointer", "border_enid text-center p-3 w-100 strong black descripcion_producto cursor_pointer", "border text-center p-3 w-100 strong black descripcion_detallada cursor_pointer"), "col-lg-10 col-lg-offset-1 mt-5  ");
        $response[] = d(desc_servicio($s, $proceso_compra, $data, $imagenes, $in_session), 10, 1);


        $response[] = d("", "place_valoraciones mt-5 col-sm-10 col-sm-offset-1");

        $response[] = d(h("TAMBIÉN PODRÍA INTERESARTE", 2, " mt-5"), "col-lg-10 col-lg-offset-1 mt-5 text_sugerencias d-none ");
        $response[] = d(d("", "place_tambien_podria_interezar bottom_100"), 10, 1);

        $response[] = hiddens(["class" => "qservicio", "value" => $nombre]);
        $response[] = hiddens(["name" => "servicio", "class" => "servicio", "value" => $id_servicio]);
        $response[] = hiddens(["name" => "desde_valoracion", "value" => $data["desde_valoracion"], "class" => 'desde_valoracion']);


        $xx[] = $boton_editar;
        $xx[] = append($response);
        $compra = append($xx);

        $data_response[] = d($producto, 12);
        $data_response[] = d($compra, 12);
        return append($data_response);


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


        $r[] = d(
            a_enid(
                d("",
                    [
                        'class' => 'valoracion_persona_principal valoracion_persona'
                    ]),
                [
                    'class' => 'lee_valoraciones ',
                    'href' => '../search/?q3=' . $id_publicador
                ]
            )
        );
        $r[] = ($es_mobile > 0) ? "" : $nombre_producto;
        $r[] = d(h(text_servicio($es_servicio, $precio, $id_ciclo_facturacion), 2, "mt-4 mb-4 strong color_venta"));


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

        if ($es_comisionista) {

            $comision = pr($servicio, 'comision');
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
        $r[] = agregar_lista_deseos($en_session, $id_servicio);
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

        $id_servicio = pr($servicio, 'id_servicio');
        $usuario = $data["usuario"];
        $tel_visible = pr($servicio, "telefono_visible");
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

        if ($tel_visible > 0) {

            $phone = format_phone(pr($usuario, "tel_contacto"));
            $z[] = _titulo($phone, 4, 'mt-4 mb-4');
        }

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
        $z[] = tb_colores($color, $es_servicio);


        $yt = pr($servicio, "url_vide_youtube");

        $r = [];


        $i = pre_youtube($imgs, $yt);
        $izquierdo = ($i["es_imagen"] > 0) ? "col-lg-7 p-0 " : "col-lg-6 col-sm-12 p-0";
        $derecha = ($i["es_imagen"] > 0) ? "col-lg-5 " : "col-lg-6 col-sm-12 p-0 mt-5 mt-md-0";
        $flex = ($i["es_imagen"] > 0) ? "align-items-center" : ["d-lg-flex "];

        $contenido_descripcion = append($z);

//        $agregar_lista_deseos = agregar_lista_deseos(0, $in_session, $id_servicio);
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

            $editar_button = d(
                a_enid(
                    text_icon('fa fa-pencil', "EDITAR"),
                    [
                        "href" => path_enid("editar_producto", $id_servicio),
                        "class" => "black strong border-bottom p-3"
                    ]
                ), ' mr-5 col-lg-12 text-right '
            );

            $response = ($id_usuario == $usuario_servicio) ? $editar_button : "";
        }
        return $response;
    }

    function text_servicio($es_servicio, $precio_unidad, $id_ciclo_facturacion)
    {

        if ($es_servicio == 1) {

            $response = ($id_ciclo_facturacion != 9 && $precio_unidad > 0) ? add_text(
                $precio_unidad, "MXN") : "";

        } else {

            $response = ($precio_unidad > 0) ? $precio_unidad . "MXN" : "A CONVENIR";
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


            $ext = ($is_mobile < 1) ? "mh_450 mah_450" : "";

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


    function agregar_lista_deseos($in_session, $id_servicio)
    {


        if ($in_session > 0) {

            $response[] = d(format_link(
                d("Agrégalo al Carrito",'border'),
                [
                    "id" => 'agregar_a_lista_deseos_add',
                    "class" => "agregar_a_lista_deseos l_deseos"
                ]
            ),'se_agregara');


            $response[] = d(format_link('Se agregó!',[],0),'se_agrego d-none');


        } else {

            $response[] = format_link(

                d(
                    "Lo deseo "
                    , 'agregar_a_lista border l_deseos'
                ),
                [
                    'class' => 'agregar_deseos_sin_antecedente',
                    'id' => $id_servicio
                ]

            );
        }

        return append($response);


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
