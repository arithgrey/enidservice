<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function seleccion_estacion($data)
    {
        $att = (is_mobile()) ? "strong" : "strong  mx-auto ";

        $in_session = $data['in_session'];
        $es_cliente = ($data['id_perfil'] == 20);
        $es_cliente = ($in_session) ? $es_cliente : 0;

        $titulo = ($es_cliente) ? "¿cual linea se te facilita?" : "¿En qué linea del metro será la entrega?";
        $r[] = flex(
            _titulo($titulo, 0, $att),
            $data["leneas_metro"],
            [
                "d-lg-flex align-items-center contenedor_estaciones",
            ],
            "col-lg-5 text_seleccion_linea mb-5 p-md-0",
            "col-lg-7 place_lineas bg-light p-md-5 "

        );

        $titulo = ($es_cliente) ? "selecciona tu estacción de entrega" : "¿En qué estación será la entrega?";
        $ext = (is_mobile()) ? 'row' : '';
        $r[] =
            flex(
                _titulo($titulo),

                "",
                [
                    "d-lg-flex desglose_estaciones p-md-0",
                ],
                "col-lg-5 text_seleccion_estacion p-md-0",
                _text_("place_estaciones_metro col-lg-7 bg-light p-5", $ext)
            );

        return append($r);
    }

    function render_pm($data)
    {


        $primer_registro = $data["primer_registro"];
        $r[] = seleccion_estacion($data);
        $r[] = hiddens(
            [
                "class" => "primer_registro",
                "value" => $primer_registro,
            ]
        );

        if ($primer_registro > 0) {

            $r[] = formulario_compra_punto_encuentro($data);

        } else {

            $r[] = formalario_cambio_punto_encuentro($data);

        }

        return d($r, "col-lg-8 col-lg-offset-2 mt-5 mb-5 proceso_compra_pe p-0");

    }

    function formulario_primer_registro_punto_encuentro(
        $num_ciclos, $carro_compras, $id_carro_compras, $es_cliente)
    {

        $extra = [

            hiddens([
                "name" => "punto_encuentro",
                "class" => "punto_encuentro_form punto_encuentro",
            ]),
            hiddens([
                "name" => "num_ciclos",
                "class" => "num_ciclos",
                "value" => $num_ciclos,
            ]),
            hiddens([
                "name" => "carro_compras",
                "class" => "carro_compras",
                "value" => $carro_compras,
            ]),
            hiddens([
                "name" => "id_carro_compras",
                "class" => "id_carro_compras",
                "value" => $id_carro_compras,
            ]),
            hiddens([
                "name" => "es_cliente",
                "class" => "es_cliente",
                "value" => $es_cliente,
            ]),
        ];

        return frm_punto_encuentro($extra, $es_cliente);

    }

    function get_format_pagina_form_horario($recibo, $punto_encuentro)
    {

        $response = frm_punto_encuentro_horario([
            hiddens(
                [
                    "class" => "recibo",
                    "name" => "recibo",
                    "value" => $recibo,
                ]
            ),

            hiddens(
                [
                    "name" => "punto_encuentro",
                    "class" => "punto_encuentro_form punto_encuentro",
                    "value" => $punto_encuentro,
                ]
            ),
        ]);

        return d($response, 6, 1);

    }

    function frm_punto_encuentro($extra, $es_cliente)
    {
        $horarios = lista_horarios();
        $lista_horarios = $horarios["select"];
        $nuevo_dia = $horarios["nuevo_dia"];
        $minimo = date_format(horario_enid(), 'Y-m-d');
        $maximo = add_date($minimo, 4);
        $minimo = ($nuevo_dia > 0) ? add_date($minimo, 1) : $minimo;

        $form[] = form_open("", ["class" => "form_punto_encuentro"]);
        $form[] = append($extra);
        $form[] = d(_titulo("¿Quién recibe?"), 'col-sm-12 mb-5');
        $es_cliente_class = ($es_cliente) ? '' : 'd-none';


        $form[] = input_frm("col-lg-6 mt-5",
            "NOMBRE",
            [
                "id" => "nombre",
                "name" => "nombre",
                "type" => "text",
                "placeholder" => "Persona que recibe",
                "class" => "nombre",
                "minlength" => 3,
                "required" => true,
                'onkeyup' => "this.value = this.value.toUpperCase();"
            ]
        );


        $config_email = [
            "id" => "correo",
            "name" => "email",
            "type" => "email",
            "placeholder" => "jonathan@gmail.com",
            "class" => "correo",
            "minlength" => 5,
            "required" => true,
        ];
        if (!$es_cliente) {

            $config_email['value'] = _text(sha1(mt_rand()), '@', 'enidservices.com');
        }

        $form[] = input_frm(
            _text_("col-lg-6 mt-5", $es_cliente_class),
            "CORREO",
            $config_email, _text_correo
        );


        $form[] = input_frm("col-lg-6 mt-5", "TELÉFONO ",
            [
                "id" => "tel",
                "name" => "telefono",
                "type" => "tel",
                "class" => "telefono ",
                "required" => true,
                "placeholder" => "5552...",
                "maxlength" => 10,
                "minlength" => 8,
            ], _text_telefono);


        $config = [
            "id" => "pw",
            "type" => "password",
            "class" => "pw",
            "required" => true,
            "placeholder" => "***",
        ];

        if (!$es_cliente) {
            $config['value'] = sha1(mt_rand());
        }

        $form[] = input_frm(_text_("col-lg-6 mt-5", $es_cliente_class), "PASSWORD", $config, _text_pass);


        $tipo = is_mobile() ? 'col-sm-12 p-0' : 'row';
        $r[] = d($form, _text_("informacion_del_cliente p-md-0", $tipo));

        $titulo = ($es_cliente) ? _text_horario_entrega : _text_horario_entrega_vendedor;
        $sec[] = d(_titulo($titulo), 'col-lg-12 mb-5 p-md-0');

        $a = input_frm("col-lg-6 mt-5 p-md-0", "FECHA",
            [
                "data-date-format" => "yyyy-mm-dd",
                "name" => 'fecha_entrega',
                "class" => "fecha_entrega",
                "type" => 'date',
                "value" => $minimo,
                "min" => $minimo,
                "max" => $maximo,
                "onChange" => "horarios_disponibles()",
                "id" => "fecha",
            ]
        );


        $b[] = d(text_icon(_tiempo_icon, "hora de tu entrega"), _strong);
        $b[] = d($lista_horarios, "mt-2");
        $horas = d($b, "col-lg-6 mt-5");

        $sec[] = $a;
        $sec[] = $horas;


        $ext = is_mobile() ? 'h4' : '';
        $sec[] = d("¿TIENES ALGUNA INDICACIÓN?",
            [
                "class" =>
                    _text_($ext, _strong,
                        "mt-5 mb-5 cursor_pointer text_agregar_nota col-lg-12 
                        underline p-md-0 text-center text-md-left"),
                "onclick" => "agregar_nota();",
            ]
        );


        $x[] = d("¿TIENES ALGUNA INDICACIÓN?", _text_("mt-3", _strong));
        $x[] = textarea(
            [
                "name" => "comentarios",
                "class" => "mt-5",
            ]
        );

        $sec[] = d($x, "input_notas mt-5 mb-5 col-sm-12 p-md-0");

        $r[] = d(d($sec, "seccion_horarios_entrega row"), 12);
        $r[] = d("", 9);
        $r[] = d(btn("CONTINUAR",
            [
                "class" => "botton_enviar_solicitud "
            ]
        ),
            "col-lg-3 continuar");


        $r[] = form_close();
        $r[] = format_usuario_registrado();
        return append($r);


    }

    function format_usuario_registrado()
    {

        return d(
            add_text("tu usuario ya existe",
                format_link("inicia sessión",
                    [
                        'class' => "mt-5 ml-3 h5 text-uppercase",
                        "href" => path_enid("login"),
                        'rm_class' => "d-block"

                    ]
                )
            ),

            'text-uppercase usuario_existente d-none  col-lg-12 h4 text-center strong');
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
        $r[] = _titulo(_text_horario_entrega, 0, "col-lg-12");

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
                    "id" => "fecha",
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
        $r[] = d($b, "col-lg-6 mt-5");

        $r[] = d("", 9);
        $r[] = d(btn("CONTINUAR", ["class" => "mt-5 "]), "col-lg-3");

        $r[] = place("place_notificacion_punto_encuentro ");
        $r[] = form_close();


        return append($r);

    }

    function formulario_compra_punto_encuentro_session(
        $punto_encuentro,
        $servicio,
        $num_ciclos,
        $id_carro_compras,
        $carro_compras
    )
    {
        return d(
            frm_punto_encuentro_horario([
                    hiddens(
                        [
                            "name" => "punto_encuentro",
                            "class" => "punto_encuentro_form punto_encuentro",
                            "value" => $punto_encuentro,
                        ]),
                    hiddens(
                        [
                            "class" => "id_servicio servicio",
                            "name" => "id_servicio",
                            "value" => $servicio,
                        ]),
                    hiddens(
                        [
                            "name" => "num_ciclos",
                            "class" => "num_ciclos",
                            "value" => $num_ciclos,
                        ]),
                    hiddens(
                        [
                            "name" => "id_carro_compras",
                            "class" => "id_carro_compras",
                            "value" => $id_carro_compras,
                        ]),
                    hiddens(
                        [
                            "name" => "carro_compras",
                            "class" => "carro_compras",
                            "value" => $carro_compras,
                        ]),

                ]
            )
        );
    }

    function formulario_compra_punto_encuentro($data)
    {
        $servicio = $data["servicio"];
        $num_ciclos = $data["num_ciclos"];
        $carro_compras = $data["carro_compras"];
        $id_carro_compras = $data["id_carro_compras"];
        $in_session = $data['in_session'];
        $punto_encuentro = $data["punto_encuentro"];
        $es_cliente = ($data['id_perfil'] == 20) ? 1 : 0;
        $es_cliente = ($in_session) ? $es_cliente : 1;
        $z[] = hiddens(
            [
                "name" => "servicio",
                "class" => "servicio id_servicio",
                "value" => $servicio,
            ]
        );


        if ($in_session < 1) {

            $z[] = formulario_primer_registro_punto_encuentro(
                $num_ciclos, $carro_compras, $id_carro_compras, $es_cliente);

        } else {


            if (!$es_cliente) {

                $z[] = formulario_primer_registro_punto_encuentro(
                    $num_ciclos, $carro_compras, $id_carro_compras, $es_cliente);

            } else {

                $z[] = formulario_compra_punto_encuentro_session(
                    $punto_encuentro, $servicio, $num_ciclos, $id_carro_compras,
                    $carro_compras);
            }

        }


        return d($z, 'formulario_quien_recibe');

    }

    function formalario_cambio_punto_encuentro($data)
    {

        $r[] = d(frm_punto_encuentro_horario(
                [
                    hiddens(
                        [
                            "name" => "punto_encuentro",
                            "class" => "punto_encuentro_form punto_encuentro",
                            "value" => $data["punto_encuentro"],
                        ]
                    ),
                    hiddens(
                        [
                            "class" => "recibo",
                            "name" => "recibo",
                            "value" => $data["recibo"],
                        ]
                    ),
                ]
            )
        );

        return d($r, 'formulario_quien_recibe');

    }
}
