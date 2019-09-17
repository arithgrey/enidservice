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


        $att = (is_mobile()) ? "" : "strong w-75 mx-auto ";
        $r[] = d(flex(
            h("SELECCIONA UNA LINEA ", 2, $att),
            $data["leneas_metro"],
            ["d-lg-flex align-items-center contenedor_estaciones"],
            "col-lg-5 text_seleccion_linea",
            "col-lg-7 place_lineas bg-light p-5 "

        ), 13);

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
                h("SELECCIONA UNA ESTACIÓN ", 2, $att),

                "", ["d-lg-flex align-items-center row desglose_estaciones"],
                "col-lg-5 text_seleccion_estacion",
                "place_estaciones_metro col-lg-7 bg-light p-5"
            );

        if ($primer_registro > 0) {
            $r[] = input_hidden(["name" => "servicio", "class" => "servicio id_servicio", "value" => $servicio]);

            if ($in_session < 1) {

                $z[] = frm_punto_encuentro($num_ciclos, $in_session, $servicio, $carro_compras, $id_carro_compras);

            } else {

                $z[] = d(frm_punto_encuentro_horario([
                    input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
                    input_hidden(["class" => "id_servicio servicio", "name" => "id_servicio", "value" => $servicio]),
                    input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]),
                    input_hidden(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]),
                    input_hidden(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras])

                ]));
            }

            $r[] = d(append($z), 'formulario_quien_recibe row');

        } else {

            $recibo = $data["recibo"];
            $r[] = frm_quien_recibe($punto_encuentro, $recibo);
            $r[] = input_hidden(["class" => "recibo", "name" => "recibo", "value" => $recibo]);
        }
        $r[] = input_hidden(["class" => "primer_registro", "value" => $primer_registro]);

        return d(append($r), "col-lg-8 col-lg-offset-2 mt-5 mb-5 proceso_compra_pe");

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

        $z[] = h("¿Quién recibe?", 3, " strong text-uppercase col-lg-12 ");
        $z[] = d(
            btw(
                input(
                    [
                        "id" => "nombre",
                        "name" => "nombre",
                        "type" => "text",
                        "placeholder" => "Persona que recibe",
                        "class" => "nombre",
                        "minlength" => 3,
                        "required" => true
                    ], 0, 0
                ),
                label("NOMBRE", ["for" => "nombre"]),
                "input_enid"
            ), 6
        );


        $z[] = d(
            btw(

                input(
                    [
                        "id" => "correo",
                        "name" => "email",
                        "type" => "email",
                        "placeholder" => "jonathan@gmail.com",
                        "class" => "correo",
                        "minlength" => 5,
                        "required" => true
                    ], 0, 0
                ),
                label("CORREO", ["for" => "correo"])
                ,
                "input_enid"
            )
            ,
            6
        );


        $z[] = d(
            btw(

                input([
                    "id" => "tel",
                    "name" => "telefono",
                    "type" => "tel",
                    "class" => "telefono ",
                    "required" => true,
                    "placeholder" => "5552...",
                    "maxlength" => 10,
                    "minlength" => 8
                ], 0, 0),
                label("TELÉFONO ", ["for" => "tel"])
                ,
                "input_enid"
            )
            ,
            6
        );


        $z[] = d(
            btw(

                input([
                    "id" => "pw",
                    "type" => "password",
                    "class" => "pw",
                    "required" => true,
                    "placeholder" => "***"
                ], 0, 0),
                label("PASSWORD", ["for" => "pw"])
                ,
                "input_enid"
            )
            ,
            6
        );

        $r[] = d(append($z), "informacion_del_cliente  col-lg-12");


        $sec[] = h("¿En qué horario te gustaría recibir tu pedido?", 3, " strong text-uppercase  col-lg-12 ");

        $a = d(
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
                "input_enid"
            )
            ,
            "col-lg-6 mt-5"
        );


        $b[] = d(text_icon("fa fa-clock-o", " HORA "), "strong");
        $b[] = d($lista_horarios, "mt-2");
        $horas = d(append($b), "col-lg-6 mt-5");

        $sec[] = $a;
        $sec[] = $horas;

        $sec[] = d("¿ALGUNA INDICACIÓN?", ["class" => " top_50 bottom_50 cursor_pointer text_agregar_nota col-lg-3 underline", "onclick" => "agregar_nota();"]);
        $x[] = d("¿ALGUNA INDICACIÓN?", "mt-3 strong");
        $x[] = textarea(
            [
                "name" => "comentarios",
                "class" => "mt-3"
            ]);
        $sec[] = d(append($x), "input_notas   top_50 bottom_50 col-lg-12");

        $r[] = d(append($sec), "seccion_horarios_entrega");


        $r[] = input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form punto_encuentro"]);
        $r[] = input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras]);
        $r[] = input_hidden(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]);
        $r[] = d("", 9);
        $r[] = d(btn("CONTINUAR", ["class" => "botton_enviar_solicitud "]), "col-lg-3 continuar");

        //$r[] = format_usuario_registrado($in_session, $servicio, $num_ciclos);
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
                input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $pe]),
                input_hidden(["class" => "recibo", "name" => "recibo", "value" => $recibo])
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
                "input_enid"
            )
            ,
            "col-lg-6 mt-5"
        );



        $b[] = d(text_icon("fa fa-clock-o", " HORA "), "strong");
        $b[] = d($horarios["select"], "mt-2");
        $r[] = d(append($b), "col-lg-6 mt-5");

        $r[] = d("", 9);
        $r[] = d(btn("CONTINUAR", ["class" => "mt-5 "]), "col-lg-3");

        $r[] = place("place_notificacion_punto_encuentro");
        $r[] = form_close();
        return append($r);

    }

}