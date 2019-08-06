<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_pm($data)
    {

        $primer_registro = $data["primer_registro"];
        $servicio = $data["servicio"];
        $in_session = $data["in_session"];
        $num_ciclos = $data["num_ciclos"];
        $carro_compras = $data["carro_compras"];
        $id_carro_compras = $data["id_carro_compras"];
        $punto_encuentro = $data["punto_encuentro"];


        $r[] = h("IDENTIFICA TU PUNTO MÁS CERCANO", 3, " titulo_punto_encuentro letter-spacing-10  text-justify  border-bottom padding_10");
        $r[] = d(d($data["leneas_metro"], ["class" => "place_lineas col-lg-12"]), 13);
        $r[] = place("place_estaciones_metro");
        if ($primer_registro > 0) {
            $r[] = input_hidden(["name" => "servicio", "class" => "servicio", "value" => $servicio]);

            if ($in_session < 1) {

                $z[] = d(frm_punto_encuentro($num_ciclos, $in_session, $servicio, $carro_compras, $id_carro_compras), "contenedor_eleccion_correo_electronico");

            } else {

                $z[] = d(frm_punto_encuentro_horario([
                    input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
                    input_hidden(["class" => "servicio", "name" => "servicio", "value" => $servicio]),
                    input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]),
                    input_hidden(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]),
                    input_hidden(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras])

                ]), 8, 1);
            }

            $r[] = d(append($z), 'formulario_quien_recibe display_none');

        } else {

            $recibo = $data["recibo"];
            $r[] = frm_quien_recibe( $punto_encuentro, $recibo);
            $r[] = input_hidden(["class" => "recibo", "name" => "recibo", "value" => $recibo]);
        }
        $r[] = input_hidden(["class" => "primer_registro", "value" => $primer_registro]);

        return d(d(append($r), 8, 1), 13);

    }

    function get_format_pagina_form_horario($recibo, $punto_encuentro)
    {

        $response = frm_punto_encuentro_horario([
            input_hidden(
                [
                    "class" => "recibo",
                    "name" => "recibo",
                    "value" => $recibo
                ]),

            input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro])
        ]);

        return  d($response, 6, 1);

    }

    function frm_punto_encuentro($num_ciclos, $in_session, $servicio, $carro_compras, $id_carro_compras)
    {
        $horarios = lista_horarios();
        $lista_horarios = $horarios["select"];
        $nuevo_dia = $horarios["nuevo_dia"];

        $minimo = date_format(horario_enid(), 'Y-m-d');
        $maximo = add_date($minimo, 4);
        $minimo = ($nuevo_dia > 0) ? add_date($minimo, 1) : $minimo;

        $z[] = form_open("", ["class" => "form-horizontal form_punto_encuentro mt-5"]);
        $z[] = label(" NOMBRE ", "col-lg-3 mt-3");

        $z[] = d(
            input(
                [
                    "id" => "nombre",
                    "name" => "nombre",
                    "type" => "text",
                    "placeholder" => "Persona que recibe",
                    "class" => "form-control input-md nombre ",
                    "required" => true
                ]), "col-lg-9 mt-3"
        );

        $z[] = label("CORREO ", "col-lg-3 mt-3");
        $z[] = d(
            input(
                [
                    "id" => "correo",
                    "name" => "email",
                    "type" => "email",
                    "placeholder" => "@",
                    "class" => "form-control input-md correo",
                    "required" => true
                ]), "col-lg-9 mt-3");

        $z[] = label(" TELÉFONO ", "col-lg-3 mt-3");

        $z[] = d(input([
            "id" => "tel",
            "name" => "telefono",
            "type" => "tel",
            "class" => "form-control input-md  telefono ",
            "required" => true
        ]), "col-lg-9 mt-3");

        $z[] = label("REGISTRA UNA CONTRASEÑA", "col-lg-4 mt-3");

        $z[] = d(input([
            "id" => "pw",
            "name" => "password",
            "type" => "password",
            "class" => "form-control input-md  pw ",
            "required" => true
        ]), "col-lg-8 mt-3");


        $r[] = d(append($z) , "display_none informacion_del_cliente top_50" );

        $r[] = h("¿En qué horario te gustaría recibir tu pedido?", 2, "col-lg-12 mt-3 top_30 text-uppercase text_horarios");
        $r[] = label(text_icon("fa fa-calendar-o" ,   " FECHA "), "col-lg-2 mt-3");

        $r[] = d(
            input(
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_entrega',
                    "class" => "form-control input-sm fecha_entrega",
                    "type" => 'date',
                    "value" => $minimo,
                    "min" => $minimo,
                    "max" => $maximo,
                    "onChange" => "horarios_disponibles()"
                ]), "col-lg-10 mt-3");


        $r[] = label(icon("fa fa-clock-o") . " HORA DE ENCUENTRO", "col-lg-4 mt-3");

        $r[] = d($lista_horarios, "col-lg-8 mt-3");

        $r[] = d("+ ¿ALGUNA INDICACIÓN?", ["class" => "col-lg-12  mt-5 cursor_pointer text_agregar_nota", "onclick" => "agregar_nota();"]);

        $x[] = d("NOTAS", "strong mt-3");
        $x[] = textarea(
            [
                "name" => "comentarios",
                "class" => "mt-3"
            ]);
        $r[] = d(append($x), "input_notas  col-lg-12 mt-3");


        $r[] = input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form "]);
        $r[] = input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras]);
        $r[] = input_hidden(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = d(btn("CONTINUAR"), ["class" => "col-lg-12 mt-5 botton_enviar_solicitud"]);
        $r[] = format_usuario_registrado($in_session, $servicio, $num_ciclos);
        $r[] = form_close();
        return d(append($r), 10, 1);


    }

    function format_usuario_registrado($in_session, $servicio, $num_ciclos)
    {

        $r = [];
        if ($in_session < 1) {

            $x[] = h("YA TIENES UN USUARIO REGISTRADO", 2, "display_none text_usuario_registrado underline");
            $x[] = h("¿Ya tienes una cuenta? ", 3, " text_usuario_registrado_pregunta text-center text-uppercase letter-spacing-10");

            $x[] = d(
                "ACCEDE AHORA!",
                [
                    "plan" => $servicio,
                    "num_ciclos" => $num_ciclos,
                    "class" => "padding_10 link_acceso cursor_pointer text-center col-lg-4 col-lg-offset-4 text-center text-uppercase letter-spacing-10  top_30 mb-5 white bg_black"
                ]
            );

            $r[] = d(append($x), "contenedor_ya_tienes_cuenta col-lg-12 top_50");
            $r[] = place("place_notificacion_punto_encuentro_registro");

        }
        return d(append($r),  "form_primer_registro display_none");

    }


    function frm_quien_recibe($pe, $recibo)
    {


        $r = [];

        $r[] = d(frm_punto_encuentro_horario(
            [
                input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $pe]),
                input_hidden(["class" => "recibo", "name" => "recibo", "value" => $recibo])
            ]
        ), 6, 1);

        return d(append($r), 'formulario_quien_recibe display_none');

    }

    function frm_punto_encuentro_horario($extra = [])
    {

        $horarios = lista_horarios();
        $nuevo_dia = $horarios["nuevo_dia"];
        $minimo = date_format(horario_enid(), 'Y-m-d');
        $maximo = add_date($minimo, 4);
        $minimo = ($nuevo_dia > 0) ? add_date($minimo, 1) : $minimo;


        $r[] = form_open("", ["class" => "form_punto_encuentro_horario top_50"]);
        $r[] = append($extra);
        $r[] = d(h("¿En qué horario te gustaría recibir tu pedido?", 2, "bottom_50"), 12);
        $r[] = d(icon("fa fa-calendar-o") . " FECHA ", 4);

        $r[] = d(
            input(
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_entrega',
                    "class" => "form-control input-sm fecha_entrega",
                    "type" => 'date',
                    "value" => $minimo,
                    "min" => $minimo,
                    "max" => $maximo,
                    "onChange" => "horarios_disponibles()"
                ]),
            8);

        $r[] = d(icon("fa fa-clock-o") . " HORA DE ENCUENTRO", "col-lg-4 top_30");
        $r[] = d($horarios["select"], "col-lg-8 top_30");
        $r[] = d(btn("CONTINUAR", ["class" => "top_50"]), 12);
        $r[] = place("place_notificacion_punto_encuentro");
        $r[] = form_close();
        return append($r);

    }

}