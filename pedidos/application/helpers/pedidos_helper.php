<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_pendidos($data)
    {

        $orden = $data["orden"];
        $status_ventas = $data["status_ventas"];
        $recibo = $data["recibo"];
        $domicilio = $data["domicilio"];
        $recordatorios = $data["recordatorios"];
        $tipo_recortario = $data["tipo_recortario"];
        $num_compras = $data["num_compras"];
        $tipificaciones = $data["tipificaciones"];
        $id_recibo = $data["id_recibo"];
        $comentarios = $data["comentarios"];
        $tipos_entregas = $data["tipos_entregas"];
        $usuario = $data["usuario"];


        $r[] = format_resumen_pedidos($orden);
        $r[] = div(crea_estado_venta($status_ventas, $recibo), 1);
        $r[] = format_estados_venta($status_ventas, $recibo, $orden);
        $r[] = crea_seccion_solicitud($recibo);
        $r[] = crea_seccion_productos($recibo);
        $r[] = crea_fecha_entrega($recibo);
        $r[] = create_fecha_contra_entrega($recibo, $domicilio);
        $r[] = notificacion_por_cambio_fecha($recibo, $num_compras, primer_elemento($recibo, "saldo_cubierto"));
        $r[] = addNRow(crea_seccion_recordatorios($recordatorios, $tipo_recortario));
        $r[] = create_seccion_tipificaciones($tipificaciones);
        $r[] = addNRow(get_form_nota($id_recibo));
        $r[] = addNRow(create_seccion_comentarios($comentarios, $id_recibo));

        $response[] = div(div(append($r), 12), 8);
        $response[] = div(get_format_resumen_cliente_compra($recibo, $tipos_entregas, $domicilio, $num_compras, $usuario, $id_recibo), 4);
        $response[] = get_hiddens_detalle($recibo);
        return div(append($response), "col-lg-10 col-lg-offset-1 top_50 bottom_100");

    }

    function render_seguimiento($data)
    {

        $recibo = $data["recibo"];
        $es_vendedor = $data["es_vendedor"];
        $evaluacion = $data["evaluacion"];
        $status_ventas = $data["status_ventas"];
        $domicilio = $data["domicilio"];
        $notificacion_pago = $data["notificacion_pago"];
        $orden = $data["orden"];
        $id_servicio = $data["id_servicio"];

        $z[] = format_resumen_seguimiento($recibo, $es_vendedor, $evaluacion, $status_ventas, $domicilio);
        $z[] = format_heading_orden($recibo, $id_servicio);
        $z[] = div("", 4);
        $r[] = div(append($z), "top_50");
        $r[] = div(heading_enid("También te podría interezar", 3), "col-lg-12 top_50 hidden text_interes");
        $r[] = div(place("place_tambien_podria_interezar"), "col-lg-12 top_50");
        $r[] = input_hidden(["value" => $notificacion_pago, "class" => "notificacion_pago"]);
        $r[] = input_hidden(["value" => $orden, "class" => "orden"]);
        $r[] = input_hidden(["value" => $id_servicio, "class" => "qservicio"]);
        return append($r);


    }

    function format_resumen_seguimiento($recibo, $es_vendedor, $evaluacion, $status_ventas, $domicilio)
    {

        $r[] = div(get_motificacion_evaluacion($recibo, $es_vendedor, $evaluacion), 1);
        $r[] = div(heading_enid("RASTREAR PEDIDO" . icon("fa fa-map-signs"), 3), 1);
        $r[] = div(create_linea_tiempo($status_ventas, $recibo, $domicilio, $es_vendedor), "timeline top_40", 1);

        return div(append($r), 5);

    }

    function format_heading_orden($recibo, $id_servicio)
    {


        return
            div(

                btw(

                    heading("ORDEN #" . primer_elemento($recibo, "id_proyecto_persona_forma_pago"), 3)

                    ,

                    anchor_enid(

                        img(
                            [
                                "src" => primer_elemento($recibo, "url_img_servicio")
                            ]
                        )
                        ,
                        get_url_servicio($id_servicio)

                    )
                    ,
                    "",
                    1

                ),
                3
            );


    }

    function render_domicilio($data)
    {
        $recibo = $data["recibo"];
        $domicilio = $data["domicilio"];
        $lista_direcciones = $data["lista_direcciones"];
        $puntos_encuentro = $data["puntos_encuentro"];

        $recibo = $recibo[0];
        $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
        $id_servicio = $recibo["id_servicio"];
        $id_error = "imagen_" . $id_servicio;
        $tipo_entrega = $recibo["tipo_entrega"];


        $r[] = div(
            div(
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

            div(get_forms_domicilio_entrega($id_recibo, $lista_direcciones), 6)
            ,
            div(get_format_listado_puntos_encuentro($tipo_entrega, $puntos_encuentro, $id_recibo, $domicilio), 6)
            ,

            7
        );

        return append($r);

    }


    function format_resumen_pedidos($orden)
    {

        $r[] = div(anchor_enid("MIS PEDIDOS",
            [
                "href" => path_enid("pedidos"),
                "class" => "black underline"


            ]), 13);
        $r[] = div(
            btw(
                div(heading_enid("# ORDEN " . $orden, 3), "numero_orden encabezado_numero_orden row")
                ,
                div(
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
            div(strong("STATUS DE LA COMPRA"))
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
            div(strong("SALDO CUBIERTO "))
            ,
            div(
                btw(
                    div(input(
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
                    div("MXN", "ml-4 mxn ")
                    ,
                    "d-flex align-items-center justify-content-between "
                )
            )
            ,
            "d-flex align-items-center justify-content-between bottom_30 form_cantidad_post_venta top_20", 1
        );
        $r[] = place("mensaje_saldo_cubierto_post_venta");
        $r[] = get_form_cantidad($recibo, $orden);
        return div(append($r), "selector_estados_ventas top_20 bottom_20");


    }

    function crea_seccion_solicitud($recibo)
    {


        $r[] = div("SOLICITUD  ", "strong");
        $r[] = div($recibo[0]["fecha_registro"]);
        return div(append($r), "letter-spacing-5 bottom_30 row");


    }

    function get_format_costo_operacion($table_costos, $tipo_costos, $id_recibo, $path, $costos_operacion, $recibo)
    {


        $r[] = btw(

            heading_enid("COSTOS DE OPERACIÓN", 3)
            ,
            get_formar_add_pedidos($table_costos)
            ,

            "contenedor_costos_registrados"
        );

        $r[] = div(get_form_costos($tipo_costos, $id_recibo, $costos_operacion), "display_none contenedor_form_costos_operacion");

        $response[] = div(append($r), 8);
        $response[] = div(format_img_recibo($path, $recibo), 4);

        return div(div(append($response), 10, 1), "row top_40");


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

            $r[] = div(anchor_enid(img($path), path_enid("pedidos_recibo", $id_recibo)), 1);
            $r[] = heading_enid(add_text("TOTAL ", $monto_a_pagar . "MXN"), 5);
            $r[] = heading_enid(add_text("CUBIERTO", $saldo_cubierto . "MXN"), 5);
            $r[] = heading_enid(add_text("ARTÍCULOS", $articulos), 5);

            if ($cancela_cliente > 0 || $se_cancela > 0 || $status == 10) {

                $r[] = heading_enid("ORDEN CANCELADA", 3, "red_enid strong");

            }

            $response = append($r);

        }

        return $response;

    }

    function get_format_resumen_cliente_compra($recibo, $tipos_entregas, $domicilio, $num_compras, $usuario, $id_recibo)
    {


        $r[] = create_seccion_tipo_entrega($recibo, $tipos_entregas);
        $r[] = div(
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
        $r[] = div(create_seccion_recordatorios($recibo), "top_30 underline text-right");

        return div(append($r));

    }

    if (!function_exists('get_forms_domicilio_entrega')) {
        function get_forms_domicilio_entrega($id_recibo, $lista_direcciones)
        {

            $r[] = heading_enid("DOMICILIOS DE ENTREGA ", 3);
            $r[] = agregar_nueva_direccion(0);
            $r[] = ul(create_lista_direcciones($lista_direcciones, $id_recibo), "list-group list-group-flush");
            return append($r);

        }

    }

    if (!function_exists('get_forms')) {
        function get_forms($id_recibo)
        {

            $r[] = get_form_registro_direccion($id_recibo);
            $r[] = get_form_puntos_medios($id_recibo);
            $r[] = get_form_puntos_medios_avanzado($id_recibo);
            return append($r);

        }
    }
    if (!function_exists('get_formar_add_pedidos')) {
        function get_formar_add_pedidos($table_costos)
        {

            $r[] = $table_costos;

            $r[] = anchor_enid("Agregar",
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

            $r[] = heading_enid("ORDENES DE COMPRA", 3);
            $r[] = form_open("", ["class" => "form_busqueda_pedidos ", "method" => "post"]);
            $r[] = form_busqueda_pedidos($tipos_entregas, $status_ventas, $fechas);

            if (is_array($param) && array_key_exists("fecha_inicio", $param)

                && array_key_exists("fecha_termino", $param)

                && array_key_exists("type", $param)

                && array_key_exists("servicio", $param)

            ) {

                $r[] = div(get_format_fecha_busqueda($param["fecha_inicio"], $param["fecha_termino"]));
                $r[] = input_hidden(["name" => "consulta", "class" => "consulta", "value" => 1]);
                $r[] = input_hidden(["name" => "servicio", "class" => "servicio", "value" => $param["servicio"]]);
                $r[] = input_hidden(["name" => "type", "class" => "type", "value" => $param["type"]]);


            } else {

                $r[] = div(get_format_fecha_busqueda());
            }


            $r[] = form_close();
            $z[] = div(append($r), " border padding_10 shadow row seccion_form_pedidos top_50");
            $z[] = div(place("place_pedidos top_50 bottom_50"), 1);
            $z[] = div(form_form_search(), 1);

            $response = div(append($z), 10, 1);
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
                div("CLIENTE", "strong"),
                div(input([
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
                div("#RECIBO", "strong"),
                div(input([
                    "name" => "recibo",
                    "class" => "form-control"
                ])),
                "col-lg-4 d-flex align-items-center justify-content-between"
            );

            $r[] = btw(
                div("TIPO ENTREGA", "strong"),

                div(
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
                div("STATUS", "strong"),
                div(create_select(
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
                div("ORDENAR", "strong"),
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

            $r[] = div(heading_enid(
                "ORDEN #" . $recibo["id_proyecto_persona_forma_pago"],
                1
            ),
                1

            );

            $x[] = div(img(
                [
                    "src" => link_imagen_servicio($id_servicio),
                    "class" => "imagen_servicio top_30"

                ]
            ), 4
            );
            $x[] = div("", 8);
            $r[] = div(append($x), 13);
            $r[] = div(
                heading_enid("DIRECCIÓN ENTREGA ESTABLECIDA", 3)
                ,
                "top_30"
                ,
                1
            );
            $r[] = div(create_descripcion_direccion_entrega($domicilio), " border-bottom padding_10 top_30 f12", 1);
            $r[] = div(valida_accion_pago($recibo), 1);

            $r[] = div(get_forms($id_recibo, $lista_direcciones), 1);
            return append($r);


        }

    }
    if (!function_exists('get_format_listado_puntos_encuentro')) {
        function get_format_listado_puntos_encuentro($tipo_entrega, $puntos_encuentro, $id_recibo, $domicilio)
        {


            $r[] = heading_enid("TUS PUNTOS DE ENCUENTRO ", 3);
            $r[] = agregar_nueva_direccion(1);
            $list = get_lista_puntos_encuentro($tipo_entrega, $puntos_encuentro, $id_recibo, $domicilio);

            $r[] = ul($list);
            return append($r);
        }

    }
    if (!function_exists('get_hiddens_detalle')) {

        function get_hiddens_detalle($recibo)
        {

            $r[] = input_hidden(
                [
                    "class" => "status_venta_registro",
                    "name" => "status_venta",
                    "value" => $recibo[0]["status"],
                    "id" => "status_venta_registro"
                ]);
            $r[] = input_hidden(
                [
                    "class" => "saldo_actual_cubierto",
                    "name" => "saldo_cubierto",
                    "value" => $recibo[0]["saldo_cubierto"]
                ]);
            $r[] = input_hidden(
                [
                    "class" => "tipo_entrega_def",
                    "name" => "tipo_entrega",
                    "value" => $recibo[0]["tipo_entrega"]
                ]);
            $r[] = input_hidden(
                [
                    "class" => "id_servicio",
                    "name" => "id_servicio",
                    "value" => $recibo[0]["id_servicio"]
                ]);
            $r[] = input_hidden(
                [
                    "class" => "articulos",
                    "name" => "articulos",
                    "value" => $recibo[0]["num_ciclos_contratados"]
                ]);

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
            $r[] = div(icon("fa fa-plus-circle fa-3x"), ["class" => " dropdown-toggle", "data-toggle" => "dropdown"]);
            $r[] = div(append($x), ["class" => "dropdown-menu  w_300 contenedor_opciones_pedido top_menos_10", "aria-labelledby" => "dropdownMenuButton"]);
            return div(append($r), "dropdown pull-right  mr-5 btn_opciones  ");


        }

    }

    if (!function_exists('get_motificacion_evaluacion')) {

        function get_motificacion_evaluacion($recibo, $es_vendedor, $evaluacion)
        {


            $response = "";

            if ($recibo[0]["status"] == 9 && $es_vendedor < 1 && $evaluacion == 0) {

                $id_servicio = $recibo[0]["id_servicio"];

                $t[] = guardar("ESCRIBE UNA RESEÑA");
                $t[] = div(str_repeat("★", 5), ["class" => "text-center f2", "style" => "color: #010148;"]);
                $response = anchor_enid(append($t), ["href" => path_enid("valoracion_servicio", $id_servicio)]);

            } elseif ($recibo[0]["status"] == 9 && $es_vendedor < 1 && $evaluacion > 0) {

                $id_servicio = $recibo[0]["id_servicio"];
                $t[] = guardar("ESCRIBE UNA RESEÑA");
                $t[] = div(str_repeat("★", 5), ["class" => "text-center f2", "style" => "color: #010148;"]);
                $response = anchor_enid(append($t), ["href" => path_enid("producto", $id_servicio . "&valoracion=1")]);

            } else {

            }
            return $response;


        }
    }

    if (!function_exists('get_form_fecha_recordatorio')) {
        function form_fecha_recordatorio($data, $tipo_recortario)
        {

            $orden = $data["orden"];
            $lista_horarios = lista_horarios()["select"];
            $x = heading_enid("RECORDATORIO", 3, "top_50");
            $r[] = form_open("", ["class" => "form_fecha_recordatorio letter-spacing-5 "]);
            $r[] = div(icon("fa fa-calendar-o") . " FECHA ", 4);

            $r[] = div(
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

            $r[] = div(icon("fa fa-clock-o") . " HORA", 3);

            $r[] = div($lista_horarios, 9);
            $r[] = input_hidden(
                [
                    "class" => "recibo",
                    "name" => "recibo",
                    "value" => $orden
                ]);

            $r[] = div(" TIPO", 3);
            $r[] = div(create_select($tipo_recortario, "tipo", "form-control tipo_recordatorio", "tipo_recordatorio", "tipo", "idtipo_recordatorio"), 9);
            $r[] = div(textarea(["name" => "descripcion", "class" => "descripcion_recordatorio"]), 12);
            $r[] = section(place("nota_recordatorio display_none"), 12);
            $r[] = div(guardar("CONTINUAR", ["class" => "top_menos_40"]), 12);
            $r[] = form_close();
            $r[] = place("place_recordatorio");
            $form = div(append($r), "top_30 form_separador ");
            $response = div($x . $form, 6, 1);
            return $response;


        }
    }
    if (!function_exists('get_form_fecha_entrega')) {
        function get_form_fecha_entrega($data)
        {

            $lista_horarios = lista_horarios()["select"];
            $orden = $data["orden"];
            $r[] = form_open("", ["class" => "form_fecha_entrega"]);
            $r[] = heading_enid("FECHA DE ENTREGA", 4, "strong titulo_horario_entra");
            $r[] = br();
            $r[] = label(icon("fa fa-calendar-o") . " FECHA ", "col-lg-4 control-label");
            $r[] = div(
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

            $r[] = label(icon("fa fa-clock-o") . " HORA DE ENCUENTRO", "col-lg-4 control-label");
            $r[] = div($lista_horarios, 8);
            $r[] = input_hidden(
                [
                    "class" => "recibo",
                    "name" => "recibo",
                    "value" => $orden
                ]);
            $r[] = div(guardar("CONTINUAR", ["class" => "top_20"]), 12);
            $r[] = place("place_notificacion_punto_encuentro");
            $r[] = form_close(place("place_fecha_entrega"));
            $response = append($r);
            $response = div($response, 6, 1);
            return $response;


        }

    }
    if (!function_exists('get_form_cantidad')) {
        function get_form_cantidad($recibo, $orden)
        {


            $r[] = '<form class="form_cantidad top_20">';
            $r[] = input_hidden(
                [
                    "name" => "recibo",
                    "class" => "recibo",
                    "value" => $orden
                ]);
            $r[] = div("MXN", "mxn col-lg-2");
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


            $response = div(heading_enid("Ya registraste todos los costos de operación para esta venta!", 3), 8, 1);
            if (count($costos_por_registro) > 0) {

                $r[] = div(heading_enid("Gasto", 3), "col-lg-12 bottom_50");
                $r[] = form_open("", ["class" => "form_costos letter-spacing-5"], ["recibo" => $id_recibo]);
                $a = div("MONTO GASTADO", 4);
                $b = div(
                    input(
                        [
                            "type" => "number",
                            "required" => true,
                            "class" => "form-control input precio",
                            "name" => "costo"
                        ]
                    ), 8);

                $r[] = btw($a, $b, "top_30");
                $r[] = div(
                    create_select(
                        $costos_por_registro,
                        "tipo",
                        "id_tipo_costo form-control",
                        "tipo",
                        "tipo",
                        "id_tipo_costo"), "col-lg-12 top_30");


                $r[] = div(guardar("AGREGAR", ["class" => "top_30"]), 12);
                $r[] = form_close(place("notificacion_registro_costo"));
                $response = div(append($r), 10, 1);
            }
            return $response;

        }

    }
    if (!function_exists('get_error_message')) {
        function get_error_message()
        {


            $r[] = div(heading_enid("UPS! NO ENCONTRAMOS EL NÚMERO DE ORDEN", 1, "funny_error_message"), "text-center");
            $r[] = div(
                img(
                    [
                        "src" => "../img_tema/gif/funny_error.gif"
                    ]
                )
            );
            $r[] = div(anchor_enid("ENCUENTRA TU ORDEN AQUÍ",
                [
                    "href" => path_enid("pedidos"),
                    "class" => "busqueda_mensaje"
                ]),
                "busqueda_mensaje_text"
            );
            $response = div(append($r));

            return $response;
        }
    }


    if (!function_exists('get_form_registro_direccion')) {
        function get_form_registro_direccion($id_recibo)
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
            $r[] = div("NOTA", "letter-spacing-10");
            $r[] = textarea(["name" => "comentarios", "class" => "comentarios form-control top_30 bottom_30"]);
            $r[] = input_hidden(["name" => "id_recibo", "value" => $id_recibo]);
            $r[] = guardar("AGREGAR", ["name" => "comentarios"]);
            $r[] = form_close(place("place_nota"));
            return append($r);

        }
    }
    if (!function_exists('agregar_nueva_direccion')) {
        function agregar_nueva_direccion($direccion = 1)
        {
            return ($direccion > 0) ? guardar("Agregar ", ["class" => "agregar_punto_encuentro_pedido"]) : guardar("Agregar ", ["class" => "agregar_direccion_pedido"]);

        }
    }
    if (!function_exists('get_lista_puntos_encuentro')) {
        function get_lista_puntos_encuentro($tipo_entrega, $puntos_encuentro, $id_recibo, $domicilio = '')
        {

            $asignado = (is_array($domicilio) && $domicilio["tipo_entrega"] == 1) ? $domicilio["domicilio"][0]["id"] : 0;
            $lista = [];
            $a = 1;
            $r = [];
            foreach ($puntos_encuentro as $row) {

                $id = $row["id"];
                $nombre = $row["nombre"];

                $extra = ($id === $asignado) ? "asignado_actualmente" : "";


                $encuentro = [];
                $encuentro[] = div("#" . $a, ["class" => "f15"], 1);
                $encuentro[] = div($nombre, 1);
                $modificar_encuentro = ($tipo_entrega < 2) ? " establecer_punto_encuentro " : "";

                $encuentro[] = guardar("ESTABLECER COMO PUNTO DE ENTREGA",
                    [
                        "class" => "h6 text-muted text-right  cursor_pointer  btn_direccion  " . $modificar_encuentro,
                        "id" => $id,
                        "id_recibo" => $id_recibo

                    ]
                );
                $r[] = div(append($encuentro), "top_50 border padding_10 contenedor_listado d-flex flex-column justify-content-between " . $extra);

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

                $id_direccion = $row["id_direccion"];
                $calle = $row["calle"];
                $numero_exterior = $row["numero_exterior"];
                $numero_interior = $row["numero_interior"];
                $cp = $row["cp"];
                $asentamiento = $row["asentamiento"];
                $municipio = $row["municipio"];
                $estado = $row["estado"];


                $direccion = $calle . " " . " NÚMERO " . $numero_exterior . " NÚMERO INTERIOR " . $numero_interior . " COLONIA " . $asentamiento . " DELEGACIÓN/MUNICIPIO " . $municipio . " ESTADO " . $estado . " CÓDIGO POSTAL " . $cp;
                $text = [];
                $text[] = div("#" . $a, "f15", 1);
                $text[] = div($direccion, 1);
                $text[] =
                    guardar("ESTABLECER COMO DIRECCIÓN DE ENTREGA",
                        [
                            "class" => " establecer_direccion cursor_pointer",
                            "id" => $id_direccion,
                            "id_recibo" => $id_recibo
                        ]);

                $a++;

                $r[] = div(append($text), "top_50 border padding_10 contenedor_listado d-flex flex-column justify-content-between");


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
                    $numero_exterior = $domicilio["numero_exterior"];
                    $numero_interior = $domicilio["numero_interior"];
                    $cp = $domicilio["cp"];
                    $asentamiento = $domicilio["asentamiento"];
                    $municipio = $domicilio["municipio"];
                    $estado = $domicilio["estado"];

                    $t = $calle . " " . " NÚMERO " . $numero_exterior . " NÚMERO INTERIOR " . $numero_interior . " COLONIA " . $asentamiento . " DELEGACIÓN/MUNICIPIO " . $municipio . " ESTADO " . $estado . " CÓDIGO POSTAL " . $cp;
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

                        $text[] = heading_enid("LUGAR DE ENCUENTRO", 3, ["class" => "top_20"]);
                        $text[] = div($tipo . " " . $nombre_estacion . " " . $numero . " COLOR " . $color, 1);
                        $text[] = div("ESTACIÓN " . $lugar_entrega, "strong", 1);


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

                $id_recibo = $recibo["id_proyecto_persona_forma_pago"];


                $response = div(
                    guardar(
                        text_icon("fa fa-2x fa-shopping-cart", "PROCEDER A LA COMPRA ", [], 0)
                        ,
                        [
                            "style" => "background:blue!important",
                            "class" => "top_30 f12"
                        ],
                        1,
                        1,
                        0,
                        path_enid("area_cliente_compras", $id_recibo)
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
            $id_estado = $recibo["status"];
            $tipo_entrega = $recibo["tipo_entrega"];
            $id_recibo = $recibo["id_proyecto_persona_forma_pago"];


            for ($i = 5; $i > 0; $i--) {

                $status = get_texto_status($i, $recibo);
                $activo = 1;

                if ($flag == 0) {
                    $activo = 0;
                    if ($id_estado == $status["estado"]) {
                        $activo = 1;
                        $flag++;
                    }
                }

                switch ($i) {

                    case 2:
                        $class = (tiene_domilio($domicilio, 1) == 0) ? "timeline__item__date" : "timeline__item__date_active";
                        $seccion_2 = get_seccion_domicilio($domicilio, $id_recibo, $tipo_entrega, $es_vendedor);

                        break;
                    case 3:

                        $class = ($recibo["saldo_cubierto"] > 0) ? "timeline__item__date_active" : "timeline__item__date";
                        $seccion_2 = get_seccion_compra($recibo, $id_recibo, $es_vendedor);

                        break;


                    default:
                        $class = ($activo == 1) ? "timeline__item__date_active" : "timeline__item__date";
                        $seccion_2 = get_seccion_base($status);
                        break;

                }
                $seccion = div(icon("fa fa-check-circle-o"), $class);
                $linea[] = div($seccion . $seccion_2, "timeline__item");


            }
            return append($linea);
        }
    }
    if (!function_exists('get_seccion_base')) {
        function get_seccion_base($status)
        {
            $seccion = div(p($status["text"], "timeline__item__content__description"), "timeline__item__content");

            return $seccion;

        }
    }
    if (!function_exists('get_seccion_compra')) {
        function get_seccion_compra($recibo, $id_recibo, $es_vendedor)
        {

            $text = ($recibo["saldo_cubierto"] > 0) ? "REALIZASTE TU COMPRA" . icon("fa fa-check") : "REALIZA TU COMPRA";
            $url = "../area_cliente/?action=compras&ticket=" . $id_recibo;
            $url = ($es_vendedor > 0) ? "" : $url;

            $seccion = div(
                p(
                    anchor_enid(

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

            $seccion = div(
                p(
                    anchor_enid($texto_entrega,
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
        function get_texto_status($status, $recibo)
        {

            $text = "";
            $response = [];
            $estado = 6;

            switch ($status) {
                case 2:
                    $text = "PAGO VERIFICADO";
                    $estado = 1;
                    break;

                case 1:
                    $text = "ORDEN REALIZADA" . icon("fa fa-check");
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
        function create_seccion_comentarios($data, $id_recibo)
        {

            $nota = [];
            if (es_data($data)) {
                $nota[] = div(heading_enid("NOTAS", 4), 13);
            }

            foreach ($data as $row) {


                $n = btw(

                    div(icon("fa fa-clock-o") . " " . $row["fecha_registro"], 4)
                    ,

                    div($row["comentario"], 8)
                    ,
                    "row"

                );


                $nota[] = div($n, "seccion_tipificacion top_30 bottom_30 padding_10 border row");

            }


            $response = div(append($nota), 1);
            return $response;

        }
    }
    if (!function_exists('crea_seccion_recordatorios')) {
        function crea_seccion_recordatorios($recordatorios, $tipo_recortario)
        {


            $list = [];
            foreach ($recordatorios as $row) {

                $id_recordatorio = $row["id_recordatorio"];
                $status = ($row["status"] > 0) ? 0 : 1;
                $fecha_cordatorio = $row["fecha_cordatorio"];
                $text_tipo = $row["tipo"];

                $config = ["type" => "checkbox", "class" => "form-control item_recordatorio", "onclick" => "modifica_status_recordatorio({$id_recordatorio} , {$status})"];

                if ($row["status"] > 0) {

                    $config = ["checked" => true, "type" => "checkbox", "class" => "form-control item_recordatorio", "onclick" => "modifica_status_recordatorio({$id_recordatorio} , {$status})"];

                }

                $r = [];

                $r[] =
                    btw(

                        div($row["descripcion"], 9)
                        ,
                        div(input($config), 3)
                        ,
                        "row"

                    );


                $r[] = btw(

                    div(icon("fa fa-clock-o") . $fecha_cordatorio, 1)
                    ,
                    div($text_tipo, 1)
                    ,
                    "row"
                );


                $list[] = div(append($r), "row border padding_10 top_30");

            }
            return div(append($list), ["id" => "listado_recordatorios bottom_40"]);
        }
    }
    if (!function_exists('create_seccion_tipificaciones')) {
        function create_seccion_tipificaciones($data)
        {

            $tipificaciones = "";

            foreach ($data as $row) {


                $tipificaciones = btw(

                    div(
                        text_icon("fa fa-clock-o", $row["fecha_registro"]), 3)

                    ,
                    div($row["nombre_tipificacion"], 9)
                    ,
                    "row"
                );


            }

            if (es_data($data)) {

                $r[] = div(heading_enid("MOVIMIENTOS", 4, "row"), " top_30 bottom_30 padding_10  row");
                $r[] = div($tipificaciones, " top_30 bottom_30 padding_10 border row");
                return append($r);

            }

        }
    }
    if (!function_exists('crea_seccion_productos')) {
        function crea_seccion_productos($recibo)
        {

            $recibo = $recibo[0];
            $num_ciclos_contratados = $recibo["num_ciclos_contratados"];
            $precio = $recibo["precio"];
            $id_servicio = $recibo["id_servicio"];
            $link = $recibo["url_img_servicio"];
            $response = [];


            for ($a = 0; $a < $num_ciclos_contratados; $a++) {


                $text_producto =
                    div(
                        $precio . "MXN",
                        "text_precio_producto"

                    );


                $r = [];

                $r[] = div(
                    img(
                        [
                            "src" => $link,
                            "class" => "img_servicio",
                        ]
                    ),
                    4
                );

                $r[] = div($text_producto, "col-lg-8 align-middle  align-self-center text-center");


                $x = anchor_enid(

                    div(
                        append($r), "border row "
                    ),

                    [
                        "href" => path_enid("producto", $id_servicio),
                        "target" => "_black",
                    ]
                );


                $response[] = $x;
            }
            return div(append($response), 1);

        }
    }

    if (!function_exists('create_fecha_contra_entrega')) {
        function create_fecha_contra_entrega($recibo, $domicilio)
        {

            if (get_param_def($domicilio, "domicilio") > 0 && es_data($recibo)) {

                $recibo = $recibo[0];
                $t[] = div("HORARIO DE ENTREGA", "strong underline");
                $t[] = div($recibo["fecha_contra_entrega"]);
                $text = div(append($t), "letter-spacing-5 text-right top_30 bottom_30");
                $fecha = ($recibo["tipo_entrega"] == 1) ? $text : "";
                return $fecha;
            }
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
                $cambio_fecha = $recibo[0]["modificacion_fecha"];
                $class = 'nula';
                $text_probabilidad = "PROBABILIDAD NULA DE COMPRA";

                switch ($cambio_fecha) {

                    case 0  :
                        $class = 'alta';
                        $text_probabilidad = "PROBABILIDAD ALTA DE COMPRA";
                        break;
                    case 1:

                        $class = 'media';
                        $text_probabilidad = "PROBABILIDAD MEDIA DE COMPRA";
                        if ($num_compras > 0) {
                            $class = 'alta';
                            $text_probabilidad = "PROBABILIDAD ALTA DE COMPRA";
                        }
                        break;
                    case 2:
                        $class = 'baja';
                        $text_probabilidad = "PROBABILIDAD BAJA DE COMPRA";
                        if ($num_compras > 0) {
                            $class = 'media';
                            $text_probabilidad = "PROBABILIDAD MEDIA DE COMPRA";

                        }

                        break;
                }

                if ($recibo[0]["status"] == 10) {

                    $class = 'baja';
                    $text_probabilidad = "PROBABILIDAD BAJA NULA (SE CANCELÓ)";

                }
                return div($text_probabilidad, $class . " border shadow row", 1);
            }
        }
    }

    if (!function_exists('create_seccion_saldos')) {
        function create_seccion_saldos($recibo)
        {

            $recibo = $recibo[0];
            $saldo_cubierto = $recibo["saldo_cubierto"];
            $precio = $recibo["precio"];
            $num_ciclos_contratados = $recibo["num_ciclos_contratados"];
            $costo_envio_cliente = $recibo["costo_envio_cliente"];
            $cargos_envio = $recibo["costo_envio_cliente"];
            $total_a_pagar = $precio * $num_ciclos_contratados + $costo_envio_cliente;


            $text[] = btw(
                div("ENVIO", "strong")
                ,
                div($cargos_envio . "MXN")
                ,
                4
            );


            $text[] =
                btw(
                    div("ENVIO", "strong")
                    ,
                    div($total_a_pagar . "MXN")
                    ,
                    4
                );


            $saldo_cubierto = $saldo_cubierto . "MXN";
            $saldo_cubierto = ($saldo_cubierto < 1) ? span($saldo_cubierto, "sin_pago") : span($saldo_cubierto, "pago_realizado");


            $text[] = btw(

                div("CUBIERTO", "strong")
                ,
                $saldo_cubierto
                ,
                "col-lg-4 text_saldo_cubierto"


            );

            return div(div(append($text), "row"), "shadow border padding_20 top_40 ");

        }
    }
    if (!function_exists('create_seccion_tipo_entrega')) {
        function create_seccion_tipo_entrega($recibo, $tipos_entregas)
        {

            if (es_data($recibo)):
                $tipo = "";
                $id_tipo_entrega = $recibo[0]["tipo_entrega"];
                foreach ($tipos_entregas as $row) {

                    if ($row["id"] == $id_tipo_entrega) {
                        $tipo = $row["nombre"];
                        echo input_hidden(
                            [
                                "class" => "text_tipo_entrega",
                                "value" => $tipo
                            ]
                        );
                        break;
                    }
                }


                $encabezado = btw(

                    heading_enid("TIPO DE ENTREGA", 3)
                    ,
                    div(icon("fa fa fa-pencil"), "editar_tipo_entrega text-right")
                    ,
                    "d-flex align-items-center justify-content-between bottom_30"

                );

                $tipo = div($tipo, "encabezado_tipo_entrega letter-spacing-5  text-right bottom_20", 1);
                return div($encabezado . $tipo, "contenedor_tipo_entrega", 1);

            endif;

        }

    }
    if (!function_exists('crea_fecha_entrega')) {
        function crea_fecha_entrega($recibo)
        {

            $response = "";
            if (es_data($recibo)):
                $recibo = $recibo[0];
                $t[] = div(icon("fa fa-check-circle") . "PEDIDO ENTREGADO", "strong");
                $t[] = div($recibo["fecha_entrega"]);
                $text = ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9) ? append($t) : "";

                if ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9):
                    $response = div($text, "letter-spacing-5 top_30 border padding_10 botttom_20 contenedor_entregado", 1);
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
                if ($recibo[0]["se_cancela"] < 1 && $recibo[0]["status"] != 10 && $recibo[0]["cancela_cliente"] < 1) {

                    $status = $recibo[0]["status"];
                    $text_status = "";
                    foreach ($status_ventas as $row) {

                        $id_estatus = $row["id_estatus_enid_service"];
                        $text_vendedor = $row["text_vendedor"];

                        if ($status == $id_estatus) {
                            $text_status = $text_vendedor;
                            break;
                        }
                    }
                    $response = div($text_status, "status_compra padding_20 white letter-spacing-5 bottom_20 row");
                }
            endif;
            return $response;

        }
    }
    if (!function_exists('create_seccion_usuario')) {
        function create_seccion_usuario($usuario, $recibo)
        {

            $r = [];
            $id_usuario = primer_elemento($recibo, "id_usuario");
            foreach ($usuario as $row) {

                $opt = ["MUJER", "HOMBRE", "INDEFINIDO"];
                $nombre =
                    append([
                        es_null($row, "nombre"),
                        es_null($row, "apellido_paterno"),
                        es_null($row, "apellido_materno")
                    ]);


                $r[] = div($nombre);
                $r[] = div($row["email"]);
                $r[] = div($row["tel_contacto"]);
                $r[] = div($row["tel_contacto_alterno"]);

                if ($row["sexo"] != 2) {

                    $r[] = div($opt[$row["sexo"]]);
                }

                $icon = icon("fa-pencil configurara_informacion_cliente black");
                $r[] = div($icon, "pull-right dropdown", 1);

            }

            $response = btw(

                ajustar("CLIENTE", icon("fa fa-cart-plus agenda_compra", ["id" => $id_usuario]))
                ,
                div(append($r), "contenido_domicilio top_10")
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
                ]) : "";

            return div($text . $starts, ["class" => "shadow border padding_20"]);

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

                $f_text = div("SIN DOMICIO REGISTRADO", "sin_domicilio padding_10 white", 1);
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

            return (es_data($recibo)) ? (($recibo[0]["status"] == 6) ? div("EMAIL RECORDATORIOS COMPRA " . $recibo[0]["num_email_recordatorio"], "") : "") : "";

        }
    }

    if (!function_exists('get_link_nota')) {
        function get_link_nota()
        {
            return div(anchor_enid("NOTA", ["class" => "agregar_comentario", "onClick" => "agregar_nota();"]), 1);
        }
    }
    if (!function_exists('get_link_costo')) {
        function get_link_costo($id_recibo, $recibo)
        {


            if (es_data($recibo)):
                $recibo = $recibo[0];
                $saldo_cubierto = $recibo["saldo_cubierto"];
                $url = path_enid("pedidos", "/?costos_operacion=" . $id_recibo . "&saldado=" . $saldo_cubierto);
                return div(anchor_enid("COSTO DE OPERACIÓN", ["href" => $url]), 1);
            endif;
        }
    }

    if (!function_exists('get_link_cambio_fecha')) {
        function get_link_cambio_fecha($domicilio, $recibo)
        {

            if (get_param_def($domicilio, "domicilio") != 0 && count($recibo) > 0) {

                $recibo = $recibo[0];
                $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
                $status = $recibo["status"];
                $saldo_cubierto_envio = $recibo["saldo_cubierto_envio"];
                $monto_a_pagar = $recibo["monto_a_pagar"];
                $se_cancela = $recibo["se_cancela"];
                $fecha_entrega = $recibo["fecha_entrega"];

                return div(
                    anchor_enid("FECHA DE ENTREGA",
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

            return div(anchor_enid("RECORDATORIO", path_enid("pedidos", "/?recibo=" . $id_recibo . "&recordatorio=1")), 1);

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
            $encabezado = div("PUNTO DE ENCUENTRO", "encabezado_domicilio", 1);
            $encuentro = div(strtoupper($punto_encuentro), "contenido_domicilio", 1);
            return div($encabezado . $encuentro, "contenedor_domicilio shadow border padding_20 top_40");

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
            $encabezado = div("DOMICIO DEL ENVIO", "encabezado_domicilio", 1);
            $direccion = div(strtoupper($direccion), "contenido_domicilio top_10", 1);
            return div($encabezado . $direccion, "shadow border padding_20 top_40", 1);
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
                $form[] = div(heading_enid("Cliente", 3), 1);
                $form[] = div("NOMBRE:", "top_10", 1);
                $form[] = input(["name" => "nombre", "value" => $nombre, "type" => "text", "required" => "true"]);
                $form[] = div("APELLIDO PATERNO:", "top_10", 1);
                $form[] = input(["name" => "apellido_paterno", "value" => $apellido_paterno, "type" => "text"]);
                $form[] = div("APELLIDO MATERNO:", "top_10", 1);
                $form[] = input(["name" => "apellido_materno", "value" => $apellido_materno, "type" => "text"]);
                $form[] = div("EMAIL:", "top_10", 1);


                $form[] = input([
                    'name' => 'email',
                    'value' => $email,
                    "required" => "true",
                    "class" => "input-sm email email",
                    "onkeypress" => "minusculas(this);"
                ]);
                $form[] = div("TELÉFONO:", " top_10", 1);
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
                $form[] = div(create_select($opt, "sexo", "sexo", "sexo", "text", "val", 1, $sexo), "top_20");
                $form[] = guardar("GUARDAR", ["class" => "top_30 bottom_50"]);
                $form[] = form_close(place("place_form_set_usuario"));
                $f = addNRow(append($form), ["id" => "contenedor_form_usuario"]);
                return $f;
            }


        }
    }
}