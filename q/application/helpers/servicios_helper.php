<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function format_simple($data)
    {

        $_response[] = _titulo("servicios postulados", 3);

        foreach ($data["servicios"] as $row) {

            $id_servicio = $row["id_servicio"];
            $r = [];
            $r[] = img(
                [
                    "src" => link_imagen_servicio($id_servicio),
                    "class" => "w_articulos_postulados",
                ]
            );
            $r[] = d(_text("alcance", $row["vista"]));

            $popu_header = d(d($r, "popup-head-left pull-left"), "popup-head");
            $_response[] = a_enid(
                d(
                    $popu_header,
                    [
                        "class" => "popup-box chat-popup mt-2",
                        "id" => "qnimate",
                    ]
                ),
                path_enid('producto', $id_servicio)
            );

        }

        return append($_response);

    }

    function render_configurador($data)
    {
        $response = "";
        $servicio = $data["servicio"];
        if (es_data($servicio)) {

            $num = $data["num"];
            $num_imagenes = $data["num_imagenes"];
            $s = $servicio[0];
            $muestra_fecha_disponible = $s['muestra_fecha_disponible'];
            $fecha_disponible = $s['fecha_disponible'];

            $id_servicio = $s["id_servicio"];
            $es_servicio = $s["flag_servicio"];
            $precio = $s["precio"];
            $extra_producto = _text($id_servicio, "&q2=", $data["id_usuario"]);
            $url_productos_publico = path_enid('producto', $extra_producto);
            $costo_envio = $data["costo_envio"];

            $comision = 0;
            $utilidad = 0;
            if ($es_servicio < 1) {

                $p_comision = $data["porcentaje_comision"];
                $comision = porcentaje(floatval($precio), $p_comision);
                $comision_num = porcentaje(floatval($precio), $p_comision, 2, 2);
                $utilidad = floatval($precio) - (($es_servicio < 1) ? floatval($costo_envio["costo_envio_vendedor"]) : 0);
                $utilidad = $utilidad - $comision_num;

            }

            $tipo_promocion = ["PRODUCTO", "SERVICIO"][$es_servicio];
            $valor_youtube = pr($servicio, "url_vide_youtube");
            $val_youtube = icon('fa fa-pencil text_url_youtube') . $valor_youtube;
            $nombre = pr($servicio, "nombre_servicio");


            $r[] = seccion_titulo($nombre, $servicio, $num_imagenes);
            $r[] = indicadores_faltantes($servicio);

            $r[] = menu_config($data, $id_servicio, $num, $num_imagenes, $url_productos_publico);

            $r[] = configurador(
                $s,
                $data,
                $num,
                $num_imagenes,
                $id_servicio,
                $data["id_perfil"],
                $tipo_promocion,
                $val_youtube,
                $valor_youtube,
                tab_activa($num, 1),
                pr($servicio, 'descripcion'),
                $es_servicio,
                $s["telefono_visible"],
                $precio,
                $costo_envio,
                $utilidad,
                $servicio,
                $nombre
            );

            $res[] = agregar_imgs();
            $res[] = d($r, "contenedor_global_servicio");
            $res[] = hiddens(['class' => 'fecha_disponible', 'value' => format_fecha($fecha_disponible)]);
            $res[] = hiddens(['class' => 'muestra_fecha_disponible', 'value' => $muestra_fecha_disponible]);
            $response = append($res);

        }
        return $response;

    }

    function indicadores_faltantes($servicio)
    {

        $descripcion = pr($servicio, "descripcion");
        $marca = pr($servicio, "marca");
        $dimensiones = pr($servicio, "dimension");
        $servicio_materiales = $servicio["servicio_materiales"];
        $metakeyword_usuario = pr($servicio, "metakeyword_usuario");

        $response[] = es_texto($descripcion, 'Descripción');
        $response[] = es_texto($marca, 'Marca');
        $response[] = es_texto($dimensiones, 'Dimensiones');
        $response[] = (es_data($servicio_materiales)) ? '' :
            flex(icon(_text_(_eliminar_icon, 'fa-2x color_red')), 'Materiales', 'd-flex align-items-center');
        $response[] = es_texto($metakeyword_usuario, 'Palabras clave');

        return d(d($response, 3), 13);


    }

    function tiene_atributos($servicio)
    {

        $descripcion = $servicio["descripcion"];
        $marca = $servicio["marca"];
        $dimensiones = $servicio["dimension"];
        $metakeyword_usuario = $servicio["metakeyword_usuario"];


        $valicacion[] = es_texto($descripcion, '', 1);
        $valicacion[] = es_texto($marca, '', 1);
        $valicacion[] = es_texto($dimensiones, '', 1);
        $valicacion[] = es_texto($metakeyword_usuario, '', 1);

        return (in_array(false, $valicacion)) ? d('', 'border-bottom border-danger') : '';


    }

    function es_texto($texto, $atributo, $booleano = 0)
    {

        if ($booleano) {

            $response = (strlen($texto) > 2);

        } else {

            $response = (strlen($texto) > 2) ? '' :
                flex(icon(_text_(_eliminar_icon, 'fa-2x color_red')), $atributo, 'd-flex align-items-center');
        }
        return $response;


    }


    function configurador($s, $data, $num,
                          $num_imagenes,
                          $id_servicio,
                          $id_perfil,
                          $tipo_promocion,
                          $val_youtube, $valor_youtube,
                          $ext_1,
                          $n_descripcion,
                          $es_servicio,
                          $tel_visible,
                          $precio,
                          $costo_envio,
                          $utilidad,
                          $servicio,
                          $nnservicio
    )
    {


        $descripcion_informacion = "INFORMACIÓN SOBRE TU " . $nnservicio;
        $descripcion_informacion = h(
            text_icon(
                'fa fa-pencil text_desc_servicio',
                $descripcion_informacion
            ), 5
        );
        $n_titulo = d($descripcion_informacion);
        $in_descripcion = d($n_descripcion, "text_desc_servicio", 1);


        $r[] = conf_entrada(
            valida_text_imagenes($tipo_promocion, $num_imagenes),
            $num_imagenes,
            $id_servicio,
            $id_perfil,
            $data["images"],
            $val_youtube,
            $valor_youtube,
            $ext_1
        );

        $r[] = conf_producto(
            $servicio,
            $n_titulo,
            $in_descripcion,
            $n_descripcion,
            $es_servicio,
            create_colores_disponibles($s["color"]),
            tab_activa($num, 2)
        );


        $r[] = conf_detalle($s,
            $data,
            $s["comision"],
            $s["status"],
            $s["es_publico"],
            $id_servicio,
            $es_servicio, $id_perfil,
            $s["stock"],
            $s["entregas_en_casa"],
            $tel_visible,
            $s["contra_entrega"],
            $s["existencia"],
            $s["flag_nuevo"],
            $data["ciclos"],
            $s["id_ciclo_facturacion"],
            $data["has_phone"],
            $s["venta_mayoreo"],
            $precio,
            $costo_envio,
            $utilidad,
            tab_activa($num, 4)

        );

        $r[] = conf_avanzado(
            $servicio,
            $id_perfil,
            $id_servicio,
            $s["metakeyword_usuario"],
            tab_activa($num, 3)
        );
        $r[] = configuracion_proveedor(tab_activa($num, 6));
        $r[] = conf_productos_relacionados(
            $data,
            $id_servicio,
            tab_activa($num, 5)
        );
        $r[] = conf_productos_proveedores($id_servicio, tab_activa($num, 7));


        return tab_content($r);


    }


    function conf_productos_relacionados(
        $data,
        $id_servicio,
        $extra_5)

    {

        $response[] = d(_titulo('Artículos relacionados ', 2), 13);
        $response[] = formato_servicios_relacionados($data["servicios_relacionados"], $id_servicio);
        $response[] = input_frm("row", "Producto relacionado",
            [
                "type" => "text",
                "name" => "busqueda_producto_relacionado",
                "required" => true,
                "placeholder" => "artículo",
                "class" => "busqueda_producto_relacionado",
                "id" => "busqueda_producto_relacionado"
            ]
        );


        $response[] = place('lista_productos_relacionados');

        return tab_seccion($response, "tab_productos_relacionados", $extra_5);


    }

    function conf_productos_proveedores($id_servicio, $extra_7)
    {

        $base_proveedores = [
            'class' => 'link_proveedor cursor_pointer',
            'id' => $id_servicio,
        ];

        $base_busqueda = [
            'class' => 'link_busqueda cursor_pointer text-center borde_accion p-2 bg_black white  text-uppercase col',
            'id' => $id_servicio,
        ];

        $proveedores = format_link("Agregar", $base_proveedores, 0);


        $icono = icon(_text_(_busqueda_icon, 'mr-5'));
        $flex_busqueda = d([d($icono), d("busqueda")], "d-flex");
        $busqueda = d($flex_busqueda, $base_busqueda);


        $icono_registros = icon(_text_("fa-address-book-o", 'mr-5'));
        $flex_registros = d([d($icono_registros), d("Proveedores asociados","")], "d-flex cursor_pointer");
        $registros = d($flex_registros, $base_busqueda);



        $titulo = _titulo('¿Qué proveedores te distribuyen este artículo? ', 2);

        $registros_asociados= flex($busqueda, $registros,"","boton_busqueda","listado_proveedores boton_asociados d-none");
        $controles = flex($registros_asociados, $proveedores);
        $response[] = flex_md($titulo, $controles, _between);
        $response[] = place("proveedores_existentes");
        $response[] = form_busqueda();

        return tab_seccion($response, "tab_proveedores", $extra_7);


    }

    function form_busqueda()
    {
        $form[] = form_open("",
            [
                "class" => "form_busqueda_proveedor busqueda_proveedores",
                "id" => "form_busqueda_proveedor",
                "method" => "post"
            ]
        );
        $form[] = input_frm(
            'mt-5',
            "Busca en los proveedores existentes",
            [
                "id" => "q_proveedor",
                "name" => "q",
                "class" => "q_proveedor",
                "type" => "text",
                "required" => true,
                "placeholder" => "Busqueda",
                "no_validar" => 1
            ]
        );

        $form[] = hiddens(["name" => "status", "value" => 1]);
        $form[] = hiddens(["name" => "id_departamento", "value" => 11]);
        $form[] = hiddens(["name" => "page", "value" => 1]);
        $form[] = hiddens(["name" => "v", "value" => 3]);

        $form[] = form_close();
        $form[] = place("seccion_usuarios busqueda_proveedores");
        return append($form);
    }

    function formato_servicios_relacionados($servicios_relacionados, $id_servicio)
    {

        $response = [];
        $ids = [];

        if (es_data($servicios_relacionados)) {

            $lista = [];
            foreach ($servicios_relacionados as $row) {


                $id = $row["id_servicio_relacion"];
                $ids[] = $id;
                if (!in_array($id, [$id_servicio])) {
                    $path_imagen_servicio = link_imagen_servicio($id);

                    $img = img(
                        [
                            "src" => $path_imagen_servicio,
                            "class" => "w_articulos_relacionados",
                        ]
                    );

                    $icono = icon(_text_("mt-5 mb-5 quitar_servicio_relacionado", _eliminar_icon), ["id" => $id]);
                    $lista[] = flex($icono, $img, 'flex-column');


                }

            }
            $seccion = d(d($lista, 'd-flex col-md-12'), 'row mb-5');
            $response[] = d($seccion, 'row mb-5');
            $response[] = hiddens(['class' => 'ids_relacionados', "value" => implode(',', $ids)]);
        } else {

            $response[] = hiddens(['class' => 'ids_relacionados', "value" => implode(',', [])]);
        }
        return append($response);

    }

    function conf_avanzado(
        $servicio,
        $id_perfil,
        $id_servicio,
        $keyword_usuario,
        $extra_3)
    {


        $f[] = restablecer($servicio, $id_perfil);
        $f[] = form_tags($id_servicio, $keyword_usuario);

        return tab_seccion($f, "tab_terminos_de_busqueda", $extra_3);


    }

    function configuracion_proveedor($extra_6)
    {

        return tab_seccion("sss", "tab_configurdor_proveedor", $extra_6);

    }

    function conf_detalle(
        $servicio,
        $data,
        $comision,
        $status,
        $es_publico,
        $id_servicio,
        $es_servicio, $id_perfil, $stock,
        $entregas_en_casa,
        $telefono_visible,
        $es_entrega,
        $existencia,
        $es_nuevo,
        $ciclos,
        $id_ciclo_facturacion,
        $has_phone,
        $venta_mayoreo,
        $precio,
        $costo_envio,
        $utilidad,
        $ext_4
    )
    {

        $activo_visita_telefono = val_class(1, $telefono_visible, "button_enid_eleccion_active");
        $baja_visita_telefono = val_class(0, $telefono_visible, "button_enid_eleccion_active");
        $t[] = estado_publicacion($status, $id_servicio);
        $t[] = form_comision($comision, $id_perfil, $id_servicio);
        $t[] = es_publico($status, $es_publico, $id_servicio);
        $t[] = form_rango_entrega($es_servicio, $id_perfil, $stock, $data);

        $t[] = compras_casa($es_servicio, $entregas_en_casa);
        $t[] = telefono_publico($has_phone, $activo_visita_telefono, $baja_visita_telefono, $es_servicio);
        $t[] = venta_mayoreo($es_servicio, $venta_mayoreo);

        $t[] = uso_disponibilidad($existencia, $es_nuevo, $es_servicio);
        $t[] = seccion_uso_producto($es_nuevo);
        $t[] = seccion_ciclos_facturacion($ciclos, $id_ciclo_facturacion, $es_servicio);


        $t[] = form_costo_envio($es_servicio, $costo_envio);
        $t[] = distribucion($servicio);
        $t[] = tipo_distribucion($servicio);
        $t[] = form_costo_unidad($precio);
        $t[] = utilidad($utilidad);

        return tab_seccion($t, "tab_info_precios", $ext_4);

    }

    function tipo_distribucion($servicio)
    {

        $response = [];
        if (es_data($servicio)) {

            $titulo = "¿MEDIOS POSIBLES?";
            $moto = (int)$servicio['moto'];
            $bicicleta = $servicio['bicicleta'];
            $a_pie = $servicio['pie'];


            $confirmar = a_enid(
                "MOTO",
                [
                    "id" => $moto,
                    "class" => _text_(
                        'button_enid_eleccion moto',
                        val_class(1, $moto, "button_enid_eleccion_active")
                    )

                ]
            );

            $omitir = a_enid(
                'BICICLETA',
                [
                    "id" => $bicicleta,
                    "class" => _text_(
                        'button_enid_eleccion bicicleta',
                        val_class(1, $bicicleta, "button_enid_eleccion_active")
                    )
                ]
            );


            $pie = a_enid(
                'PIE',
                [
                    "id" => $a_pie,
                    "class" => _text_(
                        'button_enid_eleccion pie',
                        val_class(1, $a_pie, "button_enid_eleccion_active")
                    )
                ]
            );

            $requiere_auto = $servicio['requiere_auto'];
            $extra = ($requiere_auto) ? 'd-none' : '';
            $tipo_entrega = eleccion_seleccion($titulo, $confirmar, $omitir, $pie);
            $response[] = d($tipo_entrega, $extra);
        }
        return append($response);

    }

    function eleccion_seleccion($titulo, $a, $b, $c, $ext = '')
    {

        $response[] = titulo_bloque($titulo);
        $contenido = [$a, $b, $c];
        $response[] = d($contenido, _text_('d-flex mt-5 justify-content-between ', $ext));
        return d($response, 'col-md-6 mt-5');
    }

    function distribucion($servicio)
    {

        $response = [];
        if (es_data($servicio)) {

            $titulo = "¿ES NECESARIO AUTO PARA SU ENTREGA?";
            $requiere_auto = $servicio['requiere_auto'];
            $atencion = "TAMBIÉN SE PUEDE ENTREGAR EN MOTO, BICICLETA Ó A PIE";

            $confirmar = a_enid(
                "SI",
                [
                    "id" => '1',
                    "class" => _text_(
                        'button_enid_eleccion entregas_en_auto',
                        val_class(1, $requiere_auto, "button_enid_eleccion_active")
                    )

                ]
            );

            $omitir = a_enid(
                $atencion,
                [
                    "id" => '0',
                    "class" => _text_(
                        'button_enid_eleccion entregas_en_auto',
                        val_class(0, $requiere_auto, "button_enid_eleccion_active")
                    )
                ]
            );


            $response[] = eleccion($titulo, $confirmar, $omitir);
        }
        return append($response);

    }

    function conf_producto(
        $servicio,
        $n_titulo_producto,
        $inf_n_descripcion,
        $nueva_descripcion,
        $es_servicio,
        $info_colores,
        $ext_2
    )
    {

        $d[] = $n_titulo_producto;
        $d[] = place("place_tallas_disponibles");
        $d[] = $inf_n_descripcion;
        $d[] = form_descripcion($nueva_descripcion);
        $d[] = format_atributos($servicio);
        $d[] = format_colores($es_servicio, $info_colores);
        return tab_seccion($d, "tab_info_producto", $ext_2);


    }

    function conf_entrada(
        $notificacion_imagenes,
        $num_imagenes,
        $id_servicio,
        $id_perfil,
        $images,
        $val_youtube,
        $valor_youtube,
        $ext_1)
    {


        $z[] = descartar_promocion($num_imagenes, $id_servicio, $id_perfil);
        if ($num_imagenes < 1) {
            $z[] = d($notificacion_imagenes, 'mt-3 mb-3');
        }


        $z[] = $images;
        $z[] = titulo_bloque(
            text_icon('fa fa-youtube-play', " VIDEO DE YOUTUBE "));

        if (strlen($val_youtube) > 0) {

            $z[] = d(text_icon('fa fa fa-pencil text_video_servicio',
                a_enid(
                    'ver ahora',
                    [
                        'href' => $valor_youtube,
                        'target' => '_black',
                        'class' => 'black underline'
                    ], 0
                )
            ), "text-uppercase");
        }

        $z[] = form_youtube($valor_youtube);


        return tab_seccion($z, "tab_imagenes", $ext_1);


    }

    function restablecer($servicio, $id_perfil)
    {

        $response = "";
        if (es_data($servicio) && $id_perfil == 3) {

            $response =
                d(
                    btn("RESTABLECER PUBLICACIÓN",
                        [
                            "class" => "restablecer",
                            "id" => pr($servicio, "id_servicio")
                        ]
                    )
                    ,
                    "row pull-right bottom_100"
                );
        }
        return $response;
    }

    function format_colores($es_servicio, $inf_colores)
    {
        $r = [];
        if ($es_servicio < 1) {

            $r[] = d("+ AGREGAR COLORES", "underline text_agregar_color top_30 bottom_30 strong");
            $r[] = d($inf_colores);
            $r[] = btw(

                d("", ["id" => "seccion_colores_info"])
                ,
                d("", "place_colores_disponibles")
                ,
                "input_servicio_color"
            );
        }

        return append($r);
    }

    function format_atributos($servicio)
    {

        $marca = pr($servicio, "marca");
        $modelo = pr($servicio, "modelo");
        $dimension = pr($servicio, "dimension");
        $peso = pr($servicio, "peso");
        $capacidad = pr($servicio, "capacidad");

        $r[] = form_open("", ["class" => "col-sm-4 form_marca mt-5"]);
        $r[] = flex(
            icon('fa fa-pencil'),
            _text_(strong("Marca:"), $marca),
            "texto_marca cursor_pointer",
            "mr-1"
        );

        $r[] = input_frm("d-none input_marca", "Marca",
            [
                "name" => 'q2',
                "class" => "marca",
                "id" => "marca",
                "value" => $marca,
                "required" => true
            ]
        );

        $r[] = hiddens(
            [
                "name" => "q",
                "class" => "marca",
                "id" => "marca",
                "value" => "marca",
            ]
        );

        $r[] = form_close();


        $r[] = form_open("", ["class" => "col-sm-4 form_modelo mt-5"]);
        $r[] = flex(
            icon('fa fa-pencil'),
            _text_(strong("Modelo:"), $modelo),
            "texto_modelo cursor_pointer",
            "mr-1"
        );

        $r[] = input_frm("d-none input_modelo", "Modelo",
            [
                "name" => 'q2',
                "class" => "modelo",
                "id" => "modelo",
                "value" => $modelo,
                "required" => true
            ]
        );

        $r[] = hiddens(
            [
                "name" => "q",
                "class" => "modelo",
                "id" => "modelo",
                "value" => "modelo",
            ]
        );

        $r[] = form_close();

        $r[] = form_open("",
            [
                "class" => "col-sm-4 form_dimension mt-5"
            ]
        );
        $r[] = flex(
            icon('fa fa-pencil'),
            _text_(strong("Dimensiones:"), $dimension),
            "texto_dimensiones cursor_pointer",
            "mr-1"
        );

        $r[] = input_frm("d-none input_dimensiones", "Dimensiones",
            [
                "name" => "q2",
                "class" => "dimensiones",
                "id" => "dimensiones",
                "value" => $dimension,
                "required" => true
            ]
        );

        $r[] = hiddens(
            [
                "name" => "q",
                "class" => "dimension",
                "id" => "dimension",
                "value" => "dimension",
            ]
        );

        $r[] = form_close();

        $r[] = form_open("",
            [
                "class" => "col-sm-4 form_peso mt-5"
            ]
        );
        $r[] = flex(
            icon('fa fa-pencil'),
            _text_(strong("Peso:"), $peso, 'KG'),
            "texto_peso cursor_pointer",
            "mr-1"
        );
        $r[] = input_frm("d-none input_peso", "Peso en (KG)",
            [
                "name" => "q2",
                "class" => "peso",
                "id" => "peso",
                "type" => "float",
                "value" => $peso
            ]
        );

        $r[] = hiddens(
            [
                "name" => "q",
                "class" => "peso",
                "id" => "peso",
                "value" => "peso",
            ]
        );
        $r[] = form_close();

        $r[] = seccion_materiales($servicio);
        $r[] = form_open("",
            [
                "class" => "col-sm-4 form_capacidad mt-5"
            ]
        );

        $r[] = flex(
            icon('fa fa-pencil'),
            _text_(strong("Capacidad:"), $capacidad, 'KG'),
            "texto_capacidad cursor_pointer",
            "mr-1"
        );

        $r[] = input_frm("d-none input_capacidad",
            "Capacidad en (KG)",
            [
                "name" => "q2",
                "class" => "capacidad",
                "id" => "capacidad",
                "type" => "float",
                "value" => $capacidad
            ]
        );

        $r[] = hiddens(
            [
                "name" => "q",
                "class" => "capacidad",
                "id" => "capacidad",
                "value" => "capacidad",
            ]
        );

        $r[] = form_close();


        return d($r, "row mt-5 mb-5");
    }

    function seccion_materiales($servicio)
    {

        $materiales = $servicio["materiales"];
        $servicio_materiales = $servicio["servicio_materiales"];
        $seccion_tags = [];
        $ids = [];
        if (es_data($servicio_materiales)) {

            foreach ($servicio_materiales as $row) {

                $id_material = $row["id_material"];
                $id = search_bi_array($materiales, "id_material", $id_material);
                $material = $materiales[$id];

                $tag = create_solo_tag(
                    $material,
                    "material_servicio_tag text-uppercase bg_white",
                    "id_material",
                    "nombre"
                );

                $ids[] = $material["id_material"];
                $icon = icon(
                    _text_(_eliminar_icon, 'mr-5 eliminar_material'),
                    [
                        "id" => $id_material
                    ]
                );
                $seccion_tags[] = flex($icon, $tag);
            }
        }

        $seccion_tags[] = d(d(btn("+ Nuevo", ["class" => "agregar_material mt-3"]), 6), 'row');
        $response[] = d("Materiales", "strong text-uppercase mb-3");
        $response[] = d($seccion_tags);
        $response[] = form_open("", ["class" => "form_servicio_materiales d-none"]);

        $selector = create_select(
            $materiales,
            "material",
            "material mt-5",
            "material",
            "nombre",
            "id_material",
            0,
            1,
            0,
            "-",
            $ids
        );

        $registro = btn("Agregar");
        $response[] = flex($selector, $registro, _between);
        $response[] = form_close();

        return d($response, 'col-sm-4 mt-5');

    }

    function venta_mayoreo($es_servicio, $venta_mayoreo)
    {

        $r = [];
        if ($es_servicio < 1) {

            $mayoreo = a_enid("SI",
                [
                    "id" => 1,
                    "class" =>
                        _text_(
                            'button_enid_eleccion venta_mayoreo ',
                            val_class(1, $venta_mayoreo, "button_enid_eleccion_active")
                        )
                ]
            );

            $menudeo = a_enid("NO",
                [
                    "id" => '0',
                    "class" =>
                        _text_(
                            'button_enid_eleccion venta_mayoreo ',
                            val_class(0, $venta_mayoreo, "button_enid_eleccion_active")
                        )

                ]
            );

            $r[] = eleccion(
                "¿también vendes este producto por mayoreo?", $mayoreo, $menudeo,
                "ventas_mayoreo"
            );

        }
        return append($r);

    }

    function utilidad($utilidad)
    {

        $r[] = _titulo("GANANCIA FINAL " . money($utilidad));

        return d($r, "col-lg-12 shadow border mt-5 p-5");
    }

    function seccion_ciclos_facturacion($ciclos, $id_ciclo_facturacion, $es_servicio)
    {

        $x = [];
        if ($es_servicio > 0 && es_data($ciclos)) {

            $r[] = btw(
                h('CICLO DE FACTURACIÓN', 5)
                ,
                icon('fa fa-pencil text_ciclo_facturacion')
                ,
                "display_flex_enid"
                ,
                12
            );
            $r[] = d(
                nombre_ciclo_facturacion($ciclos, $id_ciclo_facturacion)
                , "top_30");
            $r[] = btw(
                create_select_selected($ciclos,
                    "id_ciclo_facturacion",
                    "ciclo",
                    $id_ciclo_facturacion,
                    "ciclo_facturacion",
                    "ciclo_facturacion form-control"
                )
                ,
                btn("GUARDAR",
                    [
                        'class' => 'btn_guardar_ciclo_facturacion'
                    ]
                ),
                "input_ciclo_facturacion display_none top_30"
            );


            $x[] = d(append($r));
        }

        return (count($x) > 0) ? d(d(d(append($x), 12), "top_50"), 6) : "";


    }

    function uso_disponibilidad($existencia, $es_nuevo, $es_servicio)
    {


        $r = [];

        if ($es_servicio < 1) {

            $r[] = d(articulos_disponibles($existencia), 'col-md-6 mt-5');

        }

        return append($r);

    }

    function articulos_disponibles($existencia)
    {


        $r[] = d(
            titulo_bloque(
                _text(
                    icon('fa fa-pencil text_cantidad'),
                    numero_articulos($existencia)
                )
            )
        );


        $form[] = input_frm('col-lg-9 row', '¿artículos disponibles?',
            [
                "type" => "number",
                "name" => "existencia",
                "class" => "existencia",
                "id" => "existencia",
                "required" => "",
                "value" => $existencia,
            ]
        );


        $form[] = btn("GUARDAR", ["class" => "es_disponible btn_guardar_cantidad_productos"]);
        $r[] = d(flex($form), 'input_cantidad mt-5');

        return append($r);
    }

    function seccion_uso_producto($es_nuevo)
    {

        $usado = ["No", "Si"];
        $r[] = titulo_bloque("¿es nuevo?");
        $r[] = d(text_icon('fa fa-pencil text_nuevo', $usado[$es_nuevo]));

        $form[] = select_producto_usado($es_nuevo);
        $form[] = btn("GUARDAR",
            [
                "class" => "btn_guardar_producto_nuevo es_nuevo"
            ]
        );
        $r[] = d(flex($form), 'input_nuevo mt-3');
        return d($r, 'col-md-6 mt-5');

    }

    function create_vista($s, $agregar_servicio = 0)
    {
        $id_servicio = $s["id_servicio"];
        $in_session = $s["in_session"];
        $id_perfil = (prm_def($s, "id_perfil") > 0) ? $s["id_perfil"] : 0;
        $path_servicio = get_url_servicio($id_servicio);


        $img = img(
            [
                'src' => $s["url_img_servicio"],
                'alt' => $s["metakeyword"],
                'class' => 'mx-auto my-auto d-block p-1 mh_270 mh_250 mh_sm_310 mh-auto mt-5',
            ]
        );

        if ($in_session > 0) {

            $response[] = d(a_enid($img, $path_servicio));

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


            $response = d($response,
                "d-flex flex-column justify-content-center col-lg-3 mt-5 px-3"
            );

        } else {

            $response = a_enid(
                $img,
                [
                    "href" => $path_servicio,
                    "class" => "col-lg-3 hps mt-5 mx-auto my-auto d-flex align-content-center flex-wrap h_310",
                ]
            );
        }

        return $response;

    }


    function get_base_empresa($paginacion, $busqueda, $num_servicios, $productos)
    {

        $paginacion = d($paginacion, 1);
        $r = [];
        $callback = function ($n) {
            return d($n);
        };

        $r += array_map($callback, $productos);
        $str = _text(
            icon("fa fa-search"),
            "Tu búsqueda de",
            $busqueda,
            "(",
            $num_servicios,
            "Productos)"
        );
        $t[] = d($str, 1);
        $t[] = d($paginacion, 1);
        $t[] = append($r);

        $bloque[] = d(append($t), 1);
        $bloque[] = d($paginacion, 1);
        return append($bloque);

    }


    function menu_config($data, $id_servicio, $num, $num_imagenes, $url_productos_publico)
    {

        $stock = '';
        $fecha_stock = '';
        $proveedores = '';
        if (es_administrador($data)) {

            $base_stock = [
                'class' => 'stock_disponible cursor_pointer',
                'id' => $id_servicio,
            ];
            $stock = btn("Agregar stock", $base_stock);

            $base_disponibilidad = [
                'class' => 'stock_disponibilidad cursor_pointer',
                'id' => $id_servicio,
            ];

            $fecha_stock = format_link("Fecha disponibilidad", $base_disponibilidad, 0);


        }


        $link_foto = tab(icon('fa fa-picture-o'), "#tab_imagenes");
        $link_precios = tab(icon('fa fa-credit-card'), "#tab_info_precios");
        $link_detalle = tab(
            icon('fa fa-info detalle'),
            "#tab_info_producto",
            [
                'id' => 'tab_info_producto_seccion',
                'class' => 'detalle'
            ]
        );
        $link_busqueda = tab(
            icon('fa fa-fighter-jet menu_meta_key_words'),
            "#tab_terminos_de_busqueda"
        );
        $link_relacionados = tab(
            icon('fa-superpowers'),
            "#tab_productos_relacionados"
        );

        $link_proveedores = tab(icon('fa-address-book-o listado_proveedores'), "#tab_proveedores");

        $list = [
            li(
                $link_foto,
                [
                    "class" => valida_active($num, 1),
                    "style" => valida_existencia_imagenes($num_imagenes)
                ]
            ),
            li(
                $link_precios,
                [
                    "class" => valida_active($num, 4),
                    "style" => valida_existencia_imagenes($num_imagenes)
                ]
            ),
            li(
                $link_detalle,
                [
                    "style" => valida_existencia_imagenes($num_imagenes)
                ]
            ),
            li(
                $link_busqueda,
                [
                    "class" => valida_active($num, 3),
                    "style" => valida_existencia_imagenes($num_imagenes)
                ]
            )
            ,
            li(
                $link_relacionados,
                [
                    "class" => valida_active($num, 3),
                    "style" => valida_existencia_imagenes($num_imagenes)
                ]
            ),
            $link_proveedores,
            $stock,
            $fecha_stock,
            li(
                a_enid(
                    text_icon("fa fa-shopping-bag", "VER PUBLICACIÓN")
                    ,
                    [
                        "href" => $url_productos_publico,
                        "target" => "_blank",
                        "style" => 'background: #002565;color: white!important;'
                    ]
                ),
                [
                    "style" => valida_existencia_imagenes($num_imagenes)
                ]
            ),


        ];

        $ext = (is_mobile() && $num_imagenes < 1) ? 'd-none' : '';
        return ul($list, _text_("nav nav-tabs", $ext));

    }

    function get_config_categorias($data, $param)
    {

        $nivel = "nivel_" . $data["nivel"];
        $class = _text_('num_clasificacion ', $nivel, ' selector_categoria form-control w-100 mt-5 ');
        $config = [
            'class' => $class,
            'size' => 30
        ];

        return select_enid(
            $data["info_categorias"],
            "nombre_clasificacion",
            "id_clasificacion",
            $config);
    }

    function get_add_categorias($data, $param)
    {

        $data["padre"] = $param["padre"];
        $select = btn(
            text_icon('fa fa-angle-double-right', "agregar")
            ,
            [
                "class" => "nueva_categoria_producto d-flex mt-5 ",
                "id" => $data["padre"]
            ]);
        return $select;
    }

    function estado_publicacion($status, $id_servicio)
    {

        $text = ($status > 0) ? "PAUSAR PUBLICACIÓN" : "ACTIVAR PUBLICACIÓN";

        return d(a_enid(
            $text,
            [
                "id" => $id_servicio,
                "status" => $status,
                "class" => 'button_enid_eleccion activar_publicacion'
            ], 0
        ), 'col-md-12 text-right mt-5');
    }

    function une_data($data_servicios, $data_intentos_entregas)
    {

        $new_data = [];
        $response = [];
        $a = 0;
        foreach ($data_servicios as $row) {

            $new_data[$a] = $row;
            $key = array_search($row["id_servicio"], array_column($data_intentos_entregas, "id_servicio"));
            if ($key != false) {

                $new_data[$a]["intentos_compras"] = $data_intentos_entregas[$key];

            }

            $a++;
        }


        $z = 0;
        foreach ($new_data as $row) {

            $response[$z] = [
                "id_servicio" => $row["id_servicio"],
                "vista" => $row["vista"],
                "nombre_servicio" => $row["nombre_servicio"],
                "deseado" => $row["deseado"],
                "valoracion" => $row["valoracion"],
            ];

            if (array_key_exists("intentos_compras", $row)) {

                $response[$z] += [

                    "intentos" => $row["intentos_compras"]["intentos"],
                    "punto_encuentro" => $row["intentos_compras"]["punto_encuentro"],
                    "mensajeria" => $row["intentos_compras"]["mensajeria"],
                    "visita_negocio" => $row["intentos_compras"]["visita_negocio"],
                ];

            } else {

                $response[$z] += [
                    "intentos" => 0,
                    "punto_encuentro" => 0,
                    "mensajeria" => 0,
                    "visita_negocio" => 0,
                ];

            }

            $z++;
        }
        return $response;
    }

    function dropdown_button($id_imagen, $principal = 0)
    {

        $text = menorque($principal, 1, "Definir como principal", "Imagen principal");
        $ext = menorque($principal, 1, "", "blue_enid");


        $menu[] = a_enid(
            text_icon('fa fa-star', $text)
            ,
            [
                "class" => _text("imagen_principal dropdown-item text-uppercase " . $ext),
                "id" => $id_imagen
            ]
        );


        $menu[] =
            a_enid(
                text_icon('fa fa-times ', "quitar")
                ,
                [
                    "class" => "foto_producto dropdown-item text-uppercase",
                    "id" => $id_imagen
                ]
            );

        return dropdown(icon("fa fa fa-pencil boton_editar_imagenes"), $menu, 'mt-5 mt-md-1');


    }

    function nombre_ciclo_facturacion($ciclos, $id_ciclo)
    {

        return search_bi_array($ciclos, "id_ciclo_facturacion", $id_ciclo, "ciclo");

    }

    function create_colores_disponibles($text_colores)
    {

        $arr_colores = explode(",", $text_colores);
        $r = [];
        for ($a = 0; $a < count($arr_colores); $a++) {

            $codigo_color = $arr_colores[$a];
            $contenido = icon('fa fa-times elimina_color',
                    [
                        "id" => $codigo_color
                    ]
                ) . " " . $codigo_color;
            $r[] = d($contenido, ["style" => "background:" . $codigo_color . ";color:white;padding:3px;"]);
        }
        return d(append($r), ["id" => 'contenedor_colores_disponibles']);
    }

    function numero_articulos($num)
    {

        $text = d("Alerta", 'mjs_articulo_no_disponible') . "este artúculo no se encuentra disponible, agregar nuevo";
        if ($num > 0) {
            $s1 = $num . " artículos disponibles";
            $s2 = $num . " artículo disponible";
            $text = ($num > 1) ? $s1 : $s2;
        }
        return $text;
    }


    function select_producto_usado($valor_actual)
    {

        $usado = ["No", "Si"];
        $r[] = "<select class='form-control producto_nuevo'>";
        for ($z = 0; $z < count($usado); $z++) {

            $r[] = ($z == $valor_actual) ? "
    <option value='" . $z . "' selected>" . $usado[$z] . "</option>
    " : "
    <option value='" . $z . "'>" . $usado[$z] . "</option>
    ";

        }
        $r[] = "</select>";
        $response = append($r);
        return $response;
    }


    function editar_servicio($servicio, $in_session, $id_servicio, $id_perfil)
    {

        $response = "";
        $id_usuario = $servicio["id_usuario"];
        $id_usuario_registro_servicio = $servicio["id_usuario_actual"];
        $en_session_propietario = ($in_session > 0 && $id_usuario == $id_usuario_registro_servicio);
        $no_cliente = ($id_perfil > 0 && $id_perfil != 20);
        if ($en_session_propietario || $no_cliente) {
            $clase = "mt-5 mb-5 boton_editar_articulo servicio fa fa-pencil";
            $response = icon($clase, ["id" => $id_servicio]);
        }

        return $response;

    }

    function agregar_servicio($in_session, $id_servicio, $id_usuario, $id_usuario_registro_servicio, $id_perfil)
    {

        $response = "";
        if ($in_session > 0 && $id_usuario == $id_usuario_registro_servicio || ($id_perfil > 0 && $id_perfil != 20)) {
            $response = icon("mt-5 mb-5 boton_agregar_articulo fa fa-plus", ["id" => $id_servicio]);
        }

        return $response;

    }


    function rango_entrega($id_perfil, $actual, $attributes = [], $titulo, $minimo = 1, $maximo = 10)
    {


        $response = "";

        if ($id_perfil == 3) {

            $att = add_attributes($attributes);

            $select[] = "<select " . $att . ">";

            for ($a = $minimo; $a < $maximo; $a++) {

                $select[] = ($a == $actual) ? "
<option value='" . $a . "' selected>" . $a . "</option>" : "
<option value='" . $a . "'>" . $a . "</option>";

            }

            $select[] = "</select>";
            $select[] = place("response_tiempo_entrega");
            $select = append($select);

            $response = append([titulo_bloque($titulo), $select]);

        }

        return $response;

    }

    function get_link_dropshipping($id_perfil, $id_servicio, $link_dropshipping)
    {

        $response = "";
        if ($id_perfil == 3) {

            $icono = d(
                icon("fa fa fa-pencil"),
                [
                    "class" => "text_link_dropshipping",
                    "onclick" => "muestra_cambio_link_dropshipping('" . $id_servicio . "')"
                ]
            );

            $titulo = titulo_bloque("link dropshiping");
            $titulo = btw($titulo, $icono, "display_flex_enid");

            $x[] = input(
                [
                    "class" => "form-control ",
                    "name" => "link_dropshipping",
                    "required" => "true",
                    "placeholder" => "Link de compra",
                    "type" => "url",
                    "value" => $link_dropshipping
                ]
            );

            $x[] = hiddens(
                [
                    "name" => "servicio",
                    "value" => $id_servicio
                ]
            );
            $x[] = btn("GUARDAR");
            $x[] = place("response_link_dropshipping");

            if (strlen($link_dropshipping) > 10) {

                $r[] = a_enid("Link",
                    [
                        "href" => $link_dropshipping,
                        "class" => "underline",
                        "target" => "_black"
                    ]
                );
            }

            $r[] = d($x, "input_link_dropshipping");
            $response = append([$titulo, append($r)]);

        }
        return $response;

    }

    function sumatoria_array($array, $key)
    {

        return array_sum(array_column($array, $key));
    }

    function agregar_imgs()
    {

        $r[] = terminar(icon('fa fa fa-times btn_enid_blue cancelar_carga_imagen cancelar_img'));
        $titulo = d(_titulo("agregar imagenes"), 'mt-5');
        $lugar = d(place("place_img_producto mt-5"), 'mt-5');
        $r[] = flex($titulo, $lugar, 'd-flex flex-column align-items-center');
        return d($r, "contenedor_agregar_imagenes d-none mt-5");

    }

    function get_base_youtube($url)
    {

        $text = "";
        $f = 0;
        for ($a = strlen($url) - 1; $a > 1; $a--) {

            if ($url[$a] === "=" || $url[$a] === "/") {

                $f = $a;
                break;
            }
        }

        for ($b = ($f + 1); $b < strlen($url); $b++) {
            $text .= $url[$b];
        }

        return path_enid("youtube_embebed", $text, 1, 0);

    }

    function seccion_titulo($nuevo_nombre_servicio, $servicio, $num_imagenes)
    {


        $ext = (is_mobile() && $num_imagenes < 1) ? 'd-none' : '';
        $titulo = _text_(
            icon('fa fa-pencil text_nombre_servicio'),
            $nuevo_nombre_servicio
        );

        $response[] = d(titulo_bloque($titulo), $ext);
        $response[] = form_open("", ['class' => 'form_servicio_nombre_info']);
        $response[] = hiddens(["name" => "q", "value" => "nombre_servicio"], 1);

        $input = input_frm("", '¿NOMBRE DEL ARTICULO O SERVICIO?',
            [

                "type" => "text",
                "name" => "q2",
                "class" => "nuevo_producto_nombre",
                "id" => "nuevo_producto_nombre",
                "onkeyup" => "transforma_mayusculas(this)",
                "value" => pr($servicio, 'nombre_servicio'),
                "required" => true
            ]
        );

        $button = btn("modificar");
        $response[] = flex($input, $button,
            'mt-5 mb-5 align-items-center',
            'col-sm-8 p-0', 'col-sm-4 p-0');

        $response[] = form_close();
        return append($response);

    }

    function form_youtube($valor_youtube)
    {


        $r[] = form_open("", ["class" => "form_servicio_youtube"]);
        $r[] = input(
            [
                "type" => "hidden",
                "name" => "q",
                "value" => "url_vide_youtube"
            ]
        );

        $input = input_frm("", "LINK DE YOUTUBE",
            [
                "type" => "url",
                "name" => "q2",
                "class" => 'url_youtube',
                "id" => 'url_youtube',
                "value" => $valor_youtube,
                "required" => true
            ]
        );

        $button = btn("GUARDAR", ["class" => "guardar_video_btn"]);
        $r[] = flex($input, $button,
            'mt-5 align-items-end', 'col-sm-8 p-0', 'col-sm-4 p-0');
        $r[] = form_close();

        return d($r);

    }

    function form_descripcion($nueva_descripcion)
    {

        $r = [];
        array_push($r, form_open("", ["class" => "top_30 form_servicio_desc input_desc_servicio_facturacion"]));
        array_push($r, input([
                "type" => "hidden",
                "name" => "q",
                "value" => "descripcion"
            ], 1)
        );

        array_push($r, d("-" . $nueva_descripcion, ["id" => "summernote"], 1));
        array_push($r, d(btn("GUARDAR", ["class" => "btn_guardar_desc"], 1)));
        array_push($r, form_close());
        return append($r);
    }

    function form_rango_entrega($es_servicio, $id_perfil, $stock, $data)
    {

        $response = "";
        if ($es_servicio < 1 && es_administrador($data)) {

            $r[] = form_open("", ["class" => "form_stock", 'id' => 'form_stock']);
            $r[] = rango_entrega(
                $id_perfil,
                $stock,
                [
                    "name" => "stock",
                    "class" => "stock form-control"
                ],
                "artículos en stock"
                ,
                0
                ,
                1000

            );

            $r[] = form_close();
            $response = d($r, 'form_stock_select col-md-6 mt-5 ');
        }
        return $response;
    }

    function form_drop_shipping($id_perfil, $id_servicio, $link_dropshipping)
    {

        $response = [];

        if ($id_perfil == 3) {

            $r[] = form_open("", ["class" => "form_dropshipping"]);
            $r[] = get_link_dropshipping($id_perfil, $id_servicio, $link_dropshipping);
            $r[] = form_close();
            $response[] = d($r, 'col-md-6 mt-5');
        }


        return append($response);


    }

    function compras_casa($es_servicio, $entregas_en_casa)
    {
        $titulo_ca = ($es_servicio == 1) ? "OFRECES SERVICIO EN TU NEGOCIO?" : "¿CLIENTES TAMBIÉN PUEDEN RECOGER SUS COMPRAS EN TU NEGOCIO?";
        $atencion = ($es_servicio == 1) ? "NO" : "NO, SOLO HAGO ENVÍOS";

        $confirmar = a_enid(
            "SI",
            [
                "id" => '1',
                "class" => _text_(
                    'button_enid_eleccion entregas_en_casa_si entregas_en_casa ',
                    val_class(1, $entregas_en_casa, "button_enid_eleccion_active")
                )

            ]
        );

        $omitir = a_enid(
            $atencion,
            [
                "id" => '0',
                "class" => _text_(
                    'button_enid_eleccion entregas_en_casa_no entregas_en_casa ',
                    val_class(0, $entregas_en_casa, "button_enid_eleccion_active")
                )
            ]
        );


        return eleccion($titulo_ca, $confirmar, $omitir);


    }


    function es_publico($status, $es_publico, $id_servicio)
    {


        $activo = ($es_publico && $status) ? ' button_enid_eleccion_active' : '';
        $no_activo = ($es_publico == 0 || $status == 0) ? ' button_enid_eleccion_active' : '';
        $v = ($status < 1) ? '' : a_enid(
            "si",
            [
                'id' => $id_servicio,
                'es_publico' => 1,
                'class' => 'button_enid_eleccion  text-uppercase es_publico ' . $activo
            ]

        );

        $nov = a_enid(
            "no, solo yo",
            [
                'id' => $id_servicio,
                'es_publico' => 0,
                'class' => 'button_enid_eleccion text-uppercase es_publico ' . $no_activo
            ]
        );


        return eleccion("¿todos pueden ver este artículo?", $v, $nov);
    }

    function telefono_publico($has_phone, $activo_visita_telefono, $baja_visita_telefono, $es_servicio)
    {

        $ver_telefono = ($es_servicio == 1) ?
            "¿PERSONAS PUEDEN VER TU NÚMERO TELEFÓNICO PARA SOLICITARTE MÁS INFORMES?" :
            "¿PERSONAS PUEDEN SOLICITARTE MÁS INFORMES POR TELÉFONO?";

        $telefono_publico = a_enid(
            "SI",
            [
                'id' => 1,
                'class' => _text_(
                    'button_enid_eleccion telefono_visible ', $activo_visita_telefono
                )
            ]

        );


        $telefono_privado = a_enid(
            "NO, OCULTAR MI TELÉFONO",
            [
                'id' => 0,
                'class' => _text_(
                    'button_enid_eleccion  no_tel telefono_visible ',
                    $baja_visita_telefono
                )
            ]

        );


        return eleccion($ver_telefono, $telefono_publico, $telefono_privado);

    }

    function contra_entrega($es_servicio, $es_entrega, $id_servicio)
    {

        $response = [];
        if ($es_servicio < 1) {

            $v = val_class($es_entrega, 1, "button_enid_eleccion_active");
            $v2 = val_class($es_entrega, 0, "button_enid_eleccion_active");
            $si = a_enid(
                "SI",
                [
                    'id' => 1,
                    'class' => 'button_enid_eleccion  ' . $v,
                    'onClick' => "contra_entrega(1, '{$id_servicio}')"
                ]

            );

            $no = a_enid("NO, SOLO ENVÍOS",
                [
                    'id' => 0,
                    'class' => 'button_enid_eleccion ' . $v2,
                    'onClick' => "contra_entrega(0, '{$id_servicio}')"
                ]
            );


            return eleccion("¿haces entregas personalizadas?", $si, $no);


        }

        return append($response);
    }


    function form_tags($id_servicio, $keyword_usuario)
    {

        $r = [];

        $r[] = d(create_meta_tags($keyword_usuario, $id_servicio), "info_meta_tags", 'row "mt-5 mb-5"');
        $r[] = form_open("", ["class" => "form_tag", "id" => "form_tag"]);
        $r[] = input(
            [
                "type" => "hidden",
                "name" => "id_servicio",
                "class" => "id_servicio",
                "value" => $id_servicio
            ]
        );
        $in = btw(
            d(h("AGREGAR", 5), 2),
            d(input([
                "type" => "text",
                "name" => "metakeyword_usuario",
                "required" => true,
                "placeholder" => "Palabra como buscan tu producto",
                "class" => "metakeyword_usuario"
            ]), 10)
            ,
            "agregar_tags "
        );

        $r[] = $in;
        $r[] = form_close(place("contenedor_sugerencias_tags"));

        return append($r);

    }

    function form_costo_unidad($precio)
    {

        $precio_unidad = text_icon(
            'fa fa-pencil',
            _text("Precio por unidad:", money($precio))
        );
        $r[] = titulo_bloque("precio por unidad");
        $r[] = a_enid(
            $precio_unidad,
            [
                "class" => "a_precio_unidad text_costo informacion_precio_unidad"
            ]
        );
        $r[] = form_open("",
            [
                "class" => "form_costo input_costo contenedor_costo mt-5"
            ]
        );

        $r[] = input_frm('', 'MXN',
            [
                "type" => "float",
                "name" => "precio",
                "step" => "any",
                "class" => "precio_unidad",
                "id" => "precio_unidad",
                "value" => $precio
            ],
            _text_cantidad
        );


        $r[] = btn("GUARDAR", ["class" => "mt-5"]);
        $r[] = form_close(place("place_registro_costo"));


        return d($r, 'col-md-6 mt-5');


    }

    function form_comision($comision, $perfil, $id_servicio)
    {

        $response = [];
        if ($perfil == 3) {

            $text[] = text_icon(_text_(_editar_icon, 'editar_comision'),
                _text_(
                    d('COMISIÓN QUE PAGAS POR VENTA', _strong),
                    _titulo(money($comision), 2)
                )
            );

            $r[] = d($text, 'text_comision');
            $r[] = form_open("",
                [
                    "class" => "form_comision_venta d-none"
                ]
            );

            $r[] = hiddens(['name' => 'id', 'value' => $id_servicio]);
            $input = input_frm('', 'COMISIÓN QUE PAGAS POR VENTA',
                [
                    "type" => "float",
                    "name" => "comision",
                    "step" => "any",
                    "class" => "comision",
                    "id" => "comision",
                    "value" => $comision

                ],
                _text_cantidad
            );


            $guardar = btn("GUARDAR");
            $r[] = flex_md($input, $guardar, _text_(_between_md, 'row'), 8, 4);

            $response[] = append($r);
        }
        return d($response, 'col-md-6 mt-5');


    }


    function form_costo_envio($es_servicio, $costo_envio)
    {

        $res = [];
        if ($es_servicio < 1) {


            $costo_envio_configuracion = $costo_envio["text_envio"]["ventas_configuracion"];
            $consto_envio_cliente = $costo_envio["text_envio"]["cliente"];

            $r[] = titulo_bloque("costo de envío");
            $r[] = d(text_icon('fa fa fa-pencil text_info_envio', $costo_envio_configuracion));
            $r[] = d($consto_envio_cliente, "text_info_envio");

            $response[] = d($r, "contenedor_informacion_envio ");
            $opt[] = [
                "text" => "NO, QUE SE CARGUE AL CLIENTE",
                "v" => 0
            ];
            $opt[] = [
                "text" => "SI - YO PAGO EL ENVIO",
                "v" => 1
            ];


            $form[] = create_select($opt, "input_envio_incluido", "input_envio_incluido form-control", "input_envio_incluido", "text", "v");
            $form[] = btn('GUARDAR', ["class" => "btn_guardar_envio  "]);


            $formulario = _d(
                titulo_bloque("¿EL PRECIO INCLUYE ENVÍO?"),
                flex($form)
            );
            $response[] = d($formulario, "input_envio config_precio_envio");

            $res[] = d($response, 'col-md-6 mt-5');
        }
        return append($res);


    }

    function get_tabla_colores()
    {

        $colores_esp = ["Turquesa", "Emerland", "Peterriver", "Amatista", "Wetasphalt", "Mar verde", "Nefritis", "Belizehole", "Glicinas", "Medianoche azul", "Girasol", "Zanahoria", "Alizarina", "Nubes", "Hormigón", "Naranja", "Calabaza", "Granada", "Plata", "Amianto", "Blanco", "Blue", "Cafe", "Morado", "Morado 2", "Azul", "Azul", "Verde", "Verde", "Verde 2", "Amarillo", "Amarillo 2", "Amarillo 3", "Amarillo 4", "Amarillo 5 ", "Gris", "Gris 2", "Gris 3", "Gris 4", "Gris 5", "Gris 6"];
        $codigo_colores = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400",
            "#c0392b", "#bdc3c7", "#7f8c8d", "#fbfcfc", "#1b4f72", "#641e16", "#512e5f", "#4a235a", "#154360", "#1b4f72", " #0e6251", " #0b5345", " #186a3b", " #7d6608", " #7e5109", "#784212", "#6e2c00", "#626567", "#7b7d7d", "#626567", "#4d5656", " #424949", " #1b2631", "#17202a"];

        $response = [];
        for ($a = 0; $a < count($colores_esp); $a++) {

            $response[] = d("",
                [
                    "class" => "colores",
                    "style" => "background:{$codigo_colores[$a]}",
                    "id" => $codigo_colores[$a]
                ]
            );

        }
        return d($response, "colores_disponibles");

    }

    function get_view_sugerencias($servicios)
    {

        $array_servicios = array_intersect_key($servicios, array_unique(array_column($servicios, 'id_servicio')));
        $imagenes = [];
        foreach ($array_servicios as $row) {

            $img = img(
                [
                    'src' => $row["url_img_servicio"],
                    'alt' => $row["metakeyword"],
                    'class' => 'mx-auto d-block p-1 mah_100_p mh_250'
                ]
            );

            $imagenes[] = a_enid(
                $img,
                [
                    "href" => path_enid("producto", $row["id_servicio"]),
                    "class" => "col-lg-3 hps top_50 p-1 d-flex align-content-center flex-wrap h_310",
                ]
            );

        }

        return append($imagenes);
    }

    function eleccion($titulo, $a, $b, $ext = '')
    {

        $response[] = titulo_bloque($titulo);
        $response[] = flex($a, $b, _text_('mt-5 justify-content-between ', $ext));
        return d($response, 'col-md-6 mt-5');
    }

    function titulo_bloque($str)
    {
        return h($str, 5, 'text-uppercase strong');
    }

    function format_atencion($servicios)
    {


        $class = _text_('blue_enid3 white mb-5 mt-5 text-uppercase border-bottom', _between);
        $titulos = flex(
            'días publicados sin ventas', 'artículo', $class);
        $response[] = d($titulos, 4, 1);
        foreach ($servicios as $row) {

            $dias = $row["dias"];
            $url_img_servicio = $row['url_img_servicio'];
            $path = path_enid("editar_producto", $row["id_servicio"]);

            $imagen = img(
                [
                    "src" => $url_img_servicio,
                    "class" => "mx-auto d-block img_servicio_def p-2"
                ]
            );
            $item = flex($dias, $imagen, _text_(' border-bottom', _between), 'black strong ');
            $link = a_enid(
                $item,
                [
                    'href' => $path,
                    "target" => "_blank"
                ]
            );
            $response[] = d($link, 4, 1);


        }
        return $response;

    }
}
