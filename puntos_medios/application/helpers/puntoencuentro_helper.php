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


        $r[] = d(d(h("TU PUNTO MÁS CERCANO", 3, " text-center"),4,1),"row top_50 bottom_30 titulo_punto_cercano");
        $r[] = d(d($data["leneas_metro"],  "place_lineas col-lg-12"), "row bottom_100 seccion_lm");

        $r[] = d(

            input([
                "class" => "ksearch",
                "name" => "q"
            ]),4,1
        );

        $r[] = d(place("place_estaciones_metro"),4,1);

        if ($primer_registro > 0) {
            $r[] = input_hidden(["name" => "servicio", "class" => "servicio id_servicio", "value" => $servicio]);

            if ($in_session < 1) {

                $z[] = d(frm_punto_encuentro($num_ciclos, $in_session, $servicio, $carro_compras, $id_carro_compras), "contenedor_eleccion_correo_electronico");

            } else {

                $z[] = d(frm_punto_encuentro_horario([
                    input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
                    input_hidden(["class" => "id_servicio servicio", "name" => "id_servicio", "value" => $servicio]),
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


        $a = " NOMBRE ";
        $b =
            input(
                [
                    "id" => "nombre",
                    "name" => "nombre",
                    "type" => "text",
                    "placeholder" => "Persona que recibe",
                    "class" => "form-control input-md nombre ",
                    "required" => true
                ]);

        $a1 = ajustar($a,$b,4);

        $a = "CORREO ";
        $b =
            input(
                [
                    "id" => "correo",
                    "name" => "email",
                    "type" => "email",
                    "placeholder" => "@",
                    "class" => "form-control input-md correo",
                    "required" => true
                ]);


        $b1= ajustar($a,$b,4);
        $z[]=  ajustar($a1,$b1,6);

        $a = " TELÉFONO ";
        $b = input([
            "id" => "tel",
            "name" => "telefono",
            "type" => "tel",
            "class" => "form-control input-md  telefono ",
            "required" => true
        ]);

        $a2 =  ajustar($a,$b,4);
        $b2 =  ajustar(
            "PASSWORD",
            input([
                "id" => "pw",
                "name" => "password",
                "type" => "password",
                "class" => "form-control input-md  pw ",
                "required" => true
            ]),4
        );
        $z[] =  ajustar($a2,$b2,6,"top_30 bottom_30");


        $r[] = d(append($z) , "display_none informacion_del_cliente top_100" );





        $sec[] = addNRow(h("¿En qué horario te gustaría recibir tu pedido?", 4, "top_100 text-uppercase  "));
        $a = ajustar(
            text_icon("fa fa-calendar-o" ,   " FECHA "),
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
                ]),4

        );
        $b = ajustar(

            text_icon("fa fa-clock-o", " HORA "),
            $lista_horarios,
            4
        );
        $sec[] = ajustar($a,$b,6, "top_50");
        $sec[] = d("+ ¿ALGUNA INDICACIÓN?", ["class" => " top_50 bottom_50 cursor_pointer text_agregar_nota", "onclick" => "agregar_nota();"]);
        $x[] = d("NOTAS", "mt-3");
        $x[] = textarea(
            [
                "name" => "comentarios",
                "class" => "mt-3"
            ]);
        $sec[] = d(append($x), "input_notas   top_50 bottom_50");

        $r[] = d(append($sec),"seccion_horarios");




        $r[] = input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form "]);
        $r[] = input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras]);
        $r[] = input_hidden(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]);


        $r[] = ajustar("", btn("CONTINUAR"), 8," mt-5 botton_enviar_solicitud ");

        $r[] = format_usuario_registrado($in_session, $servicio, $num_ciclos);
        $r[] = form_close();
        return d(append($r), 10, 1);


    }

    function format_usuario_registrado($in_session, $servicio, $num_ciclos)
    {

        $r = [];
        if ($in_session < 1) {

            $x[] = h("YA TIENES UN USUARIO REGISTRADO", 2, "display_none text_usuario_registrado underline");
            $x[] = h("¿tienes una cuenta? ", 5,

            [
                "class" => "text-right text_usuario_registrado_pregunta  text-uppercase link_acceso cursor_pointer",
                "id_servicio" => $servicio,
                "num_ciclos" => $num_ciclos,
            ]


            );


            $r[] = d(append($x), "contenedor_ya_tienes_cuenta  top_50");
            $r[] = place("place_notificacion_punto_encuentro_registro");
            $r[] = br(10);

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