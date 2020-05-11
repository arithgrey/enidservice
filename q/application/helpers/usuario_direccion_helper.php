<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function format_domicilio_resumen($data)
    {
        $r[] = d(
            a_enid(icon("fa fa-pencil"),
                ["class" => "a_enid_blue editar_direccion_persona"]
            )
            ,
            "text-right"
            ,
            1
        );
        $r[] = d(
            get_format_domicilio($data["info_envio_direccion"])
        );

        return append($r);

    }

    function format_direccion_envio($data)
    {

        $param = $data["param"];
        $session = $param['session'];
        $id_recibo = $param["id_recibo"];
        $info_envio_direccion = $data["info_envio_direccion"];
        $registro_direccion = $data["registro_direccion"];
        $info_usuario = $data["info_usuario"];
        $id_usuario = $data["id_usuario"];

        $calle = "";
        $entre_calles = "";
        $numero_exterior = "";
        $numero_interior = "";
        $cp = "";
        $asentamiento = "";
        $municipio = "";
        $estado = "";
        $direccion_visible = "style='display:none;'";
        $nombre_receptor = "";
        $telefono_receptor = "";

        foreach ($info_envio_direccion as $row) {

            $nombre_receptor = $row["nombre_receptor"];
            $telefono_receptor = $row["telefono_receptor"];
        }


        if ($registro_direccion == 0) {
            $nombre_receptor = format_nombre($info_usuario);
            $telefono_receptor = pr($info_usuario, "tel_contacto");
        }

        $nombre_receptor = (!es_data($info_envio_direccion)) ? format_nombre($info_usuario) : $nombre_receptor;

        $r[] = _titulo("dirección de envío");
        $r[] =  texto_envio_gratis();
        $r[] = get_format_direccion_envio_pedido(
            $data,
            $session,
            $nombre_receptor,
            $telefono_receptor,
            $cp,
            $id_usuario,
            $entre_calles,
            $calle,
            $numero_exterior,
            $numero_interior,
            $direccion_visible,
            $asentamiento,
            $municipio,
            $estado,
            $id_recibo
        );


        return d($r, "contenedor_informacion_envio col-lg-6 col-lg-offset-3 p-0");
    }

    function texto_envio_gratis(){
        return d('envío gratis en Ciudad de México ','mt-5 mb-5 alert alert-light text-uppercase border black text-center');
    }
    function form_ubicacion_escrita($param)
    {
        $id_recibo = $param['id_recibo'];



        $form[] = d(_titulo('¿Tienes una de dos?'), 'selector_ubicaciones_domicilio  text-center text-md-left');
        $ubicacion = format_link('Ingresar ubicación', ['class' => 'ingreso_ubicacion']);
        $domicilio = format_link('Registrar domicilio', ['class' => 'ingreso_texto_completo'], 0);

        $form[] = d(flex_md($ubicacion, $domicilio, _text_(_between_md, 'mt-5 mb-5'),'mb-5 mb-md-0'), 'selector_ubicaciones_domicilio');


        $formulario[] = form_open('', ['class' => 'form_ubicacion']);


        $horarios = lista_horarios();
        $lista_horarios = $horarios["select"];

        $min_max_disponibilidad = min_max_disponibilidad($param);
        $text_horarios = flex('hora de entrega', $lista_horarios, 'flex-column');
        $input = input_frm("",
            "FECHA",
            [
                "data-date-format" => "yyyy-mm-dd",
                "name" => 'fecha_entrega',
                "class" => "fecha_entrega",
                "type" => 'date',
                "value" => $min_max_disponibilidad['minimo'],
                "min" => $min_max_disponibilidad['minimo'],
                "max" => $min_max_disponibilidad['maximo'],
                "onChange" => "horarios_disponibles()",
                "id" => "fecha",
            ]
        );


        $formulario[] = d(_titulo('¿Cual es la Ubicación?'), 'mb-3');
        $formulario[] = texto_envio_gratis();
        $formulario[] = d(flex_md(
            $input,
            $text_horarios,
            _text_(_between, 'col-md-12'),
            'col-sm-12 col-md-6 p-0 mt-5 mb-5',
            _strong
        ),13);
        $formulario[] = d(input_frm('', 'Ubicación',
            [
                'class' => 'ubicacion',
                'name' => 'ubicacion',
                'id' => 'ubicacion',
                'required' => true
            ]), 'mt-3'
        );
        $formulario[] = hiddens(['name' => 'id_recibo','class'=>'id_recibo', 'value' => $id_recibo]);
        $formulario[] = btn('Registrar', ['class' => 'mt-5']);
        $formulario[] = form_close();

        $form[] = d($formulario, 'd-none formulario_registro_ubicacion');
        $modal = append($form);
        return gb_modal($modal, "modal_ubicacion");
    }

    function format_direccion($data)
    {

        $info_envio_direccion = $data["info_envio_direccion"];
        $param = $data["param"];

        $calle = "";
        $entre_calles = "";
        $numero_exterior = "";
        $numero_interior = "";
        $cp = "";
        $asentamiento = "";
        $municipio = "";
        $estado = "";
        $flag_existe_direccion_previa = 0;
        $pais = "";
        $direccion_visible = "display:none;";
        $id_pais = 0;
        foreach ($info_envio_direccion as $row) {


            $calle = $row["calle"];
            $entre_calles = $row["entre_calles"];
            $numero_exterior = $row["numero_exterior"];
            $numero_interior = $row["numero_interior"];
            $cp = $row["cp"];
            $asentamiento = $row["asentamiento"];
            $municipio = $row["municipio"];
            $estado = $row["estado"];
            $flag_existe_direccion_previa++;
            $pais = $row["pais"];
            $id_pais = $row["id_pais"];
        }


        $response[] = form_open("", ["class" => "form_direccion_envio"]);
        $response[] = get_parte_direccion_envio($cp, $param, $calle, $entre_calles,
            $numero_exterior, $numero_interior);
        $r[] = btw(

            d("Colonia",
                ["class" => "label-off", "for" => "dwfrm_profile_address_colony"])
            ,
            d(input([
                "type" => "text",
                "name" => "colonia",
                "value" => $asentamiento,
                "readonly" => true,
            ]), ["class" => "place_colonias_info"])
            ,
            "value"
        );
        $r[] = place("place_asentamiento");
        $r[] = d(
            btw(
                d("Delegación o Municipio", [
                    "class" => "label-off",
                    "for" => "dwfrm_profile_address_district",
                ])
                ,
                d(
                    input([
                        "type" => "text",
                        "name" => "delegacion",
                        "value" => $municipio,
                        "readonly" => "true",
                    ]), "place_delegaciones_info")
                ,
                "value"


            ), "district delegacion_c");


        $r[] = d(btw(
            d("Estado", [
                "class" => "label-off",
                "for" => "dwfrm_profile_address_district",
            ])
            ,
            d(
                input(
                    [
                        "type" => "text",
                        "name" => "estado",
                        "value" => $estado,
                        "readonly" => "true",
                    ]
                ),
                "place_estado_info"
            )
            ,
            "value"
        ), " district  estado_c");

        $r[] = btw(
            d("País", [
                "class" => "label-off",
                "for" => "dwfrm_profile_address_district",
            ]),
            $pais,
            "district pais_c"
        );
        $r[] = hiddens([
            "name" => "pais",
            "value" => $id_pais,
        ]);
        $z[] = d("Esta es mi dirección principal", "strong");

        $opt[] = array(
            "text" => "SI",
            "val" => 1,
        );
        $opt[] = array(
            "text" => "NO",
            "val" => 0,
        );
        $z[] = create_select($opt, "direccion_principal", "direccion_principal",
            "direccion_principal", "text", "val");
        $r[] = d(append($z), "direccion_principal_c");
        $r[] = btn("Registrar dirección", ["class" => "btn text_btn_direccion_envio"]);
        $response[] = d(append($r),
            ["style" => $direccion_visible, "class" => "parte_colonia_delegacion"]);
        $response[] = form_close();
        $f[] = d(text_icon('fa fa-bus', "Dirección de envio "));
        $f[] = d(append($response), [
            "id" => 'modificar_direccion_seccion',
            "class" => "contenedor_form_envio",
        ]);

        return append($f);

    }

    function get_format_direccion_envio_pedido(
        $data,
        $session,
        $nombre_receptor,
        $telefono_receptor,
        $cp,
        $id_usuario,
        $entre_calles,
        $calle,
        $numero_exterior,
        $numero_interior,
        $direccion_visible,
        $asentamiento,
        $municipio,
        $estado,
        $id_recibo
    )
    {

        $r[] = form_open("", ["class" => "form_direccion_envio row",]);


        $base = 'col-lg-6 mt-5';
        $r[] = indicaciones_horario_entrega_domicilio($session, $data);
        $r[] = hiddens(["name" => "id_usuario", "value" => $id_usuario]);

        $r[] = input_frm(
            $base, "Nombre/Quien recibe",

            [
                "maxlength" => "80",
                "name" => "nombre_receptor",
                "value" => $nombre_receptor,
                "placeholder" => "* Tu o quien más pueda recibir tu ,pedido",
                "required" => "required",
                "class" => "nombre_receptor",
                "id" => "nombre_receptor",
                "type" => "text",

            ]
        );


        $r[] = input_frm(
            $base, "Teléfono",

            [
                "name" => "telefono_receptor",
                "value" => $telefono_receptor,
                "placeholder" => "* Algún número telefónico ",
                "required" => "required",
                "class" => "telefono_receptor",
                "id" => "telefono_receptor",
                "type" => "tel",

            ]
        );


        $r[] = input_frm('col-lg-3 mt-5', "Código postal",

            [
                "maxlength" => "5",
                "name" => "cp",
                "value" => $cp,
                "placeholder" => "* Código postal",
                "required" => "required",
                "class" => "codigo_postal",
                "id" => "codigo_postal",
                "type" => "text",
            ], '¿Es correcto el C.P.?'
        );


        $r[] = input_frm('col-lg-9 mt-5', "Calle",
            [
                "class" => "address1",
                "name" => "calle",
                "value" => $calle,
                "required" => "required",
                "autocorrect" => "off",
                "type" => "text",
                "id" => "calle",
            ]
        );


        $r[] = d(input_frm('col-lg-12 mt-5',
            'Entre la calle y la calle, o alguna referencia',
            [
                "class" => "address3",
                "name" => "referencia",
                "value" => $entre_calles,
                "type" => "text",
                "id" => "referencias",
            ]

        ), 'd-none');


        $r[] = input_frm($base, "Número Exterior",
            [
                "class" => "numero_exterior",
                "name" => "numero_exterior",
                "value" => $numero_exterior,
                "maxlength" => "6",
                "placeholder" => "* Número Exterior",
                "required" => "true",
                "type" => "number",
                'id' => 'numero_exterior',
            ]
        );

        $r[] = input_frm(
            $base,
            "Número Interior",
            [
                "class" => "numero_interior",
                "name" => "numero_interior",
                "value" => $numero_interior,
                "maxlength" => "3",
                "autocorrect" => "off",
                "type" => "text",
                "required " => "true",
                'id' => 'numero_interior',
                'value' => 1,

            ]
        );


        $r[] = '<div  ' . $direccion_visible . ' class="parte_colonia_delegacion mt-5 col-lg-12">';

        $base_titulo = 'text-uppercase strong black mb-1';
        $r[] = d("Colonia", $base_titulo);

        $r[] = d(
            input(
                [
                    "type" => "text",
                    "name" => "colonia",
                    "value" => $asentamiento,
                    "readonly" => true,
                ]

            ), "place_colonias_info"
        );


        $r[] = place('place_asentamiento mt-3 mb-4');
        $r[] = btw(

            d("Delegación o Municipio", $base_titulo),
            d(
                input(
                    [
                        "type" => "text",
                        "name" => "delegacion",
                        "value" => $municipio,
                        "readonly" => true,
                    ]
                ),
                "place_delegaciones_info"
            )
            ,
            " district delegacion_c"
        );
        $r[] = btw(
            d("Estado", $base_titulo),
            d(input([
                "type" => "text",
                "name" => "estado",
                "value" => $estado,
                "readonly" => "true",
            ]), ["class" => "place_estado_info"]),
            "district  estado_c mt-3"
        );

        $r[] = btw(
            d("País", $base_titulo),
            place("place_pais_info"),
            " district pais_c display_none mt-3"

        );


        $options[] = array(
            "text" => "SI",
            "val" => 1,
        );
        $options[] = array(
            "text" => "NO",
            "val" => 0,
        );


        $select = create_select(
            $options,
            'direccion_principal',
            'direccion_principal',
            'direccion_principal',
            'text',
            'val'
        );

        $r[] =
            btw(

                d("Esta es mi dirección principal ",
                    _text($base_titulo, ' col-lg-8 p-0'))

                ,

                d($select, 4)

                ,
                'direccion_principal_c d-flex align-items-center  mt-3  '
            );


        $r[] = hiddens(
            [
                "name" => "id_recibo",
                "value" => $id_recibo,
                "class" => "id_recibo",
            ]
        );

        $r[] = btn("Registrar dirección ",
            ['class' => "text_btn_direccion_envio top_30 bottom_20"]);
        $r[] = place("notificacion_direccion");
        $r[] = form_close();

        return d($r, "contenedor_form_envio mt-5");

    }

    function indicaciones_horario_entrega_domicilio($session, $data)
    {
        $es_administrador_vendedor = es_administrador_o_vendedor($session);
        $response = [];
        $asignacion_horario = 0;
        if ($es_administrador_vendedor) {

            $horarios = lista_horarios();
            $lista_horarios = $horarios["select"];

            $min_max_disponibilidad = min_max_disponibilidad($data);
            $text_horarios = flex('hora de entrega', $lista_horarios, 'flex-column');
            $input = input_frm("",
                "FECHA",
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_entrega',
                    "class" => "fecha_entrega",
                    "type" => 'date',
                    "value" => $min_max_disponibilidad['minimo'],
                    "min" => $min_max_disponibilidad['minimo'],
                    "max" => $min_max_disponibilidad['maximo'],
                    "onChange" => "horarios_disponibles()",
                    "id" => "fecha",
                ]
            );


            $response[] = flex_md(
                $input,
                $text_horarios,
                _text_(_between, 'col-md-12'),
                'col-sm-12 col-md-6 p-0 mt-5 mb-5',
                _strong
            );
            $asignacion_horario++;


        }
        $response[] = hiddens(['name' => 'asignacion_horario', 'value' => $asignacion_horario, 'class' => 'asignacion_horario']);
        return append($response);

    }

    function min_max_disponibilidad($data)
    {

//        new DateTime('now', new DateTimeZone(config_item('time_reference')));
        $horarios = lista_horarios();
        $nuevo_dia = $horarios["nuevo_dia"];
        $minimo = date_format(horario_enid(), 'Y-m-d');
        $maximo = add_date($minimo, 4);
        $minimo = ($nuevo_dia > 0) ? add_date($minimo, 1) : $minimo;

        if (prm_def($data, 'servicio') != 0 && es_data($data['servicio'])) {

            $servicio = $data['servicio'];
            $muestra_fecha_disponible = pr($servicio, 'muestra_fecha_disponible');
            $fecha_disponible = pr($servicio, 'fecha_disponible');
            if ($muestra_fecha_disponible > 0) {

                $fecha_disponible_stock = new DateTime($fecha_disponible);
                $fecha = horario_enid();
                $es_proxima_fecha = ($fecha_disponible_stock > $fecha);
                if ($es_proxima_fecha && $muestra_fecha_disponible > 0) {

                    $minimo = date_format($fecha_disponible_stock, 'Y-m-d');
                    $maximo = add_date($minimo, 4);
                }

            }

        }

        return [
            'maximo' => $maximo,
            'minimo' => $minimo,
        ];
    }

    function get_parte_direccion_envio(
        $cp,
        $param,
        $calle,
        $entre_calles,
        $numero_exterior,
        $numero_interior
    )
    {

        $r[] = d("Código postal", "label-off");
        $r[] = input(
            [
                "maxlength" => "5",
                "name" => "cp",
                "value" => $cp,
                "placeholder" => "* Código postal",
                "required" => "required",
                "class" => "codigo_postal",
                "id" => "codigo_postal",
                "type" => "text",

            ]);
        $r[] = place("place_codigo_postal");
        $r[] = hiddens([
            "type" => "hidden",
            "name" => "id_usuario",
            "value" => $param['id_usuario'],

        ]);
        $r[] = btw(
            d("Calle", "label-off"),

            input(
                [
                    "class" => "",
                    "name" => "calle",
                    "value" => $calle,
                    "maxlength" => "30",
                    "placeholder" => "* Calle",
                    "required" => "required",
                    "autocorrect" => "off",
                    "type" => "text",

                ]),
            "value"
        );
        $r[] = btw(
            d("Entre la calle y la calle, o información adicional", "label-off")
            ,
            input(
                [
                    "required" => true,
                    "class" => " address3",
                    "name" => "referencia",
                    "value" => $entre_calles,
                    "placeholder" => "Entre la calle y la calle, o información adicional",
                    "type" => "text",
                ])
            ,
            "value"
        );
        $r[] = btw(
            d("Número Exterior", "label-off")
            ,
            input(
                [
                    "class" => "required numero_exterior",
                    "name" => "numero_exterior",
                    "value" => $numero_exterior,
                    "maxlength" => "8",
                    "placeholder" => "* Número Exterior",
                    "required" => "true",
                    "type" => "text",
                ])
            ,
            "value"
        );
        $r[] = btw(
            d("Número Interior", "label-off")
            ,
            input(
                [
                    "class" => "numero_interior",
                    "name" => "numero_interior",
                    "value" => $numero_interior,
                    "maxlength" => "10",
                    "autocorrect" => "off",
                    "type" => "text",
                    "required" => "true",
                ])
            ,
            "value"
        );

        return append($r);

    }

    function get_format_domicilio($direccion)
    {

        $r[] = get_campo($direccion, "direccion", "Dirección", 1);
        $r[] = get_campo($direccion, "calle", "Calle", 1);
        $r[] = get_campo($direccion, "numero_exterior", " Número exterior ", 1);
        $r[] = get_campo($direccion, "numero_interior", " interior ", 1);
        $r[] = get_campo($direccion, "entre_calles", "Entre ", 1);
        $r[] = get_campo($direccion, "cp", " C.P. ", 1);
        $r[] = get_campo($direccion, "asentamiento", " Colonia ", 1);
        $r[] = get_campo($direccion, "municipio", " Delegación/Municipio ", 1);
        $r[] = get_campo($direccion, "ciudad", " Ciudad ", 1);
        $r[] = get_campo($direccion, "estado", " Estado ", 1);

        return append($r);

    }

    /*
    function val_btn_pago($param, $id_recibo)
    {


        $r = [];
        if (prm_def($param, "externo") > 0) {


            $r[] = a_enid(
                "LIQUIDAR AHORA!",
                [
                    'class' => 'resumen_pagos_pendientes top_20',
                    'id' => $id_recibo,
                    'href' => path_enid("forma_pago_search", $id_recibo)
                ]
            );

            $r[] = a_enid("ACCEDE A TU CUENTA PARA VER EL ESTADO DE TU PEDIDO"
                ,
                [
                    'class' => 'resumen_pagos_pendientes black top_20',
                    'id' => $id_recibo,
                    'href' => '../area_cliente/?action=compras'
                ]
            );


        } else {

            $r[] = a_enid("Liquida ahora!",
                [
                    'class' => 'resumen_pagos_pendientes ',
                    'id' => $id_recibo,
                    'href' => '#tab_renovar_servicio',
                    'data-toggle' => 'tab'
                ]
            );

        }

        return append($r);

    }
    */

}