<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function page_sigin($action)
    {

        $r[] = nuevo_usuario();
        $r[] = recuperacion();
        $r[] = frm_acceso($action);
        $r[] = hiddens(
            [
                "class" => "action",
                "value" => $action,
            ],
            1
        );

        return d($r, 4, 1);

    }

    function frm_acceso($action)
    {
        $r[] = img_default();
        $r[] = frm_login();
        if ($action === "registro") {

            $clases = "inf_usuario_registrado strong mt-5 bg-light p-2 text-right";
            $r[] = d("Tu usuario fué registrado, accede ahora!", $clases);
        }
        $r[] = place("place_acceso_sistema mt-5 mb-5");
        $x[] = a_enid("¿ERES NUEVO?   REGISTRATE!", ["class" => 'strong black registrar_cuenta f16 strong mt-1']);
        $x[] = a_enid(
            "¿OLVIDASTE TU CONTRASEÑA?",
            [
                "id" => "olvide-pass",
                "class" => "recupara-pass  olvide_pass top_30 underline",
            ]
        );
        $r[] = append($x);

        return d($r, " wrapper_login mt-5");

    }

    function img_default()
    {
        return
            d(
                a_enid(
                    img_enid(
                        [
                            "class" => "w-75"
                        ]
                    ),

                    path_enid("home")

                ), "text-center"
            );
    }

    function recuperacion()
    {

        $r[] = img_default();
        $r[] = h('RECUPERA TUS DATOS DE ACCESO', 3);
        $r[] = _text("<form class='form-pass' id='form-pass' action='", url_recuperacion_password(), "'>");
        $r[] = input(
            [
                "type" => "email",
                "id" => "email_recuperacion",
                "name" => 'mail',
                "placeholder" => "Email",
                "class" => "mt-3",
                "required" => true,
            ]
        );
        $r[] = d("Ingresa tu correo electrónico y tu contraseña será enviada", 'mt-4');
        $r[] = btn("Enviar",
            [
                "class" => "btn_nnuevo recupera_password  a_enid_blue top_20",
            ]
        );
        $extra = _text_(place("place_recuperacion_pw"), place("recuperacion_pw"));
        $r[] = form_close($extra);
        $r[] = ya_registro();

        return d($r, "contenedor_recuperacion_password display_none");

    }

    function ya_registro()
    {

        return d(
            a_enid("¿YA ESTÁS REGISTRADO? ACCEDE!",
                [
                    'class' => 'top_50 black bottom_100 strong f16 btn_acceder_cuenta_enid',
                ]
            ),
            "text-center"
        );
    }

    function nuevo_usuario()
    {

        $r[] = img_default();
        $r[] = _titulo('ÚNETE');
        $r[] = frm_registro();
        $r[] = ya_registro();

        return d($r, "seccion_registro_nuevo_usuario_enid_service");

    }

    function frm_registro()
    {

        $config = [
            "class" => "form-miembro-enid-service",
            "id" => "form-miembro-enid-service"
        ];
        $r[] = form_open("", $config);
        $r[] = input_frm(
            "mt-5", "TU NOMBRE",
            [
                "name" => "nombre",
                "placeholder" => "TU NOMBRE",
                "class" => "nombre_persona registros_nombre_persona",
                "type" => "text",
                "required" => true,
                "id" => "registro_nombre",
            ],
            _text_nombre
        );
        $r[] = place("place_nombre_info");
        $r[] = input_frm("mt-5", "CORREO ELECTRÓNICO",
            [
                "name" => "email",
                "placeholder" => "CORREO",
                "class" => "email registro_email ",
                "type" => "email",
                "required" => true,
                "onkeypress" => "minusculas(this);",
                "id" => "registro_email",
            ], _text_correo
        );

        $r[] = input_frm(
            "mt-5", "NÚMERO TELÉFONICO",
            [
                "id" => "tel",
                "class" => "tel texto_telefono",
                "type" => "tel",
                "required" => true,

            ], _text_telefono
        );

        $r[] = place("place_correo_incorrecto");
        $r[] = input_frm(
            "mt-5", "UNA CONTRASEÑA",
            [
                "id" => "password",
                "placeholder" => "UNA CONTRASEÑA ",
                "class" => "password registro_pw",
                "type" => "password",
                "required" => true,
                "id" => "registro_pw",

            ], _text_pass
        );


        $perfil[] = [
            'nombre_perfil' => 'Quiero vender',
            'id_perfil' => 6
        ];
        $perfil[] = [
            'nombre_perfil' => 'Quiero comprar',
            'id_perfil' => 20
        ];
        $perfil[] = [
            'nombre_perfil' => 'Quiero hacer entregas',
            'id_perfil' => 21
        ];

        $r[] = create_select(
            $perfil,
            'perfil',
            'perfil form-control mt-5',
            'perfil',
            'nombre_perfil',
            'id_perfil'
        );

        $r[] = a_texto('¿Cómo funciona?',
            [
                "href" => path_enid('sobre_vender'),
                "class" =>  "mt-3"
            ]
        );
        $r[] = place("place_password_afiliado");
        $r[] = tipo_distribucion();
        $r[] = btn('Registrar',
            [
                "class" => "mt-5 botton_registro",
            ]
        );

        $r[] = form_close(place("place_registro_miembro"));

        return append($r);

    }

    function tipo_distribucion()
    {

        $response = [];

        $titulo = "¿EN QUÉ PUEDES REPARTIR?";

        $reparto_auto = a_enid(
            "AUTO",
            [
                "id" => 0,
                "class" => _text_(
                    'button_enid_eleccion auto'
                )

            ]
        );

        $confirmar = a_enid(
            "MOTO",
            [
                "id" => 0,
                "class" => _text_(
                    'button_enid_eleccion moto'
                )

            ]
        );

        $bicicleta_reparto = a_enid(
            'BICICLETA',
            [
                "id" => 0,
                "class" => _text_(
                    'button_enid_eleccion bicicleta'
                )
            ]
        );

        $pie = a_enid(
            'PIE',
            [
                "id" => 0,
                "class" => _text_(
                    'button_enid_eleccion pie'
                )
            ]
        );

        $seccion_entrega = eleccion_seleccion($titulo, $reparto_auto, $confirmar, $bicicleta_reparto, $pie);

        $response[] = hiddens(
            [
                "name" => "auto",
                "class" => "tiene_auto",
                "value" => 0
            ]
        );
        $response[] = hiddens(
            [
                "name" => "moto",
                "class" => "tiene_moto",
                "value" => 0
            ]
        );
        $response[] = hiddens(
            [
                "name" => "bicicleta",
                "class" => "tiene_bicicleta",
                "value" => 0
            ]
        );

        $response[] = hiddens(
            [
                "name" => "reparte_a_pie",
                "class" => "reparte_a_pie",
                "value" => 0
            ]
        );

        $response[] = d($seccion_entrega, 'seccion_entrega mt-5 d-none');
        return append($response);

    }

    function eleccion_seleccion($titulo, $reparto_auto, $a, $b, $c, $ext = '')
    {

        $response[] = _titulo($titulo);
        $contenido = [$reparto_auto, $a, $b, $c];
        $response[] = d($contenido, _text_('d-flex mt-5 justify-content-between ', $ext));
        return d($response);
    }

    function frm_login()
    {

        $attr = add_attributes(
            [
                "class" => "form_sesion_enid",
                "id" => "in",
                "method" => "POST",
                "action" => base_url('index.php/api/sess/start'),
            ]
        );
        $form[] = "<form " . $attr . ">";
        $form[] = input(
            [
                "name" => mt_rand(),
                "value" => mt_rand(),
                "type" => "hidden",
            ]
        );
        $form[] = input(
            [
                "type" => 'hidden',
                "name" => 'secret',
                "id" => "secret",
            ]
        );

        $form[] = input_frm(
            " mt-4 mb-2", "CORREO ELECTRÓNICO",
            [
                "type" => "email",
                "name" => 'mail',
                "id" => "mail_acceso",
                "onkeypress" => "minusculas(this);",
                "placeholder" => "Aquí va tu email",
                
            ], _text_correo
        );


        $input_password = input_frm(
            "mt-5", "PASSWORD",
            [
                "type" => "password",
                "placeholder" => "Tu contraseña",
                "name" => 'pw',
                "id" => "pw",
                "placeholder" => "****",
            ],
            _text_password
        );

        $iconos = _text_(
            icon("fa fa-eye mostrar_password"),
            icon("fa fa-eye-slash ocultar_password d-none")
        );
        $form[] = flex($input_password, $iconos, _between, "w-100", "mt-5");


        $form[] = btn("INICIAR", ["class" => "mt-5"]);
        $form[] = form_close();

        return append($form);

    }

}
