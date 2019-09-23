<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_domicilio_resumen($data)
    {
        $r[] = d(
            a_enid(icon("fa fa-pencil"), ["class" => "a_enid_blue editar_direccion_persona"]
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
        $flag_existe_direccion_previa = 0;
        $direccion_visible = "style='display:none;'";
        $nombre_receptor = "";
        $telefono_receptor = "";

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
            $direccion_visible = "";
            $nombre_receptor = $row["nombre_receptor"];
            $telefono_receptor = $row["telefono_receptor"];
        }


        if ($registro_direccion == 0) {

            $nombre = pr($info_usuario, "nombre");
            $apellido_paterno = pr($info_usuario, "apellido_paterno");
            $apellido_materno = pr($info_usuario, "apellido_materno");
            $nombre_receptor = $nombre . " " . $apellido_paterno . " " . $apellido_materno;
            $telefono_receptor = pr($info_usuario, "tel_contacto");
        }


        $r[] =
            d(btw(
                h("DIRECCIÓN DE ENVÍO", 2, "letter-spacing-5")
                ,
                get_format_direccion_envio_pedido(
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
                ,
                "contenedor_informacion_envio top_30"

            ), 8, 1);


        return append($r);
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


        $response[] = form_open("", ["class" => "form-horizontal form_direccion_envio"]);
        $response[] = get_parte_direccion_envio($cp, $param, $calle, $entre_calles, $numero_exterior, $numero_interior);
        $r[] = btw(

            d("Colonia", ["class" => "label-off", "for" => "dwfrm_profile_address_colony"])
            ,
            d(input([
                "type" => "text",
                "name" => "colonia",
                "value" => $asentamiento,
                "readonly" => true
            ]), ["class" => "place_colonias_info"])
            ,
            "value"
        );
        $r[] = place("place_asentamiento");
        $r[] = d(
            btw(
                d("Delegación o Municipio", ["class" => "label-off", "for" => "dwfrm_profile_address_district"])
                ,
                d(
                    input([
                    "type" => "text",
                    "name" => "delegacion",
                    "value" => $municipio,
                    "readonly" => "true"
                ]),  "place_delegaciones_info")
                ,
                "value"


            ), "district delegacion_c");


        $r[] = d(btw(
            d("Estado", ["class" => "label-off", "for" => "dwfrm_profile_address_district"])
            ,
            d(
                input(
                    [
                        "type" => "text",
                        "name" => "estado",
                        "value" => $estado,
                        "readonly" => "true"
                    ]
                ),
                 "place_estado_info"
            )
            ,
            "value"
        ), " district  estado_c");

        $r[] = btw(
            d("País", ["class" => "label-off", "for" => "dwfrm_profile_address_district"]),
            $pais,
            "district pais_c"
        );
        $r[] = hiddens([
            "name" => "pais",
            "value" => $id_pais
        ]);
        $z[] = d("Esta es mi dirección principal", "strong");

        $opt[] = array(
            "text" => "SI",
            "val" => 1
        );
        $opt[] = array(
            "text" => "NO",
            "val" => 0
        );
        $z[] = create_select($opt, "direccion_principal", "direccion_principal", "direccion_principal", "text", "val");
        $r[] = d(append($z), "direccion_principal_c");
        $r[] = btn("Registrar dirección", ["class" => "btn text_btn_direccion_envio"]);
        $response[] = d(append($r), ["style" => $direccion_visible, "class" => "parte_colonia_delegacion"]);
        $response[] = form_close();
        $f[] = d(text_icon('fa fa-bus', "Dirección de envio "));
        $f[] = d(append($response), ["id" => 'modificar_direccion_seccion', "class" => "contenedor_form_envio"]);
        return append($f);

    }

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

        $r[] = form_open("",
            [
                "class" => "d-flex justify-content-between flex-column shadow form_direccion_envio  border form_direccion_envio padding_20"
            ]
        );

        $a = btw(

            d("Persona que recibe")
            ,
            d(
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


            d("Teléfono"),
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
        $r[] = d("Código postal");
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
        $r[] = hiddens(["name" => "id_usuario", "value" => $id_usuario]);

        $r[] = d("Calle");
        $r[] = input([
            "class" => "textinput address1",
            "name" => "calle",
            "value" => $calle,
            "placeholder" => "* Calle",
            "required" => "required",
            "autocorrect" => "off",
            "type" => "text"
        ]);
        $r[] = h("Entre la calle y la calle, o información adicional", 5, 1);
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
            d("Número Exterior"),
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
            d("Número Interior"),
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

        $r[] = d("Colonia");

        $r[] = d(
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

            d("Delegación o Municipio"),
            d(
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
            d("Estado"),
            d(input([
                "type" => "text",
                "name" => "estado",
                "value" => $estado,
                "readonly" => "true"
            ]), ["class" => "place_estado_info"]),
            "district  estado_c"
        );

        $r[] = btw(
            d("País"),
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

                d("Esta es mi dirección principal ", 5)

                ,

                d($select, 7)

                ,
                'direccion_principal_c row top_30 align-items-center '
            );


        $r[] = hiddens(
            [
                "name" => "id_recibo",
                "value" => $id_recibo,
                "class" => "id_recibo"
            ]
        );

        $r[] = btn("Registrar dirección ", ['class' => "text_btn_direccion_envio top_30 bottom_20"]);
        $r[] = place("notificacion_direccion");
        $r[] = form_close();

        return d(append($r), "contenedor_form_envio top_30");

    }

    function get_parte_direccion_envio($cp, $param, $calle, $entre_calles, $numero_exterior, $numero_interior)
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
            "value" => $param['id_usuario']

        ]);
        $r[] = btw(
            d("Calle", "label-off"),

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
            d("Entre la calle y la calle, o información adicional", "label-off")
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
                    "type" => "text"
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