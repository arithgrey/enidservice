<?php

function render_cuenta($data)
{

    $id_usuario = $data["id_usuario"];
    $response[] = menu($id_usuario);
    $response[] = format_cuenta($data["usuario"]);
    return append($response);
}

function format_cuenta($usuario)
{

    $r[] = tab_seccion(
        foto($usuario),
        'tab_mis_datos',
        1

    );

    $seccion[] = d(_titulo("actualizar datos de acceso",2),8,1);
    $seccion[] = d(frm_pw(),8,1);
    $actualizar = d($seccion, 'col-md-8 col-md-offset-2 p-0');


    $r[] = tab_seccion($actualizar, 'tab_privacidad');
    $r[] = tab_seccion(privacidad(), 'tab_privacidad_seguridad');
    $r[] = tab_seccion(orden_productos($usuario), 'tab_orden_productos');

    return d(tab_content($r), _10_12);
}

function orden_productos($usuario)
{


    $orden_producto = pr($usuario, "orden_producto");
    $id_empresa = pr($usuario, "id_empresa");
    $lista_orden = list_orden(get_orden(), $orden_producto);
    $texto = _titulo("Filtro principal", 5);
    $lista = flex($texto, $lista_orden, _between, "mr-3");
    $boton_cambio = btn("Modificar");

    $response[] = d(_titulo("Ordena los artículos según tus intereses"));
    $leyenda = "Con esto cada que consultes los artículos en sección principal, se listarán según tus criterios";
    $response[] = d(p($leyenda), 'mb-5');
    $response[] = form_open(
        "",
        [
            "class" => "form_orden_productos",
            "method" => "post"
        ]
    );
    $response[] = hiddens(["name" => "id_empresa", "value" => $id_empresa]);
    $response[] = flex($lista, $boton_cambio, _between);
    $response[] = form_close();

    return d($response, 8, 1);
}


function eleccion_seleccion($titulo, $reparto_auto, $a, $b, $c, $ext = '')
{

    $response[] = _titulo($titulo);
    $contenido = [$reparto_auto, $a, $b, $c];
    $response[] = d($contenido, _text_('d-flex mt-5 justify-content-between ', $ext));
    return d($response);
}

function foto($usuario)
{

    $perfil[] = perfil_usuario($usuario);
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



function perfil_usuario($usuario)
{

    $url_img_usuario = pr($usuario, "url_img_usuario");
    $r[] = d(
        img(
            [
                "src" => $url_img_usuario,
                "onerror" => "this.src='../img_tema/user/user.png'",
                'class' => 'px-auto mt-4'
            ]
        ),
        "imagen_usuario_completa text-center col-lg-12"
    );

    $r[] = d(
        btn(
            "modificar",
            [
                "class" => "editar_imagen_perfil"
            ]
        ),
        'mt-4 mb-4 col-lg-12'
    );

    return d($r, 'border row p-4');
}


function resumen_cuenta($usuario)
{

    $response[] = _titulo("tu cuenta");
    $response[] = d(format_user($usuario, 1), 'mt-5');
    $response[] = d(get_campo($usuario, "email"));
    $response[] = d(get_campo($usuario, "name"));
    $response[] = d(get_campo($usuario, "apellido_paterno"));
    $response[] = d(get_campo($usuario, "apellido_materno"));
    $response[] = d(get_campo($usuario, "tel_contacto"));


    return append($response);
}

function frm_pw()
{
    $response[] = form_open(
        "",
        [
            "id" => "form_password",
            "class" => "form_password",
            "method" => "POST"
        ]
    );

    $r[] = input_enid(
        
        
        [
            "name" => "password",
            "id" => "password",
            "class" => "pw",
            "type" => "password",
            "required" => "true",
            "placeholder" => 'Ingresa tu contraseña actual'
        ],
        _text_password
    );

    $r[] = input_enid(
        
        [
            "name" => "pw_nueva",
            "id" => "pw_nueva",
            "type" => "password",
            "class" => 'pw_nueva',
            "required" => true,
            "placeholder" => "Registra una nueva contraseña"
        ],
        _text_password

    );

    $r[] = input_enid(
        
        [
            "name" => "pw_nueva_confirm",
            "id" => "pw_nueva_confirm",
            "type" => "password",
            "class" => "pw_confirmacion",
            "required" => true,
            "placeholder" => "Escribe de nuevo la contraseña"
        ],
        _text_password
    );

    $r[] = hiddens(
        [
            "name" => "secret",
            "id" => "secret"
        ]
    );

    $r[] = btn("Actualizar");
    $response[] = d_c($r, 'mt-5');
    $response[] = form_close(place("msj_password"));

    return append($response);
}


function format_user($usuario, $vista = 0)
{

    $r = [];
    if ($vista < 1) {

        $r[] = _titulo("SOBRE TI");
        $r[] = frm_nombre($usuario);
        $r[] = frm_email($usuario);
        $r[] = frm_telefono($usuario);
    } else {

        $r[] = get_campo($usuario, "name", "Tu Nombre");
        $r[] = get_campo($usuario, "apellido_paterno", "Tu prime apellido");
        $r[] = get_campo($usuario, "apellido_materno", "Tu prime apellido");
    }
    return d_row(d_c($r, 'col-md-12 mt-5'));
}

function frm_negocio($usuario)
{

    $r[] = form_open(
        "",
        [
            "class" => "f_telefono_usuario_negocio"
        ]
    );
    $input[] = input_frm(
        '',
        "Teléfono de negocio",
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

    $input[] = input_frm(
        '',
        "Teléfono de negocio",

        [
            'name' => 'telefono_negocio',
            'id' => 'telefono',
            'value' => pr($usuario, 'tel_contacto_alterno'),
            'maxlength' => '13',
            'minlength' => '8',
            'class' => 'form-control input-sm input_enid telefono telefono_info_contacto_negocio tel2',
            'placeholder' => "El teléfono de tu negocio",
            'type' => "text"
        ],
        'registro_telefono_usuario_negocio'

    );

    $input[] = d(btn("Actualizar"), '');
    $r[] = flex_md($input, _text_(_between, 'mt-5 row'));
    $r[] = form_close();
    return d($r, 13);
}

function frm_telefono($usuario)
{
    $input = input_frm(
        '',
        "Teléfono",
        [
            "id" => "telefono_usuario",
            "name" => "tel_contacto",
            "placeholder" => "Teléfono",
            "class" => "telefono ",
            "required" => true,
            "type" => "text",
            "maxlength" => 10,
            "minlength" => 8,
            "value" => pr($usuario, 'tel_contacto')
        ],
        _text_telefono

    );


    $form[] = form_open("", ["class" => "form_telefono_usuario"]);
    $form[] = $input;
    $form[] = d(btn(''), 'd-none');
    $form[] = form_close();
    return append($form);
}

function frm_email($usuario)
{

    $r[] = form_open("");
    $r[] = input_frm(
        '',
        'email',
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
    return append($r);
}

function frm_nombre($usuario)
{

    $r[] = form_open(
        "",
        [
            "class" => "form_nombre_usuario"
        ]
    );
    $r[] = input_frm(
        '',
        'Nombre',
        [
            "id" => "nombre_usuario",
            "name" => "nombre",
            "placeholder" => "Tu nombre",
            "class" => "nombre_usuario",
            "required" => true,
            "type" => "text",
            "value" => pr($usuario, 'name'),
            "maxlength" => 30
        ],
        _text_nombre
    );
    $r[] = form_close();
    return append($r);
}

function menu($id_usuario)
{

    $separacion = 'ml-3';
    $iconos[] = d(get_url_facebook(get_url_tienda($id_usuario), 1));
    $iconos[] = d(get_url_twitter(get_url_tienda($id_usuario), "VISITA MI TIENDA EN LÍNEA!", 1), $separacion);
    $iconos[] = d(get_url_pinterest(get_url_tienda($id_usuario), 1), $separacion);


    $link_cuenta = tab(
        text_icon("fa fa-address-book-o", "CUENTA"),
        '#tab_mis_datos',
        [
            "id" => '',
            "class" => 'active'
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


    $link_orden_productos = tab(
        text_icon("fa fa-shield", "Ordenar productos"),
        '#tab_orden_productos',
        [
            "class" => 'tab_orden_productos'
        ]
    );
    $link_preferencias = a_enid(
        text_icon('fa fa-gift', 'INTERESES Y PREFERENCIAS'),
        [
            'href' => path_enid('lista_deseos_preferencias'),
        ]
    );

    $list = [
        $link_cuenta,
        $link_orden_productos,

        $link_pw,
        $link_preferencias,


    ];

    return ul($list, _text_(_2_12, 'mt-5 mb-5 menu '));
}
