<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_pagina_form_horario($recibo, $punto_encuentro)
    {

        $response = get_form_punto_encuentro_horario([
            input_hidden(
                [
                    "class" => "recibo",
                    "name" => "recibo",
                    "value" => $recibo
                ]),

            input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro])
        ]);

        $response = div($response, 6, 1);
        return $response;
    }

    function get_form_punto_encuentro($num_ciclos, $in_session, $servicio, $carro_compras, $id_carro_compras)
    {
        $horarios = lista_horarios();
        $lista_horarios = $horarios["select"];
        $nuevo_dia = $horarios["nuevo_dia"];

        $minimo = date_format(horario_enid(), 'Y-m-d');
        $maximo = add_date($minimo, 4);
        $minimo = ($nuevo_dia > 0) ? add_date($minimo, 1) : $minimo;


        $r[] = heading_enid("¿Quién recibe?", 2, ["class" => "text-uppercase"]);
        $r[] = form_open("", ["class" => "form-horizontal form_punto_encuentro mt-5"]);
        $r[] = label(" NOMBRE ", "col-lg-3 mt-3");

        $r[] = div(
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

        $r[] = label("CORREO ", "col-lg-3 mt-3");
        $r[] = div(
            input(
                [
                    "id" => "correo",
                    "name" => "email",
                    "type" => "email",
                    "placeholder" => "@",
                    "class" => "form-control input-md correo",
                    "required" => true
                ]), "col-lg-9 mt-3");

        $r[] = label(" TELÉFONO ", "col-lg-3 mt-3");

        $r[] = div(input([
            "id" => "tel",
            "name" => "telefono",
            "type" => "tel",
            "class" => "form-control input-md  telefono ",
            "required" => true
        ]), "col-lg-9 mt-3");

        $r[] = label(" CONTRASEÑA", "col-lg-3 mt-3");

        $r[] = div(input([
            "id" => "pw",
            "name" => "password",
            "type" => "password",
            "class" => "form-control input-md  pw ",
            "required" => true
        ]), "col-lg-9 mt-3");


        $r[] = heading_enid("¿En qué horario te gustaría recibir tu pedido?", 4, "col-lg-12 mt-3");

        $r[] = label(icon("fa fa-calendar-o") . " FECHA ", "col-lg-2 mt-3");


        $r[] = div(
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

        $r[] = div($lista_horarios, "col-lg-8 mt-3");

        $r[] = div("+ agregar nota", ["class" => "col-lg-12  mt-5 cursor_pointer text_agregar_nota", "onclick" => "agregar_nota();"]);

        $x[] = div("NOTAS", "strong mt-3");
        $x[] = textarea(
            [
                "name" => "comentarios",
                "class" => "mt-3"
            ]);
        $r[] = div(append($x), "input_notas  col-lg-12 mt-3");


        $r[] = input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form "]);
        $r[] = input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras]);
        $r[] = input_hidden(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = div(guardar("CONTINUAR"), ["class" => "col-lg-12 mt-5"]);
        $r[] = get_formar_usuario_registrado($in_session, $servicio, $num_ciclos);
        $r[] = form_close();
        return div(append($r), 10, 1);


    }

    function get_formar_usuario_registrado($in_session, $servicio, $num_ciclos)
    {

        $r = [];
        if ($in_session < 1) {

            $x[] = heading_enid("YA TIENES UN USUARIO REGISTRADO", 2, "display_none text_usuario_registrado underline");
            $x[] = heading_enid("¿Ya tienes una cuenta? ", 3, " text_usuario_registrado_pregunta text-center text-uppercase letter-spacing-10");

            $x[] = div(
                "ACCEDE AHORA!",
                [
                    "plan" => $servicio,
                    "num_ciclos" => $num_ciclos,
                    "class" => "padding_10 link_acceso cursor_pointer text-center col-lg-4 col-lg-offset-4 text-center text-uppercase letter-spacing-10  top_30 mb-5 white bg_black"
                ]
            );

            $r[] = div(append($x), "contenedor_ya_tienes_cuenta col-lg-12 top_50");
            $r[] = place("place_notificacion_punto_encuentro_registro");

        }
        return append($r);

    }

    function get_format_identificacion($tipos_puntos_encuentro)
    {

        return  heading_enid("IDENTIFICA TU PUNTO MÁS CERCANO", 3, " titulo_punto_encuentro letter-spacing-10  text-justify  border-bottom padding_10");

    }

    function get_form_quien_recibe($primer_registro, $punto_encuentro, $recibo)
    {


        $r = [];

        $r[] = div(get_form_punto_encuentro_horario(
            [
                input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
                input_hidden(["class" => "recibo", "name" => "recibo", "value" => $recibo])
            ]
        ), 6, 1);

        $response = div(append($r), 'formulario_quien_recibe display_none');

        return $response;

    }

    function get_form_punto_encuentro_horario($extra = [])
    {

        $horarios = lista_horarios();
        $nuevo_dia = $horarios["nuevo_dia"];
        $minimo = date_format(horario_enid(), 'Y-m-d');
        $maximo = add_date($minimo, 4);
        $minimo = ($nuevo_dia > 0) ? add_date($minimo, 1) : $minimo;


        $r[] = form_open("", ["class" => "form_punto_encuentro_horario top_50"]);
        $r[] = append($extra);
        $r[] = div(heading_enid("¿En qué horario te gustaría recibir tu pedido?", 2, "bottom_50"), 12);
        $r[] = div(icon("fa fa-calendar-o") . " FECHA ", 4);

        $r[] = div(
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

        $r[] = div(icon("fa fa-clock-o") . " HORA DE ENCUENTRO", "col-lg-4 top_30");
        $r[] = div($horarios["select"], "col-lg-8 top_30");
        $r[] = div(guardar("CONTINUAR", ["class" => "top_50"]), 12);
        $r[] = place("place_notificacion_punto_encuentro");
        $r[] = form_close();
        return append($r);

    }

}