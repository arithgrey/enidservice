<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('validate_text_title')) {
        function validate_text_title($in_session, $is_mobile)
        {
            $text = ($in_session == 0 && $is_mobile == 0) ? heading_enid("QUIEN ERES", 2) : "";
            return $text;
        }

    }

    if (!function_exists('get_format_form_primer_registro')) {


        function get_format_form_primer_registro($in_session, $is_mobile, $info_ext)
        {


            $r = [];
            if ($in_session < 1) {

            	$x[] = get_btw(
                    div("Nombre *")
                    ,
                    div(input([
                        "name" => "nombre",
                        "placeholder" => "Nombre",
                        "class" => " input-sm  nombre",
                        "type" => "text",
                        "required" => "true"
                    ]))
                    ,
                    " col-lg-6"
                );

                $x[] = div(append_data([

                    div("Correo Electrónico  *")
                    ,
                    div(input([
                        "name" => "email",
                        "placeholder" => "email",
                        "class" => " input-sm  email",
                        "type" => "email",
                        "required" => "true",
                        "onkeypress" => "minusculas(this);"
                    ]))
                    ,
                    place('place_correo_incorrecto')

                ]), ["class" => " col-lg-6"]);




				$r[] = div(append_data($x)  , ["class" => "row"]);

                $r[] = div(icon('fa fa-unlock-alt') . "Escribe una contraseña");
                $r[] = input([
                    "id" => "password",
                    "class" => " input-sm password",
                    "type" => "password",
                    "required" => "true"
                ]);
                $r[] = place("place_password_afiliado");
                $r[] = div(icon('fa fa-phone') . "Teléfono *");
                $r[] = input([
                    "id" => "telefono",
                    "class" => "telefono form-control",
                    "type" => "tel",
                    "pattern" => "^[0-9-+s()]*$",
                    "maxlength" => 13,
                    "minlength" => 8,
                    "name" => "telefono",
                    "required" => "true"
                ]);
                $r[] = place("place_telefono");
                $r[] = guardar("CREA UNA CUENTA");
                $r[] = div(anchor_enid("TU USUARIO YA SE ENCUENTRA REGISTRADO",
                    [
                        'class' => "white",
                        "href" => "../login"

                    ]),
                    [
                        'class' => "usuario_existente black_enid_background padding_1 white top_20 enid_hide"
                    ],
                    1);

                $r[] = get_text_acceder_cuenta($is_mobile, $info_ext);
                $r[] = "</div >";
                $r[] = "</div >";
                $r[] = place("place_config_usuario");
                $r[] = form_close();
            }


            return append_data($r);


        }
    }
    if (!function_exists('get_format_resumen')) {

        function get_format_resumen($resumen_producto, $text_envio, $resumen_servicio_info, $monto_total, $costo_envio_cliente, $monto_total_con_envio, $in_session)
        {
            $r[] = heading_enid(
                'RESUMEN DE TU PEDIDO' . icon("fa fa-shopping-bag")
                ,
                2,
                ['class' => 'strong']
            );
            $r[] = div($resumen_producto, 1);
            $r[] = div($text_envio, 1);
            $r[] = input_hidden([
                "name" => "resumen_producto",
                "class" => "resumen_producto",
                "value" => $resumen_servicio_info
            ]);

            $x[] = heading_enid("MONTO $" . $monto_total . "MXN", 4);
            $x[] = heading_enid("CARGOS DE ENVÍO $" . $costo_envio_cliente . "MXN", 4);
            $x[] = heading_enid("TOTAL $" . $monto_total_con_envio . "MXN", 3);
            $x[] = div("Precios expresados en Pesos Mexicanos.", ["class" => "bottom_10"]);


            $r[] = div(append_data($x), ["class" => "text-right"]);


            if ($in_session == 1):
                $r[] = guardar("ORDENAR COMPRA", ['class' => 'btn_procesar_pedido_cliente'], 1, 1);
                $r[] = place('place_proceso_compra');

            endif;
            $r[] = hr();

            return append_data($x);
        }

    }
    if (!function_exists('get_form_miembro_enid_service_hidden')) {

        function get_form_miembro_enid_service_hidden($q2, $plan, $num_ciclos, $ciclo_facturacion, $talla)
        {


            return append_data([

                input_hidden([
                    "name" => "descripcion",
                    "value" => ""
                ]),
                input_hidden([
                    "name" => "usuario_referencia",
                    "value" => $q2,
                    "class" => 'q2'
                ]),
                input_hidden([
                    "name" => "plan",
                    "class" => "plan",
                    "value" => $plan
                ]),
                input_hidden([
                    "name" => "num_ciclos",
                    "class" => "num_ciclos",
                    "value" => $num_ciclos
                ]),
                input_hidden([
                    "name" => "ciclo_facturacion",
                    "class" => "ciclo_facturacion",
                    "value" => $ciclo_facturacion
                ]),
                input_hidden([
                    "name" => "talla",
                    "class" => "talla",
                    "value" => $talla
                ])

            ]);


        }
    }
    if (!function_exists('get_text_duracion')) {
        function get_text_duracion($id_ciclo_facturacion, $num_ciclos, $is_servicio)
        {

            $text = "";
            switch ($id_ciclo_facturacion) {
                case 1:

                    $periodo = ($num_ciclos > 1) ? "Años" : "Año";
                    $text = $num_ciclos . $periodo;
                    break;

                case 2:

                    $periodo = ($num_ciclos > 1) ? "Meses" : "Mes";
                    $text = $num_ciclos . $periodo;

                    break;

                case 5:
                    $text = $num_ciclos . " ";
                    if ($num_ciclos > 1) {
                        $text = $num_ciclos . "  ";
                    }
                    break;

                default:
                    break;
            }

            return $text;

        }

    }
    if (!function_exists('create_resumen_servicio')) {
        function create_resumen_servicio($servicio, $info_solicitud_extra)
        {


            $resumen_servicio = "";
            $duracion = $info_solicitud_extra["num_ciclos"];
            $info_servicio = "";
            $id_ciclo_facturacion = "";
            $precio = 0;

            foreach ($servicio as $row) {

                $nombre_servicio = $row["nombre_servicio"];
                $info_servicio = $nombre_servicio;
                $resumen_servicio = $nombre_servicio;
                $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
                $precio = $row["precio"];
            }

            $is_servicio = 0;
            $text_label = "PIEZAS";
            if ($info_solicitud_extra["is_servicio"] == 1) {
                $text_label = "DURACIÓN";
                $is_servicio = 1;
            }
            $text_ciclos_contratados = get_text_duracion($id_ciclo_facturacion, $duracion, $is_servicio);
            $base = 'col-lg-4 tex-center';
            $resumen_completo = div(div("PRODUCTO") . $resumen_servicio, ["class" => $base]);
            $resumen_completo .= div($text_label . " " . $text_ciclos_contratados, ['class' => $base]);
            $resumen_completo .= div(div("PRECIO") . $precio, ['class' => 'col-lg-4']);
            $response["resumen_producto"] = $resumen_completo;
            $response["monto_total"] = $precio;
            $response["resumen_servicio_info"] = $info_servicio;
            return $response;
        }
    }
    if (!function_exists('get_text_acceder_cuenta')) {
        function get_text_acceder_cuenta($is_mobile, $param)
        {

            $plan = $param["plan"];
            $num_ciclos = $param["num_ciclos"];
            $ciclo_facturacion = $param["ciclo_facturacion"];
            $is_servicio = $param["is_servicio"];
            $q2 = $param["q2"];


            $extra =
                [
                    "plan" => $plan,
                    "extension_dominio" => "",
                    "ciclo_facturacion" => $ciclo_facturacion,
                    "is_servicio" => $is_servicio,
                    "q2" => $q2,
                    "num_ciclos" => $num_ciclos,
                    "class" => "link_acceso cursor_pointer"
                ];


            $text = heading_enid('¿Ya tienes una cuenta? ', 3);
            $text .= div("ACCEDE AHORA!", $extra, 1);
            return div($text, ["class" => "informacion_extra"]);

        }
    }


}