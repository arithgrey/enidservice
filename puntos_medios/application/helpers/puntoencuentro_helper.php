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


        $att = (is_mobile()) ? "strong" : "strong  mx-auto ";
        $r[] = flex(
            h("SELECCIONA TU LINEA MÁS CERCANA ", 2, $att),
            $data["leneas_metro"],
            ["d-lg-flex align-items-center contenedor_estaciones"],
            "col-lg-5 text_seleccion_linea p-0",
            "col-lg-7 place_lineas bg-light p-5 "

        );

        /*
        $r[] = d(d(

            input([
                "class" => "ksearch d-none ibusqueda_estaciones ",
                "name" => "q"
            ]),4,1
        ), 13);
        */

        $r[] =
            flex(
                h("¿CUAL ESTACIÓN SE TE FACILITA? ", 2,"strong"),

                "", ["d-lg-flex align-items-center desglose_estaciones"],
                "col-lg-5 text_seleccion_estacion p-0",
                "place_estaciones_metro col-lg-7 bg-light p-5"
            );

        if ($primer_registro > 0) {
            $r[] = hiddens(["name" => "servicio", "class" => "servicio id_servicio", "value" => $servicio]);

            if ($in_session < 1) {

                $z[] = frm_punto_encuentro($num_ciclos, $in_session, $servicio, $carro_compras, $id_carro_compras);

            } else {

                $z[] = d(frm_punto_encuentro_horario([
                    hiddens(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
                    hiddens(["class" => "id_servicio servicio", "name" => "id_servicio", "value" => $servicio]),
                    hiddens(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]),
                    hiddens(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]),
                    hiddens(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras])

                ]));
            }

            $r[] = d(append($z), 'formulario_quien_recibe');

        } else {

            $recibo = $data["recibo"];
            $r[] = frm_quien_recibe($punto_encuentro, $recibo);
            $r[] = hiddens(["class" => "recibo", "name" => "recibo", "value" => $recibo]);
        }

        $r[] = hiddens(["class" => "primer_registro", "value" => $primer_registro]);


        return d(append($r), "col-lg-8 col-lg-offset-2 mt-5 mb-5 proceso_compra_pe p-0");

    }

    function get_format_pagina_form_horario($recibo, $punto_encuentro)
    {

        $response = frm_punto_encuentro_horario([
            hiddens(
                [
                    "class" => "recibo",
                    "name" => "recibo",
                    "value" => $recibo
                ]),

            hiddens(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro])
        ]);

        return d($response, 6, 1);

    }

    function frm_punto_encuentro($num_ciclos, $in_session, $servicio, $carro_compras, $id_carro_compras)
    {
        $horarios = lista_horarios();
        $lista_horarios = $horarios["select"];
        $nuevo_dia = $horarios["nuevo_dia"];
        $minimo = date_format(horario_enid(), 'Y-m-d');
        $maximo = add_date($minimo, 4);
        $minimo = ($nuevo_dia > 0) ? add_date($minimo, 1) : $minimo;

        $z[] = form_open("", ["class" => "form_punto_encuentro mt-5 row"]);

        $z[] = contaiter(d(h("¿Quién recibe?", 3, " strong text-uppercase "), 12), "mb-5");
        $z[] =
            input_frm("col-lg-6 mt-5",
                "NOMBRE",
                [
                    "id" => "nombre",
                    "name" => "nombre",
                    "type" => "text",
                    "placeholder" => "Persona que recibe",
                    "class" => "nombre",
                    "minlength" => 3,
                    "required" => true,
                ]
            );


        $z[] = input_frm(
            "col-lg-6 mt-5",
            "CORREO",
            ["id" => "correo",
                "name" => "email",
                "type" => "email",
                "placeholder" => "jonathan@gmail.com",
                "class" => "correo",
                "minlength" => 5,
                "required" => true
            ]
        );


        $z[] = input_frm("col-lg-6 mt-5", "TELÉFONO ", [
            "id" => "tel",
            "name" => "telefono",
            "type" => "tel",
            "class" => "telefono ",
            "required" => true,
            "placeholder" => "5552...",
            "maxlength" => 10,
            "minlength" => 8,
        ], _text_telefono);


        $z[] = input_frm("col-lg-6 mt-5", "PASSWORD", [
            "id" => "pw",
            "type" => "password",
            "class" => "pw",
            "required" => true,
            "placeholder" => "***"
        ], _text_pass);

        $r[] = d(append($z), "informacion_del_cliente  col-lg-12");


        $sec[] = h("¿En qué horario te gustaría recibir tu pedido?", 3, " strong text-uppercase  col-lg-12 ");

        $a = input_frm("col-lg-6 mt-5", "FECHA", [
            "data-date-format" => "yyyy-mm-dd",
            "name" => 'fecha_entrega',
            "class" => "fecha_entrega",
            "type" => 'date',
            "value" => $minimo,
            "min" => $minimo,
            "max" => $maximo,
            "onChange" => "horarios_disponibles()",
            "id" => "fecha"
        ]);


        $b[] = d(text_icon("fa fa-clock-o", " HORA "), "strong");
        $b[] = d($lista_horarios, "mt-2");
        $horas = d(append($b), "col-lg-6 ");

        $sec[] = $a;
        $sec[] = $horas;

        $sec[] = d("¿ALGUNA INDICACIÓN?", ["class" => " strong  top_50 bottom_50 cursor_pointer text_agregar_nota col-lg-12 underline", "onclick" => "agregar_nota();"]);
        $x[] = d("¿ALGUNA INDICACIÓN?", "mt-3 strong");
        $x[] = textarea(
            [
                "name" => "comentarios",
                "class" => "mt-3"
            ]);
        $sec[] = d(append($x), "input_notas   top_50 bottom_50");

        $r[] = d(append($sec), "seccion_horarios_entrega ");


        $r[] = hiddens(["name" => "punto_encuentro", "class" => "punto_encuentro_form punto_encuentro"]);
        $r[] = hiddens(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = hiddens(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras]);
        $r[] = hiddens(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = d("", 9);
        $r[] = d(btn("CONTINUAR", ["class" => "botton_enviar_solicitud "]), "col-lg-3 continuar");

        //$r[] = format_usuario_registrado($in_session, $servicio, $num_ciclos);
        $r[] =  d(format_load(),12);
        $r[] = form_close();

        return append($r);


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


        }
        return d(append($r), "form_primer_registro display_none");

    }


    function frm_quien_recibe($pe, $recibo)
    {


        $r = [];

        $r[] = d(frm_punto_encuentro_horario(
            [
                hiddens(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $pe]),
                hiddens(["class" => "recibo", "name" => "recibo", "value" => $recibo])
            ]
        ), 6, 1);

        return d(append($r), 'formulario_quien_recibe ');

    }

    function frm_punto_encuentro_horario($extra = [])
    {

        $horarios = lista_horarios();
        $nuevo_dia = $horarios["nuevo_dia"];
        $minimo = date_format(horario_enid(), 'Y-m-d');
        $maximo = add_date($minimo, 4);
        $minimo = ($nuevo_dia > 0) ? add_date($minimo, 1) : $minimo;


        $r[] = form_open("", ["class" => "form_punto_encuentro_horario"]);
        $r[] = append($extra);
        $r[] = h("¿En qué horario te gustaría recibir tu pedido?", 3, " strong text-uppercase  col-lg-12 ");

        $r[] = d(
            btw(
                input([
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_entrega',
                    "class" => "fecha_entrega",
                    "type" => 'date',
                    "value" => $minimo,
                    "min" => $minimo,
                    "max" => $maximo,
                    "onChange" => "horarios_disponibles()",
                    "id" => "fecha"
                ], 0, 0),
                label("FECHA", ["for" => "fecha"])
                ,
                "input_enid_format"
            )
            ,
            "col-lg-6 mt-5"
        );


        $b[] = d(text_icon("fa fa-clock-o", " HORA "), "strong");
        $b[] = d($horarios["select"], "mt-2");
        $r[] = d(append($b), "col-lg-6 mt-5");

        $r[] = d("", 9);
        $r[] = d(btn("CONTINUAR", ["class" => "mt-5 "]), "col-lg-3");
        $r[] = d(format_load(),12);
        $r[] = place("place_notificacion_punto_encuentro ");
        $r[] = form_close();

        return append($r);

    }

}