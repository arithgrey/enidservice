<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_cuenta($data)
    {

        $id_usuario = $data["id_usuario"];
        return hrz(
            menu($id_usuario),
            format_cuenta($id_usuario, $data["usuario"]),
            2,
            "contenedor_principal_enid"
        );
    }

    function format_cuenta($id_usuario, $usuario)
    {

        $r[] = tab_seccion(
            foto($id_usuario, $usuario),
            'tab_mis_datos',
            1

        );
        $actualizar = btw(

            h("ACTUALIZAR DATOS DE ACCESO", 3)
            ,
            frm_pw()
            ,
            4,
            1

        );


        $r[] = tab_seccion($actualizar, 'tab_privacidad');
        $r[] = tab_seccion(privacidad(), 'tab_privacidad_seguridad');
        $r[] = tab_seccion(calma(), 'tab_direccion');
        return d(append($r), "tab-content");

    }


    function foto($id_usuario, $usuario)
    {

        $r[] = btw(
            perfil_usuario($id_usuario),
            place("place_form_img"),
            "col-lg-5 shadow padding_20"
        );
        $r[] = d(format_user($usuario), "page-header menu_info_usuario");
        $r[] = d("Mantén la calma esta información será solo será visible si tú lo permites ",
            'registro_telefono_usuario_lada_negocio blue_enid3  white padding_1'
        );
        return hrz(append($r), resumen_cuenta($usuario), 4);

    }

    function privacidad()
    {

        $x[] = h("INFORMACIÓN PERSONAL", 3);
        $x[] = place("place_registro_conceptos");
        $x[] = place("contenedor_conceptos_privacidad");
        $r[] = d(append($x), 7);
        $r[] = d(h("PRIVACIDAD Y SEGURIDAD", 3), 5);

        return append($r);
    }


    function calma()
    {


        $calma = _text(
            h("MANTEN LA CALMA!", 3),
            d("Tu dirección NO  se mostrará públicamente y solo 
            podrán tener acceso a ella, personas que han comprado tus productos o 
            las personas que te enviarán tus compras", 1),
            hr(),
            place("direcciones")
        );


        $direccion_envio = _text(
            h("DIRECCIÓN DE ENVÍO O RECEPCIÓN", 3),
            d("El lugar donde compras o recibes tus compras o ventas"),
            hr()
        );

        return dd($calma, $direccion_envio, 7);

    }


    function perfil_usuario($id_usuario)
    {


        $r[] = d(
            img(
                [
                    "src" => path_enid("imagen_usuario", $id_usuario),
                    "onerror" => "this.src='../img_tema/user/user.png'"
                ]
            ), "imagen_usuario_completa"
        );

        $r[] = btn(
            "MODIFICAR",
            [
                "class" => "editar_imagen_perfil top_20"
            ]
        );

        return append($r);

    }


    function resumen_cuenta($usuario)
    {

        $r[] = h("TU CUENTA ENID SERVICE", 3);
        $r[] = format_user($usuario, 1);
        $r[] = d(get_campo($usuario, "email"));
        $r[] = get_campo($usuario, "tel_contacto", "Tu prime apellido", 1);

        $r[] = tab(
            text_icon('fa  fa-fighter-jet', "MI DIRECCIÓN"),
            "#tab_direccion",
            [
                "class" => "a_enid_black btn_direccion top_20",
            ]
        );

        $r[] = hr();
        return append($r);

    }

    function frm_pw()
    {

        $r[] = form_open("",
            [
                "id" => "form_update_password",
                "class" => "form-horizontal", "method" => "POST"
            ]
        );


        $r[] = input_frm(12,
            "CONTRASEÑA ACTUAL",
            [
                "name" => "password",
                "id" => "password",
                "class" => "form-control input-sm",
                "type" => "password",
                "required" => "true"
            ],
            'place_pw_1'
        );

        $r[] = input_frm(
            12,
            "NUEVA",
            [
                "name" => "pw_nueva",
                "id" => "pw_nueva",
                "type" => "password",
                "class" => 'form-control input-sm',
                "required" => "true"
            ]
            , 'place_pw_2'

        );


        $r[] = input_frm(
            12, "CONFIRMAR NUEVA",
            [
                "name" => "pw_nueva_confirm",
                "id" => "pw_nueva_confirm",
                "type" => "password",
                "class" => "form-control input-sm",
                "required" => "true"
            ],
            'place_pw_3'
        );


        $r[] = hiddens(
            [
                "name" => "secret",
                "id" => "secret"
            ]
        );

        $r[] = place("reportesession");
        $r[] = btn("Actualizar",
            [
                "id" => "inbutton", "class" => "btn btn_save input-sm"
            ]
        );
        $r[] = form_close(place("msj_password"));

        return append($r);
    }


    function format_user($usuario, $vista = 0)
    {

        $r = [];
        if ($vista < 1) {

            $r[] = h("Cuenta", 1, 'strong');
            $r[] = frm_nombre($usuario);
            $r[] = frm_email($usuario);
            $r[] = d(frm_telefono($usuario));
            $r[] = d(frm_negocio($usuario));

        } else {

            $r[] = get_campo($usuario, "nombre", "Tu Nombre");
            $r[] = get_campo($usuario, "apellido_paterno", "Tu prime apellido");
            $r[] = get_campo($usuario, "apellido_materno", "Tu prime apellido");

        }
        return append($r);

    }

    function frm_negocio($usuario)
    {

        $r[] = form_open("",
            [
                "class" => "f_telefono_usuario_negocio"
            ]
        );
        $r[] = input_frm(3, "Teléfono de negocio",
            [
                'name' => 'lada_negocio',
                'id' => 'lada',
                'value' => pr($usuario, 'lada_negocio'),
                'maxlength' => '3',
                'minlength' => '2',
                'class' => 'form-control input-sm input_enid lada_negocio lada2',
                'placeholder' => "Lada",
                'type' => "text"

            ],
            "registro_telefono_usuario_lada_negocio"
        );

        $r[] = input_frm(5, "Teléfono de negocio",

            [
                'name' => 'telefono_negocio',
                'id' => 'telefono',
                'value' => pr($usuario, 'tel_contacto_alterno'),
                'maxlength' => '13',
                'minlength' => '8',
                'class' => 'form-control input-sm input_enid telefono telefono_info_contacto_negocio tel2',
                'placeholder' => "El teléfono de tu negocio",
                'type' => "text"
            ], 'registro_telefono_usuario_negocio'

        );

        $r[] = d(btn("Actualizar", ["class" => "input_enid"]), 2);
        $r[] = form_close();
        return append($r);

    }

    function frm_telefono($usuario)
    {

        $r = [];

        $r[] = input_frm(
            3,
            "Teléfon Movil1",
            [
                "id" => "lada",
                "name" => "lada",
                "placeholder" => "Lada",
                "class" => "form-control input-sm input_enid lada ",
                "required" => "",
                "type" => "text",
                "maxlength" => "3",
                "minlength" => "2",
                "value" => pr($usuario, 'tel_lada')
            ]
            , 'registro_telefono_usuario_lada'

        );


        $r[] = input_frm(5, "Teléfono",
            [
                "id" => "telefono",
                "name" => "tel_contacto",
                "placeholder" => "Teléfono",
                "class" => "form-control input-sm input_enid telefono ",
                "required" => true,
                "type" => "text",
                "maxlength" => "13",
                "minlength" => "8",
                "value" => pr($usuario, 'tel_contacto')
            ], 'registro_telefono_usuario'

        );

        $r[] = btn("Actualizar", ["class" => "input_enid"], 2);

        $form[] = form_open("", ["class" => "form_telefono_usuario"]);
        $form[] = append($r);
        $form[] = form_close();
        return append($form);


    }

    function frm_email($usuario)
    {

        $r[] = form_open("");
        $r[] = input_frm(12, 'Correo electrónico',
            [
                "id" => "correo_electronico",
                "name" => "correo_electronico",
                "placeholder" => "El correo electrónico no se mostrará públicamente",
                "class" => "form-control input-sm input_enid correo_electronico",
                "required" => "",
                "type" => "text",
                "value" => pr($usuario, 'email'),
                "readonly" => true
            ]

        );
        $r[] = d('El correo electrónico NO se mostrará públicamente');
        $r[] = form_close();
        return append($r);


    }

    function frm_nombre($usuario)
    {

        $r[] = form_open("",
            [
                "class" => "f_nombre_usuario"
            ]
        );
        $r[] = input_frm(12, 'Nombre de usuario',
            [
                "id" => "nombre_usuario",
                "name" => "nombre_usuario",
                "placeholder" => "Nombre por cual te indentifican clientes y vendedores",
                "class" => "form-control input-sm input_enid nombre_usuario",
                "required" => true,
                "type" => "text",
                "value" => pr($usuario, 'nombre_usuario'),
                "maxlength" => "15"
            ], "registro_nombre_usuario"
        );
        $r[] = form_close();
        return append($r);

    }

    function menu($id_usuario)
    {

        $f[] = get_url_facebook(get_url_tienda($id_usuario), 1);
        $f[] = get_url_twitter(get_url_tienda($id_usuario), "VISITA MI TIENDA EN LÍNEA!", 1);
        $f[] = get_url_pinterest(get_url_tienda($id_usuario), 1);
        $f[] = d("COMPARTIR ");
        $final = append($f);

        $link_cuenta = tab(
            text_icon("fa fa-address-book-o", "CUENTA"),
            '#tab_mis_datos',
            [
                "id" => 'base_tab_agendados',
                "class" => 'black  base_tab_agendados active'
            ]
        );
        $link_direccion_envio = tab(
            text_icon("fa  fa-fighter-jet", "DIRECCIÓN DE ENVÍO"),
            '#tab_direccion',
            [
                "id" => 'btn_direccion',
                "class" => 'black  btn_direccion'
            ]

        );
        $link_pw = tab(
            text_icon("fa fa-unlock-alt", "CONTRASEÑA"),
            "#tab_privacidad",
            [
                "id" => 'base_tab_privacidad',
                "class" => 'black  base_tab_privacidad'
            ]

        );
        $link_privacidad = tab(
            text_icon("fa fa-shield", "PRIVACIDAD Y SEGURIDAD"),
            '#tab_privacidad_seguridad',
            [
                "class" => 'black  tab_privacidad_seguridad'
            ]


        );
        $link_preferencias = a_enid(
            text_icon('fa fa-gift f12', 'INTERESES Y PREFERENCIAS'),
            path_enid('lista_deseos_preferencias')

        );
        $link_productos_venta = a_enid(
            text_icon('fa fa-credit-card-alt', 'TUS PRODUCTOS EN VENTA'),
            "../search/?q3=" . $id_usuario . "&tienda=1"

        );


        $list = [
            $link_cuenta
            ,
            $link_direccion_envio
            ,
            $link_pw
            ,
            $link_privacidad
            ,
            $link_preferencias
            ,
            $link_productos_venta
            ,
            $final

        ];

        return ul($list);
    }

}

