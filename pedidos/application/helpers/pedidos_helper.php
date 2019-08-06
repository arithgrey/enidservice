<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_pendidos($data)
    {

        $orden = $data["orden"];
        $status_ventas = $data["status_ventas"];
        $recibo = $data["recibo"];
        $domicilio = $data["domicilio"];
        $num_compras = $data["num_compras"];
        $id_recibo = $data["id_recibo"];



        $r[] = format_resumen_pedidos($orden);
        $r[] = d(crea_estado_venta($status_ventas, $recibo), 1);
        $r[] = format_estados_venta($status_ventas, $recibo, $orden);
        $r[] = crea_seccion_solicitud($recibo);
        $r[] = crea_seccion_productos($recibo);
        $r[] = crea_fecha_entrega($recibo);
        $r[] = create_fecha_contra_entrega($recibo, $domicilio);
        $r[] = fecha_espera_servicio($recibo, $data["servicio"]);
        $r[] = notificacion_por_cambio_fecha($recibo, $num_compras, pr($recibo, "saldo_cubierto"));
        $r[] = addNRow(crea_seccion_recordatorios($data["recordatorios"]));
        $r[] = create_seccion_tipificaciones($data["tipificaciones"]);
        $r[] = addNRow(get_form_nota($id_recibo));
        $r[] = addNRow(create_seccion_comentarios($data["comentarios"]));

        $response[] = d(d(append($r), 12), 8);
        $response[] = d(get_format_resumen_cliente_compra($recibo, $data["tipos_entregas"], $domicilio, $num_compras, $data["usuario"], $id_recibo), 4);
        $response[] = get_hiddens_detalle($recibo);
        return d(append($response), "col-lg-10 col-lg-offset-1 top_50 bottom_100");

    }

    function render_seguimiento($data)
    {

        $recibo = $data["recibo"];
        $id_servicio = $data["id_servicio"];

        $z[] = format_resumen_seguimiento($recibo, $data["es_vendedor"], $data["evaluacion"], $data["status_ventas"], $data["domicilio"]);
        $z[] = format_heading_orden($data["servicio"], $recibo, $id_servicio);
        $z[] = d("", 4);
        $r[] = d(append($z), "top_50");
        $r[] = d(h("También te podría interezar", 3), "col-lg-12 top_50 hidden text_interes");
        $r[] = d(place("place_tambien_podria_interezar"), "col-lg-12 top_50");
        $r[] = input_hidden(["value" => $data["notificacion_pago"], "class" => "notificacion_pago"]);
        $r[] = input_hidden(["value" => $data["orden"], "class" => "orden"]);
        $r[] = input_hidden(["value" => $id_servicio, "class" => "qservicio"]);
        return append($r);


    }

    function format_resumen_seguimiento($recibo, $es_vendedor, $evaluacion, $status_ventas, $domicilio)
    {

        $r[] = d(get_motificacion_evaluacion($recibo, $es_vendedor, $evaluacion), 1);
        $r[] = d(h("RASTREAR PEDIDO" . icon("fa fa-map-signs"), 3), 1);
        $r[] = d(create_linea_tiempo($status_ventas, $recibo, $domicilio, $es_vendedor), "timeline top_40", 1);

        return d(append($r), 5);

    }

    function format_heading_orden($servicio, $recibo, $id_servicio)
    {


        $recibo = $recibo[0];


        $z = [];
        if ($recibo["cancela_cliente"] > 0 || $recibo["se_cancela"] > 0) {

            $z[] = d(h("ORDEN CANCELADA", 4));

        } else if ($recibo["status"] == 15) {

            $z[] = d(h("ORDEN ENTREGADA!", 4));

        } else {

            $fecha = (pr($servicio, "flag_servicio") > 0) ? prm_def($recibo, "fecha_servicio") :
                (prm_def($recibo, "tipo_entrega") == 2) ? prm_def($recibo, "fecha_contra_entrega") : prm_def($recibo, "fecha_vencimiento");

            $text = (pr($servicio, "flag_servicio") ) ?  "PLANEADO PARA EL DÍA " :"FECHA EN QUE SE  ESTIMADA LLEGARÁ TU PEDIDO";
            $z[] = d(h(add_text($text, $fecha), 4));

        }


        $a[] = btw(

            heading("ORDEN #" . prm_def($recibo, "id_proyecto_persona_forma_pago"), 3)
            ,
            a_enid(

                img(
                    [
                        "src" => prm_def($recibo, "url_img_servicio")
                    ]
                )
                ,
                get_url_servicio($id_servicio)
            )
        );
        $a[] = append($z);
        $r[] = d(append($a), 3);
        return append($r);

    }

    function render_domicilio($data)
    {
        $recibo = $data["recibo"];
        $domicilio = $data["domicilio"];
        $lista_direcciones = $data["lista_direcciones"];
        $recibo = $recibo[0];
        $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
        $id_servicio = $recibo["id_servicio"];
        $id_error = "imagen_" . $id_servicio;
        $tipo_entrega = $recibo["tipo_entrega"];


        $r[] = d(
            d(
                get_format_pre_orden(
                    $id_servicio,
                    $id_error,
                    $recibo,
                    $domicilio,
                    $id_recibo,
                    $lista_direcciones
                )
                ,

                " padding_20 shadow"
            ),
            5
        );
        $r[] = btw(

            d(get_forms_domicilio_entrega($id_recibo, $lista_direcciones), 6)
            ,
            d(get_format_listado_puntos_encuentro($tipo_entrega, $data["puntos_encuentro"], $id_recibo, $domicilio), 6)
            ,

            7
        );

        return append($r);

    }


    function format_resumen_pedidos($orden)
    {

        $r[] = d(a_enid("MIS PEDIDOS",
            [
                "href" => path_enid("pedidos"),
                "class" => "black underline"


            ]), 13);
        $r[] = d(
            btw(
                d(h("# ORDEN " . $orden, 3), "numero_orden encabezado_numero_orden row")
                ,
                d(
                    icon("fa fa-pencil"),
                    [
                        "class" => "text-right editar_estado",
                        "id" => $orden
                    ]
                ),
                "d-flex align-items-center justify-content-between bottom_30"
                ,
                1
            )
            ,
            1
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
            d(strong("SALDO CUBIERTO "))
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
                                "value" => $recibo[0]["saldo_cubierto"]
                            ]
                        )
                    ),
                    d("MXN", "ml-4 mxn ")
                    ,
                    "d-flex align-items-center justify-content-between "
                )
            )
            ,
            "d-flex align-items-center justify-content-between bottom_30 form_cantidad_post_venta top_20", 1
        );
        $r[] = place("mensaje_saldo_cubierto_post_venta");
        $r[] = form_cantidad($recibo, $orden);
        return d(append($r), "selector_estados_ventas top_20 bottom_20");


    }

    function crea_seccion_solicitud($recibo)
    {


        $r[] = d("SOLICITUD  ", "strong");
        $r[] = d($recibo[0]["fecha_registro"]);
        return d(append($r), "letter-spacing-5 bottom_30 row");


    }

    function get_format_costo_operacion($table_costos, $tipo_costos, $id_recibo, $path, $costos_operacion, $recibo)
    {


        $r[] = btw(

            h("COSTOS DE OPERACIÓN", 3)
            ,
            format_add_pedidos($table_costos)
            ,

            "contenedor_costos_registrados"
        );


        $r[] = d(get_form_costos($tipo_costos, $id_recibo, $costos_operacion), "display_none contenedor_form_costos_operacion");
        $response[] = d(append($r), 8);
        $response[] = d(format_img_recibo($path, $recibo), 4);

        return d(d(append($response), 10, 1), "row top_40");


    }

    function format_img_recibo($path, $recibo)
    {


        $response = "";
        if (is_array($recibo) && count($recibo) > 0) {

            $recibo = $recibo[0];
            $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
            $saldo_cubierto = $recibo["saldo_cubierto"];
            $articulos = $recibo["num_ciclos_contratados"];
            $monto_a_pagar = $recibo["monto_a_pagar"] * $articulos;
            $cancela_cliente = $recibo["cancela_cliente"];
            $se_cancela = $recibo["se_cancela"];
            $status = $recibo["status"];

            $r[] = d(a_enid(img($path), path_enid("pedidos_recibo", $id_recibo)), 1);
            $r[] = h(add_text("TOTAL ", $monto_a_pagar . "MXN"), 5);
            $r[] = h(add_text("CUBIERTO", $saldo_cubierto . "MXN"), 5);
            $r[] = h(add_text("ARTÍCULOS", $articulos), 5);

            if ($cancela_cliente > 0 || $se_cancela > 0 || $status == 10) {

                $r[] = h("ORDEN CANCELADA", 3, "red_enid strong");

            }

            $response = append($r);

        }

        return $response;

    }

    function get_format_resumen_cliente_compra($recibo, $tipos_entregas, $domicilio, $num_compras, $usuario, $id_recibo)
    {


        $r[] = create_seccion_tipo_entrega($recibo, $tipos_entregas);
        $r[] = d(
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
                "-"
            )
            ,
            "form_edicion_tipo_entrega top_20 bottom_50"

        );
        $r[] = get_format_menu($domicilio, $recibo, $id_recibo);
        $r[] = tiene_domilio($domicilio);
        $r[] = resumen_compras_cliente($num_compras);
        $r[] = create_seccion_usuario($usuario, $recibo);
        $r[] = get_form_usuario($usuario);
        $r[] = create_seccion_domicilio($domicilio);
        $r[] = addNRow(create_seccion_saldos($recibo));
        $r[] = d(create_seccion_recordatorios($recibo), "top_30 underline text-right");

        return d(append($r));

    }

    if (!function_exists('get_forms_domicilio_entrega')) {
        function get_forms_domicilio_entrega($id_recibo, $lista_direcciones)
        {

            $r[] = h("DOMICILIOS DE ENTREGA ", 3);
            $r[] = agregar_nueva_direccion(0);
            $r[] = ul(create_lista_direcciones($lista_direcciones, $id_recibo), "list-group list-group-flush");
            return append($r);

        }

    }

    if (!function_exists('get_forms')) {
        function get_forms($id_recibo)
        {

            $r[] = form_registro_direccion($id_recibo);
            $r[] = get_form_puntos_medios($id_recibo);
            $r[] = get_form_puntos_medios_avanzado($id_recibo);
            return append($r);

        }
    }
    if (!function_exists('format_add_pedidos')) {
        function format_add_pedidos($table_costos)
        {

            $r[] = $table_costos;

            $r[] = a_enid("Agregar",
                [
                    "class" => "underline top_50",
                    "style" => "font-size: 1.4em;color: #031326;",
                    "onclick" => "muestra_formulario_costo();"
                ]
            );

            return append($r);


        }

    }
    if (!function_exists('get_form_busqueda_pedidos')) {

        function get_form_busqueda_pedidos($data, $param)
        {

            $tipos_entregas = $data["tipos_entregas"];
            $status_ventas = $data["status_ventas"];

            $fechas[] = array(
                "fecha" => "FECHA REGISTRO",
                "val" => 1
            );
            $fechas[] = array(
                "fecha" => "FECHA CONTRA ENTREGA",
                "val" => 5
            );
            $fechas[] = array(
                "fecha" => "FECHA ENTREGA",
                "val" => 2
            );
            $fechas[] = array(
                "fecha" => "FECHA CANCELACION",
                "val" => 3
            );
            $fechas[] = array(
                "fecha" => "FECHA PAGO",
                "val" => 4
            );

            $r[] = h("ORDENES DE COMPRA", 3);
            $r[] = form_open("", ["class" => "form_busqueda_pedidos ", "method" => "post"]);
            $r[] = form_busqueda_pedidos($tipos_entregas, $status_ventas, $fechas);

            if (is_array($param) && array_key_exists("fecha_inicio", $param)

                && array_key_exists("fecha_termino", $param)

                && array_key_exists("type", $param)

                && array_key_exists("servicio", $param)

            ) {

                $r[] = d(frm_fecha_busqueda($param["fecha_inicio"], $param["fecha_termino"]));
                $r[] = input_hidden(["name" => "consulta", "class" => "consulta", "value" => 1]);
                $r[] = input_hidden(["name" => "servicio", "class" => "servicio", "value" => $param["servicio"]]);
                $r[] = input_hidden(["name" => "type", "class" => "type", "value" => $param["type"]]);


            } else {

                $r[] = d(frm_fecha_busqueda());
            }


            $r[] = form_close();
            $z[] = d(append($r), " border padding_10 shadow row seccion_form_pedidos top_50");
            $z[] = d(place("place_pedidos top_50 bottom_50"), 1);
            $z[] = d(form_form_search(), 1);

            $response = d(append($z), 10, 1);
            return $response;


        }
    }

    if (!function_exists('form_form_search')) {
        function form_form_search()
        {

            $r[] = form_open("", ["class" => "form_search", "method" => "GET"]);
            $r[] = input_hidden(["name" => "recibo", "value" => "", "class" => "numero_recibo"]);
            $r[] = form_close();
            return append($r);

        }

    }
    if (!function_exists('form_busqueda_pedidos')) {

        function form_busqueda_pedidos($tipos_entregas, $status_ventas, $fechas)
        {


            $r[] = btw(
                d("CLIENTE", "strong"),
                d(input([
                    "name" => "cliente",
                    "class" => "form-control",
                    "placeholder" => "Nombre, correo, telefono ..."
                ])),
                "col-lg-4 d-flex align-items-center justify-content-between"
            );
            $r[] = input_hidden([
                "name" => "v",
                'value' => 1

            ]);
            $r[] = btw(
                d("#RECIBO", "strong"),
                d(input([
                    "name" => "recibo",
                    "class" => "form-control"
                ])),
                "col-lg-4 d-flex align-items-center justify-content-between"
            );

            $r[] = btw(
                d("TIPO ENTREGA", "strong"),

                d(
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
                        "-")),
                "col-lg-4 d-flex align-items-center justify-content-between"

            );
            $r[] = btw(
                d("STATUS", "strong"),
                d(create_select(
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
                )),
                "col-lg-6 d-flex align-items-center justify-content-between"

            );


            $r[] = btw(
                d("ORDENAR", "strong"),
                create_select(
                    $fechas,
                    "tipo_orden",
                    "form-control",
                    "tipo_orden",
                    "fecha",
                    "val"
                ),
                "col-lg-6 d-flex align-items-center justify-content-between"
            );

            return append($r);

        }
    }

    if (!function_exists('get_format_pre_orden')) {

        function get_format_pre_orden($id_servicio, $id_error, $recibo, $domicilio, $id_recibo, $lista_direcciones)
        {

            $r[] = d(
                h(
                "ORDEN #" . $recibo["id_proyecto_persona_forma_pago"],
                1
            ),
                1

            );

            $x[] = d(img(
                [
                    "src" => link_imagen_servicio($id_servicio),
                    "class" => "imagen_servicio top_30"

                ]
            ), 4
            );
            $x[] = d("", 8);
            $r[] = d(append($x), 13);
            $r[] = d(
                h("DIRECCIÓN ENTREGA ESTABLECIDA", 3)
                ,
                "top_30"
                ,
                1
            );
            $r[] = d(create_descripcion_direccion_entrega($domicilio), " border-bottom padding_10 top_30 f12", 1);
            $r[] = d(valida_accion_pago($recibo), 1);

            $r[] = d(get_forms($id_recibo, $lista_direcciones), 1);
            return append($r);


        }

    }
    if (!function_exists('get_format_listado_puntos_encuentro')) {
        function get_format_listado_puntos_encuentro($tipo_entrega, $puntos_encuentro, $id_recibo, $domicilio)
        {


            $r[] = h("TUS PUNTOS DE ENCUENTRO ", 3);
            $r[] = agregar_nueva_direccion(1);
            $r[] = ul(lista_puntos_encuentro($tipo_entrega, $puntos_encuentro, $id_recibo, $domicilio));
            return append($r);
        }

    }
    if (!function_exists('get_hiddens_detalle')) {

        function get_hiddens_detalle($recibo)
        {

            $r = [];

            if (es_data($recibo)){
                $rb = $recibo[0];

                $r[] = input_hidden(
                    [
                        "class" => "status_venta_registro",
                        "name" => "status_venta",
                        "value" => $rb["status"],
                        "id" => "status_venta_registro"
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "saldo_actual_cubierto",
                        "name" => "saldo_cubierto",
                        "value" => $rb["saldo_cubierto"]
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "tipo_entrega_def",
                        "name" => "tipo_entrega",
                        "value" => $rb["tipo_entrega"]
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "id_servicio",
                        "name" => "id_servicio",
                        "value" => $rb["id_servicio"]
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "articulos",
                        "name" => "articulos",
                        "value" => $rb["num_ciclos_contratados"]
                    ]);
            }


            return append($r);

        }
    }
    if (!function_exists('get_format_menu')) {

        function get_format_menu($domicilio, $recibo, $id_recibo)
        {

            $x[] = get_link_cambio_fecha($domicilio, $recibo);
            $x[] = get_link_recordatorio($id_recibo);
            $x[] = get_link_nota();
            $x[] = get_link_costo($id_recibo, $recibo);
            $r[] = d(icon("fa fa-plus-circle fa-3x"), ["class" => " dropdown-toggle", "data-toggle" => "dropdown"]);
            $r[] = d(append($x), ["class" => "dropdown-menu  w_300 contenedor_opciones_pedido top_menos_10", "aria-labelledby" => "dropdownMenuButton"]);
            return d(append($r), "dropdown pull-right  mr-5 btn_opciones  ");


        }

    }

    if (!function_exists('get_motificacion_evaluacion')) {

        function get_motificacion_evaluacion($recibo, $es_vendedor, $evaluacion)
        {


            $response = "";
            if (es_data($recibo)){


                if ($recibo[0]["status"] == 9 && $es_vendedor < 1 && $evaluacion == 0) {

                    $id_servicio = $recibo[0]["id_servicio"];

                    $t[] = btn("ESCRIBE UNA RESEÑA");
                    $t[] = d(str_repeat("★", 5), ["class" => "text-center f2", "style" => "color: #010148;"]);
                    $response = a_enid(append($t), ["href" => path_enid("valoracion_servicio", $id_servicio)]);

                } elseif ($recibo[0]["status"] == 9 && $es_vendedor < 1 && $evaluacion > 0) {

                    $id_servicio = $recibo[0]["id_servicio"];
                    $t[] = btn("ESCRIBE UNA RESEÑA");
                    $t[] = d(str_repeat("★", 5), ["class" => "text-center f2", "style" => "color: #010148;"]);
                    $response = a_enid(append($t), ["href" => path_enid("producto", $id_servicio . "&valoracion=1")]);

                } else {

                }
            }
            return $response;


        }
    }

    if (!function_exists('get_form_fecha_recordatorio')) {
        function form_fecha_recordatorio($data, $tipo_recortario)
        {

            $orden = $data["orden"];
            $x = h("RECORDATORIO", 3, "top_50");
            $r[] = form_open("", ["class" => "form_fecha_recordatorio letter-spacing-5 "]);
            $r[] = d(icon("fa fa-calendar-o") . " FECHA ", 4);

            $r[] = d(
                input(
                    [
                        "data-date-format" => "yyyy-mm-dd",
                        "name" => 'fecha_cordatorio',
                        "class" => "form-control input-sm ",
                        "type" => 'date',
                        "value" => date("Y-m-d"),
                        "min" => add_date(date("Y-m-d"), -15),
                        "max" => add_date(date("Y-m-d"), 15)
                    ]),
                8
            );

            $r[] = d(icon("fa fa-clock-o") . " HORA", 3);

            $r[] = d(lista_horarios()["select"], 9);
            $r[] = input_hidden(
                [
                    "class" => "recibo",
                    "name" => "recibo",
                    "value" => $orden
                ]
            );

            $r[] = d(" TIPO", 3);
            $r[] = d(create_select($tipo_recortario, "tipo", "form-control tipo_recordatorio", "tipo_recordatorio", "tipo", "idtipo_recordatorio"), 9);
            $r[] = d(textarea(["name" => "descripcion", "class" => "descripcion_recordatorio"]), 12);
            $r[] = section(place("nota_recordatorio display_none"), 12);
            $r[] = d(btn("CONTINUAR", ["class" => "top_menos_40"]), 12);
            $r[] = form_close();
            $r[] = place("place_recordatorio");
            $form = d(append($r), "top_30 form_separador ");
            $response = d($x . $form, 6, 1);
            return $response;


        }
    }
    if (!function_exists('get_form_fecha_entrega')) {
        function get_form_fecha_entrega($data)
        {

            $orden = $data["orden"];
            $r[] = form_open("", ["class" => "form_fecha_entrega"]);
            $r[] = h("FECHA DE ENTREGA", 4, "strong titulo_horario_entra");
            $r[] = br();
            $r[] = label(text_icon("fa fa-calendar-o",  " FECHA ") , "col-lg-4 control-label");
            $r[] = d(
                input(
                    [
                        "data-date-format" => "yyyy-mm-dd",
                        "name" => 'fecha_entrega',
                        "class" => "form-control input-sm ",
                        "type" => 'date',
                        "value" => date("Y-m-d"),
                        "min" => add_date(date("Y-m-d"), -15),
                        "max" => add_date(date("Y-m-d"), 15)
                    ]),
                8);

            $r[] = label(text_icon("fa fa-clock-o" , " HORA DE ENCUENTRO"), "col-lg-4 control-label");
            $r[] = d(lista_horarios()["select"], 8);
            $r[] = input_hidden(
                [
                    "class" => "recibo",
                    "name" => "recibo",
                    "value" => $orden
                ]);
            $r[] = d(btn("CONTINUAR", ["class" => "top_20"]), 12);
            $r[] = place("place_notificacion_punto_encuentro");
            $r[] = form_close(place("place_fecha_entrega"));
            $response = append($r);
            $response = d($response, 6, 1);
            return $response;


        }

    }
    if (!function_exists('form_cantidad')) {
        function form_cantidad($recibo, $orden)
        {


            $r[] = '<form class="form_cantidad top_20">';
            $r[] = input_hidden(
                [
                    "name" => "recibo",
                    "class" => "recibo",
                    "value" => $orden
                ]);
            $r[] = d("MXN", "mxn col-lg-2");
            $r[] = place("mensaje_saldo_cubierto");
            $r[] = form_close();

            return append($r);

        }

    }

    if (!function_exists('get_form_costos')) {


        function get_form_costos($tipo_costos, $id_recibo, $costos_registrados)
        {

            $costos_por_registro = [];
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

                    $costos_por_registro[] = $row;

                }

            }


            $response = d(h("Ya registraste todos los costos de operación para esta venta!", 3), 8, 1);
            if (es_data($costos_por_registro)) {

                $r[] = d(h("Gasto", 3), "col-lg-12 bottom_50");
                $r[] = form_open("", ["class" => "form_costos letter-spacing-5"], ["recibo" => $id_recibo]);
                $a = d("MONTO GASTADO", 4);
                $b = d(
                    input(
                        [
                            "type" => "number",
                            "required" => true,
                            "class" => "form-control input precio",
                            "name" => "costo"
                        ]
                    ), 8);

                $r[] = btw($a, $b, "top_30");
                $r[] = d(
                    create_select(
                        $costos_por_registro,
                        "tipo",
                        "id_tipo_costo form-control",
                        "tipo",
                        "tipo",
                        "id_tipo_costo"
                    ), "col-lg-12 top_30");


                $r[] = d(btn("AGREGAR", ["class" => "top_30"]), 12);
                $r[] = form_close(place("notificacion_registro_costo"));
                $response = d(append($r), 10, 1);
            }
            return $response;

        }

    }
    if (!function_exists('get_error_message')) {
        function get_error_message()
        {


            $r[] = d(h("UPS! NO ENCONTRAMOS EL NÚMERO DE ORDEN", 1, "funny_error_message"), "text-center");
            $r[] = d(
                img(
                    [
                        "src" => "../img_tema/gif/funny_error.gif"
                    ]
                )
            );
            $r[] = d(a_enid("ENCUENTRA TU ORDEN AQUÍ",
                [
                    "href" => path_enid("pedidos"),
                    "class" => "busqueda_mensaje"
                ]),
                "busqueda_mensaje_text"
            );
            return d(append($r));

        }
    }


    if (!function_exists('form_registro_direccion')) {
        function form_registro_direccion($id_recibo)
        {

            $r[] = '<form  class="form_registro_direccion" action="../procesar/?w=1" method="POST" >';
            $r[] = input_hidden(["class" => "recibo", "name" => "recibo", "value" => $id_recibo]);
            $r[] = form_close();
            return append($r);

        }
    }

    if (!function_exists('get_form_puntos_medios')) {
        function get_form_puntos_medios($id_recibo)
        {

            $r[] = '<form   class="form_puntos_medios" action="../puntos_medios/?recibo=' . $id_recibo . '"  method="POST">';
            $r[] = input_hidden([
                "name" => "recibo",
                "value" => $id_recibo
            ]);
            $r[] = input_hidden([
                "name" => "carro_compras",
                "value" => 0
            ]);

            $r[] = input_hidden([
                "name" => "id_carro_compras",
                "value" => 0
            ]);

            $r[] = form_close();
            return append($r);

        }
    }
    if (!function_exists('get_form_puntos_medios_avanzado')) {

        function get_form_puntos_medios_avanzado($id_recibo)
        {


            $r[] = '<form   class="form_puntos_medios_avanzado" action="../puntos_medios/?recibo=' . $id_recibo . '"  method="POST">';
            $r[] = input_hidden([
                "name" => "recibo",
                "value" => $id_recibo
            ]);

            $r[] = input_hidden([
                "name" => "avanzado",
                "value" => 1
            ]);

            $r[] = input_hidden([
                "class" => "punto_encuentro_asignado",
                "name" => "punto_encuentro",
                "value" => 0
            ]);
            $r[] = input_hidden([
                "name" => "carro_compras",
                "value" => 0
            ]);

            $r[] = input_hidden([
                "name" => "id_carro_compras",
                "value" => 0
            ]);

            $r[] = form_close();

            return append($r);

        }

    }
    if (!function_exists('get_form_nota')) {
        function get_form_nota($id_recibo)
        {

            $r[] = form_open("", ["class" => "form_notas row top_80 bottom_80 ", "style" => "display:none;"]);
            $r[] = d("NOTA", "letter-spacing-10");
            $r[] = textarea(["name" => "comentarios", "class" => "comentarios form-control top_30 bottom_30"]);
            $r[] = input_hidden(["name" => "id_recibo", "value" => $id_recibo]);
            $r[] = btn("AGREGAR", ["name" => "comentarios"]);
            $r[] = form_close(place("place_nota"));
            return append($r);

        }
    }
    if (!function_exists('agregar_nueva_direccion')) {
        function agregar_nueva_direccion($direccion = 1)
        {
            return ($direccion > 0) ? btn("Agregar ", ["class" => "agregar_punto_encuentro_pedido"]) : btn("Agregar ", ["class" => "agregar_direccion_pedido"]);

        }
    }
    if (!function_exists('lista_puntos_encuentro')) {
        function lista_puntos_encuentro($tipo_entrega, $puntos_encuentro, $id_recibo, $domicilio = '')
        {

            $asignado = (is_array($domicilio) && $domicilio["tipo_entrega"] == 1) ? $domicilio["domicilio"][0]["id"] : 0;
            $a = 1;
            $r = [];
            foreach ($puntos_encuentro as $row) {

                $id = $row["id"];
                $extra = ($id === $asignado) ? "asignado_actualmente" : "";
                $encuentro = [];
                $encuentro[] = d("#" . $a, ["class" => "f15"], 1);
                $encuentro[] = d($row["nombre"], 1);
                $modificar_encuentro = ($tipo_entrega < 2) ? " establecer_punto_encuentro " : "";

                $encuentro[] = btn("ESTABLECER COMO PUNTO DE ENTREGA",
                    [
                        "class" => "h6 text-muted text-right  cursor_pointer  btn_direccion  " . $modificar_encuentro,
                        "id" => $id,
                        "id_recibo" => $id_recibo

                    ]
                );
                $r[] = d(append($encuentro), "top_50 border padding_10 contenedor_listado d-flex flex-column justify-content-between " . $extra);

                $a++;
            }

            return append($r);

        }
    }
    if (!function_exists('create_lista_direcciones')) {
        function create_lista_direcciones($lista, $id_recibo)
        {

            $a = 1;
            $r = [];
            foreach ($lista as $row) {


                $direccion = $row["calle"] . " " . " NÚMERO " . $row["numero_exterior"] .
                    " NÚMERO INTERIOR " . $row["numero_interior"] . " COLONIA " .
                    $row["asentamiento"] . " DELEGACIÓN/MUNICIPIO " . $row["municipio"] .
                    " ESTADO " . $row["estado"] . " CÓDIGO POSTAL " . $row["cp"];

                $text = [];
                $text[] = d("#" . $a, "f15", 1);
                $text[] = d($direccion, 1);
                $text[] =
                    btn("ESTABLECER COMO DIRECCIÓN DE ENTREGA",
                        [
                            "class" => " establecer_direccion cursor_pointer",
                            "id" => $row["id_direccion"],
                            "id_recibo" => $id_recibo
                        ]
                    );

                $a++;

                $r[] = d(append($text), "top_50 border padding_10 contenedor_listado d-flex flex-column justify-content-between");


            }
            return append($r);
        }
    }
    if (!function_exists('create_descripcion_direccion_entrega')) {
        function create_descripcion_direccion_entrega($data_direccion)
        {

            $text = [];

            if (is_array($data_direccion)) {
                if ($data_direccion["tipo_entrega"] == 2 && count($data_direccion["domicilio"]) > 0) {


                    $domicilio = $data_direccion["domicilio"][0];
                    $calle = $domicilio["calle"];

                    $t = $calle . " " . " NÚMERO " .
                        $domicilio["numero_exterior"] . " NÚMERO INTERIOR " . $domicilio["numero_interior"] .
                        " COLONIA " . $domicilio["asentamiento"] . " DELEGACIÓN/MUNICIPIO " . $domicilio["municipio"] .
                        " ESTADO " . $domicilio["estado"] . " CÓDIGO POSTAL " .  $domicilio["cp"];

                    $text[] = $t;

                } else {

                    if (is_array($data_direccion)
                        && array_key_exists("domicilio", $data_direccion)
                        && is_array($data_direccion["domicilio"])
                        && count($data_direccion["domicilio"]) > 0) {

                        $punto_encuentro = $data_direccion["domicilio"][0];
                        $tipo = $punto_encuentro["tipo"];
                        $color = $punto_encuentro["color"];
                        $nombre_estacion = $punto_encuentro["nombre"];
                        $lugar_entrega = $punto_encuentro["lugar_entrega"];
                        $numero = "NÚMERO " . $punto_encuentro["numero"];

                        $text[] = h("LUGAR DE ENCUENTRO", 3, ["class" => "top_20"]);
                        $text[] = d($tipo . " " . $nombre_estacion . " " . $numero . " COLOR " . $color, 1);
                        $text[] = d("ESTACIÓN " . $lugar_entrega, "strong", 1);


                    }

                }
            }
            $response = append($text);
            return $response;
        }

    }
    if (!function_exists('valida_accion_pago')) {
        function valida_accion_pago($recibo)
        {

            $response = "";
            if ($recibo["saldo_cubierto"] < 1) {

                $response = d(
                    btn(
                        text_icon("fa fa-2x fa-shopping-cart", "PROCEDER A LA COMPRA ", [], 0)
                        ,
                        [
                            "style" => "background:blue!important",
                            "class" => "top_30 f12"
                        ],
                        1,
                        1,
                        0,
                        path_enid("area_cliente_compras", $recibo["id_proyecto_persona_forma_pago"])
                    ), 1
                );

            }
            return $response;
        }
    }
    if (!function_exists('create_linea_tiempo')) {

        function create_linea_tiempo($status_ventas, $recibo, $domicilio, $es_vendedor)
        {

            $linea = [];
            $flag = 0;
            $recibo = $recibo[0];
            $id_recibo = $recibo["id_proyecto_persona_forma_pago"];


            for ($i = 5; $i > 0; $i--) {

                $status = get_texto_status($i);
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
                        $class = (tiene_domilio($domicilio, 1) == 0) ? "timeline__item__date" : "timeline__item__date_active";
                        $seccion_2 = get_seccion_domicilio($domicilio, $id_recibo, $recibo["tipo_entrega"], $es_vendedor);

                        break;
                    case 3:

                        $class = ($recibo["saldo_cubierto"] > 0) ? "timeline__item__date_active" : "timeline__item__date";
                        $seccion_2 = get_seccion_compra($recibo, $id_recibo, $es_vendedor);

                        break;


                    default:
                        $class = ($activo == 1) ? "timeline__item__date_active" : "timeline__item__date";
                        $seccion_2 = seccion_base($status);
                        break;

                }
                $seccion = d(icon("fa fa-check-circle-o"), $class);
                $linea[] = d($seccion . $seccion_2, "timeline__item");


            }
            return append($linea);
        }
    }
    if (!function_exists('seccion_base')) {
        function seccion_base($status)
        {

            return  d(p($status["text"], "timeline__item__content__description"), "timeline__item__content");

        }
    }
    if (!function_exists('get_seccion_compra')) {
        function get_seccion_compra($recibo, $id_recibo, $es_vendedor)
        {

            $text = ($recibo["saldo_cubierto"] > 0) ? text_icon("fa fa-check" , "REALIZASTE TU COMPRA")   : "REALIZA TU COMPRA";
            $url = "../area_cliente/?action=compras&ticket=" . $id_recibo;
            $url = ($es_vendedor > 0) ? "" : $url;

            $seccion = d(
                p(
                    a_enid(

                        $text,

                        [

                            "href" => $url,

                            "class" => "text-line-tiempo"

                        ]
                    )
                    ,

                    "timeline__item__content__description"

                ),
                "timeline__item__content");

            return $seccion;
        }
    }
    if (!function_exists('get_seccion_domicilio')) {
        function get_seccion_domicilio($domicilio, $id_recibo, $tipo_entrega, $es_vendedor)
        {

            $texto_entrega = "DOMICILIO DE ENTREGA CONFIRMADO " . icon("fa fa-check");

            if (tiene_domilio($domicilio, 1) == 0) {
                $texto_entrega = ($tipo_entrega == 1) ? "REGISTRA TU DIRECCIÓN DE ENTREGA" : "INDICA TU PUNTO DE DE ENTREGA";
            }


            $url = "../pedidos/?seguimiento=" . $id_recibo . "&domicilio=1";
            $url = ($es_vendedor > 0) ? "" : $url;

            $seccion = d(
                p(
                    a_enid($texto_entrega,
                        [
                            "href" => $url,
                            "class" => "text-line-tiempo"
                        ]
                    ),
                    "timeline__item__content__description"
                ),
                "timeline__item__content"
            );
            return $seccion;
        }
    }
    if (!function_exists('get_texto_status')) {
        function get_texto_status($status)
        {

            $text = "";
            $estado = 6;

            switch ($status) {
                case 2:
                    $text = "PAGO VERIFICADO";
                    $estado = 1;
                    break;

                case 1:
                    $text = text_icon("fa fa-check", "ORDEN REALIZADA" ) ;
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
    }
    if (!function_exists('create_seccion_comentarios')) {
        function create_seccion_comentarios($data)
        {

            $nota = [];
            if (es_data($data)) {
                $nota[] = d(h("NOTAS", 4), 13);
            }

            foreach ($data as $row) {


                $n = btw(

                    d(icon("fa fa-clock-o") . " " . $row["fecha_registro"], 4)
                    ,

                    d($row["comentario"], 8)
                    ,
                    "row"

                );


                $nota[] = d($n, "seccion_tipificacion top_30 bottom_30 padding_10 border row");

            }


            return d(append($nota), 1);


        }
    }
    if (!function_exists('crea_seccion_recordatorios')) {
        function crea_seccion_recordatorios($recordatorios)
        {


            $list = [];
            foreach ($recordatorios as $row) {

                $id_recordatorio = $row["id_recordatorio"];
                $status = ($row["status"] > 0) ? 0 : 1;


                $config = ["type" => "checkbox", "class" => "form-control item_recordatorio", "onclick" => "modifica_status_recordatorio({$id_recordatorio} , {$status})"];

                if ($row["status"] > 0) {

                    $config = ["checked" => true, "type" => "checkbox", "class" => "form-control item_recordatorio", "onclick" => "modifica_status_recordatorio({$id_recordatorio} , {$status})"];

                }

                $r = [];

                $r[] =
                    btw(

                        d($row["descripcion"], 9)
                        ,
                        d(input($config), 3)
                        ,
                        "row"

                    );

                $r[] = btw(

                    d(text_icon("fa fa-clock-o", $row["fecha_cordatorio"])    , 1)
                    ,
                    d($row["tipo"], 1)
                    ,
                    "row"
                );


                $list[] = d(append($r), "row border padding_10 top_30");

            }
            return d(append($list), ["id" => "listado_recordatorios bottom_40"]);
        }
    }
    if (!function_exists('create_seccion_tipificaciones')) {
        function create_seccion_tipificaciones($data)
        {

            $tipificaciones = "";
            $r = [];
            foreach ($data as $row) {


                $tipificaciones = btw(

                    d(text_icon("fa fa-clock-o", $row["fecha_registro"]), 3)
                    ,
                    d($row["nombre_tipificacion"], 9)
                    ,
                    "row"
                );


            }

            if (es_data($data)) {
                $r[] = d(h("MOVIMIENTOS", 4, "row"), " top_30 bottom_30 padding_10  row");
                $r[] = d($tipificaciones, " top_30 bottom_30 padding_10 border row");
            }
            return append($r);
        }
    }
    if (!function_exists('crea_seccion_productos')) {
        function crea_seccion_productos($recibo)
        {

            $recibo = $recibo[0];

            $response = [];
            for ($a = 0; $a < $recibo["num_ciclos_contratados"]; $a++) {


                $text_producto =
                    d(

                        add_text($recibo["precio"] , "MXN"),
                        "text_precio_producto"

                    );


                $r = [];

                $r[] = d(
                    img(
                        [
                            "src" => $recibo["url_img_servicio"],
                            "class" => "img_servicio",
                        ]
                    ),
                    4
                );

                $r[] = d($text_producto, "col-lg-8 align-middle  align-self-center text-center");


                $x = a_enid(

                    d(
                        append($r), "border row "
                    ),

                    [
                        "href" => path_enid("producto", $recibo["id_servicio"]),
                        "target" => "_black",
                    ]
                );


                $response[] = $x;
            }
            return d(append($response), 1);

        }
    }

    if (!function_exists('create_fecha_contra_entrega')) {
        function create_fecha_contra_entrega($recibo, $domicilio)
        {

            if (prm_def($domicilio, "domicilio") > 0 && es_data($recibo)) {

                $recibo = $recibo[0];
                $t[] = d("HORARIO DE ENTREGA", "strong underline");
                $t[] = d($recibo["fecha_contra_entrega"]);
                $text = d(append($t), "letter-spacing-5 text-right top_30 bottom_30");
                $fecha = ($recibo["tipo_entrega"] == 1) ? $text : "";
                return $fecha;
            }
        }
    }
    if (!function_exists('fecha_servicio')) {
        function fecha_espera_servicio($recibo, $servicio)
        {

            $r = [];
            if (es_data($recibo) && es_data($servicio) && pr($servicio, "flag_servicio")) {

                $recibo = $recibo[0];
                $t[] = d("FECHA EN QUE SE ESPERA EL SERVICIO ", "strong underline");
                $t[] = d($recibo["fecha_servicio"]);
                $text = d(append($t), "letter-spacing-5 text-right top_30 bottom_30");
                $fecha = ($recibo["tipo_entrega"] > 1) ? $text : "";
                return $fecha;

            }
            return append($r);

        }
    }

    if (!function_exists('notificacion_por_cambio_fecha')) {
        function notificacion_por_cambio_fecha($recibo, $num_compras, $saldo_cubierto)
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
    }

    if (!function_exists('create_seccion_saldos')) {
        function create_seccion_saldos($recibo)
        {

            $recibo = $recibo[0];
            $saldo_cubierto = $recibo["saldo_cubierto"];
            $total_pago = $recibo["precio"] * $recibo["num_ciclos_contratados"] + $recibo["costo_envio_cliente"];

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
                    d($total_pago . "MXN")
                    ,
                    4
                );


            $saldo_cubierto = $saldo_cubierto . "MXN";
            $saldo_cubierto = ($saldo_cubierto < 1) ? span($saldo_cubierto, "sin_pago") : span($saldo_cubierto, "pago_realizado");


            $text[] = btw(

                d("CUBIERTO", "strong")
                ,
                $saldo_cubierto
                ,
                "col-lg-4 text_saldo_cubierto"


            );

            return d(d(append($text), "row"), "shadow border padding_20 top_40 ");

        }
    }
    if (!function_exists('create_seccion_tipo_entrega')) {
        function create_seccion_tipo_entrega($recibo, $tipos_entregas)
        {

            $r = [];
            if (es_data($recibo)):
                $tipo = "";
                $id_tipo_entrega = $recibo[0]["tipo_entrega"];
                foreach ($tipos_entregas as $row) {

                    if ($row["id"] == $id_tipo_entrega) {
                        $tipo = $row["nombre"];
                        $r[] = input_hidden(
                            [
                                "class" => "text_tipo_entrega",
                                "value" => $tipo
                            ]
                        );
                        break;
                    }
                }


                $encabezado = btw(

                    h("TIPO DE ENTREGA", 3)
                    ,
                    d(icon("fa fa fa-pencil"), "editar_tipo_entrega text-right")
                    ,
                    "d-flex align-items-center justify-content-between bottom_30"

                );

                $tipo = d($tipo, "encabezado_tipo_entrega letter-spacing-5  text-right bottom_20", 1);
                return d($encabezado . $tipo . append($r), "contenedor_tipo_entrega", 1);

            endif;

        }

    }
    if (!function_exists('crea_fecha_entrega')) {
        function crea_fecha_entrega($recibo)
        {

            $response = "";
            if (es_data($recibo)):
                $recibo = $recibo[0];
                $t[] = d(icon("fa fa-check-circle") . "PEDIDO ENTREGADO", "strong");
                $t[] = d($recibo["fecha_entrega"]);
                $text = ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9) ? append($t) : "";

                if ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9):
                    $response = d($text, "letter-spacing-5 top_30 border padding_10 botttom_20 contenedor_entregado", 1);
                endif;

            endif;
            return $response;
        }
    }
    /**NO canceladas*/
    if (!function_exists('crea_estado_venta')) {
        function crea_estado_venta($status_ventas, $recibo)
        {

            $response = "";
            if (es_data($recibo)):
                if (
                    pr($recibo, "se_cancela") < 1 &&
                    pr($recibo, "status") != 10 &&
                    pr($recibo, "cancela_cliente") < 1) {

                    $status = $recibo[0]["status"];
                    $text_status = "";
                    foreach ($status_ventas as $row) {

                        if ($status == $row["id_estatus_enid_service"]) {
                            $text_status = $row["text_vendedor"];
                            break;
                        }
                    }
                    $response = d($text_status, "status_compra padding_20 white letter-spacing-5 bottom_20 row");
                }
            endif;
            return $response;

        }
    }
    if (!function_exists('create_seccion_usuario')) {
        function create_seccion_usuario($usuario, $recibo)
        {

            $r = [];
            $id_usuario = pr($recibo, "id_usuario");
            foreach ($usuario as $row) {

                $opt = ["MUJER", "HOMBRE", "INDEFINIDO"];
                $nombre =
                    append([
                        es_null($row, "nombre"),
                        es_null($row, "apellido_paterno"),
                        es_null($row, "apellido_materno")
                    ]);


                $r[] = d($nombre);
                $r[] = d($row["email"]);
                $r[] = d($row["tel_contacto"]);
                $r[] = d($row["tel_contacto_alterno"]);

                if ($row["sexo"] != 2) {

                    $r[] = d($opt[$row["sexo"]]);
                }

                $icon = icon("fa-pencil configurara_informacion_cliente black");
                $r[] = d($icon, "pull-right dropdown", 1);

            }

            $response = btw(

                ajustar("CLIENTE", icon("fa fa-cart-plus agenda_compra", ["id" => $id_usuario]))
                ,
                d(append($r), "contenido_domicilio top_10")
                ,

                "shadow border padding_20 top_40"


            );

            return $response;
        }
    }
    if (!function_exists('resumen_compras_cliente')) {
        function resumen_compras_cliente($num)
        {

            $text = ($num > 0) ? $num . " COMPRAS A LO LARGO DEL TIEMPO " : "NUEVO PROSPECTO";
            $starts = ($num > 0) ? label("★★★★★",
                [
                    "class" => 'estrella',
                ]
            ) : "";

            return d($text . $starts, ["class" => "shadow border padding_20"]);

        }
    }

    if (!function_exists('tiene_domilio')) {
        function tiene_domilio($domicilio, $numero = 0)
        {

            $f_text = "";
            $f_numeric = 0;
            if (es_data($domicilio["domicilio"])) {

                $f_numeric++;

            } else {

                $f_text = d("SIN DOMICIO REGISTRADO", "sin_domicilio padding_10 white", 1);
            }

            return ($numero == 0) ? $f_text : $f_numeric;
        }
    }
    if (!function_exists('create_seccion_domicilio')) {
        function create_seccion_domicilio($domicilio)
        {
            $response = "";

            if (es_data($domicilio, "domicilio")) {

                $data_domicilio = $domicilio["domicilio"];
                $response = ($domicilio["tipo_entrega"] != 1) ? create_domicilio_entrega($data_domicilio) : create_punto_entrega($data_domicilio);

            } else {
                /*solicita dirección de envio*/
            }

            return $response;
        }
    }
    if (!function_exists('create_seccion_recordatorios')) {
        function create_seccion_recordatorios($recibo)
        {

            return (es_data($recibo)) ? (($recibo[0]["status"] == 6) ? d("EMAIL RECORDATORIOS COMPRA " . $recibo[0]["num_email_recordatorio"], "") : "") : "";

        }
    }

    if (!function_exists('get_link_nota')) {
        function get_link_nota()
        {
            return d(a_enid("NOTA", ["class" => "agregar_comentario", "onClick" => "agregar_nota();"]), 1);
        }
    }
    if (!function_exists('get_link_costo')) {
        function get_link_costo($id_recibo, $recibo)
        {


            if (es_data($recibo)):
                $recibo = $recibo[0];

                $url = path_enid("pedidos", "/?costos_operacion=" . $id_recibo . "&saldado=" .  $recibo["saldo_cubierto"]);
                return d(a_enid("COSTO DE OPERACIÓN", ["href" => $url]), 1);
            endif;
        }
    }

    if (!function_exists('get_link_cambio_fecha')) {
        function get_link_cambio_fecha($domicilio, $recibo)
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
                            "class" => "editar_horario_entrega  text-right ",
                            "id" => $id_recibo,
                            "onclick" => "confirma_cambio_horario({$id_recibo} , {$status } , {$saldo_cubierto_envio} , {$monto_a_pagar} , {$se_cancela} , '{$fecha_entrega}' )"
                        ]), 1
                );

            }


        }
    }
    if (!function_exists('get_link_recordatorio')) {
        function get_link_recordatorio($id_recibo)
        {

            return d(a_enid("RECORDATORIO", path_enid("pedidos", "/?recibo=" . $id_recibo . "&recordatorio=1")), 1);

        }
    }
    if (!function_exists('create_punto_entrega')) {
        function create_punto_entrega($domicilio)
        {

            $punto_encuentro = "";
            foreach ($domicilio as $row) {

                $id = $row["id_tipo_punto_encuentro"];
                $lugar_entrega = $row["lugar_entrega"];
                $tipo = $row["tipo"];
                $nombre_linea = $row["nombre_linea"];
                $color = $row["color"];
                $numero = $row["numero"];

                switch ($id) {

                    //1 | LÍNEA DEL METRO
                    case 1:
                        $punto_encuentro .=
                            strtoupper(strong("ESTACIÓN DEL METRO ") . $lugar_entrega . " LINEA " . $numero . " " . $nombre_linea . " COLOR " . $color);
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
            $encabezado = d("PUNTO DE ENCUENTRO", "encabezado_domicilio", 1);
            $encuentro = d(strtoupper($punto_encuentro), "contenido_domicilio", 1);
            return d($encabezado . $encuentro, "contenedor_domicilio shadow border padding_20 top_40");

        }
    }
    if (!function_exists('create_domicilio_entrega')) {
        function create_domicilio_entrega($domicilio)
        {

            $direccion = "";
            foreach ($domicilio as $row) {

                $calle = $row["calle"];
                $numero_exterior = $row["numero_exterior"];
                $numero_interior = $row["numero_interior"];
                $cp = $row["cp"];
                $asentamiento = $row["asentamiento"];
                $municipio = $row["municipio"];
                $estado = $row["estado"];
                $direccion = $calle . " " . " NÚMERO " . $numero_exterior . " NÚMERO INTERIOR " . $numero_interior . " COLONIA " . $asentamiento . " DELEGACIÓN/MUNICIPIO " . $municipio . " ESTADO " . $estado . " CÓDIGO POSTAL " . $cp;

            }
            $encabezado = d("DOMICIO DEL ENVIO", "encabezado_domicilio", 1);
            $direccion = d(strtoupper($direccion), "contenido_domicilio top_10", 1);
            return d($encabezado . $direccion, "shadow border padding_20 top_40", 1);
        }
    }
    if (!function_exists('get_form_usuario')) {
        function get_form_usuario($usuario)
        {


            if (es_data($usuario)) {

                $usuario = $usuario[0];
                $nombre = $usuario["nombre"];
                $apellido_paterno = $usuario["apellido_paterno"];
                $apellido_materno = $usuario["apellido_materno"];
                $email = $usuario["email"];
                $telefono = $usuario["tel_contacto"];
                $id_usuario = $usuario["id_usuario"];
                $sexo = $usuario["sexo"];
                $action = "../../q/index.php/api/usuario/index/format/json/";
                $attr = ["METHOD" => "PUT", "id" => "form_set_usuario", "class" => "border form_set_usuario padding_10 shadow"];
                $form[] = form_open($action, $attr);
                $form[] = d(h("Cliente", 3), 1);
                $form[] = d("NOMBRE:", "top_10", 1);
                $form[] = input(["name" => "nombre", "value" => $nombre, "type" => "text", "required" => "true"]);
                $form[] = d("APELLIDO PATERNO:", "top_10", 1);
                $form[] = input(["name" => "apellido_paterno", "value" => $apellido_paterno, "type" => "text"]);
                $form[] = d("APELLIDO MATERNO:", "top_10", 1);
                $form[] = input(["name" => "apellido_materno", "value" => $apellido_materno, "type" => "text"]);
                $form[] = d("EMAIL:", "top_10", 1);


                $form[] = input([
                    'name' => 'email',
                    'value' => $email,
                    "required" => "true",
                    "class" => "input-sm email email",
                    "onkeypress" => "minusculas(this);"
                ]);
                $form[] = d("TELÉFONO:", " top_10", 1);
                $form[] = input([
                    'name' => 'tel_contacto',
                    'value' => $telefono,
                    "required" => "true",
                    'type' => "tel",
                    "maxlength" => 13,
                    "minlength" => 8,
                    "class" => "form-control input-sm  telefono telefono_info_contacto"
                ]);
                $form[] = input([
                    "value" => $id_usuario,
                    "name" => "id_usuario",
                    "type" => "hidden"

                ]);
                $opt[] = array(

                    "text" => "Femenino",
                    "val" => 0
                );
                $opt[] = array(

                    "text" => "Masculino",
                    "val" => 1
                );
                $opt[] = array(

                    "text" => "Indefinido",
                    "val" => 2
                );
                $form[] = d(create_select($opt, "sexo", "sexo", "sexo", "text", "val", 1, $sexo), "top_20");
                $form[] = btn("GUARDAR", ["class" => "top_30 bottom_50"]);
                $form[] = form_close(place("place_form_set_usuario"));
                $f = addNRow(append($form), ["id" => "contenedor_form_usuario"]);
                return $f;
            }


        }
    }
}