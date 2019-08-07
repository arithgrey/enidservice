<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {

    function actividad_mail_marketing($data)
    {

        $email = $data["email"];
        $seccion_fechas = "";
        $seccion_envios = "";
        $seccion_solicitudes = "";
        $seccion_ventas = "";
        $total_envios = 0;
        $total_solicitudes = 0;
        $total_ventas = 0;
        $num_dias = 0;
        $dias = ["", 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        $l_fechas = [];
        $l_fecha_texto = [];
        $l_envios = [];
        $l_solicitudes = [];
        $l_ventas = [];

        foreach ($email as $row) {

            $fecha_texto = $dias[date('N', strtotime($row["fecha_registro"]))];
            array_push($l_fechas, $row["fecha_registro"]);
            array_push($l_envios, $row["envios"]);
            array_push($l_solicitudes, $row["solicitudes"]);
            array_push($l_ventas, $row["ventas"]);
            array_push($l_fecha_texto, $fecha_texto);
        }

        $a = 0;
        foreach ($l_fechas as $row) {

            $fecha_registro_texto = $l_fecha_texto[$a];
            $fecha_registro = $l_fechas[$a];
            $ft = $fecha_registro_texto . "" . $fecha_registro;

            $envios = valida_num($l_envios[$a]);
            $solicitudes = valida_num($l_solicitudes[$a]);
            $ventas = valida_num($l_ventas[$a]);

            $total_envios = $total_envios + $envios;
            $total_solicitudes = $total_solicitudes + $solicitudes;
            $total_ventas = $total_ventas + $ventas;
            $num_dias++;
            $a++;

            $seccion_fechas .= td($ft);
            $seccion_envios .= td($envios);
            $seccion_solicitudes .= td($solicitudes);
            $seccion_ventas .= td($ventas);

        }


        $a[] = td("Periodo");
        $a[] = td("Totales  Días " . $num_dias);
        $a[] = $seccion_fechas;

        $response[] = tr(append($a));

        $b[] = td("Envios");
        $b[] = td($total_envios);
        $b[] = $seccion_envios;
        $response[] = tr(append($b));

        $c[] = td("Solicitudes");
        $c[] = td($total_solicitudes);
        $c[] = $seccion_solicitudes;

        $response[] = tr(append($c));

        $d[] = td("Ventas");
        $d[] = td($total_ventas);
        $d[] = $seccion_ventas;
        $response[] = tr(append($d));

        return tb(append($response), ["border" => "1", "class" => "text-center"]);


    }

    function metricas($data)
    {

        $envio_usuario = $data["envio_usuario"];
        $ext_periodo = ["style" => 'background:#02316f;color:white!important;'];
        $ext_valoraciones = ["style" => 'background: #000;color: white !important;text-align: center;'];

        $accesos = "";
        $transacciones = "";
        $contacto = "";
        $labores_resueltas = "";
        $total_valoraciones = "";

        $fecha_inicio = $envio_usuario["fecha_inicio"];
        $fecha_termino = $envio_usuario["fecha_termino"];
        $conversaciones = "";
        $lista_deseos = "";


        foreach ($data["actividad_enid_service"] as $row) {


            $ext_td_usablidad = "title ='Personas que acceden al sistema para emplearlo' ";
            $table = "<table width='100%' border=1  style='text-align: center;'>";
            $table .= "<tr>";
            $table .= td("Usuarios", "class='strong' ");
            $table .= td("Servicios postulados", "class='strong' ");
            $table .= td("Ingresos a Enid", $ext_td_usablidad);
            $table .= "</tr>";
            $table .= "<tr>";
            $table .= td($row["usuarios"], [
                "class" => 'usuarios',
                "fecha_inicio" => $fecha_inicio,
                "fecha_termino" => $fecha_termino,
                "href" => '#reporte',
                "data-toggle" => 'tab',
                "title" => 'Personas que se registran en el sistema'
            ]);
            $table .= td($row["servicios_creados"], [
                "class" => 'servicios',
                "fecha_inicio" => $fecha_inicio,
                "fecha_termino" => $fecha_termino,
                "href" => '#reporte',
                "data-toggle" => 'tab',
                "title" => 'Servicios postulados'
            ]);
            $table .= td($row["accesos_area_cliente"],
                ["title" => 'Personas que acceden a Enid Service desde su área de cliente']);
            $table .= "</tr>";
            $table .= "</table>";
            $nuevos_usuarios = td($table);


            $accesos_enid = $row["accesos"];
            $accesos_a_intento_compra = $row["accesos_a_intento_compra"];
            $accesos_contacto = $row["accesos_contacto"];
            $contacto = $row["contacto"];

            $table = "<table width='100%' border=1  style='text-align: center;'>";
            $table .= "<tr>";
            $table .= td("Total");
            $table .= td("Acesso a procesar compra");
            $table .= td("Accesos a contacto");
            $table .= td("Mensajes recibidos");
            $table .= "</tr>";
            $table .= "<tr>";
            $table .= td($accesos_enid);
            $table .= td($accesos_a_intento_compra);
            $table .= td($accesos_contacto);
            $table .= td($contacto, [
                "class" => 'contactos',
                "fecha_inicio" => $fecha_inicio,
                "fecha_termino" => $fecha_termino,
                "href" => '#reporte',
                "data-toggle" => 'tab',
                "title" => 'Mensajes enviados por personas a Enid Service'
            ]);
            $table .= "</tr>";
            $table .= "</table>";
            $accesos .= td($table);


            if (count($row["ventas"]) > 0) {


                $ventas = $row["ventas"][0];
                $num_transacciones = $ventas["total"];
                $compras_efectivas = $ventas["compras_efectivas"];
                $solicitudes = $ventas["solicitudes"];
                $envios = $ventas["envios"];
                $cancelaciones = $ventas["cancelaciones"];

                $table = "<table width='100%' border=1  style='text-align: center;'>";
                $table .= "<tr>";
                $table .= td("Transacciones");
                $table .= td("Ventas");
                $table .= td("Cancelaciones");
                $table .= td("Solicitudes");
                $table .= td("Envíos");
                $table .= "</tr>";
                $table .= "<tr>";
                $table .= td($num_transacciones);
                $table .= td($compras_efectivas, [

                    "class" => 'solicitudes',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "tipo_compra" => '9',
                    "href" => '#reporte',
                    "data-toggle" => 'tab',
                    "title" => 'COMPRAS SATISFACTORIAS'
                ]);
                $table .= td($cancelaciones, [
                    "class" => 'solicitudes',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "tipo_compra" => '10',
                    "href" => '#reporte',
                    "data-toggle" => 'tab',
                    "title" => 'Solicitudes de compra'
                ]);
                $table .= td($solicitudes, [
                    "class" => 'solicitudes',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "tipo_compra" => '6',
                    "href" => '#reporte',
                    "data-toggle" => 'tab',
                    "title" => 'Solicitudes de compra'
                ]);
                $table .= td($envios, [
                    "class" => 'solicitudes',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "tipo_compra" => '7',
                    "href" => '#reporte',
                    "data-toggle" => 'tab',
                    "title" => 'Se han enviado'
                ]);
                $table .= "</tr>";
                $table .= "</table>";
                $transacciones .= td($table);


            } else {

                $table = "<table width='100%' border=1  style='text-align: center;'>";
                $table .= "<tr>";
                $table .= td("Transacciones");
                $table .= td("Ventas");
                $table .= td("Cancelaciones");
                $table .= td("Solicitudes");
                $table .= td("Envíos");
                $table .= "</tr>";
                $table .= "<tr>";
                $table .= td(0);
                $table .= td(0);
                $table .= td(0);
                $table .= td(0);
                $table .= td(0);
                $table .= "</tr>";
                $table .= "</table>";
                $transacciones .= td($table);

            }

            $contacto .= td($row["contacto"]);

            $table = "<table width='100%' border=1  style='text-align: center;'>";
            $table .= "<tr>";
            $table .= td("Labores");
            $table .= td("Prospección email");
            $table .= "</tr>";
            $table .= "<tr>";
            $table .= td(
                a_enid($row["labores_resueltas"],
                    [
                        "href" => '../desarrollo/',
                        "target" => '_blank',
                        "class" => 'strong',
                        "style" => 'color:blue !important;'
                    ]));


            if ($row["correos"] > 0) {
                $table .= td($row["correos"]);
            } else {
                $table .= td(0);
            }


            $table .= "</tr>";
            $table .= "</table>";
            $labores_resueltas .= td($table);

            $productos_valorados =
                ($row["valoraciones_productos"] > 0) ? $row["valoraciones_productos"][0]["productos_valorados"] : 0;

            if (es_data($row["valoraciones"])) {


                $valoraciones = $row["valoraciones"][0];
                $total_val = $valoraciones["num_valoraciones"];
                $si_recomendarian = $valoraciones["si_recomendarian"];
                $no_recomendarian = $valoraciones["no_recomendarian"];


                $ext_si_recomendaria = ["title" => "Personas que SI recomendarían la compra  " . $si_recomendarian];
                $ext_no_recomendaria = ["title" => "Personas que NO recondarían la compra " . $no_recomendarian];

                $porcentaje_si = porcentaje($total_val, intval($si_recomendarian));
                $porcentaje_no = porcentaje($total_val, intval($no_recomendarian));

                $table = "<table width='100%' border=1  style='text-align: center;'>";
                $table .= "<tr>";
                $table .= td("Valoraciones");
                $table .= td("Productos distintos valorados");
                $table .= td("Recomendarian");
                $table .= td("NO recomendarían");

                $table .= "</tr>";
                $table .= "<tr>";
                $table .= td($total_val, [
                    "class" => 'valoraciones',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "href" => '#reporte',
                    "data-toggle" => 'tab',
                    "title" => 'Valoraciones que se han hecho en Enid Service'
                ]);
                $table .= td($productos_valorados, [
                    "class" => 'productos_valorados_distintos',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "href" => '#reporte',
                    "data-toggle" => 'tab',
                    "title" => 'Productos distintos valorados'
                ]);
                $table .= td($porcentaje_si . "%", $ext_si_recomendaria);
                $table .= td($porcentaje_no . "%", $ext_no_recomendaria);
                $table .= "</tr>";
                $table .= "</table>";

                $total_valoraciones .= td($table);

            } else {


                $table = "<table width='100%' border=1>";
                $table .= "<tr>";
                $table .= td("Total");
                $table .= td("Productos distintos valorados");
                $table .= td("Recomendarian");
                $table .= td("NO recomendarían");

                $table .= "</tr>";
                $table .= "<tr>";
                $table .= td("0");
                $table .= td("0");
                $table .= td("0%");
                $table .= td("0%");
                $table .= "</tr>";
                $table .= "</table>";

                $total_valoraciones .= td($table);

            }


            if (es_data($row["lista_deseo"])) {

                $ext_lista_deseos = " 
				fecha_inicio = '" . $fecha_inicio . "' 
				fecha_termino ='" . $fecha_termino . "' 
				class='lista_deseos lista_deseos_num'
				href='#reporte' data-toggle='tab' ";

                $num_lista_deseos = $row["lista_deseo"][0]["num"];
                $table = "<table width='100%' border=1  style='text-align: center;'>";
                $table .= "<tr>";
                $table .= td("Agregados a la lista");
                $table .= "</tr>";
                $table .= "<tr>";
                $table .= td($num_lista_deseos, $ext_lista_deseos);
                $table .= "</tr>";
                $table .= "</table>";
                $lista_deseos .= td($table);

            } else {

                $table = "<table width='100%' border=1  style='text-align: center;'>";
                $table .= "<tr>";
                $table .= td("Agregados a la lista");
                $table .= "</tr>";
                $table .= "<tr>";
                $table .= td(0);
                $table .= "</tr>";
                $table .= "</table>";
                $lista_deseos .= td($table);
            }

        }

        $a[] = td("PERIODO", $ext_periodo);
        $a[] = td($fecha_inicio . " al " . $fecha_termino, $ext_periodo);


        $b[] = td("USUARIOS NUEVOS", ["style" => 'background: #2372e9;color: white !important;text-align: center;']);
        $b[] = $nuevos_usuarios;

        $c[] = td("CONVERSACIONES", ["style" => 'background: #006475;color: white !important;text-align: center;']);
        $c[] = $conversaciones;

        $d[] = td("TRANSACCIONES", ["style" => 'background: #002763;color: white !important;text-align: center;']);
        $d[] = $transacciones;

        $e[] = td("VALORACIONES", $ext_valoraciones);
        $e[] = $total_valoraciones;

        $f[] = td("VALORACIONES", $ext_valoraciones);
        $f[] = $total_valoraciones;


        $g[] = td("ACCESOS", ["style" => 'background: #00b7ff;color: white !important;text-align:center;']);
        $g[] = $accesos;

        $h[] = td("CONTACTO", ["style" => 'text-align: center;']);
        $h[] = $contacto;

        $i[] = td("LABORES RESUELTAS", ["style" => 'text-align: center;background: #1c404e;color: white !important;']);
        $i[] = $labores_resueltas;

        $j[] = td("LISTA DE DESEOS", ["style" => 'text-align: center;background: #ff0048;color: white !important;']);
        $j[] = $lista_deseos;


        $response[] = tr(append($a));
        $response[] = tr(append($b));
        $response[] = tr(append($c));
        $response[] = tr(append($d));
        $response[] = tr(append($e));
        $response[] = tr(append($f));
        $response[] = tr(append($g));
        $response[] = tr(append($h));
        $response[] = tr(append($i));
        $response[] = tr(append($j));
        return tb(append($response), ["width" => "100%", "border" => "1"]);


    }

    function format_miembros($data)
    {

        $_response[] = h("USUARIOS", 3);
        $_response[] = $data["paginacion"];

        foreach ($data["miembros"] as $row) {

            $id_usuario = $row["id_usuario"];
            $afiliado = $row["nombre"] . " " . $row["apellido_paterno"] . " " . $row["apellido_materno"];


            $re[] = img([
                "src" => "../imgs/index.php/enid/imagen_usuario/" . $id_usuario,
                "style" => 'width: 44px!important;',
                "onerror" => "this.src='../img_tema/user/user.png'"
            ]);
            $re[] = d($afiliado);
            $re[] = d($row["fecha_registro"]);
            $response[] = d(append($re), "popup-head-left pull-left");

            if ($data["modo_edicion"] == 1):
                $res[] = d(icon("fa fa-envelope"), ["title" => "Email de recordatorio enviados"]);
                $m[] = btn(
                    icon('fa fa-plus'),
                    [
                        "class" => "chat-header-button",
                        "data-toggle" => "dropdown"
                    ]
                );

                $m[] = ul(
                    [
                        a_enid(
                            append([icon('fa fa-pencil'), "Editar información"]),
                            [
                                "class" => 'usuario_enid_service',
                                "data-toggle" => 'tab',
                                "href" => '#tab_mas_info_usuario',
                                "id" => $id_usuario
                            ]
                        )
                    ],
                    "dropdown-menu pull-right");
                $res[] = d(append($m), "btn-group");
                $response[] = d(append($res), "popup-head-right pull-right");
            endif;

            $_response[] = d(d(append($response), "popup-head"), ["class" => "popup-box chat-popup", "id" => "qnimate"]);

        }
        return append($_response);

    }

    function gb_calidad($data)
    {

        $info_global = $data["info_global"];
        $style = [];
        $style_terminos = ["style" => 'background:#024d8d;color:white;'];
        $style_solicitudes = ["style" => 'font-size:.8em;background:#ea330c;color:white;'];
        $lista_fechas_text = td("Periodo", $style);
        $lista_fechas_text .= td("Total", $style);
        $lista_solicitudes = "";

        $lista_terminos = "";
        $totales_solicitudes = 0;
        $totales_realizadas = 0;
        foreach ($info_global["lista_fechas"] as $row) {

            $fecha = $row["fecha"];
            $lista_fechas_text .= td($fecha, $style);
            $valor_solicitudes = get_valor_fecha_solicitudes($info_global["solicitudes"], $fecha);
            $totales_solicitudes = $totales_solicitudes + $valor_solicitudes;
            $lista_solicitudes .= td($valor_solicitudes, $style);
            $valor_terminos = tareas_realizadas($info_global["terminos"], $fecha);
            $totales_realizadas = $totales_realizadas + $valor_terminos;
            $lista_terminos .= td($valor_terminos, $style);

        }

        $response[] = d("Atención al cliente/ tareas resueltas", ["class" => "blue_enid_background white"], 1);


        $r[] = tr($lista_fechas_text);

        $sl[] = td("Solicitudes", $style_solicitudes);
        $sl[] = td($totales_solicitudes, $style_solicitudes);
        $sl[] = $lista_solicitudes;

        $r[] = tr(append($sl));

        $tr[] = td("Términos", $style_terminos);
        $tr[] = td($totales_realizadas, $style_terminos);
        $tr[] = $lista_terminos;

        $r[] = tr(append($tr));
        $response[] = tb(append($r));
        return append($response);


    }

    function comparativa_gb($data)
    {

        $info_global = $data["info_global"];
        $lista_fechas = get_arreglo_valor($info_global, "fecha");
        $list = [];
        foreach ( get_franja_horaria() as $row) {

            $franja_h = $row;
            $list[] = "<tr>";
            $list[] = td($franja_h);

            $total_tareas = 0;
            $lista2 = "";
            foreach ($lista_fechas as $row) {

                $fecha_actual = $row;
                $tareas_realizadas = valida_tareas_fecha($info_global, $fecha_actual, $franja_h);
                $total_tareas = $total_tareas + $tareas_realizadas;
                $lista2 .= td($tareas_realizadas);
            }
            $list[] = td($total_tareas);
            $list[] = $lista2;
            $list[] = "</tr>";

        }

        $response[] = d("Atención al cliente/ tareas resueltas", "blue_enid_background white padding_10", 1);
        $response[] = get_fechas_global($lista_fechas);
        $response[] = append($list);
        return tb(append($response), 'table_enid_service text-center');

    }

    function format_comparativa($data)
    {


        $info_global = $data["info_global"];

        $lista = [];
        $franja_horaria = get_franja_horaria();
        for ($a = 0; $a < count($franja_horaria); $a++) {

            $lista[] = "
<tr>";
            $lista[] = td($franja_horaria[$a]);
            $lista[] = get_comparativas_metricas($franja_horaria[$a], $info_global);
            $lista[] = "
</tr>";
        }

        $response[] = d("Comparativa atención al cliente y tareas resueltas", "blue_enid_background white pading_10");
        $t[] = td("Franja horaria");
        $t[] = td("Hace 7 días");
        $t[] = td("Ayer");
        $t[] = td("Hoy");
        tr($t, 'f - enid');
        $response[] = "
<table>";
        $response[] = append($lista);
        $response[] = "
</table>";
        return d(append($response), 6, 1);


    }

    if (!function_exists('format_contactos_dia')) {
        function format_contactos_dia($data)
        {


            $contactos = $data["contactos"];
            $r[] = h("MENSAJES ENVIADOS A ENID SERVICE", 3);


            foreach ($contactos as $row) {

                $r[] = d(d(
                    d(
                        append(
                            [
                                img([
                                    "src" => "../img_tema/user/user.png",
                                    "style" => 'width: 44px!important;',
                                    "onerror" => "../img_tema/user/user.png"
                                ]),
                                d($row["nombre"] . "|" . $row["email"]),
                                d($row["mensaje"] . $row["telefono"] . $row["fecha_registro"])
                            ]
                        ), "popup-head-left pull-left"),
                    "popup-head"), [
                        "class" => "popup-box chat-popup", "id" => "qnimate", "style" => "margin-top: 4px;"
                    ]
                );

            }
            return append($r);
        }
    }


    if (!function_exists('get_mensaje_modificacion_pwd')) {
        function get_mensaje_modificacion_pwd($nombre)
        {

            $r[] = h(add_text("HOLA, ", strtoupper($nombre)), 3);
            $r[] = d(img(["src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg", "style" => "width: 100%"]));
            $r[] = d("Observamos un cambio de contraseña en tu cuenta. ¿Fuiste tú?");
            $r[] = d("Si es así ignora este correo, en caso contrario notificanos aquí http://enidservice.com/inicio/contact/");
            return append($r);

        }
    }

    if (!function_exists('get_mensaje_bienvenida')) {
        function get_mensaje_bienvenida($param)
        {


            $r[] = heading("Buen día " . $param["nombre"] . " " . $param["email"]);
            $r[] = d(
                img(
                    [
                        "src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg",
                        "style" => "width: 100%"
                    ]),
                [
                    "style" => "width: 30%;margin: 0 auto;"
                ]);

            $r[] = d("TU USUARIO SE HA REGISTRADO!", ["style" => "font-size: 1.4em;font-weight: bold"]);
            $r[] = hr();
            $r[] = d("Desde ahora podrás adquirir y vender las mejores promociones a lo largo de México");
            $r[] = br();
            $r[] = a_enid("ACCEDE A TU CUENTA AHORA!",
                [
                    "href" => "http://enidservice.com/inicio/login/",
                    "target" => "_blank",
                    "style" => "background: #001936;padding: 10px;color: white;margin-top: 23px;text-decoration: none;"
                ]);

            return append($r);

        }
    }


    if (!function_exists('base_valoracion')) {
        function b_valoracion()
        {
            return str_repeat("\n" . label("★", 'estrella') . "\n", 5);
        }
    }
    if (!function_exists('tareas_realizadas')) {
        function tareas_realizadas($realizado, $fecha_actual)
        {

            return $realizado[search_bi_array($realizado, "fecha_termino", $fecha_actual)]["tareas_realizadas"];
        }
    }
    if (!function_exists('valida_total_menos1')) {
        function valida_total_menos1($anterior, $nuevo, $extra = '')
        {


            return td(
                $nuevo,
                menorque($anterior, $nuevo, 'style = "background:#ff1b00!important; color:white!important;" ') . " " .
                $extra);
        }
    }

    if (!function_exists('valida_tareas_fecha')) {
        function valida_tareas_fecha($lista_fechas, $fecha_actual, $franja_horaria)
        {

            $num_visitas_web = 0;
            foreach ($lista_fechas as $row) {

                if ($row["fecha"] == $fecha_actual && $row["hora"] == $franja_horaria) {
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
            $fechas = "
<tr>";
            $b = 0;
            $estilos2 = "";
            foreach ($lista_fechas as $row) {
                if ($b < 1) {

                    $fechas .= td("Horario", $estilos2);
                    $fechas .= td("Total", $estilos2);
                    $b++;
                }
                $fecha_text = $dias[date('N', strtotime($row))];
                $text_fecha = $fecha_text . "" . $row;
                $fechas .= td($text_fecha, $estilos2);
            }
            $fechas .= "
</tr>";
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


    if (!function_exists('m_b_notificaciones')) {
        function m_b_notificaciones($tipo, $num_tareas)
        {

            $seccion = "";
            if ($num_tareas > 0) {
                switch ($tipo) {
                    case 1:
                        $seccion = d(h("NOTIFICACIONES ", 5), 1);
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

                $new_flag = d($f,
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

                $lista = b_notificacion(path_enid("administracion_cuenta"), "fa fa-map-marker", 'Registra tu dirección de compra y venta');

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


                $text = d(substr($row["asunto"], 0, 30), "black");
                $text = d(h(icon(" fas fa-tasks"), 5) . $text, "col-lg-12 top_10  shadow padding_10 mh_notificaciones");

                $r[] = a_enid($text, "../desarrollo/?q=1&ticket=" . $row["id_ticket"]);
                $f++;
            }


            $agregar = d(a_enid(text_icon("fas fa-plus-circle black", " TAREA"), path_enid("desarrollo")), "bottom_50 black underline");
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

                $text = "Hace falta por resolver " . ($meta - $hecho) . " tareas!";
                $lista = b_notificacion("../desarrollo/?q=1", "fa fa-credit-card ", $text);
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


                $text = "Apresúrate completa tu logro sólo hace falta 
                " . ($meta - $hecho) . " venta para completar tus labores del día!";
                $lista = b_notificacion("../reporte_enid/?q=2", " fa fa-money ", $text);
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

                $text = "Otros usuarios ya han compartido sus productos en redes sociales, alcanza a tu
                 competencia sólo te hacen falta 
                 " . ($meta - $hecho) . " 
                 vistas a tus productos";
                $lista = b_notificacion("../tareas/?q=2", " fa fa-clock-o ", $text);
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
        function add_email_pendientes_por_enviar($meta_email, $email_enviados)
        {

            $lista = "";
            $f = 0;
            if ($meta_email > $email_enviados) {


                $text = 'Te hacen falta enviar ' . ($meta_email - $email_enviados) . ' correos a 
                posibles clientes para cumplir tu 
                meta de prospección';
                $lista = b_notificacion("../tareas/?q=2", "fa fa-bullhorn ", $text);
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
                $lista = b_notificacion("../administracion_cuenta/", "fa fa-mobile-alt", $text);

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
                $text = d(h(
                    icon(" fa fa-ticket ") . $saldo_cubierto . " MXN ", 3),
                    "col-lg-12 top_10  shadow padding_10 mh_notificaciones");


                $r[] = a_enid($text,
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

                $text_comentario =

                    add_text(
                        d("Alguien han agregado sus comentarios sobre uno de tus artículos en venta ", 1),
                        b_valoracion()
                    );

                $text = d($num . " personas han agregado sus comentarios sobre tus artículos", 1) . b_valoracion();
                $text = ($num > 1) ? $text : $text_comentario;
                $lista = b_notificacion("../recomendacion/?q=" . $id_usuario, "fa fa-star", $text);
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
            $lista = b_notificacion("../area_cliente/?action=compras", "fa fa-bus ", $text);
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

            $pendiente = round($adeudos_cliente, 2);
            $text = 'Saldo por liquidar ' . span($pendiente . 'MXN',
                    [
                        "class" => "saldo_pendiente_notificacion",
                        "deuda_cliente" => $pendiente
                    ]
                );

            $lista = b_notificacion("../area_cliente/?action=compras", "fa fa-credit-card", $text);

            $f++;
        }

        $response = [

            "html" => $lista,
            "flag" => $f,

        ];

        return $response;
    }

    function b_notificacion($url = '', $class_icono = '', $text = '')
    {
        return li(a_enid(text_icon($class_icono, $text),
                [
                    "href" => $url,
                    "class" => "black notificacion_restante top_10"
                ])
        );
    }

    function add_mensajes_respuestas_vendedor($param, $tipo)
    {

        $lista = "";
        $f = 0;

        $num = ($tipo == 1) ? $param["modo_vendedor"] : $param["modo_cliente"];

        if ($num > 0) {

            $text = val_class($tipo, 1, "Alguien quiere saber más sobre tu producto", "Tienes una nueva respuesta en tu buzón");
            $lista = b_notificacion(path_enid("area_cliente_pregunta"), "fa fa-comments", $text);
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

            $text = btw(

                d(text_icon("fa  fa fa-clock-o ", $row["fecha_cordatorio"])),
                d($row["descripcion"]),
                "col-lg-12 top_10  shadow padding_10 mh_notificaciones"
            );


            $r[] = a_enid($text, path_enid("pedidos_recibo", $row["id_recibo"] . "#listado_recordatorios"));
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


                $text = btw(
                    d(
                        img($row["url_img_servicio"])
                        ,
                        "w_50"
                    ),
                    d($row["total"] . "MXN", "text_monto_sin_cierre text-left"),
                    "display_flex_enid top_10 border padding_10"
                );

                $url = path_enid("pedidos_recibo", $row["id_recibo"]);
                $r[] = a_enid($text, $url);
                $f++;
            }

            if (es_data($r)) {

                array_unshift($r, br(2) . d(h("VENTAS EN PROCESO", 5, ["class" => "top_20"])));

            }

        }

        $response = [

            "html" => append($r),
            "flag" => $f,

        ];
        return $response;


    }

    function pendientes_cliente($info)
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
            d($compras_sin_cierre["html"], "top_20")


        ];

        $response["lista_pendientes"] =
            ul($list, "d-flex flex-column justify-content-between text_notificacion");

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
            $pregunta =
                d(((strlen($pregunta) > 50) ? substr($pregunta, 0, 60) : $pregunta), "black");

            $t = [];
            $t[] = ajustar(
                d(img_servicio($id_servicio), "w_50"),
                $pregunta,
                0
            );


            $r[] = a_enid(
                    append($t),
                    "../pregunta/?action=recepcion&id=" . $id_pregunta . "&id_servicio=" . $id_servicio . "#pregunta" . $id_pregunta
                ) .
                hr();
            $f++;
        }


        if (es_data($r)) {
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
            $pregunta = d(((strlen($pregunta) > 50) ? substr($pregunta, 0, 60) : $pregunta), "black");


            $t = [];
            $t[] = ajustar(
                d(img_servicio($id_servicio), "w_50"),
                $pregunta,
                0
            );


            $r[] = a_enid(
                    append($t),
                    "../pregunta/?action=hechas&id=" . $id_pregunta . "&id_servicio=" . $id_servicio . "#pregunta" . $id_pregunta
                ) . hr();
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
        $lista = [];
        $f = 0;

        $ventas_enid_service = $info["ventas_enid_service"];
        $tareas_enid_service = $inf["tareas_enid_service"];
        $num_telefonico = $inf["numero_telefonico"];


        $tareas = add_tareas($info["tareas"]);
        $f = $f + $tareas["flag"];
        $lista[] = $tareas["html"];


        $compras_sin_cierre = add_compras_sin_cierre($info["compras_sin_cierre"]);
        $lista[] = d($compras_sin_cierre["html"], "top_20");
        $f = $f + $compras_sin_cierre["flag"];

        $recibos_sin_costos_operacion = add_recibos_sin_costo($info["recibos_sin_costos_operacion"]);
        $f = $f + $recibos_sin_costos_operacion["flag"];
        $lista[] = $recibos_sin_costos_operacion["html"];


        $recordatorios = add_recordatorios($info["recordatorios"]);
        $lista[] = $recordatorios["html"];
        $f = $f + $recordatorios["flag"];


        $preguntas = add_preguntas_sin_lectura($info["preguntas"]);
        $lista[] = $preguntas["html"];
        $f = $f + $preguntas["flag"];


        $respuestas = add_respuestas_sin_lectura($info["respuestas"]);
        $lista[] = $respuestas["html"];
        $f = $f + $respuestas["flag"];


        $deuda = add_saldo_pendiente($inf["adeudos_cliente"]);
        $f = $f + $deuda["flag"];
        $lista[] = $deuda["html"];

        $deuda = add_pedidos_sin_direccion($inf["adeudos_cliente"]);
        $f = $f + $deuda["flag"];
        $lista[] = $deuda["html"];

        $deuda = add_valoraciones_sin_leer($inf["valoraciones_sin_leer"], $info["id_usuario"]);
        $f = $f + $deuda["flag"];
        $lista[] = $deuda["html"];

        $num_telefonico = add_numero_telefonico($num_telefonico);
        $f = $f + $num_telefonico["flag"];
        $lista[] = $num_telefonico["html"];


        if (is_array($inf) && array_key_exists("objetivos_perfil", $inf)) {
            foreach ($inf["objetivos_perfil"] as $row) {

                switch ($row["nombre_objetivo"]) {
                    case "Ventas":

                        $notificacion = add_envios_a_ventas($row["cantidad"], $ventas_enid_service);
                        $lista[] = $notificacion["html"];
                        $f = $f + $notificacion["flag"];

                        break;


                    case "Desarrollo_web":

                        $notificacion = add_tareas_pendientes($row["cantidad"], $tareas_enid_service);
                        $lista[] = $notificacion["html"];
                        $f = $f + $notificacion["flag"];
                        break;
                    default:
                        break;
                }

            }

        }


        $new_flag = "";
        if ($f > 0) {

            $new_flag = d($f,
                [
                    "id" => $f,
                    "class" => 'notificacion_tareas_pendientes_enid_service'
                ]);

        }


        $response = [
            "num_tareas_pendientes_text" => $f,
            "num_tareas_pendientes" => $new_flag,
            "lista_pendientes" => m_b_notificaciones(1, $f) . append($lista),

        ];

        return $response;

    }

    function get_valor_fecha_solicitudes($solicitudes, $fecha_actual)
    {

        return search_bi_array($solicitudes, "fecha_registro", $fecha_actual, "tareas_solicitadas", 0);
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


            $info_uso .= '
    < tr  ' . $style . ' > ';
            $info_uso .= td($f_registro);
            $info_uso .= $total_registrado;
            $info_uso .= $faq;
            $info_uso .= $formas_pago;
            $info_uso .= td($contacto);
            $info_uso .= $sobre_enid;
            $info_uso .= $afiliados;
            $info_uso .= $nosotros;
            $info_uso .= $procesar_compra;
            $info_uso .= '</tr > ';
            $b++;
            $x++;
        }

        $t = [];
        $t[] = "
<tr style=\"background: #000;color: white;text-align: center!important;\">";
        $t[] = td("Horario");
        $t[] = td("Total");
        $t[] = td("FAQ");
        $t[] = td("Formas de pago");
        $t[] = td("Contacto");
        $t[] = td("Sobre Enid");
        $t[] = td("Afiliados");
        $t[] = td("Home");
        $t[] = td("Procesar compra");
        $t[] = "</tr>";

        $t[] = $info_uso;

        $t[] = "<tr style=\"background: #000;color: white;text-align: center!important;\">";
        $t[] = td("Total");
        $t[] = td($total_visitas);
        $t[] = td($total_faqs);
        $t[] = td($total_formas_pago);
        $t[] = td($total_contacto);
        $t[] = td($total_principal);
        $t[] = td($total_afiliado);
        $t[] = td($total_home);
        $t[] = td($total_procesar_compra);
        $t[] = "</tr>";

        $t = tb(append($t));
        return $t;

    }
}