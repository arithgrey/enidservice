<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_cuenta($data)
    {

        $id_usuario = $data["id_usuario"];
        $response[] = menu($id_usuario);
        $response[] = format_cuenta($id_usuario, $data["usuario"]);
        return append($response);

    }

    function format_cuenta($id_usuario, $usuario)
    {

        $r[] = tab_seccion(
            foto($id_usuario, $usuario),
            'tab_mis_datos',
            1

        );

        $seccion[] = _titulo("actualizar datos de acceso");
        $seccion[] = frm_pw();
        $actualizar = d($seccion,'col-md-8 col-md-offset-2 p-0');


        $r[] = tab_seccion($actualizar, 'tab_privacidad');
        $r[] = tab_seccion(privacidad(), 'tab_privacidad_seguridad');
        $r[] = tab_seccion(calma(), 'tab_direccion');

        return d(tab_content($r), _10_12);

    }

    function foto($id_usuario, $usuario)
    {

        $perfil[] = perfil_usuario($id_usuario);
        $perfil[] = place("place_form_img");
        $r[] = d_row(d($perfil, 8, 1));

        $r[] = d(d(format_user($usuario), "page-header menu_info_usuario col-sm-12"), 13);

        $response[] = d($r, 7);
        $response[] = d(resumen_cuenta($usuario), _5p);
        return append($response);

    }

    function privacidad()
    {

        $x[] = _titulo("INFORMACIÓN PERSONAL");
        $x[] = place("place_registro_conceptos");
        $x[] = place("contenedor_conceptos_privacidad");
        return d_row(dd($x, _titulo("PRIVACIDAD Y SEGURIDAD"), 5));

    }

    function calma()
    {

        $str = d("Tu dirección NO  se mostrará públicamente y solo podrán tener 
        acceso a ella, personas que han comprado tus productos o las personas que 
        te enviarán tus compras");

        $calma = _text_(
            _titulo("manten la calma!")
            ,
            $str
            ,
            hr()
            ,
            place("direcciones")
        );


        $direccion_envio = _text(
            _titulo("DIRECCIÓN DE ENVÍO O RECEPCIÓN"),
            d("El lugar donde compras o recibes tus compras o ventas"),
            hr()
        );
        $direccion_envio = d($direccion_envio, 'mt-5 mt-md-0');


        return d_row(dd($calma, $direccion_envio, 7));

    }

    function perfil_usuario($id_usuario)
    {

        $r[] = d(
            img(
                [
                    "src" => path_enid("imagen_usuario", $id_usuario),
                    "onerror" => "this.src='../img_tema/user/user.png'",
                    'class' => 'px-auto mt-4'
                ]
            ), "imagen_usuario_completa text-center col-lg-12"
        );

        $r[] = d(
            btn(
                "modificar",
                [
                    "class" => "editar_imagen_perfil"
                ]
            ), 'mt-4 mb-4 col-lg-12'
        );

        return d($r, 'border row p-4');

    }


    function resumen_cuenta($usuario)
    {

        $response[] = _titulo("tu cuenta");
        $response[] = d(format_user($usuario, 1), 'mt-5');
        $response[] = d(get_campo($usuario, "email"));
        $response[] = d(get_campo($usuario, "nombre"));
        $response[] = d(get_campo($usuario, "apellido_paterno"));
        $response[] = d(get_campo($usuario, "apellido_materno"));
        $response[] = d(get_campo($usuario, "tel_contacto"));

        $boton = btn(text_icon('fa  fa-fighter-jet', "MI DIRECCIÓN"));
        $response[] = tab(
            $boton,
            "#tab_direccion",
            [
                "class" => "btn_direccion mt-5",
            ]
        );

        return append($response);

    }

    function frm_pw()
    {

        $r[] = form_open("",
            [
                "id" => "form_update_password",
                "class" => "form-horizontal mt-5",
                "method" => "POST"
            ]
        );

        $r[] = input_frm('',
            "Contraseña actual",
            [
                "name" => "password",
                "id" => "password",
                "class" => "pw",
                "type" => "password",
                "required" => "true"
            ],
            'place_pw_1'
        );

        $r[] = input_frm(
            'mt-5',
            "Nueva contraseña",
            [
                "name" => "pw_nueva",
                "id" => "pw_nueva",
                "type" => "password",
                "class" => 'pw_nueva',
                "required" => true
            ]
            , 'place_pw_2'

        );

        $r[] = input_frm(
            'mt-5', "Confirmar",
            [
                "name" => "pw_nueva_confirm",
                "id" => "pw_nueva_confirm",
                "type" => "password",
                "class" => "pw_confirmacion",
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
                "id" => "inbutton",
                "class" => "btn_save mt-5"
            ]
        );
        $r[] = form_close(place("msj_password"));

        return append($r);
    }


    function format_user($usuario, $vista = 0)
    {

        $r = [];
        if ($vista < 1) {

            $r[] = d(d(_titulo("SOBRE TI"), _12p), 'row mt-5 mb-5');
            $r[] = frm_nombre($usuario);
            $r[] = frm_email($usuario);
            $r[] = frm_telefono($usuario);


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
        $input[] = input_frm('', "Teléfono de negocio",
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

        $input[] = input_frm('', "Teléfono de negocio",

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

        $input[] = d(btn("Actualizar"), '');
        $r[] = flex_md($input, _text_(_between, 'mt-5 row'));
        $r[] = form_close();
        return d($r, 13);

    }

    function frm_telefono($usuario)
    {
        $r[] = d(input_frm(
            '',
            "Lada",
            [
                "id" => "lada",
                "name" => "lada",
                "placeholder" => "Lada",
                "class" => "lada ",
                "required" => true,
                "type" => "text",
                "maxlength" => "3",
                "minlength" => "2",
                "value" => pr($usuario, 'tel_lada')
            ]
            , 'registro_telefono_usuario_lada'

        ), 'col-md-3 mb-5');


        $r[] = d(input_frm('', "Teléfono",
            [
                "id" => "telefono",
                "name" => "tel_contacto",
                "placeholder" => "Teléfono",
                "class" => "telefono ",
                "required" => true,
                "type" => "text",
                "maxlength" => "13",
                "minlength" => "8",
                "value" => pr($usuario, 'tel_contacto')
            ], 'registro_telefono_usuario'

        ), 'col-md-5  mb-5');

        $r[] = d(btn("Actualizar"), 'col');

        $form[] = form_open("", ["class" => "form_telefono_usuario row"]);
        $form[] = flex_md($r, 'row');
        $form[] = form_close();
        return d($form, 'mt-4 mb-4');


    }

    function frm_email($usuario)
    {

        $r[] = form_open("");
        $r[] = input_frm('', 'Correo electrónico',
            [
                "id" => "correo_electronico",
                "name" => "correo_electronico",
                "placeholder" => "El correo electrónico no se mostrará públicamente",
                "class" => "correo_electronico",
                "required" => "",
                "type" => "text",
                "value" => pr($usuario, 'email'),
                "readonly" => true
            ]

        );

        $r[] = form_close();
        $response[] = d(d($r, _12p), 'row mt-5 mb-3');
        $response[] = d(d('El correo electrónico NO se mostrará públicamente', _12p), 'row mb-5');
        return append($response);


    }

    function frm_nombre($usuario)
    {

        $r[] = form_open("",
            [
                "class" => "form_nombre_usuario"
            ]
        );
        $r[] = input_frm('', 'Nombre de usuario',
            [
                "id" => "nombre_usuario",
                "name" => "nombre_usuario",
                "placeholder" => "Nombre por cual te indentifican clientes y vendedores",
                "class" => "nombre_usuario",
                "required" => true,
                "type" => "text",
                "value" => pr($usuario, 'nombre_usuario'),
                "maxlength" => 30
            ], "registro_nombre_usuario"
        );
        $r[] = form_close();
        return d(d($r, _12p), 'row mt-5 mb-5');

    }

    function menu($id_usuario)
    {

        $separacion = 'ml-3';
        $iconos[] = d(get_url_facebook(get_url_tienda($id_usuario), 1));
        $iconos[] = d(get_url_twitter(get_url_tienda($id_usuario), "VISITA MI TIENDA EN LÍNEA!", 1), $separacion);
        $iconos[] = d(get_url_pinterest(get_url_tienda($id_usuario), 1), $separacion);
        $final = flex($iconos);

        $link_cuenta = tab(
            text_icon("fa fa-address-book-o", "CUENTA"),
            '#tab_mis_datos',
            [
                "id" => '',
                "class" => 'active'
            ]
        );
        $link_direccion_envio = tab(
            text_icon("fa  fa-fighter-jet", "DIRECCIÓN DE ENVÍO"),
            '#tab_direccion',
            [
                "id" => 'btn_direccion',
                "class" => 'btn_direccion'
            ]

        );
        $link_pw = tab(
            text_icon("fa fa-unlock-alt", "CONTRASEÑA"),
            "#tab_privacidad",
            [
                "id" => 'base_tab_privacidad',
                "class" => '  base_tab_privacidad'
            ]
        );
        $link_privacidad = tab(
            text_icon("fa fa-shield", "PRIVACIDAD "),
            '#tab_privacidad_seguridad',
            [
                "class" => 'tab_privacidad_seguridad'
            ]
        );
        $link_preferencias = a_enid(
            text_icon('fa fa-gift', 'INTERESES Y PREFERENCIAS'),
            [
                'href' => path_enid('lista_deseos_preferencias'),
                'class' => 'text-right'
            ]

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
            $final

        ];

        return ul($list, _text_(_2_12, 'mt-5 mb-5 menu '));
    }

}
