<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('format_cuenta')) {
        function render_cuenta($data)
        {

            $id_usuario = $data["id_usuario"];
            $r[] = d(get_menu($id_usuario), 2);
            $r[] = d(format_cuenta($id_usuario, $data["usuario"]), 10);
            return append($r, "contenedor_principal_enid");

        }

    }

    if (!function_exists('format_cuenta')) {
        function format_cuenta($id_usuario, $usuario)
        {

            $r[] = d(get_format_foto_usuario($id_usuario, $usuario), ["class" => "tab-pane active", "id" => "tab_mis_datos"]);
            $r[] =
                d(
                    btw(

                        h("ACTUALIZAR DATOS DE ACCESO", 3)
                        ,
                        get_form_set_password()
                        ,
                        4,
                        1

                    )
                    ,
                    [
                        "class" => "tab-pane ",
                        "id" => "tab_privacidad"
                    ]
                );

            $r[] = d(get_format_privacidad_seguridad(), ["class" => "tab-pane ", "id" => "tab_privacidad_seguridad"]);
            $r[] = d(get_format_calma(), ["class" => "tab-pane ", "id" => "tab_direccion"]);
            return d(append($r), "tab-content");

        }
    }
    if (!function_exists('get_format_foto_usuario')) {
        function get_format_foto_usuario($id_usuario, $usuario)
        {

            $r[] = btw(
                get_format_perfil_usuario($id_usuario),
                place("place_form_img"),
                "col-lg-5 shadow padding_20"
            );
            $r[] = d(get_format_user($usuario), "page-header menu_info_usuario");
            $r[] = d("Mantén la calma esta información será solo será visible si tú lo permites ", 'registro_telefono_usuario_lada_negocio blue_enid3  white padding_1', 1);
            $x[] = d(append($r), 8);
            $x[] = d(get_format_resumen_cuenta($usuario), 4);
            return append($x);
        }
    }
    if (!function_exists('get_format_privacidad_seguridad')) {
        function get_format_privacidad_seguridad()
        {

            $x[] = h("INFORMACIÓN PERSONAL", 3);
            $x[] = hr();
            $x[] = place("place_registro_conceptos");
            $x[] = place("contenedor_conceptos_privacidad");
            $r[] = d(append($x), 7);
            $r[] = d(h("PRIVACIDAD Y SEGURIDAD", 3), 5);

            return append($r);
        }
    }

    if (!function_exists('get_format_calma')) {
        function get_format_calma()
        {


            $r[] = d(
                append(
                    [
                        h("MANTEN LA CALMA!", 3),
                        d("Tu dirección NO  se mostrará públicamente y solo podrán tener acceso a ella, personas que han comprado tus productos o las personas que te enviarán tus compras", 1),
                        hr(),
                        place("direcciones")
                    ]

                ), 7);


            $r[] = d(
                append(
                    [
                        h("DIRECCIÓN DE ENVÍO O RECEPCIÓN", 3),
                        d("El lugar donde compras o recibes tus compras o ventas", 1),
                        hr()
                    ]
                ),
                5
            );

            return append($r);

        }
    }
    if (!function_exists('get_format_perfil_usuario')) {

        function get_format_perfil_usuario($id_usuario)
        {


            $r[] = d(
                img(
                    [
                        "src" => path_enid("imagen_usuario", $id_usuario),
                        "onerror" => "this.src='../img_tema/user/user.png'"
                    ]
                ), "imagen_usuario_completa"
            );

            $r[] = btn("MODIFICAR", ["class" => "editar_imagen_perfil top_20"]);

            return append($r);

        }

    }

    if (!function_exists('get_format_resumen_cuenta')) {

        function get_format_resumen_cuenta($usuario)
        {

            $r[] = h("TU CUENTA ENID SERVICE", 3);
            $r[] = get_format_user($usuario, 1);
            $r[] = addNRow(d(get_campo($usuario, "email", ""), "top_20", 1));
            $r[] = addNRow(get_campo($usuario, "tel_contacto", "Tu prime apellido", 1));
            $r[] = anchor_enid(text_icon('fa  fa-fighter-jet', "MI DIRECCIÓN"),
                [
                    "class" => "a_enid_black btn_direccion top_20",
                    "href" => "#tab_direccion",
                    "data-toggle" => "tab"
                ],
                1,
                1);
            $r[] = hr();

            return append($r);

        }

    }
    if (!function_exists('get_form_set_password')) {
        function get_form_set_password()
        {

            $r[] = form_open("", ["id" => "form_update_password", "class" => "form-horizontal", "method" => "POST"]);
            $r[] = d("CONTRASEÑA ACTUAL", 1);
            $r[] = input(
                [
                    "name" => "password",
                    "id" => "password",
                    "class" => "form-control input-sm",
                    "type" => "password",
                    "required" => "true"
                ]);
            $r[] = place('place_pw_1');
            $r[] = d("NUEVA", 1);
            $r[] = input([
                "name" => "pw_nueva",
                "id" => "pw_nueva",
                "type" => "password",
                "class" => 'form-control input-sm',
                "required" => "true"
            ]);
            $r[] = place('place_pw_2');
            $r[] = d("CONFIRMAR NUEVA", 1);
            $r[] = input([
                "name" => "pw_nueva_confirm",
                "id" => "pw_nueva_confirm",
                "type" => "password",
                "class" => "form-control input-sm",
                "required" => "true"
            ]);
            $r[] = input_hidden(["name" => "secret", "id" => "secret"]);
            $r[] = place('place_pw_3');
            $r[] = d("", ["id" => "reportesession", "class" => "reportesession"]);
            $r[] = btn("Actualizar", ["id" => "inbutton", "class" => "btn btn_save input-sm"]);
            $r[] = form_close(place("msj_password"));

            return append($r);
        }

    }

    if (!function_exists('get_format_user')) {

        function get_format_user($usuario, $vista = 0)
        {

            $r = [];
            if ($vista < 1) {

                $r[] = h("Cuenta", 1, 'strong', 1);
                $r[] = addNRow(get_form_nombre($usuario));
                $r[] = addNRow(get_form_email($usuario));
                $r[] = addNRow(d(get_form_telefono($usuario), "row"));
                $r[] = addNRow(d(get_form_negocio($usuario), "row"));

            } else {

                $r[] = get_campo($usuario, "nombre", "Tu Nombre");
                $r[] = get_campo($usuario, "apellido_paterno", "Tu prime apellido");
                $r[] = get_campo($usuario, "apellido_materno", "Tu prime apellido");

            }
            return append($r);

        }
    }
    if (!function_exists('get_form_negocio')) {

        function get_form_negocio($usuario)
        {

            $r[] = form_open("", ["class" => "f_telefono_usuario_negocio"]);
            $r[] = d("Teléfono de negocio", "col-lg-3 strong");
            $r[] = btw(
                input(
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
                2

            );


            $r[] = btw(
                input(
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

                5
            );

            $r[] = d(btn("Actualizar", ["class" => "input_enid"]), 2);
            $r[] = form_close();
            return append($r);

        }
    }
    if (!function_exists('get_form_telefono')) {
        function get_form_telefono($usuario)
        {

            $r = [];
            $r[] = d("Teléfon Movil1", 3);
            $r[] = btw(
                input(
                    [
                        "id" => "lada",
                        "name" => "lada",
                        "placeholder" => "Lada",
                        "class" => "form-control input-sm input_enid lada ",
                        "required" => "",
                        "type" => "text",
                        "maxlength" => "3",
                        "minlength" => "2",
                        "value" => get_campo($usuario, 'tel_lada')
                    ]
                )
                ,
                place("registro_telefono_usuario_lada")
                ,
                2

            );

            $r[] = btw(
                input([
                    "id" => "telefono",
                    "name" => "tel_contacto",
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
                5
            );
            $r[] = btn("Actualizar", ["class" => "input_enid"], 2);


            $response = form_open("", ["class" => "form_telefono_usuario"]) . append($r) . form_close();
            return $response;

        }
    }
    if (!function_exists('get_form_email')) {
        function get_form_email($usuario)
        {

            $r[] = form_open("");
            $r[] = d('Correo electrónico', 'strong', 1);
            $r[] = input(
                [
                    "id" => "correo_electronico",
                    "name" => "correo_electronico",
                    "placeholder" => "El correo electrónico no se mostrará públicamente",
                    "class" => "form-control input-sm input_enid correo_electronico",
                    "required" => "",
                    "type" => "text",
                    "value" => get_campo($usuario, 'email'),
                    "readonly" => true
                ]);

            $r[] = d('El correo electrónico NO se mostrará públicamente', 'blue_enid ', 1);
            $r[] = form_close();
            return append($r);


        }
    }
    if (!function_exists('get_form_nombre')) {
        function get_form_nombre($usuario)
        {

            $r[] = form_open("", ["class" => "f_nombre_usuario"]);
            $r[] = d('Nombre de usuario', 'strong', 1);
            $r[] = input(
                [
                    "id" => "nombre_usuario",
                    "name" => "nombre_usuario",
                    "placeholder" => "Nombre por cual te indentifican clientes y vendedores",
                    "class" => "form-control input-sm input_enid nombre_usuario",
                    "required" => true,
                    "type" => "text",
                    "value" => get_campo($usuario, 'nombre_usuario'),
                    "maxlength" => "15"
                ]
            );
            $r[] = place("registro_nombre_usuario");
            $r[] = form_close();

            return append($r);

        }
    }
    if (!function_exists('get_menu')) {
        function get_menu($id_usuario)
        {

            $f[] = get_url_facebook(get_url_tienda($id_usuario), 1);
            $f[] = get_url_twitter(get_url_tienda($id_usuario), "VISITA MI TIENDA EN LÍNEA!", 1);
            $f[] = get_url_pinterest(get_url_tienda($id_usuario), 1);
            $f[] = get_url_tumblr(get_url_tienda($id_usuario), 1);
            $f[] = d("COMPARTIR ");
            $final = append($f);

            $list = [
                li(
                    anchor_enid(
                        text_icon("fa fa-address-book-o", "CUENTA")

                        ,
                        [
                            "href" => "#tab_mis_datos",
                            "data-toggle" => "tab",
                            "id" => 'base_tab_agendados',
                            "class" => 'black  base_tab_agendados active'
                        ]
                    )
                ),

                li(anchor_enid(
                        text_icon("fa  fa-fighter-jet", "DIRECCIÓN DE ENVÍO")
                        ,
                        [
                            "href" => "#tab_direccion",
                            "data-toggle" => "tab",
                            "id" => 'btn_direccion',
                            "class" => 'black  btn_direccion'

                        ]
                    )
                ),


                li(anchor_enid(
                        text_icon("fa fa-unlock-alt", "CONTRASEÑA")
                        ,
                        [
                            "href" => "#tab_privacidad",
                            "data-toggle" => "tab",
                            "id" => 'base_tab_privacidad',
                            "class" => 'black  base_tab_privacidad'
                        ])
                ),


                li(anchor_enid(

                        text_icon("fa fa-shield", "PRIVACIDAD Y SEGURIDAD"),
                        [
                            "href" => "#tab_privacidad_seguridad",
                            "data-toggle" => "tab",
                            "class" => 'black  tab_privacidad_seguridad'
                        ])
                ),


                li(icon("fa fa-gift f12 ") . anchor_enid(
                        "INTERESES Y PREFERENCIAS",
                        [
                            "class" => "btn_intereses",
                            "href" => "../lista_deseos/?q=preferencias"
                        ])
                ),


                li(

                    text_icon("fa fa-credit-card-alt", anchor_enid("TUS PRODUCTOS EN VENTA",
                        [
                            "class" => "btn_cuenta_personal",
                            "href" => "../search/?q3=" . $id_usuario . "&tienda=1"
                        ]
                    ))
                ),

                li(d($final, "contenedor_compartir_redes_sociales"))

            ];

            return ul($list);
        }
    }
}

