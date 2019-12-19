<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {
    function render_pendidos($data)
    {

        $orden = $data["orden"];
        $status = $data["status_ventas"];
        $r = $data["recibo"];
        $domicilio = $data["domicilio"];
        $num_compras = $data["num_compras"];
        $id_recibo = $data["id_recibo"];
        $cupon = $data['cupon'];

        $re[] = frm_pedidos($orden);
        $re[] = d(crea_estado_venta($status, $r));
        $re[] = format_estados_venta($status, $r, $orden);
        $re[] = crea_seccion_solicitud($r);
        $re[] = crea_seccion_productos($r);
        $re[] = crea_fecha_entrega($r);
        $re[] = create_fecha_contra_entrega($r, $domicilio);
        $re[] = fecha_espera_servicio($r, $data["servicio"]);
        $re[] = notificacion_cambio_fecha(
            $r, $num_compras, pr($r, "saldo_cubierto")
        );
        $re[] = crea_seccion_recordatorios($data["recordatorios"]);
        $re[] = create_seccion_tipificaciones($data["tipificaciones"]);
        $re[] = frm_nota($id_recibo);
        $re[] = create_seccion_comentarios($data["comentarios"]);

        $response[] = d(append($re), 7);
        $response[] = d("", "col-lg-1 ");
        $response[] = d(
            cliente_compra_inf($r, $data["tipos_entregas"], $domicilio,
                $num_compras, $data["usuario"], $id_recibo, $cupon), 4
        );
        $response[] = hiddens_detalle($r);

        return d(append($response), "col-lg-10 col-lg-offset-1 p-0");

    }

    function render_seguimiento($data)
    {

        $recibo = $data["recibo"];
        $id_servicio = $data["id_servicio"];

        $r[] = $data['breadcrumbs'];
        $z[] = seguimiento($recibo, $data);
        $z[] = resumen_orden($data, $recibo, $id_servicio);
        $r[] = append($z);

        $r[] = d(
            place("place_tambien_podria_interezar"), "col-lg-12 top_50"
        );
        $r[] = hiddens(
            [
                "value" => $data["notificacion_pago"],
                "class" => "notificacion_pago",
            ]
        );
        $r[] = hiddens(
            [
                "value" => $data["orden"],
                "class" => "orden"
            ]
        );
        $r[] = hiddens(
            [
                "value" => $id_servicio,
                "class" => "qservicio"
            ]);

        return append($r);

    }

    function seguimiento($recibo, $data)
    {


        $es_vendedor = $data["es_vendedor"];
        $domicilio = $data["domicilio"];

        $r[] = _titulo(
            text_icon(
                "fa fa-map-signs",
                "¿Donde se encuentra mi pedido?", [], 0
            )
        );


        $r[] = d(
            tiempo($recibo, $domicilio, $es_vendedor),
            "timeline top_40", 1
        );

        return d(append($r), 8);

    }

    function resumen_orden($data, $recibo, $id_servicio)
    {


        $z = [];
        $servicio = $data["servicio"];
        $es_vendedor = $data["es_vendedor"];
        $evaluacion = evaluacion($recibo, $es_vendedor);
        $recibo = $recibo[0];
        $se_cancela = ($recibo["cancela_cliente"] || $recibo["se_cancela"]);

        if ($se_cancela) {

            $text = "ORDEN CANCELADA";

        } elseif ($recibo["status"] == 15) {

            $text = "ORDEN ENTREGADA!";

        } else {

            $es_servicio = pr($servicio, "flag_servicio");
            $fecha_servicio = prm_def($recibo, "fecha_servicio");
            $tipo_entrega = prm_def($recibo, "tipo_entrega");
            $fecha_contra_entrega = prm_def($recibo, "fecha_contra_entrega");
            $fecha_vencimiento = prm_def($recibo, "fecha_vencimiento");
            $fecha = ($es_servicio) ? $fecha_servicio : (
                $tipo_entrega == 2) ? $fecha_contra_entrega : $fecha_vencimiento;

            $status = prm_def($recibo, "status");
            $text = "";
            if (!in_array($status, [15, 9, 10]) && $tipo_entrega == 2) {

                $text = ($es_servicio) ?
                    "PLANEADO PARA EL DÍA " :
                    "FECHA EN QUE SE  ESTIMA LLEGARÁ TU PEDIDO";
                $text = add_text($text, format_fecha($fecha), 1);
            }


        }

        $z[] = $evaluacion;
        $z[] = h($text, 4);
        $z[] = text_domicilio($data);
        $id_recibo = prm_def($recibo, "id_proyecto_persona_forma_pago");

        $text_orden = _text("ORDEN #", $id_recibo);

        $a[] = btw(

            _titulo($text_orden, 2, 'text-right')
            ,
            a_enid(
                img(
                    [
                        "src" => prm_def($recibo, "url_img_servicio"),
                    ]
                )
                ,
                get_url_servicio($id_servicio)
            )
        );
        $a[] = append($z);

        return d($a, 3);


    }

    function text_domicilio($data)
    {


        $recibo = $data['recibo'];
        $domicilio = $data['domicilio'];
        $tipo_entrega = $domicilio['tipo_entrega'];
        $text = "";

        switch ($tipo_entrega) {

            case 1:

                $punto_encuetro = $domicilio['domicilio'];
                if (es_data($punto_encuetro)) {

                    $pe = $punto_encuetro[0];
                    $tipo = $pe['tipo'];
                    $nombre_linea = $pe['nombre_linea'];
                    $numero = $pe['numero'];
                    $nombre = $pe['nombre'];


                    $text = _text(
                        'TIENES UNA CITA EL DÍA ',
                        format_fecha(pr($recibo, 'fecha_contra_entrega'), 1),
                        ' EN ',
                        'ESTACIÓN DEL METRO DE CIUDAD DE MÉXICO, ',
                        strong($nombre),
                        ' ',
                        $tipo,
                        ' #',
                        $numero,
                        ' ',
                        $nombre_linea,
                        ' '
                    );
                }

                break;

            case 2:

                $domicilio = $domicilio['domicilio'];
                if (es_data($domicilio)) {

                    $domicilio = $domicilio[0];
                    $calle = $domicilio['calle'];
                    $numero_exterior = $domicilio['numero_exterior'];
                    $asentamiento = $domicilio['asentamiento'];
                    $municipio = $domicilio['municipio'];
                    $ciudad = $domicilio['ciudad'];
                    $cp = $domicilio['cp'];

                    $text = _text(
                        $calle,
                        ' #',
                        $numero_exterior,
                        ' ',
                        $asentamiento,
                        ', ',
                        $municipio,
                        ' ',
                        $ciudad,
                        ' C.P. ',
                        $cp
                    );


                }

                break;

            default:

                break;

        }


        return $text;

    }

    function render_domicilio($data)
    {


        $r = $data["recibo"];
        $punto_entrega = $data['punto_entrega'];
        $lista_direcciones = $data["lista_direcciones"];
        $lista_puntos_encuentro = $data['puntos_encuentro'];
        $r = $r[0];
        $id_recibo = $r["id_proyecto_persona_forma_pago"];
        $tipo_entrega = $r["tipo_entrega"];
        $domicilio_entrega = $data['domicilio_entrega'];

        $response[] = $data['breadcrumbs'];
        $response[] =
            d(
                h('selecciona una dirección de envío',
                    3,
                    'strong text-uppercase'
                )
            );

        $response[] = hiddens(
            [
                "value" => $tipo_entrega,
                "class" => 'tipo_entrega',
            ]
        );
        $response[] = hiddens(
            [
                "value" => $data['num_domicilios'],
                "class" => 'num_domicilios',
            ]
        );
        $response[] = frm_direccion($id_recibo);
        $response[] = frm_puntos($id_recibo);
        $response[] = frm_pe_avanzado($id_recibo);
        $response[] = d(
            _text(
                d_p(
                    'Haz click en el boton "Enviar a esta dirección". 
                        También puedes registrar un',
                    'mt-1'
                ),
                agregar_nueva_direccion(0),
                d(' ó ', 'ml-2 '),
                agregar_nueva_direccion()
            ),
            'mt-1 letter-spacing-1 d-lg-flex'
        );


        $response[] = hr(['class' => 'mt-5 mb-5'], 0);

        $response[] = d(
            h('usadas recientemente', 4, 'text-uppercase strong ')
        );


        $registradas = dd(
            create_direcciones($domicilio_entrega, $lista_direcciones, $id_recibo),
            crea_puntos_entrega($punto_entrega, $lista_puntos_encuentro, $id_recibo),
            10
        );
        $response[] = d(
            $registradas
            ,
            'col-lg-12 p-0 mt-5 mb-5'
        );
        $response[] = d(hr([], 0), 'col-lg-12 p-0 mt-3 mb-5');

        return d(append($response), 'col-lg-12 contenedor_domicilios');

    }


    function frm_pedidos($orden)
    {

        $r[] = d(
            a_enid("MIS PEDIDOS",
                [
                    "href" => path_enid("pedidos"),
                    "class" => "black underline",


                ]
            ), 13);
        $r[] = flex(
            h("# ORDEN " . $orden, 3, "numero_orden encabezado_numero_orden ")
            ,
            d(
                icon("fa fa-pencil"),
                [
                    "class" => "text-right editar_estado",
                    "id" => $orden,
                ]
            ),
            "row align-items-center   mt-4 mb-4", "", "ml-auto"

        );

        return append($r);

    }

    function format_estados_venta($status_ventas, $recibo, $orden)
    {


        $r[] = btw(
            d(strong("STATUS DE LA COMPRA"))
            ,
            create_select(
                $status_ventas,
                "status_venta",
                "status_venta form-control ",
                "status_venta",
                "text_vendedor",
                "id_estatus_enid_service",
                1,
                1,
                0,
                "-"
            )
            ,
            "d-flex align-items-center justify-content-between bottom_30", 1
        );
        $r[] = place("place_tipificaciones");
        $r[] = btw(
            d("SALDO CUBIERTO ", "strong")
            ,
            d(
                btw(
                    d(input(
                            [
                                "class" => "form-control saldo_cubierto_pos_venta",
                                "id" => "saldo_cubierto_pos_venta",
                                "type" => "number",
                                "step" => "any",
                                "required" => "true",
                                "name" => "saldo_cubierto",
                                "value" => $recibo[0]["saldo_cubierto"],
                            ]
                        )
                    ),
                    d("MXN", "ml-4 mxn ")
                    ,
                    "d-flex align-items-center justify-content-between "
                )
            )
            ,
            "d-flex align-items-center justify-content-between 
            bottom_30 form_cantidad_post_venta top_20",
            1
        );
        $r[] = place("mensaje_saldo_cubierto_post_venta");
        $r[] = form_cantidad($recibo, $orden);

        return d(append($r), "selector_estados_ventas top_20 bottom_20");


    }

    function crea_seccion_solicitud($recibo)
    {

        $r[] = d("SOLICITADO EL ");
        $str = date_format(
            date_create(pr($recibo, "fecha_registro")), 'd M Y H:i:s');

        $r[] = d($str, "ml-1 strong");

        return d(append($r), "mb-5 row");
    }

    function get_format_costo_operacion(
        $table_costos,
        $resumen,
        $tipo_costos,
        $id_recibo,
        $path,
        $costos_operacion,
        $recibo
    )
    {

        $r[] = btw(

            h("COSTOS DE OPERACIÓN", 3, "strong")
            ,
            $table_costos
            ,

            "bottom_100"
        );
        $r[] = d($resumen);

        $r[] = format_link(
            "Agregar",
            [
                "onclick" => "muestra_formulario_costo();",
                "class" => "mt-5 col-lg-3",
            ]
        );

        $r[] = d(
            frm_costos(
                $tipo_costos,
                $id_recibo,
                $costos_operacion
            ), "display_none contenedor_form_costos_operacion"
        );
        $response = hrz(append($r), format_img_recibo($path, $recibo), 8);

        return d($response, 10, 1);


    }

    function format_img_recibo($path, $r)
    {
        $response = "";
        if (es_data($r)) {

            $r = $r[0];
            $articulos = $r["num_ciclos_contratados"];
            $monto_a_pagar = $r["monto_a_pagar"] * $articulos;
            $r[] = d(a_enid(img($path),
                path_enid("pedidos_recibo", $r["id_proyecto_persona_forma_pago"])));
            $r[] = h(add_text("TOTAL ", $monto_a_pagar, "MXN"), 4, "strong");
            $r[] = h(add_text("CUBIERTO", $r["saldo_cubierto"] . "MXN"), 5);
            $r[] = h(add_text("ARTÍCULOS", $articulos, 1), 5);

            if ($r["cancela_cliente"] > 0 || $r["se_cancela"] > 0 || $r["status"] == 10) {

                $r[] = h("ORDEN CANCELADA", 3, "red_enid strong");

            }
            $response = d(append($r), "text-right");
        }

        return $response;

    }

    function cliente_compra_inf(
        $recibo,
        $tipos_entregas,
        $domicilio,
        $num_compras,
        $usuario,
        $id_recibo,
        $cupon
    )
    {

        $r[] = create_seccion_tipo_entrega($recibo, $tipos_entregas);
        $r[] = create_select(
            $tipos_entregas,
            "tipo_entrega",
            "tipo_entrega form_edicion_tipo_entrega mt-3 mb-3",
            "tipo_entrega",
            "nombre",
            "id",
            0,
            1,
            0,
            "-"
        );
        $r[] = menu($domicilio, $recibo, $id_recibo, $usuario);
        $r[] = tiene_domilio($domicilio);
        $r[] = compras_cliente($num_compras);
        $r[] = resumen_usuario($usuario, $recibo);
        $r[] = frm_usuario($usuario);
        $r[] = create_seccion_domicilio($domicilio);
        $r[] = create_seccion_saldos($recibo);
        $r[] = d(seccion_cupon($cupon), "top_30 underline text-right");
        $r[] = d(create_seccion_recordatorios($recibo), "top_30 underline text-right");

        return append($r);

    }


    function get_form_busqueda_pedidos($data, $param)
    {

        $tipos_entregas = $data["tipos_entregas"];
        $status_ventas = $data["status_ventas"];
        $fechas[] =
            [
                "fecha" => "FECHA REGISTRO",
                "val" => 1,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA CONTRA ENTREGA",
                "val" => 5,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA ENTREGA",
                "val" => 2,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA CANCELACION",
                "val" => 3,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA PAGO",
                "val" => 4,
            ];


        $r[] = form_open("", ["class" => "form_busqueda_pedidos row", "method" => "post"]);
        $r[] = form_busqueda_pedidos($tipos_entregas, $status_ventas, $fechas);
        $es_busqueda = keys_en_arreglo($param,
            [
                'fecha_inicio',
                'fecha_termino',
                'type',
                'servicio'
            ]
        );
        if ($es_busqueda) {

            $r[] = frm_fecha_busqueda($param["fecha_inicio"], $param["fecha_termino"]);
            $r[] = hiddens(
                [
                    "name" => "consulta",
                    "class" => "consulta",
                    "value" => 1,
                ]
            );
            $r[] = hiddens(
                [
                    "name" => "servicio",
                    "class" => "servicio",
                    "value" => $param["servicio"],
                ]
            );
            $r[] = hiddens(
                [
                    "name" => "type",
                    "class" => "type",
                    "value" => $param["type"],
                ]
            );


        } else {

            $r[] = frm_fecha_busqueda();
        }


        $r[] = form_close();
        $z[] = d($r, "p-5 shadow  ");
        $z[] = place("place_pedidos ");
        $z[] = frm_busqueda();

        $response[] = d(_titulo("ORDENES DE COMPRA"), 'col-lg-10 col-lg-offset-1 p-md-0 mb-4');
        $response[] =  d($z,10,1);
        return append($response);


    }


    function frm_busqueda()
    {

        $r[] = form_open("", ["class" => "form_search", "method" => "GET"]);
        $r[] = hiddens(["name" => "recibo", "value" => "", "class" => "numero_recibo"]);
        $r[] = form_close();

        return append($r);

    }


    function form_busqueda_pedidos($tipos_entregas, $status_ventas, $fechas)
    {


        $r[] = input_frm(6, 'Cliente',
            [
                "name" => "cliente",
                "id" => "cliente",
                "placeholder" => "Nombre, correo, telefono ...",
            ]);


        $r[] = hiddens(
            [
                "name" => "v",
                'value' => 1,
            ]
        );

        $r[] = input_frm(6, '#Recibo',
            [
                "name" => "recibo",
                "id" => 'busqueda_recibo'
            ]
        );

        $r[] = flex(
            "Tipo de entrega",
            create_select(
                $tipos_entregas,
                "tipo_entrega",
                "tipo_entrega form-control",
                "tipo_entrega",
                "nombre",
                "id",
                0,
                1,
                0,
                "-"),
            "flex-column col-md-4 p-0 mt-3"
        );

        $r[] = flex('Status',
            create_select(
                $status_ventas,
                "status_venta",
                "status_venta  form-control",
                "status_venta",
                "text_vendedor",
                "id_estatus_enid_service",
                0,
                1,
                0,
                "-"
            )
            ,
            "flex-column col-md-4 p-0 mt-3"
        );


        $r[] = flex(
            "Ordenar",
            create_select(
                $fechas,
                "tipo_orden",
                "form-control",
                "tipo_orden",
                "fecha",
                "val"
            ),
            "flex-column col-md-4 p-0 mt-3"
        );


        return append($r);

    }


    function puntos_encuentro(
        $tipo_entrega,
        $puntos_encuentro,
        $id_recibo,
        $domicilio
    )
    {


        $r[] = agregar_nueva_direccion();

//        $r[] = lista_puntos_encuentro($tipo_entrega, $puntos_encuentro, $id_recibo, $domicilio);

        return append($r);
    }


    function hiddens_detalle($recibo)
    {

        $r = [];

        if (es_data($recibo)) {
            $rb = $recibo[0];

            $r[] = hiddens(
                [
                    "class" => "status_venta_registro",
                    "name" => "status_venta",
                    "value" => $rb["status"],
                    "id" => "status_venta_registro",
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "saldo_actual_cubierto",
                    "name" => "saldo_cubierto",
                    "value" => $rb["saldo_cubierto"],
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "tipo_entrega_def",
                    "name" => "tipo_entrega",
                    "value" => $rb["tipo_entrega"],
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "id_servicio",
                    "name" => "id_servicio",
                    "value" => $rb["id_servicio"],
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "articulos",
                    "name" => "articulos",
                    "value" => $rb["num_ciclos_contratados"],
                ]
            );
        }


        return append($r);

    }


    function menu($domicilio, $recibo, $id_recibo, $usuario)
    {

        $x[] = link_cambio_fecha($domicilio, $recibo);
        $x[] = link_recordatorio($recibo, $usuario);
        $x[] = link_nota();
        $x[] = link_costo($id_recibo, $recibo);
        $r[] = d(
            icon("fa fa-plus-circle fa-3x"),
            [
                "class" => " dropdown-toggle",
                "data-toggle" => "dropdown"
            ]
        );
        $r[] = d(
            append($x),
            [
                "class" => "dropdown-menu  w_300 contenedor_opciones_pedido p-4 ",

            ]
        );

        return d(d(append($r), "dropleft position-fixed "), "pull-right");


    }


    function evaluacion($recibo, $es_vendedor)
    {

        $response = "";
        if (es_data($recibo)) {

            $id_servicio = $recibo[0]["id_servicio"];
            $status = pr($recibo, "status");
            if ($status == 9 && $es_vendedor < 1) {

                $t[] = btn("ESCRIBE UNA RESEÑA");
                $t[] = d(
                    str_repeat("★", 5),
                    [
                        "class" => "text-center f2 black"
                    ]
                );
                $response = a_enid(
                    append($t),
                    [
                        "href" => path_enid("valoracion_servicio", $id_servicio),
                        "class" => "mb-5"
                    ]
                );
            }
        }
        return $response;
    }


    function form_fecha_recordatorio($data, $tipo_recortario)
    {

        $recibo = prm_def($data, "recibo");
        $str = pr($recibo, "resumen_pedido");
        $usuario = prm_def($data, "usuario");
        if (es_data($usuario)) {

            $str .= " \n%0A" . pr($usuario, "nombre") . "\n%0A";
            $str .= pr($usuario, "tel_contacto");
        }

        $x = h("RECORDATORIO", 3);
        $r[] = form_open("",
            ["class" => "form_fecha_recordatorio letter-spacing-5 "]);
        $r[] = d(
            flex("FECHA", input([
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_cordatorio',
                    "class" => "fecha_cordatorio",
                    "id" => "fecha_cordatorio",
                    "type" => 'date',
                    "value" => date("Y-m-d"),
                    "min" => add_date(date("Y-m-d"), -15),
                    "max" => add_date(date("Y-m-d"), 15),
                ]
            ), "d-flex  justify-content-between align-items-center", "",
                "w-100 mr-3"
            ), 4);

        $r[] = d(flex("HORA", horarios(),
            "justify-content-between align-items-center", "", "w-100 mr-3"), 4);


        $r[] = d(
            flex(" TIPO",
                create_select(
                    $tipo_recortario,
                    "tipo",
                    "form-control tipo_recordatorio",
                    "tipo_recordatorio",
                    "tipo",
                    "idtipo_recordatorio")
                , "d-flex  justify-content-between align-items-center",
                "",
                "w-100 mr-3"
            ), 4);
        $r[] = hiddens(
            [
                "class" => "recibo",
                "name" => "recibo",
                "value" => $data["orden"],
            ]
        );


        $r[] = d(h("Recordatorio", 5), 12);
        $r[] = d(
            textarea(
                [
                    "name" => "descripcion",
                    "class" => "descripcion_recordatorio",
                    "rows" => 3,
                ], 0, $str), "col-lg-12 bottom_50 p-0");
        $r[] = section(place("nota_recordatorio display_none"), 12);
        $r[] = d(btn("CONTINUAR", ["class" => "top_menos_40"]), 12);
        $r[] = form_close();
        $r[] = place("place_recordatorio");
        $form = d(append($r), "top_30 form_separador ");

        return d(add_text($x, $form), 8, 1);

    }

    function get_form_fecha_entrega($data)
    {

        $orden = $data["orden"];
        $r[] = form_open("", ["class" => "form_fecha_entrega"]);
        $r[] = h("FECHA DE ENTREGA", 4, "strong titulo_horario_entra");
        $r[] = label(text_icon("fa fa-calendar-o", " FECHA "),
            "col-lg-4 control-label");
        $r[] = d(
            input(
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_entrega',
                    "class" => "form-control input-sm ",
                    "type" => 'date',
                    "value" => date("Y-m-d"),
                    "min" => add_date(date("Y-m-d"), -15),
                    "max" => add_date(date("Y-m-d"), 15),
                ]),
            8);

        $r[] = label(text_icon("fa fa-clock-o", " HORA DE ENCUENTRO"),
            "col-lg-4 control-label");
        $r[] = d(lista_horarios()["select"], 8);
        $r[] = hiddens(
            [
                "class" => "recibo",
                "name" => "recibo",
                "value" => $orden,
            ]);
        $r[] = d(btn("CONTINUAR", ["class" => "top_20"]), 12);
        $r[] = format_load();
        $r[] = form_close(place("place_fecha_entrega"));
        $response = append($r);
        $response = d($response, 6, 1);

        return $response;


    }

    function form_cantidad($recibo, $orden)
    {
        $r[] = '<form class="form_cantidad top_20">';
        $r[] = hiddens(
            [
                "name" => "recibo",
                "class" => "recibo",
                "value" => $orden,
            ]);
        $r[] = d("MXN", "mxn col-lg-2");
        $r[] = place("mensaje_saldo_cubierto");
        $r[] = form_close();

        return append($r);

    }


    function frm_costos($tipo_costos, $id_recibo, $costos_registrados)
    {

        $costos_registro = [];
        foreach ($tipo_costos as $row) {

            $repetible = $row["repetible"];
            $id = $row["id_tipo_costo"];
            $f = 1;
            foreach ($costos_registrados as $row2) {

                if ($id == $row2["id_tipo_costo"]) {
                    $f = 0;
                    if ($repetible > 0) {
                        $f = 1;
                    }
                    break;
                }
            }
            if ($f > 0) {
                $costos_registro[] = $row;
            }

        }


        $response = d(h("Ya registraste todos los costos de operación para esta venta!",
            3), 8, 1);
        if (es_data($costos_registro)) {

            $r[] = h("Gasto", 3, "strong text-uppercase");
            $r[] = form_open("", ["class" => "form_costos letter-spacing-5 mt-5"],
                ["recibo" => $id_recibo]);

            $r[] =
                input_frm(6, "MONTO GASTADO",
                    [
                        "type" => "number",
                        "required" => true,
                        "class" => "precio",
                        "name" => "costo",
                        "id" => "precio",
                    ]
                );


            $r[] =
                create_select(
                    $costos_registro,
                    "tipo",
                    "id_tipo_costo form-control p-0 col-lg-5 select_gastos ml-2",
                    "tipo",
                    "tipo",
                    "id_tipo_costo"
                );


            $r[] = d(btn("AGREGAR"), "mt-5 col-lg-6 p-0");
            $r[] = form_close(place("notificacion_registro_costo"));
            $response = append($r);
        }

        return $response;

    }

    function get_error_message()
    {


        $r[] = d(h("UPS! NO ENCONTRAMOS EL NÚMERO DE ORDEN", 1,
            "funny_error_message"), "text-center");
        $r[] = d(
            img(
                [
                    "src" => "../img_tema/gif/funny_error.gif",
                ]
            )
        );
        $r[] = d(a_enid("ENCUENTRA TU ORDEN AQUÍ",
            [
                "href" => path_enid("pedidos"),
                "class" => "busqueda_mensaje",
            ]
        ),
            "busqueda_mensaje_text"
        );

        return d(append($r));

    }

    function frm_direccion($id_recibo)
    {

        $r[] = '<form  class="form_registro_direccion" action="../procesar/?w=1" method="POST" >';
        $r[] = hiddens([
            "class" => "recibo",
            "name" => "recibo",
            "value" => $id_recibo,
        ]);
        $r[] = form_close();

        return append($r);

    }

    function frm_puntos($id_recibo)
    {

        $r[] = '<form   class="form_puntos_medios" action="../puntos_medios/?recibo=' . $id_recibo . '"  method="POST">';
        $r[] = hiddens([
            "name" => "recibo",
            "value" => $id_recibo,
        ]);
        $r[] = hiddens([
            "name" => "carro_compras",
            "value" => 0,
        ]);

        $r[] = hiddens([
            "name" => "id_carro_compras",
            "value" => 0,
        ]);
        $r[] = hiddens([
            "class" => "punto_encuentro_asignado",
            "name" => "punto_encuentro",
            "value" => 0,
        ]);


        $r[] = form_close();

        return append($r);

    }

    function frm_pe_avanzado($id_recibo)
    {


        $r[] = '<form   class="form_puntos_medios_avanzado" action="../puntos_medios/?recibo=' . $id_recibo . '"  method="POST">';
        $r[] = hiddens([
            "name" => "recibo",
            "value" => $id_recibo,
        ]);

        $r[] = hiddens([
            "name" => "avanzado",
            "value" => 1,
        ]);

        $r[] = hiddens([
            "class" => "punto_encuentro_asignado",
            "name" => "punto_encuentro",
            "value" => 0,
        ]);
        $r[] = hiddens([
            "name" => "carro_compras",
            "value" => 0,
        ]);

        $r[] = hiddens([
            "name" => "id_carro_compras",
            "value" => 0,
        ]);

        $r[] = form_close();

        return append($r);

    }

    function frm_nota($id_recibo)
    {

        $r[] = form_open("", [
            "class" => "form_notas row top_80 bottom_80 ",
            "style" => "display:none;",
        ]);
        $r[] = d("NOTA", "letter-spacing-10");
        $r[] = textarea([
            "name" => "comentarios",
            "class" => "comentarios form-control top_30 bottom_30",
        ]);
        $r[] = hiddens(["name" => "id_recibo", "value" => $id_recibo]);
        $r[] = btn("AGREGAR", ["name" => "comentarios"]);
        $r[] = form_close(place("place_nota"));

        return append($r);

    }

    function agregar_nueva_direccion($direccion = 1)
    {
        return ($direccion > 0) ?
            d(
                form_submit(
                    [
                        "class" => "agregar_punto_encuentro_pedido border-0 bg_black white",
                    ],
                    "Punto de entrega"
                ), 'ml-lg-3 mt-2'
            ) :
            d(
                form_submit(
                    [
                        "class" => "agregar_direccion_pedido border-0 bg_black white ",
                    ],
                    "Domicilio de envío"
                )
                , 'ml-lg-3 mt-2'
            );

    }


    function create_direcciones($domicilio_entrega, $lista, $id_recibo)
    {

        $a = 1;
        $r = [];

        $id_domicilio = pr($domicilio_entrega, 'id_direccion', 0);
        foreach ($lista as $row) {


            $text = [];
            $calle_numero = d(
                _text(
                    $row["calle"],
                    ' ',
                    'número ',
                    ' ',
                    $row["numero_exterior"]
                )
            );
            $interior_asentamiento = d(
                _text(

                    ' interior ',
                    $row["numero_interior"],
                    ' ',
                    $row["asentamiento"],
                    ' '
                )
            );

            $municipio_estado = d(
                _text(
                    $row["municipio"],
                    ' ',
                    $row["estado"]

                )
            );
            $codigo_postal = d(
                _text(
                    'C.P. ',
                    $row["cp"]

                )
            );
            $telefono = d(
                _text(
                    'teléfono:',
                    $row['telefono_receptor']
                )
            );

            $receptor = d(
                h(
                    substr($row['nombre_receptor'], 0, 19),
                    4,
                    'strong'
                )
            );
            $direccion = _text(
                $receptor,
                $calle_numero,
                $interior_asentamiento,
                $municipio_estado,
                $codigo_postal,
                $telefono
            );

            $id_direccion = $row['id_direccion'];
            $en_uso = ($id_domicilio == $id_direccion);
            $extra = ($en_uso) ? 'bg-light' : '';

            $text[] = d($direccion, 'text-uppercase mb-5 letter-spacing-1 p-2 ');
            if (!$en_uso) {
                $text[] = d(btn(
                    "entregar a esta dirección",
                    [
                        "class" => "establecer_direccion mt-2",
                        "id" => $row["id_direccion"],
                        "id_recibo" => $id_recibo,
                        'tipo' => 2,

                    ]
                ), 'p-1');
            }
            if ($en_uso) {

                $text[] = h(
                    text_icon('fa fa-check-circle', "domicilio de envío", [], 0),
                    5,
                    'text-uppercase text-right strong'

                );
            }

            $text[] = format_link(
                'eliminar',
                [
                    'class' => 'eliminar_domicilio mt-4 mb-5',
                    "id" => $row["id_direccion"],
                    "id_recibo" => $id_recibo,
                    'tipo' => 2,
                ],
                0);


            $r[] = d(append($text), _text("col-lg-4 mt-5 ", $extra));

        }

        return append($r);
    }

    function crea_puntos_entrega($punto_entrega, $lista_puntos_encuentro, $id_recibo)
    {

        $id_registro = pr($punto_entrega, 'id', 0);
        $r = [];
        if (es_data($lista_puntos_encuentro)) {
            $r[] = h('puntos de encuentro', 4, 'text-uppercase mt-5 strong text-right');
        }
        foreach ($lista_puntos_encuentro as $row) {

            $id = $row['id'];
            $nombre = ($id != $id_registro) ? $row['nombre'] : text_icon('fa fa-check-circle',
                $row['nombre']);
            $status = $row['status'];
            $id_tipo_punto_encuentro = $row['id_tipo_punto_encuentro'];
            $id_linea_metro = $row['id_linea_metro'];
            $costo_envio = $row['costo_envio'];

            $class = ($id != $id_registro) ? "dropdown-toggle bg-white w-100 text-right border-top-0 border-right-0 border-left-0 solid_bottom_2 mt-3" :
                "dropdown-toggle bg_black white w-100 text-right border-top-0 border-right-0 border-left-0 solid_bottom_2 mt-3";
            $button = form_button(
                [
                    "class" => $class,
                    "data-toggle" => "dropdown",
                    "aria-haspopup" => true,
                    "aria-expanded" => false,

                ], $nombre
            );

            $acciones = [];
            $acciones[] = d_p($nombre, 'strong');
            if ($id != $id_registro) {

                $acciones[] = format_link(
                    "Entregar en esta estación",
                    [
                        "class" => "establecer_direccion mt-2 mt-3",
                        "id" => $id,
                        'tipo' => 1,
                        "id_recibo" => $id_recibo,


                    ]
                );
            }

            $acciones[] = format_link(
                "Eliminar",
                [
                    'class' => 'eliminar_domicilio mt-3',
                    "id" => $id,
                    'tipo' => 1,
                    "id_recibo" => $id_recibo,

                ],
                0
            );

            $menu = d(append($acciones),
                [
                    "class" => "dropdown-menu mw_300 mh_100 p-4 border-0",

                ]
            );
            $punto_encuentro = d(add_text($button, $menu), 'dropleft');
            $r[] = d($punto_encuentro, 'text-right col-lg-12 p-0 mt-3');


        }

        return append($r);
    }

    function desc_direccion_entrega($data_direccion)
    {

        $text = [];

        if (es_data($data_direccion)) {
            if ($data_direccion["tipo_entrega"] == 2 && count($data_direccion["domicilio"]) > 0) {


                $domicilio = $data_direccion["domicilio"][0];
                $calle = $domicilio["calle"];

                $t = $calle . " " . " NÚMERO " .
                    $domicilio["numero_exterior"] . " NÚMERO INTERIOR " . $domicilio["numero_interior"] .
                    " COLONIA " . $domicilio["asentamiento"] . " DELEGACIÓN/MUNICIPIO " . $domicilio["municipio"] .
                    " ESTADO " . $domicilio["estado"] . " CÓDIGO POSTAL " . $domicilio["cp"];

                $text[] = $t;

            } else {

                if (is_array($data_direccion)
                    && array_key_exists("domicilio", $data_direccion)
                    && is_array($data_direccion["domicilio"])
                    && count($data_direccion["domicilio"]) > 0) {

                    $pe = $data_direccion["domicilio"][0];
                    $numero = "NÚMERO " . $pe["numero"];
                    $text[] = h("LUGAR DE ENCUENTRO", 3, ["class" => "top_20"]);
                    $text[] = d($pe["tipo"] . " " . $pe["nombre"] . " " . $numero . " COLOR " . $pe["color"],
                        1);
                    $text[] = d("ESTACIÓN " . $pe["lugar_entrega"], "strong", 1);


                }

            }
        }
        $response = append($text);

        return $response;
    }

    function accion_pago($recibo)
    {

        $response = "";
        if ($recibo["saldo_cubierto"] < 1) {

            $response = d(
                btn(
                    text_icon("fa fa-2x fa-shopping-cart",
                        "PROCEDER A LA COMPRA ", [], 0)
                    ,
                    [
                        "style" => "background:blue!important",
                        "class" => "top_30 f12",
                    ],
                    1,
                    1,
                    0,
                    path_enid("area_cliente_compras",
                        $recibo["id_proyecto_persona_forma_pago"])
                ), 1
            );

        }

        return $response;
    }

    function tiempo($recibo, $domicilio, $es_vendedor)
    {

        $linea = [];
        $flag = 0;
        $recibo = $recibo[0];
        $id_recibo = $recibo["id_proyecto_persona_forma_pago"];


        for ($i = 5; $i > 0; $i--) {

            $status = texto_status($i);
            $activo = 1;

            if ($flag == 0) {
                $activo = 0;
                if ($recibo["status"] == $status["estado"]) {
                    $activo = 1;
                    $flag++;
                }
            }

            switch ($i) {

                case 2:
                    $class = (tiene_domilio($domicilio,
                            1) == 0) ? "timeline__item__date" : "timeline__item__date_active";
                    $seccion_2 = seccion_domicilio($domicilio, $id_recibo,
                        $recibo["tipo_entrega"], $es_vendedor);

                    break;
                case 3:

                    $class = ($recibo["saldo_cubierto"] > 0) ? "timeline__item__date_active" : "timeline__item__date";
                    $seccion_2 = seccion_compra($recibo, $id_recibo, $es_vendedor);

                    break;


                default:
                    $class = ($activo > 0) ? "f12 timeline__item__date_active" : "timeline__item__date";
                    $seccion_2 = seccion_base($status);
                    break;

            }
            $seccion = d(icon("fa fa-check-circle-o"), $class);
            $linea[] = d($seccion . $seccion_2, "timeline__item");


        }

        return append($linea);
    }

    function seccion_base($status)
    {

        return d(p($status["text"], "timeline__item__content__description strong"),
            "timeline__item__content strong");

    }

    function seccion_compra($recibo, $id_recibo, $es_vendedor)
    {

        $path_ticket = path_enid('area_cliente_compras', $id_recibo);
        $pago_realizado = text_icon("fa fa-check black", "COMPRASTÉ!");
        $comprar = format_link("COMPRA AHORA!", ["href" => $path_ticket]);
        $text = ($recibo["saldo_cubierto"] > 0) ? $pago_realizado : $comprar;
        $seccion = d(
            p(
                $text
                ,

                "timeline__item__content__description strong"

            ),
            "timeline__item__content");

        return $seccion;
    }

    function seccion_domicilio($domicilio, $id_recibo, $tipo_entrega, $es_vendedor)
    {

        $url = path_enid(
            'pedido_seguimiento', _text($id_recibo, '&domicilio=1&asignacion=1')
        );

        $tipos_entrega = [
            "INDICA TU PUNTO DE ENTREGA",
            "INDICA EL DOMICILIO DE ENVÍO",
        ];

        $entrega = text_icon("fa fa-check", "DOMICILIO DE ENTREGA CONFIRMADO");
        if (tiene_domilio($domicilio, 1) < 1) {
            $entrega = format_link($tipos_entrega[$tipo_entrega - 1], ['href' => $url]);
        }


        $url = ($es_vendedor > 0) ? "" : $url;
        $seccion = d(
            p(
                a_enid(
                    $entrega,
                    [
                        "href" => $url,
                        "class" => "black strong",
                    ]
                ),
                "timeline__item__content__description black mt-4"
            ),
            "timeline__item__content"
        );

        return $seccion;
    }

    function texto_status($status)
    {

        $text = "";
        $estado = 6;

        switch ($status) {
            case 2:
                $text = "PAGO VERIFICADO";
                $estado = 1;
                break;

            case 1:
                $text = text_icon("fa fa-check", "ORDEN REALIZADA");
                $estado = 6;
                break;

            case 4:
                $text = "PEDIDO EN CAMINO";
                $estado = 7;
                break;

            case 5:
                $text = "ENTREGADO";
                $estado = 9;
                break;

            case 3:
                $text = "EMPACADO";
                $estado = 12;
                break;

            default:

                break;
        }

        $response = [
            "text" => $text,
            "estado" => $estado,
        ];

        return $response;

    }

    function create_seccion_comentarios($data)
    {

        $nota = [];
        if (es_data($data)) {

            $nota[] = h("Seguimiento al cliente", 4, "strong row mt-5 mb-5");
        }

        foreach ($data as $row) {


            $n = dd_p(
                text_icon("fa fa-clock-o",
                    date_format(date_create($row["fecha_registro"]),
                        'd M Y H:i:s'))
                ,
                $row["comentario"]
                ,
                4
            );

            $nota[] = d($n, "row mt-4 d-flex align-items-center  border-bottom");

        }


        return append($nota);


    }

    function crea_seccion_recordatorios($recordatorios)
    {


        $list = [];
        if (es_data($recordatorios)) {

            $list[] = h("Recordatorios", 4, "strong row mt-5 mb-5");
        }
        foreach ($recordatorios as $row) {

            $id_recordatorio = $row["id_recordatorio"];
            $status = ($row["status"] > 0) ? 0 : 1;


            $config = [
                "type" => "checkbox",
                "class" => "item_recordatorio checkbox_enid",
                "onclick" => "modifica_status_recordatorio({$id_recordatorio} , {$status})",
            ];

            if ($row["status"] > 0) {

                $config = [
                    "checked" => true,
                    "type" => "checkbox",
                    "class" => "checkbox_enid item_recordatorio",
                    "onclick" => "modifica_status_recordatorio({$id_recordatorio} , {$status})",
                ];

            }


            $a = hrz(
                input($config),
                d($row["descripcion"]) .
                d(
                    text_icon(
                        "fa fa-clock-o",
                        date_format(date_create($row["fecha_cordatorio"]),
                            'd M Y H:i:s')
                    )
                    ,
                    "text-right"
                )

                , 2,
                "flex row d-flex align-items-center  border-bottom mt-5 mb-5");


            $list[] = $a;

        }

        return append($list);
    }

    function create_seccion_tipificaciones($data)
    {

        $tipificacon = [];
        $r = [];
        foreach ($data as $row) {


            $tipificacon[] = flex(

                text_icon("fa fa-clock-o", $row["fecha_registro"])
                ,
                $row["nombre_tipificacion"]
                ,
                "row mt-4 d-flex align-items-center  border-bottom",
                "col-lg-4 p-0", "col-lg-8 p-0"
            );


        }

        if (es_data($data)) {

            $r[] = d(h("MOVIMIENTOS", 4, "strong row mt-5 mb-5"),
                " top_30 bottom_30 padding_10  row");
            $r[] = append($tipificacon);

        }

        return append($r);
    }

    function crea_seccion_productos($recibo)
    {

        $recibo = $recibo[0];
        $response = [];
        for ($a = 0; $a < $recibo["num_ciclos_contratados"]; $a++) {

            $r = [];
            $r[] =
                img(
                    [
                        "src" => $recibo["url_img_servicio"],
                        "class" => "img_servicio",
                    ]
                );

            $x = a_enid(
                append($r),
                [
                    "href" => path_enid("producto", $recibo["id_servicio"]),
                    "target" => "_black mah_250",
                ]
            );


            $response[] = ajustar(
                $x,
                p(add_text($recibo["precio"], "MXN"), "h3 strong text-primary"),
                4, "text-center border-bottom mb-5 row"
            );
        }

        return append($response);

    }

    function create_fecha_contra_entrega($recibo, $domicilio)
    {

        $fecha = "";
        if (prm_def($domicilio, "domicilio") > 0 && es_data($recibo)) {

            $recibo = $recibo[0];
            $t[] = d("ENTREGA PLANEADA PARA EL ");
            $t[] = d(date_format(date_create($recibo["fecha_contra_entrega"]),
                'd M Y H:i:s'), "ml-auto");
            $text = d(append($t),
                " d-flex p-3 row bg-light border border-primary border-top-0 border-right-0 border-left-0 strong mb-5");
            $fecha = ($recibo["tipo_entrega"] == 1) ? $text : "";

        }

        return $fecha;

    }

    function fecha_espera_servicio($recibo, $servicio)
    {


        $fecha = "";
        if (es_data($recibo) && es_data($servicio) && pr($servicio,
                "flag_servicio")) {

            $recibo = $recibo[0];
            $t[] = d("FECHA EN QUE SE ESPERA REALIZAR EL SERVICIO ",
                "strong underline");
            $t[] = d(date_format(date_create($recibo["fecha_contra_entrega"]),
                'd M Y H:i:s'), "ml-auto");
            $text = d(append($t),
                " d-flex p-3 row bg-light border border-primary border-top-0 border-right-0 border-left-0 strong mb-5");
            $fecha = ($recibo["tipo_entrega"] > 1) ? $text : "";
        }

        return $fecha;

    }


    function notificacion_cambio_fecha($recibo, $num_compras, $saldo_cubierto)
    {


        if (es_data($recibo)) {
            return "";
        }
        $tipo = $recibo[0]["tipo_entrega"];
        if ($tipo == 1 && $saldo_cubierto < 1) {

            $class = 'nula';
            $str_prob = "PROBABILIDAD NULA DE COMPRA";

            switch ($recibo[0]["modificacion_fecha"]) {

                case 0  :
                    $class = 'alta';
                    $str_prob = "PROBABILIDAD ALTA DE COMPRA";
                    break;
                case 1:

                    $class = 'media';
                    $str_prob = "PROBABILIDAD MEDIA DE COMPRA";
                    if ($num_compras > 0) {
                        $class = 'alta';
                        $str_prob = "PROBABILIDAD ALTA DE COMPRA";
                    }
                    break;
                case 2:
                    $class = 'baja';
                    $str_prob = "PROBABILIDAD BAJA DE COMPRA";
                    if ($num_compras > 0) {
                        $class = 'media';
                        $str_prob = "PROBABILIDAD MEDIA DE COMPRA";

                    }

                    break;
            }

            if ($recibo[0]["status"] == 10) {

                $class = 'baja';
                $str_prob = "PROBABILIDAD BAJA NULA (SE CANCELÓ)";

            }

            return d($str_prob, $class . " border shadow row", 1);
        }
    }

    function create_seccion_saldos($recibo)
    {

        $recibo = $recibo[0];
        $s_cubierto = $recibo["saldo_cubierto"];
        $total = $recibo["precio"] * $recibo["num_ciclos_contratados"] + $recibo["costo_envio_cliente"];

        $text[] = btw(
            d("ENVIO", "strong")
            ,
            d($recibo["costo_envio_cliente"] . "MXN")
            ,
            4
        );


        $text[] =
            btw(
                d("ENVIO", "strong")
                ,
                d($total . "MXN")
                ,
                4
            );


        $s_cubierto = $s_cubierto . "MXN";
        $s_cubierto = ($s_cubierto < 1) ? span($s_cubierto,
            "sin_pago") : span($s_cubierto, "pago_realizado");


        $text[] = btw(

            d("CUBIERTO", "strong")
            ,
            $s_cubierto
            ,
            "col-lg-4 text_saldo_cubierto"


        );

        return d(d(append($text), "row"), " border p-3 mt-3 mb-3 ");

    }

    function create_seccion_tipo_entrega($recibo, $tipos_entregas)
    {

        $r = [];
        if (es_data($recibo)):
            $tipo = "";
            $id_tipo_entrega = $recibo[0]["tipo_entrega"];
            foreach ($tipos_entregas as $row) {

                if ($row["id"] == $id_tipo_entrega) {
                    $tipo = $row["nombre"];
                    $r[] = hiddens(
                        [
                            "class" => "text_tipo_entrega",
                            "value" => $tipo,
                        ]
                    );
                    break;
                }
            }


            $encabezado = btw(

                h("TIPO DE ENTREGA " . $tipo, 4)
                ,
                d(icon("fa fa fa-pencil"), "editar_tipo_entrega ")
                ,
                "d-flex align-items-center justify-content-between mt-5 mb-1"

            );

            return add_text($encabezado, append($r));

        endif;

    }


    function crea_fecha_entrega($recibo)
    {

        $response = "";
        if (es_data($recibo)):
            $recibo = $recibo[0];
            $t[] = d(icon("fa fa-check-circle") . "PEDIDO ENTREGADO", "strong");
            $t[] = d($recibo["fecha_entrega"]);
            $text = ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9) ? append($t) : "";

            if ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9):
                $response = d($text,
                    "letter-spacing-5 top_30 border padding_10 botttom_20 contenedor_entregado mb-5 row");
            endif;

        endif;

        return $response;
    }

    function crea_estado_venta($status_ventas, $recibo)
    {

        $response = "";
        if (es_data($recibo)):
            if (
                pr($recibo, "se_cancela") < 1 &&
                pr($recibo, "status") != 10 &&
                pr($recibo, "cancela_cliente") < 1) {
                $status = pr($recibo, "status");
                $text_status = "";

                foreach ($status_ventas as $row) {

                    if ($status == $row["id_estatus_enid_service"]) {
                        $text_status = $row["text_vendedor"];
                        break;
                    }
                }
                $response = d($text_status, "row bg-dark white p-4 row mb-5");
            }
        endif;

        return $response;

    }

    function resumen_usuario($usuario, $recibo)
    {

        $r = [];
        $id_usuario = pr($recibo, "id_usuario");
        foreach ($usuario as $row) {

            $opt = ["MUJER", "HOMBRE", "INDEFINIDO"];
            $nombre =
                append([
                    es_null($row, "nombre"),
                    es_null($row, "apellido_paterno"),
                    es_null($row, "apellido_materno"),
                ]);


            $r[] = d($nombre);
            $r[] = d($row["email"]);
            $r[] = d($row["tel_contacto"]);
            $r[] = d($row["tel_contacto_alterno"]);

            if ($row["sexo"] != 2) {
                $r[] = d($opt[$row["sexo"]]);
            }


            $r[] = d(icon("fa-pencil configurara_informacion_cliente black"),
                " dropdown text-right");

        }

        $response = btw(

            ajustar("CLIENTE",
                icon("fa fa-cart-plus agenda_compra", ["id" => $id_usuario]))
            ,
            d(append($r), "contenido_domicilio top_10")
            ,

            " border p-3 mt-4"


        );

        return $response;
    }

    function compras_cliente($num)
    {

        $text = ($num > 0) ? $num . " COMPRAS A LO LARGO DEL TIEMPO " : "NUEVO PROSPECTO";
        $starts = ($num > 0) ? label("★★★★★", 'estrella') : "";

        return d(add_text($text, $starts), " border p-3 mt-3");

    }

    function tiene_domilio($domicilio, $numero = 0)
    {

        $f_text = "";
        $f_numeric = 0;
        if (es_data($domicilio["domicilio"])) {

            $f_numeric++;

        } else {

            $f_text = d("SIN DOMICIO REGISTRADO",
                "sin_domicilio padding_10 white mt-3");
        }

        return ($numero == 0) ? $f_text : $f_numeric;
    }

    function create_seccion_domicilio($domicilio)
    {
        $response = "";

        if (es_data($domicilio)) {

            $d_domicilio = $domicilio["domicilio"];
            $response = ($domicilio["tipo_entrega"] != 1) ? create_domicilio_entrega($d_domicilio) : create_punto_entrega($d_domicilio);

        } else {
            /*solicita dirección de envio*/
        }

        return $response;
    }

    function create_seccion_recordatorios($recibo)
    {

        return (es_data($recibo)) ? (($recibo[0]["status"] == 6) ? d("EMAIL RECORDATORIOS COMPRA " . $recibo[0]["num_email_recordatorio"],
            "") : "") : "";

    }

    function seccion_cupon($cupon)
    {

        $response = [];
        if (es_data($cupon)) {

            $response[] = h("CUPON PROMOCIONAL POR PRIMER COMPRA", 4, 'strong');
            $response[] = formated_link(pr($cupon, 'cupon'));
            $response[] = h(add_text("Valor ", money(pr($cupon, 'valor', 0))), 4);

        }

        return d(append($response), 'mt-2 border p-2');
    }


    function link_nota()
    {
        return d(a_enid("NOTA",
            ["class" => "agregar_comentario", "onClick" => "agregar_nota();"]));
    }

    function link_costo($id_recibo, $recibo)
    {
        if (es_data($recibo)) {
            $url = path_enid("pedidos",
                "/?costos_operacion=" . $id_recibo . "&saldado=" . pr($recibo,
                    "saldo_cubierto"));

            return d(a_enid("COSTO DE OPERACIÓN", ["href" => $url]));
        }

    }


    function link_cambio_fecha($domicilio, $recibo)
    {

        if (prm_def($domicilio, "domicilio") != 0 && count($recibo) > 0) {

            $recibo = $recibo[0];
            $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
            $status = $recibo["status"];
            $saldo_cubierto_envio = $recibo["saldo_cubierto_envio"];
            $monto_a_pagar = $recibo["monto_a_pagar"];
            $se_cancela = $recibo["se_cancela"];
            $fecha_entrega = $recibo["fecha_entrega"];

            return d(
                a_enid("FECHA DE ENTREGA",
                    [
                        "class" => "editar_horario_entrega",
                        "id" => $id_recibo,
                        "onclick" => "confirma_cambio_horario({$id_recibo} , {$status } , {$saldo_cubierto_envio} , {$monto_a_pagar} , {$se_cancela} , '{$fecha_entrega}' )",
                    ])
            );

        }
    }

    function link_recordatorio($recibo, $usuario)
    {

        $id_recibo = pr($recibo, "id_proyecto_persona_forma_pago");

        return d(a_enid("RECORDATORIO",
            path_enid("pedidos", "/?recibo=" . $id_recibo . "&recordatorio=1")));

    }


    function create_punto_entrega($domicilio)
    {

        $punto_encuentro = "";
        foreach ($domicilio as $row) {

            $id = $row["id_tipo_punto_encuentro"];
            $lugar_entrega = $row["lugar_entrega"];
            $tipo = $row["tipo"];
            $nombre_linea = $row["nombre_linea"];

            switch ($id) {

                //1 | LÍNEA DEL METRO
                case 1:
                    $punto_encuentro .=
                        strtoupper(strong("ESTACIÓN DEL METRO ") . $lugar_entrega . " LINEA " . $row["numero"] . " " . $nombre_linea . " COLOR " . $row["color"]);
                    break;
                //2 | ESTACIÓN DEL  METRO BUS
                case 2:
                    $punto_encuentro .=
                        $tipo . " " . $lugar_entrega . " " . $nombre_linea;
                    break;

                // 3 | CENTRO COMERCIAL
                case 3:

                    break;

                default:

                    break;
            }

        }
        $encabezado = d("PUNTO DE ENCUENTRO", "encabezado_domicilio");
        $encuentro = d(strtoupper($punto_encuentro), "contenido_domicilio p-0 mt-2");

        return d(add_text($encabezado, $encuentro),
            "contenedor_domicilio  border mt-3 mb-3 p-3");

    }

    function create_domicilio_entrega($domicilio)
    {

        $direccion = "";
        foreach ($domicilio as $row) {

            $direccion = $row["calle"] . " " .
                " NÚMERO " . $row["numero_exterior"] .
                " NÚMERO INTERIOR " . $row["numero_interior"] .
                " COLONIA " . $row["asentamiento"] . " DELEGACIÓN/MUNICIPIO " .
                $row["municipio"] . " ESTADO " . $row["estado"] . " CÓDIGO POSTAL " . $row["cp"];

        }
        $encabezado = d("DOMICIO DEL ENVIO", "encabezado_domicilio");
        $direccion = d(strtoupper($direccion), "contenido_domicilio top_10");

        return d($encabezado . $direccion, "shadow border padding_20 top_40");
    }

    function frm_usuario($usuario)
    {
        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $action = "../../q/index.php/api/usuario/index/format/json/";
            $attr = [
                "METHOD" => "PUT",
                "id" => "form_set_usuario",
                "class" => "border form_set_usuario padding_10 shadow",
            ];
            $form[] = form_open($action, $attr);
            $form[] = h("Cliente", 3, "strong");
            $form[] = d("NOMBRE:", "top_10", 1);
            $form[] = input([
                "name" => "nombre",
                "value" => $usuario["nombre"],
                "type" => "text",
                "required" => "true",
            ]);
            $form[] = d("APELLIDO PATERNO:", "top_10", 1);
            $form[] = input([
                "name" => "apellido_paterno",
                "value" => $usuario["apellido_paterno"],
                "type" => "text",
            ]);
            $form[] = d("APELLIDO MATERNO:", "top_10", 1);
            $form[] = input([
                "name" => "apellido_materno",
                "value" => $usuario["apellido_materno"],
                "type" => "text",
            ]);
            $form[] = d("EMAIL:", "top_10", 1);
            $form[] = input([
                'name' => 'email',
                'value' => $usuario["email"],
                "required" => "true",
                "class" => "input-sm email email",
                "onkeypress" => "minusculas(this);",
            ]);
            $form[] = d("TELÉFONO:", " top_10", 1);
            $form[] = input([
                'name' => 'tel_contacto',
                'value' => $usuario["tel_contacto"],
                "required" => "true",
                'type' => "tel",
                "maxlength" => 13,
                "minlength" => 8,
                "class" => "form-control input-sm  telefono telefono_info_contacto",
            ]);
            $form[] = input([
                "value" => $usuario["id_usuario"],
                "name" => "id_usuario",
                "type" => "hidden",

            ]);
            $opt[] = array(

                "text" => "Femenino",
                "val" => 0,
            );
            $opt[] = array(

                "text" => "Masculino",
                "val" => 1,
            );
            $opt[] = array(

                "text" => "Indefinido",
                "val" => 2,
            );
            $form[] = d(create_select($opt, "sexo", "sexo", "sexo", "text", "val", 1,
                $usuario["sexo"]), "top_20");
            $form[] = btn("GUARDAR", ["class" => "top_30 bottom_50"]);
            $form[] = form_close(place("place_form_set_usuario"));
            $f = d(append($form), ["id" => "contenedor_form_usuario"]);

            return $f;
        }


    }


//    function lista_puntos_encuentro(
//        $tipo_entrega,
//        $puntos_encuentro,
//        $id_recibo,
//        $domicilio = ''
//    )
//    {
//
//        $asignado = (is_array($domicilio) && $domicilio["tipo_entrega"] == 1) ? $domicilio["domicilio"][0]["id"] : 0;
//        $a = 1;
//        $r = [];
//        foreach ($puntos_encuentro as $row) {
//
//            $id = $row["id"];
//            $extra = ($id === $asignado) ? "asignado_actualmente" : "";
//            $str = [];
//            $str[] = d("#" . $a, ["class" => "f15"], 1);
//            $str[] = d($row["nombre"], 1);
//            $modificar = ($tipo_entrega < 2) ? " establecer_punto_encuentro " : "";
//
//            $str[] = btn("ESTABLECER COMO PUNTO DE ENTREGA",
//                [
//                    "class" => "h6 text-muted text-right  cursor_pointer  btn_direccion  " . $modificar,
//                    "id" => $id,
//                    "id_recibo" => $id_recibo,
//
//                ]
//            );
//            $r[] = d(append($str),
//                "top_50 border padding_10 contenedor_listado d-flex flex-column justify-content-between " . $extra);
//
//            $a++;
//        }
//
//        return append($r);
//
//    }
}
