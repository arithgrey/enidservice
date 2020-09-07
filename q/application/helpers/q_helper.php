<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
        $dias = [
            "",
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
            'Domingo',
        ];

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


            $link_usuarios = tab(
                $row["usuarios"], '#reporte',

                [
                    "class" => 'usuarios',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "title" => 'Personas que se registran en el sistema',
                ]

            );
            $table .= td($link_usuarios);


            $link_servicios_creados = tab(
                $row["servicios_creados"], '#reporte',
                [
                    "class" => 'servicios',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "title" => 'Servicios postulados',
                ]
            );
            $table .= td($link_servicios_creados);

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

            $link_contactos = tab($contacto, '#reporte',
                [
                    "class" => 'contactos',
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_termino" => $fecha_termino,
                    "title" => 'Mensajes enviados por personas a Enid Service',
                ]
            );

            $table .= td($link_contactos);
            $table .= "</tr>";
            $table .= "</table>";
            $accesos .= td($table);


            if (count($row["ventas"]) > 0) {


                $ventas = $row["ventas"][0];
                $num_transacciones = $ventas["total"];
                $compras_efectivas = $ventas["compras_efectivas"];

                $envios = $ventas["envios"];
                $cancelaciones = $ventas["cancelaciones"];

                $table = "<table width='100%' border=1  style='text-align: center;'>";
                $table .= "<tr>";
                $table .= td("Transacciones");
                $table .= td("Ventas");
                $table .= td("Cancelaciones");
                $table .= td("Envíos");
                $table .= "</tr>";
                $table .= "<tr>";
                $table .= td($num_transacciones);


                $link_compras_efectivas = tab(
                    $compras_efectivas, '#reporte',
                    [
                        "class" => 'solicitudes',
                        "fecha_inicio" => $fecha_inicio,
                        "fecha_termino" => $fecha_termino,
                        "tipo_compra" => '9',
                        "title" => 'COMPRAS SATISFACTORIAS',
                    ]
                );
                $table .= td($link_compras_efectivas);


                $link_cancelaciones = tab($cancelaciones, '#reporte',
                    [
                        "class" => 'solicitudes',
                        "fecha_inicio" => $fecha_inicio,
                        "fecha_termino" => $fecha_termino,
                        "tipo_compra" => '10',
                        "title" => 'Solicitudes de compra',
                    ]);
                $table .= td($link_cancelaciones);

                $link_envios = tab(
                    $envios, '#reporte',
                    [

                        "class" => 'solicitudes',
                        "fecha_inicio" => $fecha_inicio,
                        "fecha_termino" => $fecha_termino,
                        "tipo_compra" => 7,
                        "title" => 'Se han enviado',
                    ]
                );
                $table .= td($link_envios);
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
                        "style" => 'color:blue !important;',
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

                $link_valoraciones = tab(
                    $total_val, '#reporte'
                    , [
                        "class" => 'valoraciones',
                        "fecha_inicio" => $fecha_inicio,
                        "fecha_termino" => $fecha_termino,
                        "title" => 'Valoraciones que se han hecho en Enid Service',
                    ]
                );

                $table .= td($link_valoraciones);


                $link_productos_valorados = tab(
                    $productos_valorados, '#reporte',
                    [
                        "class" => 'productos_valorados_distintos',
                        "fecha_inicio" => $fecha_inicio,
                        "fecha_termino" => $fecha_termino,
                        "title" => 'Productos distintos valorados',
                    ]
                );
                $table .= td($link_productos_valorados);

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


                $num_lista_deseos = $row["lista_deseo"][0]["num"];
                $link_lista_deseos = tab(
                    $num_lista_deseos,
                    '#reporte',
                    [
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_termino' => $fecha_termino,
                        'class' => 'lista_deseos lista_deseos_num'
                    ]
                );


                $table = "<table width='100%' border=1  style='text-align: center;'>";
                $table .= "<tr>";
                $table .= td("Agregados a la lista");
                $table .= "</tr>";
                $table .= "<tr>";
                $table .= td($link_lista_deseos);
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

        $b[] = td("USUARIOS NUEVOS",
            ["style" => 'background: #2372e9;color: white !important;text-align: center;']);
        $b[] = $nuevos_usuarios;

        $c[] = td("CONVERSACIONES",
            ["style" => 'background: #006475;color: white !important;text-align: center;']);
        $c[] = $conversaciones;

        $d[] = td("TRANSACCIONES",
            ["style" => 'background: #002763;color: white !important;text-align: center;']);
        $d[] = $transacciones;

        $e[] = td("VALORACIONES", $ext_valoraciones);
        $e[] = $total_valoraciones;

        $f[] = td("VALORACIONES", $ext_valoraciones);
        $f[] = $total_valoraciones;


        $g[] = td("ACCESOS",
            ["style" => 'background: #00b7ff;color: white !important;text-align:center;']);
        $g[] = $accesos;

        $h[] = td("CONTACTO", ["style" => 'text-align: center;']);
        $h[] = $contacto;

        $i[] = td("LABORES RESUELTAS",
            ["style" => 'text-align: center;background: #1c404e;color: white !important;']);
        $i[] = $labores_resueltas;

        $j[] = td("LISTA DE DESEOS",
            ["style" => 'text-align: center;background: #ff0048;color: white !important;']);
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


    function format_encuesta($data)
    {

        $response[] = $data["paginacion"];
        $mientros = $data["miembros"];

        if (es_data($mientros)) {

            foreach ($mientros as $row) {

                $contenido = [];

                $id_usuario = $row["id_usuario"];
                $persona = format_nombre($row);
                $link_usuarios =  path_enid('usuario_contacto', $id_usuario);
                $imagen =
                    img(
                        [
                            "src" => path_enid('imagen_usuario', $id_usuario),
                            "onerror" => "this.src='../img_tema/user/user.png'",
                            'class' => 'mx-auto d-block rounded-circle mah_50'
                        ]
                    );

                $contenido[] = d($imagen);
                $contenido[] = flex(
                    format_fecha($row["fecha_registro"]),
                    _titulo($persona, 4),
                    'flex-column'
                );

                $elemento = d_c($contenido, ['class' => 'col-sm-4 text-md-left text-center']);
                $response[] = a_enid(d($elemento, _text_('d-flex border-bottom mb-5 mt-3 row linea cursor_pointer', _between)),$link_usuarios);

            }

        } else {

            $texto[] = h(_text_(strong('Ups!'), 'no encontramos a este ', strong('usuario')), 1, 'text-center  text-uppercase');
            $texto[] = d('Intenta con otro nombre, email ó teléfono', 'text-center text-danger mt-5 border border-secondary');
            $response[] = d($texto, 'col-md-4 col-md-offset-4 mt-5 bg-light p-5');

        }


        return append($response);

    }

    function format_miembros($data)
    {


        $response[] = $data["paginacion"];
        foreach ($data["miembros"] as $row) {

            $contenido = [];
            $id_usuario = $row["id_usuario"];
            $persona = _text_($row["nombre"], $row["apellido_paterno"], $row["apellido_materno"]);
            $imagen = a_enid(
                img(
                    [
                        "src" => path_enid('imagen_usuario', $id_usuario),
                        "onerror" => "this.src='../img_tema/user/user.png'",
                        'class' => 'mx-auto d-block rounded-circle mah_50'
                    ]
                ), path_enid('usuario_contacto', $id_usuario)
            );

            $contenido[] = d($imagen);
            $contenido[] = flex(
                format_fecha($row["fecha_registro"]),
                _titulo($persona, 4),
                'flex-column'
            );

            if ($data["modo_edicion"] > 0):
                $contenido[] = tab(
                    text_icon('usuario_enid_service fa fa-pencil', '', ["id" => $id_usuario]),
                    '#tab_mas_info_usuario',
                    [
                        "class" => 'ml-auto',
                    ]
                );

            endif;

            $elemento = d_c($contenido, ['class' => 'col-sm-4 text-md-left text-center']);
            $response[] = d($elemento, _text_('d-flex border-bottom mb-5 mt-3 row', _between));

        }

        return append($response);

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
            $valor_solicitudes = get_valor_fecha_solicitudes($info_global["solicitudes"],
                $fecha);
            $totales_solicitudes = $totales_solicitudes + $valor_solicitudes;
            $lista_solicitudes .= td($valor_solicitudes, $style);
            $valor_terminos = tareas_realizadas($info_global["terminos"], $fecha);
            $totales_realizadas = $totales_realizadas + $valor_terminos;
            $lista_terminos .= td($valor_terminos, $style);

        }

        $response[] = d("Atención al cliente/ tareas resueltas",
            ["class" => "blue_enid_background white"], 1);


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
        foreach (get_franja_horaria() as $row) {

            $franja_h = $row;
            $list[] = "<tr>";
            $list[] = td($franja_h);

            $total_tareas = 0;
            $lista2 = "";
            foreach ($lista_fechas as $row) {

                $fecha_actual = $row;
                $tareas_realizadas = valida_tareas_fecha($info_global, $fecha_actual,
                    $franja_h);
                $total_tareas = $total_tareas + $tareas_realizadas;
                $lista2 .= td($tareas_realizadas);
            }
            $list[] = td($total_tareas);
            $list[] = $lista2;
            $list[] = "</tr>";

        }

        $response[] = d("Atención al cliente/ tareas resueltas",
            "blue_enid_background white ", 1);
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

        $response[] = d("Comparativa atención al cliente y tareas resueltas",
            "blue_enid_background white pading_10");
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
                                "onerror" => "../img_tema/user/user.png",
                            ]),
                            d($row["nombre"] . "|" . $row["email"]),
                            d($row["mensaje"] . $row["telefono"] . $row["fecha_registro"]),
                        ]
                    ), "popup-head-left pull-left"),
                "popup-head"), [
                    "class" => "popup-box chat-popup",
                    "id" => "qnimate",
                    "style" => "margin-top: 4px;",
                ]
            );

        }

        return append($r);

    }


    function get_mensaje_modificacion_pwd($nombre)
    {

        $r[] = h(add_text("HOLA, ", strtoupper($nombre)), 3);
        $r[] = d(img([
            "src" => _text("https://enidservices.com/", _web, "/img_tema/enid_service_logo.jpg"),
            "style" => "width: 100%",
        ]));
        $r[] = d("Observamos un cambio de contraseña en tu cuenta. ¿Fuiste tú?");
        $r[] = d(_text("Si es así ignora este correo, en caso contrario notificanos aquí https://enidservices.com/", _web, "/contact/"));

        return append($r);

    }


    function get_mensaje_bienvenida($param)
    {


        $r[] = h("Buen día " . $param["nombre"] . " " . $param["email"]);
        $r[] = d(
            img(
                [
                    "src" => _text("https://enidservices.com/", _web, "/img_tema/enid_service_logo.jpg"),
                    "style" => "width: 100%",
                ]),
            [
                "style" => "width: 30%;margin: 0 auto;",
            ]);

        $r[] = d("TU USUARIO SE HA REGISTRADO!", "f14 strong");
        $r[] = hr();
        $r[] = d("Desde ahora podrás adquirir y vender las mejores promociones a lo largo de México");
        $r[] = br();
        $r[] = a_enid("ACCEDE A TU CUENTA AHORA!",
            [
                "href" => _text("https://enidservices.com/", _web, "/login/"),
                "target" => "_blank",
                "style" => "background: #001936;padding: 10px;color: white;margin-top: 23px;text-decoration: none;",
            ]);

        return append($r);

    }


    function b_valoracion()
    {
        return str_repeat("\n" . label("★", 'estrella') . "\n", 5);
    }


    function tareas_realizadas($realizado, $fecha_actual)
    {

        return $realizado[search_bi_array($realizado, "fecha_termino",
            $fecha_actual)]["tareas_realizadas"];
    }

    function valida_total_menos1($anterior, $nuevo, $extra = '')
    {


        return td(
            $nuevo,
            menorque($anterior, $nuevo,
                'style = "background:#ff1b00!important; color:white!important;" ') . " " .
            $extra);
    }

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

    function get_fechas_global($lista_fechas)
    {

        $dias = [
            "",
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
            'Domingo',
        ];
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

    function get_franja_horaria()
    {

        $response = [];
        for ($a = 23; $a >= 0; $a--) {

            $response[$a] = $a;
        }

        return $response;
    }

    function crea_tareas_pendientes_info($f)
    {

        $new_flag = "";
        if ($f > 0) {

            $new_flag = d($f,
                [
                    "class" => 'notificacion_tareas_pendientes_enid_service strong white ml-1',
                    "id" => $f,
                ]
            );
        }

        return $new_flag;
    }


    function add_direccion_envio($num_direccion)
    {

        $lista = "";
        $f = 0;
        if ($num_direccion < 1) {

            $lista = b_notificacion(
                path_enid("administracion_cuenta"),
                'Registra tu dirección de compra y venta');

            $f++;

        }

        return [

            "html" => $lista,
            "flag" => $f,

        ];


    }


    function add_ventas_semana($ventas)
    {

        $ventas = d($ventas, 'border p-2 border-secondary');
        return a_enid(
            flex("ventas de la semana", $ventas, _between),
            [
                "href" => path_enid("pedidos"),
                "class" => "strong text-uppercase h3 color_azul_fuerte",
            ]
        );


    }

    function add_tareas($tareas)
    {

        $r = [];
        $f = 0;
        foreach ($tareas as $row) {


            $text = d(substr($row["asunto"], 0, 30), "black");
            $text = flex(
                icon("fa fa-check-square black"),
                $text,
                "top_10 mh_notificaciones align-items-center border-bottom justify-content-between",
                "",
                "ml-2  black");
            $r[] = a_enid($text, "../desarrollo/?q=1&ticket=" . $row["id_ticket"]);
            $f++;
        }


        $agregar = d(
            a_enid(
                text_icon("fas fa-plus-circle black", " TAREA"),
                [
                    "href" => path_enid("desarrollo"),
                    "target" => "black",
                    "class" => "black",
                ]), "bottom_50 black strong f14 black");
        $tareas = add_text($agregar, append($r));


        $response =
            [
                "html" => $tareas,
                "flag" => $f,

            ];

        return $response;

    }


    function add_tareas_pendientes($meta, $hecho)
    {

        $lista = "";
        $f = 0;
        if ($meta > $hecho) {

            $text = "Hace falta por resolver " . ($meta - $hecho) . " tareas!";
            $lista = b_notificacion("../desarrollo/?q=1", $text);
            $f++;
        }

        return [
            "html" => $lista,
            "flag" => $f,
        ];

    }


    function add_envios_a_ventas($meta, $hecho)
    {

        $lista = "";
        $f = 0;
        if ($meta > $hecho) {


            $text = "Apresúrate completa tu logro sólo hace falta 
                " . ($meta - $hecho) . " venta para completar tus labores del día!";
            $lista = b_notificacion("../reporte_enid/?q=2", $text);
            $f++;
        }

        $response = [

            "html" => $lista,
            "flag" => $f,

        ];

        return $response;
    }


    function add_accesos_pendientes($meta, $hecho)
    {

        $lista = "";
        $f = 0;
        if ($meta > $hecho) {

            $text = "Otros usuarios ya han compartido sus productos en redes sociales, alcanza a tu
                 competencia sólo te hacen falta 
                 " . ($meta - $hecho) . " 
                 vistas a tus productos";
            $lista = b_notificacion("../tareas/?q=2", $text);
            $f++;
        }

        $response = [

            "html" => $lista,
            "flag" => $f,

        ];

        return $response;

    }


    function add_email_pendientes_por_enviar($meta_email, $email_enviados)
    {

        $lista = "";
        $f = 0;
        if ($meta_email > $email_enviados) {


            $text = 'Te hacen falta enviar ' . ($meta_email - $email_enviados) . ' correos a 
                posibles clientes para cumplir tu 
                meta de prospección';
            $lista = b_notificacion("../tareas/?q=2", $text);
            $f++;
        }

        return [

            "html" => $lista,
            "flag" => $f,

        ];


    }

    function add_numero_telefonico($num)
    {

        $lista = "";
        $f = 0;
        if ($num > 0) {

            $text = "Agrega un número para compras o ventas";
            $lista = b_notificacion(
                path_enid('administracion_cuenta'), $text);

            $f++;
        }

        return [

            "html" => $lista,
            "flag" => $f,

        ];

    }

    function add_recibos_sin_costo($recibos)
    {

        $r = [];
        $f = 0;
        foreach ($recibos as $row) {

            $id_recibo = $row["id_recibo"];
            $saldo_cubierto = $row["saldo_cubierto"];

            $text = flex(
                icon("fa fa-ticket black"),
                money($saldo_cubierto),
                "top_10  justify-content-between  mh_notificaciones border-bottom",
                "",
                "strong black");


            $r[] = a_enid($text,
                [
                    "href" => "../pedidos/?costos_operacion=" . $id_recibo . "&saldado=" . $saldo_cubierto,
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

    function add_usuarios_sin_tags_arquetipos($recibos)
    {

        $r = [];
        $f = 0;
        foreach ($recibos as $row) {

            $id_recibo = $row["id_recibo"];
            $saldo_cubierto = $row["saldo_cubierto"];


            $text = flex(
                icon("fa-inbox"),
                "SIN CARACTERÍSTICAS DEL CLIENTE",
                "top_10 justify-content-between  mh_notificaciones border-bottom",
                "",
                "strong black");


            $r[] = a_enid($text,
                [
                    "href" => path_enid('pedidos_recibo', $id_recibo),
                ]
            );

            $f++;
        }

        return
            [
                "html" => append($r),
                "flag" => $f,

            ];


    }

    function add_valoraciones_sin_leer($num, $id_usuario)
    {
        $lista = "";
        $f = 0;
        if ($num > 0) {

            $text_comentario =

                add_text(
                    d("Alguien han agregado sus comentarios sobre uno de tus artículos en venta ",
                        1),
                    b_valoracion()
                );
            $text = add_text($num, " preguntas sobre tus artículos");
            $text = ($num > 1) ? $text : $text_comentario;
            $lista = b_notificacion(
                "../recomendacion/?q=" . $id_usuario, $text);
            $f++;
        }

        $response = [

            "html" => $lista,
            "flag" => $f,

        ];

        return $response;
    }


    function add_pedidos_sin_direccion($param)
    {

        $sin_direcciones = $param["sin_direcciones"];
        $lista = "";
        $f = 0;
        if ($sin_direcciones > 0) {

            $lista = b_notificacion(
                path_enid('area_cliente'), "Registra tu dirección de envio");
            $f++;

        }

        return [

            "html" => $lista,
            "flag" => $f,

        ];

    }


    function add_saldo_pendiente($param)
    {

        $adeudos_cliente = $param["total_deuda"];
        $lista = "";
        $f = 0;
        if ($adeudos_cliente > 0) {

            $pendiente = round($adeudos_cliente, 2);

            $text = ajustar(
                d('Saldo por liquidar', 'black '),
                d(
                    money($pendiente),
                    [
                        "class" => "strong f15 black",
                        "deuda_cliente" => $pendiente,
                    ]
                )
            );

            $lista = b_notificacion(
                "../area_cliente/?action=compras", $text);

            $f++;
        }

        $response = [

            "html" => $lista,
            "flag" => $f,

        ];

        return $response;
    }

    function b_notificacion($url = '', $text = '')
    {
        return a_enid(

            $text
            ,
            [
                "href" => $url,
                "class" => "mb-4 black border-bottom pt-2 pb-2",
            ]
        );
    }

    function add_mensajes_respuestas_vendedor($param, $tipo)
    {

        $lista = "";
        $f = 0;

        $num = ($tipo == 1) ? $param["modo_vendedor"] : $param["modo_cliente"];

        if ($num > 0) {

            $text = val_class($tipo, 1, "Alguien quiere saber más sobre tu producto",
                "Tienes una nueva respuesta en tu buzón");
            $lista = b_notificacion(path_enid("area_cliente_pregunta"), $text);
            $f++;

        }

        return [

            "html" => $lista,
            "flag" => $f,
        ];

    }

    function add_recordatorios($recordatorios)
    {


        $r = [];
        $f = 0;
        foreach ($recordatorios as $row) {

            $text = btw(
                d(text_icon("fa  fa fa-clock-o strong", $row["fecha_cordatorio"])),
                d($row["descripcion"]),
                "top_10  mh_notificaciones border-bottom black 
                    align-items-center"
            );
            $r[] = a_enid($text, path_enid(
                "pedidos_recibo", $row["id_recibo"] . "#listado_recordatorios"));
            $f++;
        }

        return [

            "html" => append($r),
            "flag" => $f,
        ];

    }

    function add_reintentos_compras($recibos)
    {
        $r = [];
        $f = 0;
        if (es_data($recibos)) {

            foreach ($recibos as $row) {


                $text = d('Podrías vender nuevamente a este cliente!', 'black strong text-right');
                $url = path_enid("pedidos_recibo", $row["id_recibo"]);
                $r[] = d(a_enid($text, $url), "border-bottom");
                $f++;
            }

            if (es_data($r)) {

                array_unshift($r, d(_titulo("intentos de reventa")));
            }

        }

        return [

            "html" => append($r),
            "flag" => $f,

        ];

    }

    function add_recuperacion($recibos)
    {
        $r = [];
        $f = 0;
        if (es_data($recibos)) {

            foreach ($recibos as $row) {


                $text = d('Podrías recuperar la venta de este pedido', 'black strong text-right');
                $url = path_enid("pedidos_recibo", $row["id_recibo"]);
                $r[] = d(a_enid($text, $url), "border-bottom");
                $f++;
            }

            if (es_data($r)) {

                array_unshift($r, d(_titulo("RECUPERACIÓN!")));
            }

        }

        return [

            "html" => append($r),
            "flag" => $f,

        ];

    }


    function add_compras_sin_cierre($data, $recibos, $es_reparto = 0)
    {
        $r = [];
        $f = 0;
        $ventas_posteriores = [];
        $ventas_hoy = [];
        if (es_data($recibos)) {

            sksort($recibos, "fecha_contra_entrega", true);
            foreach ($recibos as $row) {

                $fecha_contra_entrega = $row['fecha_contra_entrega'];
                $fecha_entrega = date_create($fecha_contra_entrega)->format('Y-m-d');
                $fecha = horario_enid();

                $hoy = $fecha->format('Y-m-d');
                $es_mayor = ($fecha_entrega > $hoy);


                $dias = date_difference($hoy, $fecha_entrega);

                $es_menor = ($dias > 0 && !$es_mayor);

                $text_entrega = _text_('Se entregará en ', $dias, 'días!');
                $text_entrega_paso = _text_('La fecha de entrega fué hace ', $dias, 'días!');
                $text_entrega = (!$es_mayor) ? $text_entrega_paso : $text_entrega;
                $id_recibo = $row['id_recibo'];

                $ubicacion = $row['ubicacion'];
                if ($dias == 1 && $es_mayor) {
                    $text_entrega = 'Se entregará mañana';
                } elseif ($dias == 1 && !$es_mayor) {
                    $text_entrega = 'La entrega fué ayer';
                } elseif ($ubicacion > 0) {
                    $text_entrega = '';
                }


                $tipo_entrega = $row['tipo_entrega'];
                $es_contra_entrega = $row['es_contra_entrega'];
                $es_contra_entrega_domicilio_sin_direccion = false;
                $format_hora = 0;
                if ($es_contra_entrega) {
                    $es_contra_entrega_domicilio_sin_direccion = $row['es_contra_entrega_domicilio_sin_direccion'];
                    $format_hora = 1;
                    if ($es_contra_entrega_domicilio_sin_direccion) {
                        $format_hora = 0;
                    }
                    if ($ubicacion > 0) {
                        $format_hora = 1;
                    }
                }

                $es_formato_hora = (($tipo_entrega == 1) || ($tipo_entrega == 2 && $format_hora));
                $hora_entrega = ($es_formato_hora) ? format_hora($fecha_contra_entrega) : '';
                $notificacion_hoy = ($hoy === $fecha_entrega) ? 'Se entregá hoy! ' : $text_entrega;

                $es_hoy = ($hoy === $fecha_entrega) ? 'bg-dark white' : '';
                $dia_entrega = d(_text_($notificacion_hoy, $hora_entrega), _text_('badge', $es_hoy));

                $imagenes = d(img($row["url_img_servicio"]), "w_50");
                $totales_recibo = money($row["total"]);
                $total = d($totales_recibo, "text-left black");
                $id_usuario_entrega = $row['id_usuario_entrega'];


                $usuario_entrega  = $row['usuario_entrega'];
                $ubicacion = $row['ubicacion'];
                $text_total = ayuda_notificacion(
                    $usuario_entrega,
                    $total,
                    $dia_entrega,
                    $es_contra_entrega,
                    $es_contra_entrega_domicilio_sin_direccion,
                    $id_usuario_entrega,
                    $ubicacion,
                    $text_entrega
                );

                $total_seccion = d($text_total, 'd-flex flex-column');

                $orden = _text('ORDEN #', $id_recibo);
                $es_vendedor = es_vendedor($data);
                $nombre_vendedor = (!$es_vendedor) ? $row['nombre_vendedor'] : '';
                $identificador = flex($orden, $nombre_vendedor, 'flex-column');
                $seccion_imagenes = flex($imagenes, $identificador, 'flex-column black fp9', '', 'font-weight-bolder');

                $text = flex($seccion_imagenes, $total_seccion, _between);

                $desglose_pedido = path_enid("pedidos_recibo", $row["id_recibo"]);
                $tracker = path_enid("pedido_seguimiento", $row["id_recibo"]);
                $url = ($es_reparto > 0) ? $tracker : $desglose_pedido;

                $extra_class = ($es_hoy || $es_menor) ? '' : 'venta_futura d-none';
                $linea = d(a_enid($text, $url), _text_("border-bottom", $extra_class));
                if ($es_hoy || $es_menor) {

                    $ventas_hoy[] = $linea;

                } else {

                    $ventas_posteriores[] = $linea;
                }

                $f++;
            }

            if (es_data($recibos)) {

                $titulo = es_repartidor($data) ? 'Próximas entregas' : 'ventas en proceso';
                $r[] = d(_titulo($titulo));
                $r[] = append($ventas_hoy);
                $r[] = append($ventas_posteriores);
                $r[] = d(icon(_text_(_mas_opciones_bajo_icon, 'fa-2x mt-3 mas_ventas_notificacion')), 'text-center ');
                $r[] = d(icon(_text_(_mas_opciones_icon, 'fa-2x mt-3 menos_ventas_notificacion d-none')), 'text-center ');
            }

        }


        return [
            "html" => append($r),
            "flag" => $f,
        ];

    }

    function ayuda_notificacion($usuario_entrega, $total, $dia_entrega, $es_contra_entrega, $es_contra_entrega_domicilio_sin_direccion,
                                $id_usuario_entrega, $ubicacion, $text_entrega)
    {
        $text_total = [];
        $icon = '';
        if ($id_usuario_entrega > 0) {

            $icono = d(icon(_entregas_icon));
            $nombre_repatidor = format_nombre($usuario_entrega);
            $icon =  flex($icono, $nombre_repatidor,'flex-column justify-content-center', 'ml-auto');


        }

        $text_total[] = flex($total, $icon, _between);
        $text_total[] = $dia_entrega;
        if ($es_contra_entrega) {

            $text_total[] = ($ubicacion < 1) ? 'Es contra entrega a domicilio' : $text_entrega;

            if ($es_contra_entrega_domicilio_sin_direccion && $ubicacion < 1) {
                $text_total[] = d('Falta la direccion y hora de entrega', 'text-danger strong');
            }
        }


        return $text_total;


    }

    function pendientes_cliente($info)
    {

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


        $response["num_tareas_pendientes_text"] = $f;
        $response["num_tareas_pendientes"] = crea_tareas_pendientes_info($f);
        $menu_ventas_semana = menu_ventas_semana($info);
        $list = [
            $deuda["html"],
            $direccion["html"],
            $preguntas["html"],
            $respuestas["html"],
            d($compras_sin_cierre["html"], "mt-5"),
            $menu_ventas_semana
        ];

        $response["lista_pendientes"] =
            d($list, "d-flex flex-column justify-content-between text_notificacion");

        return $response;

    }

    function menu_ventas_semana($data)
    {


        $id_perfil = $data['id_perfil'];
        $es_reparto = (in_array($id_perfil, [6, 3, 1]));

        $response = [];
        if ($es_reparto) {

            $link = format_link('Próximas entregas', ['href' => path_enid('entregas')]);
            $response[] = d($link, 'mt-5');

        }


        return append($response);
    }

    function add_preguntas_sin_lectura($preguntas, $es_vendedor = 0)
    {
        $r = [];
        $f = 0;
        if (es_data($preguntas)) {


            foreach ($preguntas as $row) {

                $id_pregunta = $row["id_pregunta"];
                $pregunta = $row["pregunta"];
                $id_servicio = $row["id_servicio"];
                $pregunta = d(((strlen($pregunta) > 50) ? substr($pregunta, 0,
                    60) : $pregunta),
                    "black");

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


        }
        return [
            "html" => append($r),
            "flag" => $f,
        ];

    }

    function add_respuestas_sin_lectura($respuestas)
    {

        $r = [];
        $f = 0;
        if (es_data($respuestas)) {
            foreach ($respuestas as $row) {
                $id_pregunta = $row["id_pregunta"];
                $pregunta = $row["pregunta"];
                $id_servicio = $row["id_servicio"];
                $pregunta = d(((strlen($pregunta) > 50) ? substr($pregunta, 0,
                    60) : $pregunta), "black");


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

        }


        return [
            "html" => append($r),
            "flag" => $f,

        ];

    }

    function tareas_administrador($info)
    {


        $inf = $info["info_notificaciones"];
        $lista = [];
        $f = 0;
        $ventas_semana = $info["ventas_semana"];
        $num_telefonico = $inf["numero_telefonico"];

        $lista[] = add_ventas_semana($ventas_semana);
        $tareas = add_tareas($info["tareas"]);
        $f = $f + $tareas["flag"];
        $lista[] = $tareas["html"];


        $compras_sin_cierre = add_compras_sin_cierre($info, $info["compras_sin_cierre"]);
        $lista[] = d($compras_sin_cierre["html"], "mt-5");
        $f = $f + $compras_sin_cierre["flag"];


        $reintentos_compras = add_reintentos_compras($info["reintentos_compras"]);
        $lista[] = d($reintentos_compras["html"], "mt-5");
        $f = $f + $reintentos_compras["flag"];

        $recuperacion = add_recuperacion($info["recuperacion"]);
        $lista[] = d($recuperacion["html"], "mt-5");
        $f = $f + $recuperacion["flag"];

        $recibos_sin_costos_operacion = add_recibos_sin_costo($info["recibos_sin_costos_operacion"]);
        $f = $f + $recibos_sin_costos_operacion["flag"];
        $lista[] = $recibos_sin_costos_operacion["html"];

        $usuarios_sin_tag_arquetipos = add_usuarios_sin_tags_arquetipos($info["clientes_sin_tags_arquetipos"]);
        $f = $f + $usuarios_sin_tag_arquetipos["flag"];
        $lista[] = $usuarios_sin_tag_arquetipos["html"];

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

        $deuda = add_valoraciones_sin_leer($inf["valoraciones_sin_leer"],
            $info["id_usuario"]);
        $f = $f + $deuda["flag"];
        $lista[] = $deuda["html"];


        $new_flag = "";
        if ($f > 0) {

            $new_flag = d($f,
                [
                    "id" => $f,
                    "class" => 'notificacion_tareas_pendientes_enid_service strong white ml-1',
                ]);

        }

        $lista[] = menu_ventas_semana($info);

        return [
            "num_tareas_pendientes_text" => $f,
            "num_tareas_pendientes" => $new_flag,
            "lista_pendientes" => append($lista),
        ];

    }

    function get_valor_fecha_solicitudes($solicitudes, $fecha_actual)
    {

        return search_bi_array($solicitudes, "fecha_registro", $fecha_actual,
            "tareas_solicitadas", 0);
    }


    function pendientes_reparto($data)
    {

        $f = 0;
        $recibos = $data['proximos_pedidos'];
        $proximas_entregas = add_compras_sin_cierre($data, $recibos, 1);
        $f = $f + $proximas_entregas["flag"];
        $lista[] = d($proximas_entregas["html"], "mt-5");
        $tareas_pendiente = "";
        if ($f > 0) {

            $tareas_pendiente = d(
                $f,
                [
                    "id" => $f,
                    "class" => 'notificacion_tareas_pendientes_enid_service strong white ml-1',
                ]
            );

        }


        return [
            "num_tareas_pendientes_text" => $f,
            "num_tareas_pendientes" => $tareas_pendiente,
            "lista_pendientes" => append($lista),
        ];


    }

    function format_reporte_ventas_comisionadas($estadisticas)
    {


        $response = [];
        $contenido = [];
        $base = 'col-md-2 border strong text-center';
        $contenido[] = d("#", 'col-md-1');
        $contenido[] = d("Vendedor", 'col-md-2 strong text-center');
        $contenido[] = d("Ventas en el tiempo", 'col-md-1 strong text-center');
        $contenido[] = d("Dias desde la última venta", 'col-md-1 strong text-center');
        $contenido[] = d("Operaciones", $base);
        $contenido[] = d("Ventas efectivas", $base);
        $contenido[] = d("En proceso", $base);
        $contenido[] = d("Ventas caidas", 'col-md-1 border text-center');

        $response[] = d($contenido, 'row border');

        $total_operaciones = 0;
        $total_ventas = 0;
        $total_proceso = 0;
        $total_canceladas = 0;

        $ids_usuarios_actividad = [];
        $ids_usuarios_actividad_venta = [];

        $a = 1;
        foreach ($estadisticas as $row) {

            $idusuario = $row['idusuario'];
            $ids_usuarios[] = $idusuario;
            $id_usuario_referencia = $row['id_usuario_referencia'];
            if ($id_usuario_referencia > 0) {
                $ids_usuarios_actividad[] = $id_usuario_referencia;
                if ($row['efectivas'] > 0) {
                    $ids_usuarios_actividad_venta[] = $id_usuario_referencia;
                }
            }

            $actividad = ($id_usuario_referencia > 0);
            $total = ($actividad) ? $row['total'] : 0;
            $total_operaciones = ($total_operaciones + $total);

            $efectivas = ($actividad) ? $row['efectivas'] : 0;
            $total_ventas = ($total_ventas + $efectivas);

            $en_proceso = ($row['id_usuario_agenda'] > 0) ? $row['proximas'] : 0;
            $total_proceso = ($total_proceso + $en_proceso);

            $canceladas = ($actividad) ? $row['canceladas'] : 0;
            $total_canceladas = ($total_canceladas + $canceladas);

            $link = path_enid('usuario_contacto', $idusuario);
            $nombre_completo = a_enid(format_nombre($row), ['href' => $link]);
            $ha_vendido = $row['ha_vendido'];
            $fecha_ultima_venta = $row['fecha_ultima_venta'];

            $fecha = horario_enid();
            $hoy = $fecha->format('Y-m-d');
            $dias = date_difference($hoy, $fecha_ultima_venta);

            $extra_ventas_dias = ($dias > 3 || !$ha_vendido) ? 'bg-danger white' : 'bg-primary white ';

            $extra_ventas_en_tiempo = ($ha_vendido > 0) ? 'bg-primary' : 'bg-danger white';
            $contenido = [];
            $base = 'col-md-2 border text-center';
            $extra = ($efectivas < 1) ? 'bg-danger white' : '';
            $contenido[] = d($idusuario, 'col-md-1');
            $contenido[] = d($nombre_completo, 'col-md-2 text-uppercase');
            $contenido[] = d($ha_vendido, _text_('col-md-1 border text-center', $extra_ventas_en_tiempo));
            $contenido[] = d($dias, _text_('col-md-1 border text-center', $extra_ventas_dias));
            $contenido[] = d($total, $base);
            $contenido[] = d($efectivas, _text_($base, $extra));
            $contenido[] = d($en_proceso, $base);
            $contenido[] = d($canceladas, 'col-md-1 border text-center');

            $response[] = d($contenido, 'row border');
            $a++;
        }


        $contenido = [];
        $base = 'col-md-2 border text-center';

        $contenido[] = d(_titulo('Totales', 2), 'col-md-5');
        $contenido[] = d($total_operaciones, $base);
        $contenido[] = d($total_ventas, $base);
        $contenido[] = d($total_proceso, $base);
        $contenido[] = d($total_canceladas, "col-md-1 border text-center");
        $totales = d($contenido, 'row');


        /*usuarios activos*/
        $usuarios_activos = [];
        $base = 'col-md-2 border text-center';

        $total_vendedores = ($a - 1);
        $usuarios_activos[] = d(_d('VENDEDORES', $total_vendedores), $base);
        $total_vendedores_activos = count(array_unique($ids_usuarios_actividad));
        $usuarios_activos[] = d(_d('ACTIVOS', $total_vendedores_activos), 'col-md-2 border text-center bg-primary white');

        $total_vendedores_activos_ventas = count(array_unique($ids_usuarios_actividad_venta));
        $usuarios_activos[] = d(_d('LOGRARON VENTAS', $total_vendedores_activos_ventas), 'bg-light col-md-2 border text-center');
        $sin_ventas = ($total_vendedores_activos - $total_vendedores_activos_ventas);
        $usuarios_activos[] = d(_d('ACTIVOS SIN VENTAS', $sin_ventas), 'col-md-3 border text-center');


        $bajas = ($total_vendedores - $total_vendedores_activos);
        $usuarios_activos[] = d(_d('SIN ACTIVIDAD', $bajas), 'col-md-3 border text-center bg-danger white');


        $totales_usuarios_activos = d($usuarios_activos, 'row');


        $data[] = d($totales_usuarios_activos, 'mt-5 col-md-12');
        $data[] = d($totales, 'mt-5 col-md-12');
        $data[] = d($response, 'mt-5 col-md-12');
        return append($data);

    }

    function format_reporte_ventas_reparto($data_complete)
    {

        $estadisticas = $data_complete["totales"];
        $sin_asignacion = $data_complete['sin_asignacion'];
        $totales_proximas_agendas = pr($sin_asignacion, 'proximas');

        $contenido = [];
        $base = 'col-md-2 border strong text-center';
        $contenido[] = d("#", 'col-md-1');
        $contenido[] = d("Vendedor", 'col-md-3');
        $contenido[] = d("Operaciones", $base);
        $contenido[] = d("Ventas efectivas", $base);
        $contenido[] = d("En proceso", $base);
        $contenido[] = d("Ventas caidas", $base);

        $response[] = d($contenido, 'row border');

        $total_operaciones = 0;
        $total_ventas = 0;
        $total_proceso = 0;
        $total_canceladas = 0;

        $ids_usuarios_actividad = [];
        $ids_usuarios_actividad_venta = [];
        $a = 1;
        foreach ($estadisticas as $row) {

            $idusuario = $row['idusuario'];
            $ids_usuarios[] = $idusuario;
            $id_usuario_entrega = $row['id_usuario_entrega'];
            $id_repartidor = $row['id_repartidor'];


            if ($id_usuario_entrega > 0) {
                $ids_usuarios_actividad[] = $id_usuario_entrega;
                if ($row['efectivas'] > 0) {
                    $ids_usuarios_actividad_venta[] = $id_usuario_entrega;
                }
            }

            $actividad = ($id_usuario_entrega > 0);
            $total = ($actividad) ? $row['total'] : 0;
            $total_operaciones = ($total_operaciones + $total);

            $efectivas = ($actividad) ? $row['efectivas'] : 0;
            $total_ventas = ($total_ventas + $efectivas);

            $en_proceso = ($id_repartidor > 0) ? $row['proximas'] : 0;
            $total_proceso = ($total_proceso + $en_proceso);

            $canceladas = ($actividad) ? $row['lista_negra'] : 0;
            $total_canceladas = ($total_canceladas + $canceladas);


            $email = $row['email'];
            $link = path_enid('busqueda_usuario', $email);
            $nombre_completo = a_enid(format_nombre($row), $link);

            $contenido = [];
            $base = 'col-md-2 border text-center';
            $extra = ($efectivas < 1) ? 'bg-danger white' : '';
            $contenido[] = d($idusuario, 'col-md-1');
            $contenido[] = d($nombre_completo, 'col-md-3 text-uppercase');
            $contenido[] = d($total, $base);
            $contenido[] = d($efectivas, _text_($base, $extra));
            $contenido[] = d($en_proceso, $base);
            $contenido[] = d($canceladas, $base);

            $response[] = d($contenido, 'row border');
            $a++;
        }


        $contenido = [];
        $base = 'col-md-2 border text-center';

        $contenido[] = d(_titulo('Totales', 2), 'col-md-4');
        $contenido[] = d($total_operaciones, $base);
        $contenido[] = d($total_ventas, $base);
        $contenido[] = d($total_proceso, $base);
        $contenido[] = d($total_canceladas, $base);
        $totales = d($contenido, 'row');


        /*usuarios activos*/
        $usuarios_activos = [];
        $base = 'col-md-2 border text-center';


        $usuarios_activos[] = d(_d('PRÓXIMAS ENTREGAS SIN REPARTIDOR ASIGNADO', $totales_proximas_agendas),
            'col-md-3 border text-center');


        $total_vendedores = ($a - 1);
        $usuarios_activos[] = d(_d('REPARTIDORES', $total_vendedores), $base);
        $total_vendedores_activos = count(array_unique($ids_usuarios_actividad));
        $usuarios_activos[] = d(_d('ACTIVOS', $total_vendedores_activos), 'col-md-2 border text-center bg-primary white');

        $total_vendedores_activos_ventas = count(array_unique($ids_usuarios_actividad_venta));
        $usuarios_activos[] = d(_d('LOGRARON ENTREGAS', $total_vendedores_activos_ventas), 'bg-light col-md-2 border text-center');
        $sin_ventas = ($total_vendedores_activos - $total_vendedores_activos_ventas);
        $usuarios_activos[] = d(_d('ACTIVOS SIN ENREGAS', $sin_ventas), 'col-md-3 border text-center');


        $bajas = ($total_vendedores - $total_vendedores_activos);
        $usuarios_activos[] = d(_d('SIN ACTIVIDAD', $bajas), 'col-md-3 border text-center bg-danger white');


        $totales_usuarios_activos = d($usuarios_activos, 'row');


        $data[] = d($totales_usuarios_activos, 'mt-5 col-md-12');
        $data[] = d($totales, 'mt-5 col-md-12');
        $data[] = d($response, 'mt-5 col-md-12');
        return append($data);

    }

    function tareas_vendedor($data)
    {


        $lista = [];
        $f = 0;
        $compras_sin_cierre = add_compras_sin_cierre($data, $data["compras_sin_cierre"]);
        $lista[] = d($compras_sin_cierre["html"], "mt-5");
        $f = $f + $compras_sin_cierre["flag"];

        $reintentos_compras = add_reintentos_compras($data["reintentos_compras"]);
        $lista[] = d($reintentos_compras["html"], "mt-5");
        $f = $f + $reintentos_compras["flag"];

        $recuperacion = add_recuperacion($data["recuperacion"]);
        $lista[] = d($recuperacion["html"], "mt-5");
        $f = $f + $recuperacion["flag"];

        $recordatorios = add_recordatorios($data["recordatorios"]);
        $lista[] = $recordatorios["html"];
        $f = $f + $recordatorios["flag"];

        $new_flag = "";
        if ($f > 0) {

            $new_flag = d($f,
                [
                    "id" => $f,
                    "class" => 'notificacion_tareas_pendientes_enid_service strong white ml-1',
                ]);

        }

//        $lista[] = menu_ventas_semana($data);

        return [
            "num_tareas_pendientes_text" => $f,
            "num_tareas_pendientes" => $new_flag,
            "lista_pendientes" => append($lista),
        ];

    }
}
