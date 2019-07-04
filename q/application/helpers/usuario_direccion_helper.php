<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function get_format_direccion_envio_pedido($nombre_receptor,
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
                                               $id_recibo)
    {

        $r[] = form_open("", ["class" => "d-flex justify-content-between flex-column shadow form_direccion_envio  border form_direccion_envio padding_20"]);

        $a = btw(

            div("Persona que recibe")
            ,
            div(
                input(
                    [
                        "maxlength" => "80",
                        "name" => "nombre_receptor",
                        "value" => $nombre_receptor,
                        "placeholder" => "* Tu o quien más pueda recibir tu ,pedido",
                        "required" => "required",
                        "class" => "nombre_receptor",
                        "id" => "nombre_receptor",
                        "type" => "text"
                    ]))
            ,
            6
        );

        $b = btw(


            div("Teléfono"),
            input(
                [
                    "maxlength" => "12",
                    "name" => "telefono_receptor",
                    "value" => $telefono_receptor,
                    "placeholder" => "* Algún número telefónico ",
                    "required" => "required",
                    "class" => "telefono_receptor",
                    "id" => "telefono_receptor",
                    "type" => "text"
                ]
            ),
            6
        );
        $r[] = btw($a, $b, "row mt-5");
        $r[] = div("Código postal");
        $r[] = input([
            "maxlength" => "5",
            "name" => "cp",
            "value" => $cp,
            "placeholder" => "* Código postal",
            "required" => "required",
            "class" => "codigo_postal",
            "id" => "codigo_postal",
            "type" => "text"
        ]);
        $r[] = place('place_codigo_postal');
        $r[] = input_hidden(["name" => "id_usuario", "value" => $id_usuario]);

        $r[] = div("Calle");
        $r[] = input([
            "class" => "textinput address1",
            "name" => "calle",
            "value" => $calle,
            "placeholder" => "* Calle",
            "required" => "required",
            "autocorrect" => "off",
            "type" => "text"
        ]);
        $r[] = heading_enid("Entre la calle y la calle, o información adicional", 5, 1);
        $r[] = input([
            "required" => true,
            "class" => "textinput address3 ",
            "name" => "referencia",
            "value" => $entre_calles,
            "placeholder" => "true",
            "Entre la calle y la calle, o información adicional",
            "type" => "text"
        ]);

        $a = btw(
            div("Número Exterior"),
            input([
                "class" => "required numero_exterior",
                "name" => "numero_exterior",
                "value" => $numero_exterior,
                "maxlength" => "8",
                "placeholder" => "* Número Exterior",
                "required" => "true",
                "type" => "text"
            ]),
            6
        );
        $b = btw(
            div("Número Interior"),
            input([
                "class" => "numero_interior",
                "name" => "numero_interior",
                "value" => $numero_interior,
                "maxlength" => "10",
                "autocorrect" => "off",
                "type" => "text",
                "required " => "true"
            ]),
            6

        );


        $r[] = btw($a, $b, "row");
        $r[] = '<div  ' . $direccion_visible . ' class="parte_colonia_delegacion">';

        $r[] = div("Colonia");

        $r[] = div(
            input(
                [
                    "type" => "text",
                    "name" => "colonia",
                    "value" => $asentamiento,
                    "readonly" => true
                ]

            ), "place_colonias_info"
        );


        $r[] = place('place_asentamiento');
        $r[] = btw(

            div("Delegación o Municipio"),
            div(
                input(
                    [
                        "type" => "text",
                        "name" => "delegacion",
                        "value" => $municipio,
                        "readonly" => true
                    ]),
                "place_delegaciones_info"
            )
            ,
            " district delegacion_c"
        );
        $r[] = btw(
            div("Estado"),
            div(input([
                "type" => "text",
                "name" => "estado",
                "value" => $estado,
                "readonly" => "true"
            ]), ["class" => "place_estado_info"]),
            "district  estado_c"
        );

        $r[] = btw(
            div("País"),
            place("place_pais_info"),
            " district pais_c display_none"

        );


        $options[] = array(
            "text" => "SI",
            "val" => 1
        );
        $options[] = array(
            "text" => "NO",
            "val" => 0
        );


        $select = create_select($options, 'direccion_principal', 'direccion_principal', 'direccion_principal', 'text', 'val');

        $r[] =
            btw(

                div("Esta es mi dirección principal ", 5)

                ,

                div($select, 7)

                ,
                'direccion_principal_c row top_30 align-items-center '
            );


        $r[] = input_hidden(
            [
                "name" => "id_recibo",
                "value" => $id_recibo,
                "class" => "id_recibo"
            ]);

        $r[] = guardar("Registrar dirección ", ['class' => "text_btn_direccion_envio top_30 bottom_20"]);
        $r[] = place("notificacion_direccion");
        $r[] = form_close();

        return div(append($r), "contenedor_form_envio top_30");

    }

    function get_parte_direccion_envio($cp, $param, $calle, $entre_calles, $numero_exterior, $numero_interior)
    {

        $r[] = div("Código postal", "label-off");
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
        $r[] = input_hidden([
            "type" => "hidden",
            "name" => "id_usuario",
            "value" => $param['id_usuario']

        ]);
        $r[] = btw(
            div("Calle", "label-off"),

            input(
                [
                    "class" => "textinput",
                    "name" => "calle",
                    "value" => $calle,
                    "maxlength" => "30",
                    "placeholder" => "* Calle",
                    "required" => "required",
                    "autocorrect" => "off",
                    "type" => "text"

                ]),
            "value"
        );
        $r[] = btw(
            div("Entre la calle y la calle, o información adicional", "label-off")
            ,
            input(
                [
                    "required" => true,
                    "class" => "textinput address3",
                    "name" => "referencia",
                    "value" => $entre_calles,
                    "placeholder" => "Entre la calle y la calle, o información adicional",
                    "type" => "text"
                ])
            ,
            "value"
        );
        $r[] = btw(
            div("Número Exterior", "label-off")
            ,
            input(
                [
                    "class" => "required numero_exterior",
                    "name" => "numero_exterior",
                    "value" => $numero_exterior,
                    "maxlength" => "8",
                    "placeholder" => "* Número Exterior",
                    "required" => "true",
                    "type" => "text"
                ])
            ,
            "value"
        );
        $r[] = btw(
            div("Número Interior", "label-off")
            ,
            input(
                [
                    "class" => "numero_interior",
                    "name" => "numero_interior",
                    "value" => $numero_interior,
                    "maxlength" => "10",
                    "autocorrect" => "off",
                    "type" => "text",
                    "required" => "true"
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
        $r[] = get_campo($direccion, "numero_interior", " Número interior ", 1);
        $r[] = get_campo($direccion, "entre_calles", "Entre ", 1);
        $r[] = get_campo($direccion, "cp", " C.P. ", 1);
        $r[] = get_campo($direccion, "asentamiento", " Colonia ", 1);
        $r[] = get_campo($direccion, "municipio", " Delegación/Municipio ", 1);
        $r[] = get_campo($direccion, "ciudad", " Ciudad ", 1);
        $r[] = get_campo($direccion, "estado", " Estado ", 1);
        return append($r);

    }

    function val_btn_pago($param, $id_recibo)
    {


        $r = [];
        if (get_param_def($param, "externo") > 0) {


            $r[] = anchor_enid(
                "LIQUIDAR AHORA!",
                [
                    'class' => 'resumen_pagos_pendientes top_20',
                    'id' => $id_recibo,
                    'href' => path_enid("forma_pago_search", $id_recibo)
                ]
            );

            $r[] = anchor_enid("ACCEDE A TU CUENTA PARA VER EL ESTADO DE TU PEDIDO"
                ,
                [
                    'class' => 'resumen_pagos_pendientes black top_20',
                    'id' => $id_recibo,
                    'href' => '../area_cliente/?action=compras'
                ]
            );


        } else {

            $r[] = anchor_enid("Liquida ahora!",
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

}