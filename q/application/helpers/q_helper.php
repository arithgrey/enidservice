<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_mensaje_modificacion_pwd')) {
        function get_mensaje_modificacion_pwd($nombre)
        {

            $r[] = heading_enid("HOLA, " . strtoupper($nombre), 3);
            $r[] = div(img(["src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg", "style" => "width: 100%"]));
            $r[] = div("Observamos un cambio de contraseña en tu cuenta. ¿Fuiste tú?");
            $r[] = div("Si es así ignora este correo, en caso contrario notificanos aquí http://enidservice.com/inicio/contact/");
            return append($r);

        }
    }

    if (!function_exists('get_mensaje_bienvenida')) {
        function get_mensaje_bienvenida($param)
        {

            $nombre = $param["nombre"];
            $email = $param["email"];

            $r[] = heading("Buen día " . $nombre . " " . $email);
            $r[] = div(
                img(
                    [
                        "src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg",
                        "style" => "width: 100%"
                    ]),
                [
                    "style" => "width: 30%;margin: 0 auto;"
                ]);

            $r[] = div("TU USUARIO SE HA REGISTRADO!", ["style" => "font-size: 1.4em;font-weight: bold"]);
            $r[] = hr();
            $r[] = div("Desde ahora podrás adquirir y vender las mejores promociones a lo largo de México");
            $r[] = br();
            $r[] = anchor_enid("ACCEDE A TU CUENTA AHORA!",
                [
                    "href" => "http://enidservice.com/inicio/login/",
                    "target" => "_blank",
                    "style" => "background: #001936;padding: 10px;color: white;margin-top: 23px;text-decoration: none;"
                ]);

            return append($r);

        }
    }


    if (!function_exists('base_valoracion')) {
        function base_valoracion()
        {
            return str_repeat("\n" . label("★", 'estrella') . "\n", 5);
        }
    }
    if (!function_exists('tareas_realizadas')) {
        function tareas_realizadas($realizado, $fecha_actual)
        {

            $index =  search_bi_array($realizado, "fecha_termino", $fecha_actual);
            return $realizado[$index]["tareas_realizadas"];
        }
    }
    if (!function_exists('valida_total_menos1')) {
        function valida_total_menos1($anterior, $nuevo, $extra = '')
        {

            $ext = menorque($anterior, $nuevo, 'style="background:#ff1b00!important; color:white!important;" ');
            return get_td($nuevo, $ext . " " . $extra);
        }
    }

    if (!function_exists('valida_tareas_fecha')) {
        function valida_tareas_fecha($lista_fechas, $fecha_actual, $franja_horaria)
        {

            $num_visitas_web = 0;
            foreach ($lista_fechas as $row) {
                $fecha = $row["fecha"];
                $hora = $row["hora"];
                if ($fecha == $fecha_actual && $hora == $franja_horaria) {
                    $num_visitas_web = $row["total"];
                    break;
                }
            }
            return $num_visitas_web;
        }
    }

    if (!function_exists('get_fechas_global')) {
        function get_fechas_global($lista_fechas)
        {

            $dias = ["", 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
            $fechas = "<tr>";
            $b = 0;
            $estilos2 = "";
            foreach ($lista_fechas as $row) {
                if ($b < 1) {

                    $fechas .= get_td("Horario", $estilos2);
                    $fechas .= get_td("Total", $estilos2);
                    $b++;
                }
                $fecha_text = $dias[date('N', strtotime($row))];
                $text_fecha = $fecha_text . "" . $row;
                $fechas .= get_td($text_fecha, $estilos2);
            }
            $fechas .= "</tr>";
            return $fechas;

        }
    }

    if (!function_exists('get_arreglo_valor')) {
        function get_arreglo_valor($info, $columna)
        {

            $tmp_arreglo = [];
            $z = 0;
            foreach ($info as $row) {

                $fecha = $row[$columna];
                if (strlen($fecha) > 1) {
                    $tmp_arreglo[$z] = $fecha;
                    $z++;
                }
            }
            return array_unique($tmp_arreglo);
        }
    }
    if (!function_exists('get_franja_horaria')) {
        function get_franja_horaria()
        {

            $response = [];
            for ($a = 23; $a >= 0; $a--) {

                $response[$a] = $a;
            }
            return $response;
        }
    }


    if (!function_exists('get_mensaje_inicial_notificaciones')) {
        function get_mensaje_inicial_notificaciones($tipo, $num_tareas)
        {

            $seccion = "";
            if ($num_tareas > 0) {
                switch ($tipo) {
                    case 1:
                        $seccion = div(heading_enid("NOTIFICACIONES ", 5), 1);
                        break;
                    default:
                        break;
                }
            }
            return $seccion;
        }
    }

    if (!function_exists('crea_tareas_pendientes_info')) {
        function crea_tareas_pendientes_info($f)
        {

            $new_flag = "";
            if ($f > 0) {

                $new_flag = div($f,
                    [
                        "class" => 'notificacion_tareas_pendientes_enid_service',
                        "id" => $f
                    ]
                );
            }
            return $new_flag;
        }

    }
    if (!function_exists('add_direccion_envio')) {
        function add_direccion_envio($num_direccion)
        {

            $lista = "";
            $f = 0;
            if ($num_direccion < 1) {

                $lista = base_notificacion(path_enid("administracion_cuenta"), "fa fa-map-marker", 'Registra tu dirección de compra y venta');

                $f++;

            }

            $response = [

                "html" => $lista,
                "flag" => $f,

            ];

            return $response;

        }

    }


    if (!function_exists('add_tareas')) {
        function add_tareas($tareas)
        {

            $r = [];
            $f = 0;
            foreach ($tareas as $row) {


                $id_ticket = $row["id_ticket"];
                $text = div(substr($row["asunto"], 0, 30), "black");
                $text = div(heading_enid(icon(" fas fa-tasks"), 5) . $text, "col-lg-12 top_10  shadow padding_10 mh_notificaciones");

                $r[] = anchor_enid($text, "../desarrollo/?q=1&ticket=" . $id_ticket);
                $f++;
            }


            $agregar = div(anchor_enid(text_icon("fas fa-plus-circle black", " TAREA"), path_enid("desarrollo")), "bottom_50 black underline");
            $tareas = add_text($agregar, append($r));


            $response =
                [
                    "html" => $tareas,
                    "flag" => $f,

                ];

            return $response;

        }

    }
    if (!function_exists('add_tareas_pendientes')) {
        function add_tareas_pendientes($meta, $hecho)
        {

            $lista = "";
            $f = 0;
            if ($meta > $hecho) {

                $restantes = ($meta - $hecho);
                $text = "Hace falta por resolver " . $restantes . " tareas!";
                $lista = base_notificacion("../desarrollo/?q=1", "fa fa-credit-card ", $text);

                $f++;
            }

            $response = [
                "html" => $lista,
                "flag" => $f,

            ];

            return $response;
        }

    }
    if (!function_exists('add_envios_a_ventas')) {
        function add_envios_a_ventas($meta, $hecho)
        {

            $lista = "";
            $f = 0;
            if ($meta > $hecho) {

                $restantes = ($meta - $hecho);
                $text = "Apresúrate completa tu logro sólo hace falta " . $restantes . " venta para completar tus labores del día!";
                $lista = base_notificacion("../reporte_enid/?q=2", " fa fa-money ", $text);
                $f++;
            }

            $response = [

                "html" => $lista,
                "flag" => $f,

            ];

            return $response;
        }
    }

    if (!function_exists('add_accesos_pendientes')) {
        function add_accesos_pendientes($meta, $hecho)
        {

            $lista = "";
            $f = 0;
            if ($meta > $hecho) {
                $restantes = ($meta - $hecho);

                $text = "Otros usuarios ya han compartido sus productos en redes sociales, alcanza a tu competencia sólo te hacen falta  " . $restantes . " vistas a tus productos";
                $lista = base_notificacion("../tareas/?q=2", " fa fa-clock-o ", $text);
                $f++;
            }

            $response = [

                "html" => $lista,
                "flag" => $f,

            ];
            return $response;
        }
    }

    if (!function_exists('add_email_pendientes_por_enviar')) {
        function add_email_pendientes_por_enviar($meta_email, $email_enviados_enid_service)
        {

            $lista = "";
            $f = 0;
            if ($meta_email > $email_enviados_enid_service) {

                $email_restantes = ($meta_email - $email_enviados_enid_service);
                $text = 'Te hacen falta enviar ' . $email_restantes . ' correos a posibles clientes para cumplir tu meta de prospección';
                $lista = base_notificacion("../tareas/?q=2", "fa fa-bullhorn ", $text);
                $f++;
            }
            $response = [

                "html" => $lista,
                "flag" => $f,

            ];

            return $response;
        }
    }
    if (!function_exists('add_numero_telefonico')) {
        function add_numero_telefonico($num)
        {

            $lista = "";
            $f = 0;
            if ($num > 0) {

                $text = "Agrega un número para compras o ventas";
                $lista = base_notificacion("../administracion_cuenta/", "fa fa-mobile-alt", $text);

                $f++;
            }

            $response = [

                "html" => $lista,
                "flag" => $f,

            ];


            return $response;
        }
    }
    if (!function_exists('add_recibos_sin_costo')) {
        function add_recibos_sin_costo($recibos)
        {

            $r = [];
            $f = 0;
            foreach ($recibos as $row) {

                $id_recibo = $row["id_recibo"];
                $saldo_cubierto = $row["saldo_cubierto"];
                $text = div(heading_enid(icon(" fa fa-ticket ") . $saldo_cubierto . " MXN ", 3), "col-lg-12 top_10  shadow padding_10 mh_notificaciones");


                $r[] = anchor_enid($text,
                    [
                        "href" => "../pedidos/?costos_operacion=" . $id_recibo . "&saldado=" . $saldo_cubierto
                    ]
                );

                $f++;
            }

            $response =
                [
                    "html" => append($r),
                    "flag" => $f,

                ];

            return $response;

        }
    }

    if (!function_exists('add_valoraciones_sin_leer')) {
        function add_valoraciones_sin_leer($num, $id_usuario)
        {
            $lista = "";
            $f = 0;
            if ($num > 0) {

                $text_comentario = div("Alguien han agregado sus comentarios sobre uno de tus artículos en venta ", 1) . base_valoracion();
                $text = div($num . " personas han agregado sus comentarios sobre tus artículos", 1) . base_valoracion();
                $text = ($num > 1) ? $text : $text_comentario;
                $lista = base_notificacion("../recomendacion/?q=" . $id_usuario, "fa fa-star", $text);
                $f++;
            }

            $response = [

                "html" => $lista,
                "flag" => $f,

            ];

            return $response;
        }
    }


    function add_pedidos_sin_direccion($param)
    {

        $sin_direcciones = $param["sin_direcciones"];
        $lista = "";
        $f = 0;
        if ($sin_direcciones > 0) {

            $text = ($sin_direcciones > 1) ? $sin_direcciones . " de tus compras solicitadas, aún no cuentan con tu dirección de envio" : "Tu compra aún,  no cuentan con tu dirección de envio";
            $lista = base_notificacion("../area_cliente/?action=compras", "fa fa-bus ", $text);
            $f++;

        }

        $response = [

            "html" => $lista,
            "flag" => $f,

        ];

        return $response;
    }


    function add_saldo_pendiente($param)
    {

        $adeudos_cliente = $param["total_deuda"];
        $lista = "";
        $f = 0;
        if ($adeudos_cliente > 0) {

            $total_pendiente = round($adeudos_cliente, 2);
            $text = 'Saldo por liquidar ' . span($total_pendiente . 'MXN',
                    [
                        "class" => "saldo_pendiente_notificacion",
                        "deuda_cliente" => $total_pendiente
                    ]
                );

            $lista = base_notificacion("../area_cliente/?action=compras", "fa fa-credit-card", $text);

            $f++;
        }

        $response = [

            "html" => $lista,
            "flag" => $f,

        ];

        return $response;
    }

    function base_notificacion($url = '', $class_icono = '', $text = '')
    {
        return li(anchor_enid(icon($class_icono) . $text, ["href" => $url, "class" => "black notificacion_restante top_10"]));
    }

    function add_mensajes_respuestas_vendedor($param, $tipo)
    {

        $lista = "";
        $f = 0;

        $num = ($tipo == 1) ? $param["modo_vendedor"] : $param["modo_cliente"];

        if ($num > 0) {

            $text = val_class($tipo, 1, "Alguien quiere saber más sobre tu producto", "Tienes una nueva respuesta en tu buzón");
            $lista = base_notificacion(path_enid("area_cliente_pregunta"), "fa fa-comments", $text);
            $f++;

        }

        $response = [

            "html" => $lista,
            "flag" => $f,
        ];

        return $response;
    }

    function add_recordatorios($recordatorios)
    {


        $r = [];
        $f = 0;
        foreach ($recordatorios as $row) {


            $fecha_cordatorio = $row["fecha_cordatorio"];
            $id_recibo = $row["id_recibo"];

            $text = btw(

                div(text_icon("fa  fa fa-clock-o ", $fecha_cordatorio)),
                div($row["descripcion"]),
                "col-lg-12 top_10  shadow padding_10 mh_notificaciones"
            );


            $r[] = anchor_enid($text, path_enid("pedidos_recibo", $id_recibo . "#listado_recordatorios"));
            $f++;
        }

        $response = [

            "html" => append($r),
            "flag" => $f,
        ];

        return $response;
    }

    function add_compras_sin_cierre($recibos)
    {


        $r = [];
        $f = 0;

        if (es_data($recibos)) {

            foreach ($recibos as $row) {


                $id_recibo = $row["id_recibo"];
                $total = div($row["total"] . "MXN", "text_monto_sin_cierre text-left");
                $text = btw(
                    div(
                        img($row["url_img_servicio"])
                        ,
                        "w_50"
                    ),
                    $total,
                    "display_flex_enid top_10 border padding_10"
                );

                $url = path_enid("pedidos_recibo", $id_recibo);
                $r[] = anchor_enid($text, $url);
                $f++;
            }

            if (es_data($r)) {

                array_unshift($r, br(2) . div(heading_enid("VENTAS EN PROCESO", 5, ["class" => "top_20"])));

            }

        }

        $response = [

            "html" => append($r),
            "flag" => $f,

        ];
        return $response;


    }

    function get_tareas_pendienetes_usuario_cliente($info)
    {

        $num_telefonico = $info["info_notificaciones"]["numero_telefonico"];
        $f = 0;
        $inf_notificacion = $info["info_notificaciones"];

        $compras_sin_cierre = add_compras_sin_cierre($info["compras_sin_cierre"]);

        $f = $f + $compras_sin_cierre["flag"];


        $deuda = add_saldo_pendiente($inf_notificacion["adeudos_cliente"]);
        $f = $f + $deuda["flag"];

        $preguntas = add_preguntas_sin_lectura($info["preguntas"]);
        $f = $f + $preguntas["flag"];


        $respuestas = add_respuestas_sin_lectura($info["respuestas"]);

        $f = $f + $respuestas["flag"];


        $direccion = add_pedidos_sin_direccion($inf_notificacion["adeudos_cliente"]);
        $f = $f + $direccion["flag"];


        $direccion_envio = add_direccion_envio($info["flag_direccion"]);
        $f = $f + $direccion_envio["flag"];


        $numtelefonico = add_numero_telefonico($num_telefonico);
        $f = $f + $numtelefonico["flag"];


        $response["num_tareas_pendientes_text"] = $f;
        $response["num_tareas_pendientes"] = crea_tareas_pendientes_info($f);

        $list = [
            $deuda["html"],
            $direccion["html"],
            $direccion_envio["html"],
            $numtelefonico["html"],
            $preguntas["html"],
            $respuestas["html"],
            div($compras_sin_cierre["html"], "top_20")


        ];

        $response["lista_pendientes"] = ul($list, "d-flex flex-column justify-content-between text_notificacion");

        return $response;

    }

    function add_preguntas_sin_lectura($preguntas, $es_vendedor = 0)
    {

        $r = [];
        $f = 0;
        foreach ($preguntas as $row) {


            $id_pregunta = $row["id_pregunta"];
            $pregunta = $row["pregunta"];
            $id_servicio = $row["id_servicio"];
            $pregunta = (strlen($pregunta) > 50) ? substr($pregunta, 0, 60) : $pregunta;
            $pregunta = div($pregunta, "black");


            $imagenes = div(img_servicio($id_servicio), ["style" => "width:50px"]);
            $t = [];
            $t[] = btw($imagenes, $pregunta, " d-flex flex-column justify-content-between ");
            $text = append($t);

            $id = "#pregunta" . $id_pregunta;
            $url = "../pregunta/?action=recepcion&id=" . $id_pregunta . "&id_servicio=" . $id_servicio . $id;
            $r[] = anchor_enid($text, ["href" => $url]) . hr();
            $f++;
        }


        if (es_data($r) ) {
            array_unshift($r, "LO QUE COMPRADORES TE PREGUNTAN");
        }

        $response = [

            "html" => append($r),
            "flag" => $f,

        ];

        return $response;

    }

    function add_respuestas_sin_lectura($respuestas)
    {

        $r = [];
        $f = 0;
        foreach ($respuestas as $row) {


            $id_pregunta = $row["id_pregunta"];
            $pregunta = $row["pregunta"];
            $id_servicio = $row["id_servicio"];
            $pregunta = (strlen($pregunta) > 50) ? substr($pregunta, 0, 60) : $pregunta;
            $pregunta = div($pregunta, ["class" => "black"]);

            $imagenes = div(img_servicio($id_servicio), ["style" => "width:50px"]);
            $t = [];
            $t[] = btw($imagenes, $pregunta, "columna ->   d-flex flex-column justify-content-between");
            $text = append($t);

            $id = "#pregunta" . $id_pregunta;
            $url = "../pregunta/?action=hechas&id=" . $id_pregunta . "&id_servicio=" . $id_servicio . $id;
            $r[] = anchor_enid($text, ["href" => $url]) . hr();
            $f++;
        }

        if (es_data($r)) {

            array_unshift($r, "TU BUZÓN");
        }

        $response = [
            "html" => append($r),
            "flag" => $f,

        ];

        return $response;

    }

    function get_tareas_pendienetes_usuario($info)
    {


        $inf = $info["info_notificaciones"];
        $lista = "";
        $f = 0;
        $ventas_enid_service = $info["ventas_enid_service"];
        $tareas_enid_service = $inf["tareas_enid_service"];
        $num_telefonico = $inf["numero_telefonico"];


        $tareas = add_tareas($info["tareas"]);
        $f = $f + $tareas["flag"];
        $lista .= $tareas["html"];


        $compras_sin_cierre = add_compras_sin_cierre($info["compras_sin_cierre"]);
        $lista .= div($compras_sin_cierre["html"], "top_20");
        $f = $f + $compras_sin_cierre["flag"];

        $recibos_sin_costos_operacion = add_recibos_sin_costo($info["recibos_sin_costos_operacion"]);
        $f = $f + $recibos_sin_costos_operacion["flag"];
        $lista .= $recibos_sin_costos_operacion["html"];


        $recordatorios = add_recordatorios($info["recordatorios"]);
        $lista .= $recordatorios["html"];
        $f = $f + $recordatorios["flag"];





        $preguntas = add_preguntas_sin_lectura($info["preguntas"]);
        $lista .= $preguntas["html"];
        $f = $f + $preguntas["flag"];


        $respuestas = add_respuestas_sin_lectura($info["respuestas"]);
        $lista .= $respuestas["html"];
        $f = $f + $respuestas["flag"];


        $deuda = add_saldo_pendiente($inf["adeudos_cliente"]);
        $f = $f + $deuda["flag"];
        $lista .= $deuda["html"];

        $deuda = add_pedidos_sin_direccion($inf["adeudos_cliente"]);
        $f = $f + $deuda["flag"];
        $lista .= $deuda["html"];

        $deuda = add_valoraciones_sin_leer($inf["valoraciones_sin_leer"], $info["id_usuario"]);
        $f = $f + $deuda["flag"];
        $lista .= $deuda["html"];

        $num_telefonico = add_numero_telefonico($num_telefonico);
        $f = $f + $num_telefonico["flag"];
        $lista .= $num_telefonico["html"];


        if (is_array($inf) && array_key_exists("objetivos_perfil", $inf)) {
            foreach ($inf["objetivos_perfil"] as $row) {

                switch ($row["nombre_objetivo"]) {
                    case "Ventas":

                        $meta_ventas = $row["cantidad"];
                        $notificacion =
                            add_envios_a_ventas($meta_ventas, $ventas_enid_service);
                        $lista .= $notificacion["html"];
                        $f = $f + $notificacion["flag"];

                        break;


                    case "Desarrollo_web":

                        $meta_tareas = $row["cantidad"];
                        $notificacion =
                            add_tareas_pendientes($meta_tareas, $tareas_enid_service);
                        $lista .= $notificacion["html"];
                        $f = $f + $notificacion["flag"];
                        break;
                    default:
                        break;
                }

            }

        }


        $new_flag = "";
        if ($f > 0) {

            $new_flag = div($f,
                [
                    "id" => $f,
                    "class" => 'notificacion_tareas_pendientes_enid_service'
                ]);

        }


        $response = [
            "num_tareas_pendientes_text" => $f,
            "num_tareas_pendientes" => $new_flag,
            "lista_pendientes" => get_mensaje_inicial_notificaciones(1, $f) . $lista,

        ];

        return $response;

    }

    function get_valor_fecha_solicitudes($solicitudes, $fecha_actual)
    {

        $valor = 0;
        foreach ($solicitudes as $row) {

            $fecha_registro = $row["fecha_registro"];
            if ($fecha_registro == $fecha_actual) {
                $tareas_solicitadas = $row["tareas_solicitadas"];
                $valor = $tareas_solicitadas;
                break;
            }
        }
        return $valor;
    }

    function get_comparativa($info_sistema)
    {

        $info_uso = "";
        $b = 1;
        $x = 0;
        $total_d_m_1 = 0;
        $formas_pago_1 = 0;
        $faq_1 = 0;
        $sobre_enid_1 = 0;
        $afiliados_1 = 0;
        $nosotros_1 = 0;
        $procesar_compra_1 = 0;
        $total_visitas = 0;
        $total_faqs = 0;
        $total_formas_pago = 0;
        $total_contacto = 0;
        $total_principal = 0;
        $total_afiliado = 0;
        $total_home = 0;

        $total_procesar_compra = 0;
        foreach ($info_sistema["semanal"] as $row) {

            $f_registro = $row["horario"];
            $total_registrado = valida_total_menos1($total_d_m_1, $row["total_registrado"]);
            $total_visitas = $total_visitas + $row["total_registrado"];
            $faq = valida_total_menos1($faq_1, $row["faq"]);
            $faq_1 = $row["faq"];
            $total_faqs = $total_faqs + $row["faq"];
            $formas_pago = valida_total_menos1($formas_pago_1, $row["formas_pago"]);
            $formas_pago_1 = $row["formas_pago"];
            $total_formas_pago = $total_formas_pago + $row["formas_pago"];
            $sobre_enid = valida_total_menos1($sobre_enid_1, $row["sobre_enid"]);
            $sobre_enid_1 = $row["sobre_enid"];
            $total_principal = $total_principal + $row["sobre_enid"];
            $procesar_compra = valida_total_menos1($procesar_compra_1, $row["procesar_compra"]);
            $procesar_compra_1 = $row["procesar_compra"];

            $total_procesar_compra = $total_procesar_compra + $row["procesar_compra"];

            $afiliados = valida_total_menos1($afiliados_1, $row["afiliados"]);
            $total_afiliado = $total_afiliado + $row["afiliados"];
            $afiliados_1 = $row["afiliados"];
            $nosotros = valida_total_menos1($nosotros_1, $row["nosotros"]);
            $nosotros_1 = $row["nosotros"];
            $total_home = $total_home + $row["nosotros"];
            $contacto = $row["contacto"];
            $total_contacto = $total_contacto + $contacto;

            $style = "";


            $info_uso .= '<tr  ' . $style . '>';
            $info_uso .= get_td($f_registro);
            $info_uso .= $total_registrado;
            $info_uso .= $faq;
            $info_uso .= $formas_pago;
            $info_uso .= get_td($contacto);
            $info_uso .= $sobre_enid;
            $info_uso .= $afiliados;
            $info_uso .= $nosotros;
            $info_uso .= $procesar_compra;
            $info_uso .= '</tr>';
            $b++;
            $x++;
        }

        $t = [];
        $t[] = "<tr  style=\"background: #000;color: white;text-align: center!important;\">";
        $t[] = get_td("Horario");
        $t[] = get_td("Total");
        $t[] = get_td("FAQ");
        $t[] = get_td("Formas de pago");
        $t[] = get_td("Contacto");
        $t[] = get_td("Sobre Enid");
        $t[] = get_td("Afiliados");
        $t[] = get_td("Home");
        $t[] = get_td("Procesar compra");
        $t[] = "</tr>";

        $t[] = $info_uso;

        $t[] = "<tr style=\"background: #000;color: white;text-align: center!important;\">";
        $t[] = get_td("Total");
        $t[] = get_td($total_visitas);
        $t[] = get_td($total_faqs);
        $t[] = get_td($total_formas_pago);
        $t[] = get_td($total_contacto);
        $t[] = get_td($total_principal);
        $t[] = get_td($total_afiliado);
        $t[] = get_td($total_home);
        $t[] = get_td($total_procesar_compra);
        $t[] = "</tr>";

        $t = " <table class='table' >" . append($t) . "</table>";
        return $t;

    }
}