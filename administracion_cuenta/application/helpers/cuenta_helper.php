<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_form_set_password')) {
        function get_form_set_password(){

            $r[] = form_open("", ["id" => "form_update_password", "class" => "form-horizontal", "method" => "POST"]);
            $r[] = div("CONTRASEÑA ACTUAL", 1);
            $r[] = input([
                "name" => "password",
                "id" => "password",
                "class" => "form-control input-sm",
                "type" => "password",
                "required" => "true"
            ]);
            $r[] = place('place_pw_1');
            $r[] = div("NUEVA", 1);
            $r[] = input([
                "name" => "pw_nueva",
                "id" => "pw_nueva",
                "type" => "password",
                "class" => 'form-control input-sm',
                "required" => "true"
            ]);
            $r[] = place('place_pw_2');
            $r[] = div("CONFIRMAR NUEVA", 1);
            $r[] = input([
                "name" => "pw_nueva_confirm",
                "id" => "pw_nueva_confirm",
                "type" => "password",
                "class" => "form-control input-sm",
                "required" => "true"
            ]);
            $r[] = input_hidden(["name" => "secret", "id" => "secret"]);
            $r[] = place('place_pw_3');
            $r[] = div("", ["id" => "reportesession", "class" => "reportesession"]);
            $r[] = guardar("Actualizar", ["id" => "inbutton", "class" => "btn btn_save input-sm"]);
            $r[] = form_close(place("msj_password"));

            return append_data($r);
        }

    }

    if (!function_exists('get_format_user')) {

        function get_format_user($usuario, $vista = 0)
        {

            $r = [];
            if ($vista < 1) {
                $r[] = heading_enid("Cuenta", 1, ['class' => 'strong'], 1);
                $r[] = br();
                $r[] = addNRow(get_form_nombre($usuario));
                $r[] = addNRow(get_form_email($usuario));
                $r[] = br();
                $r[] = addNRow(get_form_telefono($usuario));
                $r[] = addNRow(get_form_negocio($usuario));

            } else {

                $r[] = get_campo($usuario, "nombre", "Tu Nombre");
                $r[] = get_campo($usuario, "apellido_paterno", "Tu prime apellido");
                $r[] = get_campo($usuario, "apellido_materno", "Tu prime apellido");

            }
            return append_data($r);

        }
    }
    if (!function_exists('get_form_negocio')) {

        function get_form_negocio($usuario)
        {

            $r[] = form_open("", ["class" => "f_telefono_usuario_negocio"]);
            $r[] = div("Teléfono de negocio", ["class" => "col-lg-3 strong"]);
            $r[] = get_btw(form_input(
                [
                    'name' => 'lada_negocio',
                    'id' => 'lada',
                    'value' => get_campo($usuario, 'lada_negocio'),
                    'maxlength' => '3',
                    'minlength' => '2',
                    'class' => 'form-control input-sm input_enid lada_negocio lada2',
                    'placeholder' => "Lada",
                    'type' => "text"

                ]
            ),
                place("registro_telefono_usuario_lada_negocio")
                ,
                "col-lg-2"

            );


            $r[] = get_btw(
                form_input(
                    [
                        'name' => 'telefono_negocio',
                        'id' => 'telefono',
                        'value' => get_campo($usuario, 'tel_contacto_alterno'),
                        'maxlength' => '13',
                        'minlength' => '8',
                        'class' => 'form-control input-sm input_enid telefono telefono_info_contacto_negocio tel2',
                        'placeholder' => "El Teléfono de tu negocio",
                        'type' => "text"
                    ]
                )
                ,
                place("registro_telefono_usuario_negocio"),

                "col-lg-5"
            );

            $r[] = div(guardar("Actualizar", ["class" => "input_enid"]), ["class" => "col-lg-2"]);
            $r[] = form_close();
            return append_data($r);

        }
    }
    if (!function_exists('get_form_telefono')) {
        function get_form_telefono($usuario)
        {

            $r[] = form_open("", ["class" => "f_telefono_usuario"]);
            $r[] = div("Teléfon Movil", ["class" => "col-lg-3 strong"]);

            $r[] = get_btw(
                input([
                    "id" => "lada",
                    "name" => "lada",
                    "placeholder" => "Lada",
                    "class" => "form-control input-sm input_enid lada ",
                    "required" => "",
                    "type" => "text",
                    "maxlength" => "3",
                    "minlength" => "2",
                    "value" => get_campo($usuario, 'tel_lada')
                ])
                ,
                place("registro_telefono_usuario_lada")
                ,
                "col-lg-2"

            );

            $r[] = get_btw(
                input([
                    "id" => "telefono",
                    "name" => "telefono",
                    "placeholder" => "Teléfono",
                    "class" => "form-control input-sm input_enid telefono ",
                    "required" => true,
                    "type" => "text",
                    "maxlength" => "13",
                    "minlength" => "8",
                    "value" => get_campo($usuario, 'tel_contacto')
                ])
                ,
                place("registro_telefono_usuario")
                ,
                "col-lg-5"
            );
            $r[] = div(guardar("Actualizar", ["class" => "input_enid"]), ["class" => "col-lg-2"]);
            $r[] = form_close();
            return append_data($r);


        }
    }
    if (!function_exists('get_form_email')) {
        function get_form_email($usuario)
        {

            $r[] = form_open("");
            $r[] = div('Correo electrónico', ['class' => 'strong'], 1);
            $r[] = input([
                "id" => "correo_electronico",
                "name" => "correo_electronico",
                "placeholder" => "El correo electrónico no se mostrará públicamente",
                "class" => "form-control input-sm input_enid correo_electronico",
                "required" => "",
                "type" => "text",
                "value" => get_campo($usuario, 'email'),
                "readonly" => true
            ]);

            $r[] = div('El correo electrónico NO se mostrará públicamente', ['class' => 'blue_enid '], 1);
            return append_data($r);


        }
    }
    if (!function_exists('get_form_nombre')) {
        function get_form_nombre($usuario)
        {

            $r[] = form_open("", ["class" => "f_nombre_usuario"]);
            $r[] = div('Nombre de usuario', ['class' => 'strong'], 1);
            $r[] = input([
                "id" => "nombre_usuario",
                "name" => "nombre_usuario",
                "placeholder" => "Nombre por cual te indentifican clientes y vendedores",
                "class" => "form-control input-sm input_enid nombre_usuario",
                "required" => true,
                "type" => "text",
                "value" => get_campo($usuario, 'nombre_usuario'),
                "maxlength" => "15"
            ]);
            $r[] = div(div("", ['class' => 'registro_nombre_usuario']), ['class' => '"col-lg-7"']);
            $r[] = form_close();

            return append_data($r);

        }
    }
    if (!function_exists('get_menu')) {
        function get_menu($id_usuario)
        {


            $final =
                get_url_facebook(get_url_tienda($id_usuario), 1) .
                get_url_twitter(get_url_tienda($id_usuario), "VISITA MI TIENDA EN LÍNEA!", 1) .
                get_url_pinterest(get_url_tienda($id_usuario), 1) .
                get_url_tumblr(get_url_tienda($id_usuario), 1) .
                div("COMPARTIR ");


            $list = [
                li(
                    anchor_enid(icon("fa fa-address-book-o") . "CUENTA"
                        ,
                        [
                            "href" => "#tab_mis_datos",
                            "data-toggle" => "tab",
                            "id" => 'base_tab_agendados',
                            "class" => 'black  base_tab_agendados active'
                        ]
                    )
                ),

                li(anchor_enid(icon("fa  fa-fighter-jet") . "DIRECCIÓN DE ENVÍO",
                        [
                            "href" => "#tab_direccion",
                            "data-toggle" => "tab",
                            "id" => 'btn_direccion',
                            "class" => 'black  btn_direccion'

                        ]
                    )
                ),


                li(anchor_enid(icon("fa fa-unlock-alt") . "CONTRASEÑA", [
                        "href" => "#tab_privacidad",
                        "data-toggle" => "tab",
                        "id" => 'base_tab_privacidad',
                        "class" => 'black  base_tab_privacidad'
                    ])
                ),


                li(anchor_enid(
                        icon("fa fa-shield") . "PRIVACIDAD Y SEGURIDAD",
                        [
                            "href" => "#tab_privacidad_seguridad",
                            "data-toggle" => "tab",
                            "class" => 'black  tab_privacidad_seguridad'
                        ])
                ),


                li(icon("fa fa-gift", ["style" => "font-size:1.2em!important;"]) . anchor_enid("INTERESES Y PREFERENCIAS",
                        [
                            "class" => "btn_intereses",
                            "href" => "../lista_deseos/?q=preferencias"
                        ])
                ),


                li(icon("fa fa-credit-card-alt") . anchor_enid("TUS PRODUCTOS EN VENTA",
                        [
                            "class" => "btn_cuenta_personal",
                            "href" => "../search/?q3=" . $id_usuario . "&tienda=1"
                        ]
                    )
                ),

                li(div($final, ["class" => "contenedor_compartir_redes_sociales"]))

            ];

            return ul($list);
        }
    }
}

