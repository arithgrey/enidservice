<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_tipo_entrega($data)
    {
        $orden_pedido = $data["orden_pedido"];
        $id_servicio = $data["id_servicio"];

        $a = _text_(
            _titulo("SELECCIONA TU TIPO DE ENTREGA")
            ,
            punto_entrega($id_servicio, $orden_pedido)
            ,
            mensajeria($id_servicio, $orden_pedido)
        );

        $b = pre_pedido(
            $data["url_imagen_servicio"],
            $orden_pedido,
            $id_servicio,
            $data["extension_dominio"],
            $data["ciclo_facturacion"],
            $data["is_servicio"],
            $data["q2"],
            $data["num_ciclos"],
            $data["carro_compras"],
            $data["id_carro_compras"]
        );

        $r[] = flex(
            $a,
            $b,

            "d-lg-flex col-lg-8 col-lg-offset-2 mb-5 justify-content-between align-items-center p-md-0"
            ,
            "col-lg-4 p-0",
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

            d($imagenes["preview"], " align-self-center col-lg-2 d-none d-lg-block d-xl-block d-md-block d-xl-none "),
            d($imagenes["imagenes_contenido"], " tab-content col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 col-lg-6 col-lg-offset-3 align-self-center"),
            "d-flex col-lg-9 mb-5"
        );

        $r[] = d($imagenes["preview_mb"], "d-none d-sm-block d-md-none d-flex mt-5 row bg-light");

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

        $response[] = d(h("TAMBIÉN PODRÍA INTERESARTE", 2, "strong mt-5"), "col-lg-10 col-lg-offset-1 mt-5 text_sugerencias d-none ");
        $response[] = d(d("", "place_tambien_podria_interezar bottom_100"), 10, 1);

        $response[] = hiddens(["class" => "qservicio", "value" => $nombre]);
        $response[] = hiddens(["name" => "servicio", "class" => "servicio", "value" => $id_servicio]);
        $response[] = hiddens(["name" => "desde_valoracion", "value" => $data["desde_valoracion"], "class" => 'desde_valoracion']);


        $xx[] = $boton_editar;
        $xx[] = append($response);
        $compra = append($xx);
        return dd($producto, $compra);


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

        $r[] = d(icon('fa fa-truck fa-3x'));
        $r[] = h("MENSAJERÍA", 4, "strong black");
        $r[] = d("LO ENVIAMOS A CASA U OFICINA", "text");

        $response = d($r,
            [
                "class" => "cursor_pointer p-4 mt-5 bg-light mb-5 mh-selector d-flex flex-column justify-content-center selector_entrega ",
                "onclick" => "carga_opcion_entrega(2, " . $id_servicio . " , " . $orden_pedido . " );"
            ]
        );

        return $response;


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
            $text_comisionn = strong(money($comision), 'white f12');
            $text = _text_('gana', $text_comisionn, 'al verder este artículo');
            $class = 'aviso_comision mb-2 white text-uppercase border shadow text-right p-2';
            $response[] = d($text, $class);
        }
        return append($response);

    }

    function get_frm($data, $id_servicio, $es_servicio, $existencia, $q2, $tiempo_entrega)
    {


        $r[] = '<form class="form_pre_pedido" action="../procesar/?w=1" method="POST">';
        $r[] = form_hidden([
            "id_servicio" => $id_servicio,
            "extension_dominio" => "",
            "ciclo_facturacion" => "",
            "is_servicio" => $es_servicio,
            "q2" => $q2
        ]);
        $tipo = (is_mobile()) ? 2 : 4;

        $r[] = ganancia_comisionista($data);
        $r[] = flex(
            _titulo("PIEZAS", $tipo),
            select_cantidad_compra($es_servicio, $existencia)
            , _between
        );
        $r[] = $tiempo_entrega;
        $r[] = btn("Envio a domicilio", ["class" => "text-left mt-5 text-uppercase"]);

        $r[] = d('ó', 'text-center mt-1 mb-1 ');

        $path = _text("../puntos_medios/?producto=", $id_servicio);

        $r[] = form_hidden([
            "id_servicio" => $id_servicio,
            "extension_dominio" => "",
            "ciclo_facturacion" => "",
            "is_servicio" => $es_servicio,
            "q2" => $q2
        ]);
        $r[] = hiddens([
            "class" => "servicio",
            "name" => "servicio",
            "value" => $id_servicio
        ]);

        $r[] = hiddens(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => 0]);
        $r[] = hiddens(["class" => "carro_compras", "name" => "carro_compras", "value" => 0]);
        $r[] = hiddens(["class" => "extension_dominio", "name" => "extension_dominio", "value" => '']);
        $r[] = form_close();


        $r[] = '<form class="form_pre_puntos_medios" action="' . $path . '" method="POST">';
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
            "value" => 1
        ]);

        $r[] = hiddens(["class" => "carro_compras", "name" => "carro_compras", "value" => 0]);
        $r[] = hiddens(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => 0]);
        $r[] = btn("Pago contra entrega", ['class' => 'mt-2']);

        $r[] = form_close();


        return d($r, "contenedor_form");


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

    function max_compra($es_servicio, $existencia)
    {

        return ($es_servicio == 1) ? 100 : $existencia;

    }

    function url_post($id_servicio)
    {
        return "http://enidservices.com/inicio/img_tema/productos/" . $id_servicio;
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


    function select_cantidad_compra($es_servicio, $existencia)
    {

        $config = [
            "name" => "num_ciclos",
            "class" => "telefono_info_contacto select_cantidad form-control ",
            "id" => "num_ciclos"
        ];

        $select[] = "<select " . add_attributes($config) . ">";
        for ($a = 1; $a < max_compra($es_servicio, $existencia); $a++) {

            $select[] = "<option value=" . $a . ">" . $a . "</option>";
        }
        $select[] = "</select>";
        return append($select);
    }


    function desc_servicio($servicio, $proceso_compra, $data, $imgs, $in_session)
    {

        $usuario = $data["usuario"];
        $tel_visible = pr($servicio, "telefono_visible");
        $id_publicador = $data["id_publicador"];
        $descripcion = pr($servicio, "descripcion");
        $nombre = pr($servicio, "nombre_servicio");
        $color = pr($servicio, "color");
        $es_servicio = pr($servicio, "flag_servicio");
        $es_nuevo = pr($servicio, "flag_nuevo");

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

        $z[] = d(social($proceso_compra, 1), "iconos_social mb-5");
        $z[] = tb_colores($color, $es_servicio);
        $yt = pr($servicio, "url_vide_youtube");

        $r = [];


        $i = pre_youtube($imgs, $yt);
        $izquierdo = ($i["es_imagen"] > 0) ? "col-lg-7 p-0 " : "col-lg-6 col-sm-12 p-0";
        $derecha = ($i["es_imagen"] > 0) ? "col-lg-5 " : "col-lg-6 col-sm-12 p-0 mt-5 mt-md-0";
        $flex = ($i["es_imagen"] > 0) ? "align-items-center" : ["d-lg-flex "];

        $contenido_descripcion = append($z);

        $agregar_lista_deseos = agregar_lista_deseos(0, $in_session);
        $imagen = flex_md($i["img"], $agregar_lista_deseos, 'flex-column');
        $r[] = flex(
            $contenido_descripcion,
            $imagen,
            $flex,
            $izquierdo,
            $derecha
        );

        return append($r);


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
                        'class' => 'col-lg-8 mt-2 border cursor_pointer ' . $extra_class,
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


    function agregar_lista_deseos($proceso_compra, $in_session)
    {

        if ($proceso_compra == 0) {

            $btn = a_enid(

                d(
                    text_icon("fa fa-long-arrow-right", "Lo deseo ", [], 0)
                    ,
                    [
                        'class' => 'agregar_a_lista text-uppercase black strong mt-3 border l_deseos p-1 border-dark p-2',

                    ]

                )
                ,
                path_enid("login")

            );

            if ($in_session > 0) {
                $btn =
                    d(
                        text_icon("fa fa-long-arrow-right", "Lo deseo", [], 0),
                        [
                            "id" => 'agregar_a_lista_deseos_add',
                            "class" => "cursor_pointer border agregar_a_lista_deseos l_deseos p-1 border-dark mt-3 text-uppercase strong border_bottom_big p-2"

                        ]
                    );
            }
            return $btn;

        }
    }

    function nombre_vendedor($proceso_compra, $usuario, $id_vendedor)
    {

        return ($proceso_compra == 0) ? d(crea_nombre_publicador_info($usuario, $id_vendedor), "mt-2") : "";

    }

    function punto_entrega($id_servicio, $orden_pedido)
    {

        $r[] = d(img(["src" => "../img_tema/linea_metro/metro.jpg", "class" => "icono_metro"]));
        $r[] = h("PUNTO MEDIO", 4, "strong");
        $r[] = d(d("PAGO CONTRA ENTREGA "), "text");
        $response = d($r,
            [
                "class" => " cursor_pointer p-4 bg-light mh-selector d-flex flex-column justify-content-center selector_entrega mt-5",
                "onclick" => "carga_opcion_entrega(1, " . $id_servicio . " , " . $orden_pedido . " );"
            ]
        );
        return $response;

    }

    function pre_pedido($url_imagen_servicio, $orden_pedido,
                        $id_servicio, $extension_dominio,
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
            $r[] = frm_pre_pedido($id_servicio, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $carro_compras, $id_carro_compras);
            $r[] = frm_pre_contact($id_servicio, $num_ciclos, $carro_compras, $id_carro_compras);
            $r[] = form_pre_puntos_medios($id_servicio, $num_ciclos, $carro_compras, $id_carro_compras);

        }

        return append($r);

    }

    function frm_pre_pedido($id_servicio, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $carro_compras, $id_carro_compras)
    {

        $r[] = '<form class="form_pre_pedido d-none" action="../procesar/?w=1" method="POST">';
        $r[] = hiddens(["class" => "id_servicio", "name" => "id_servicio", "value" => $id_servicio]);
        $r[] = hiddens(["class" => "extension_dominio", "name" => "extension_dominio", "value" => $extension_dominio]);
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

    /*
     * if (!function_exists('text_periodo_compra')) {
        function text_periodo_compra($es_servicio)
        {

            return ($es_servicio == 0) ? "Piezas" : "";

        }
    }
    */
    /*
    function no_visible($nombre, $precio, $existencia, $es_servicio, $id_servicio)
    {

        $r[] = d($nombre, "card-header");
        $r[] = disponibilidad($precio, $existencia, $es_servicio, $id_servicio);
        return d(append($r), "card box-shadow");

    }
    *
     *
     */


//    function disponibilidad($precio, $existencia, $es_servicio, $id_servicio)
//    {
//
//        $r[] = h($precio . "MXN" . text_diponibilidad($existencia, $es_servicio),
//            1,
//            "card-title pricing-card-title"
//        );
//
//        $r[] = ul([
//            "Artículo temporalmente agotado",
//            a_enid(
//                "Preguntar cuando estará disponible",
//                [
//                    path_enid("pregunta_search", $id_servicio . "&disponible=1")
//                ],
//                1,
//                1
//            )
//
//        ],
//            "list-unstyled mt-3 mb-4"
//        );
//        return append($r);
//
//    }
//
//    function ventas_efectivas($deseado)
//    {
//
//        return ($deseado > 0) ? d($deseado . " VENTAS EN LOS ÚLTIMOS 2 MESES", "top_50 ") : "";
//
//    }

//
//    function get_text_costo_envio($es_servicio, $param)
//    {
//
//        return ($es_servicio == 0 && es_data($param) && array_key_exists("text_envio", $param)) ? $param["text_envio"]["cliente"] : "";
//
//    }
//
//
//    function precio_mayoreo($es_servicio, $venta_mayoreo)
//    {
//
//
//        $r[] = ($es_servicio == 0 && $venta_mayoreo == 1) ? text_icon('fa fa-check-circle', "VENTAS MAYORISTAS ") : "";
//        $r[] = d(text_icon('fa fa-check-circle', "COMPRAS CONTRA ENTREGA"));
//        return append($r);
//
//
//    }
//
//    function formas_pago()
//    {
//
//        $r[] = d(icon("fa fa-shopping-cart") .
//            a_enid(
//                "FORMAS PAGO",
//                [
//                    "href" => path_enid("forma_pago"),
//                    "class" => "black"
//                ]
//            )
//        );
//        return append($r);
//
//
//    }

//    function text_diponibilidad($existencia, $es_servicio)
//    {
//        if ($es_servicio == 0 && $existencia > 0) {
//            $text = d("SOLO HAY 2 EN EXISTENCIA!", 'mt-5 text-right text-muted ');
//            return $text;
//        }
//    }
//
//    function solicitud_inf($id_servicio, $es_servicio)
//    {
//
//
//        $r = [];
//        if ($es_servicio < 1) {
//
//            $r[] =
//                a_enid(
//                    "MÁS INFORMACIÓN"
//                    ,
//                    [
//
//                        "href" => path_enid("pregunta_search", $id_servicio),
//                        "class" => "black"
//
//                    ]
//
//
//                );
//        }
//
//        return append($r);
//
//    }


//    function inf_vendedor($nombre_producto, $entregas_en_casa, $es_servicio, $proceso_compra, $tel_visible, $in_session, $usuario)
//    {
//
//        $r[] = d(entrega_en_casa($entregas_en_casa, $es_servicio));
//        $r[] = contacto_cliente($nombre_producto, $proceso_compra, $tel_visible, $in_session, $usuario);
//        return d(append($r), 1);
//
//    }


//    function contacto_cliente($nombre_producto, $proceso_compra, $tel_visible, $in_session, $usuario)
//    {
//
//        $inf = "";
//        $response = "";
//
//        if ($tel_visible == 1 && $proceso_compra == 0) {
//
//            $usr = $usuario[0];
//            $ftel = 1;
//            $ftel2 = 1;
//            $tel = (strlen($usr["tel_contacto"]) > 4) ? $usr["tel_contacto"] : $ftel = 0;
//            $tel2 = (strlen($usr["tel_contacto_alterno"]) > 4) ? $usr["tel_contacto_alterno"] : $ftel2 = 0;
//            if ($ftel == 1) {
//
//                $lada = (strlen($usr["tel_lada"]) > 0) ? "(" . $usr["tel_lada"] . ")" : "";
//                $contacto = $lada . $tel;
//                $inf .= d(icon("fa fa-phone") . $contacto);
//            }
//            if ($ftel2 == 1) {
//                $lada = (strlen($usr["lada_negocio"]) > 0) ? "(" . $usr["lada_negocio"] . ")" : "";
//                $inf .= d(icon('fa fa-phone') . $lada . $tel2);
//            }
//            $response = d(a_enid($inf, "https://wa.me/" . $usr["tel_lada"] . $tel . "?text=Hola me puedes dar precio sobre tu " . $nombre_producto), 1);
//        }
//        return $response;
//
//
//    }
//
//
//    function entrega_en_casa($entregas_en_casa, $es_servicio)
//    {
//
//        $response = "";
//        if ($entregas_en_casa == 1) {
//
//            $text = ($es_servicio == 1) ?
//                "EL VENDEDOR TAMBIÉN BRINDA ATENCIÓN EN SU NEGOCIO" :
//                "PUEDES COMPRAR EN EL NEGOCIO DEL VENDEDOR";
//            $response = text_icon("fa fa-check-circle", $text);
//
//        }
//
//        return $response;
//    }

}
