<?php

use function PHPUnit\Framework\returnSelf;

 if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function page_sigin($action, $data, $param)
    {   
        
        $r[] = nuevo_usuario($data, $param);
        $r[] = recuperacion();
        $r[] = frm_acceso($action, $data);
        $r[] = hiddens(
            [
                "class" => "action",
                "value" => $action,
            ],
            1
        );
            
        return d($r, 'col-md-4 col-md-offset-4 ');
        
    }

    function frm_acceso($action, $data)
    {
        $r[] = img_default();
        $r[] = frm_login($data);
        if ($action === "registro") {

            $clases = "inf_usuario_registrado  mt-5 bg-light p-2 text-right f12 strong border border-secondary";
            $r[] = d("Te registrasté, ingresa ahora!", $clases);
        }
        $r[] = place("place_acceso_sistema mt-5 mb-5");
        $x[] = a_enid("¿ERES NUEVO?   REGISTRATE!", ["class" => 'black registrar_cuenta strong mt-1']);
        $x[] = a_enid(
            "¿Olvidasté tu contraseña?",
            [
                "id" => "olvide-pass",
                "class" => "recupara-pass black olvide_pass mt-3 underline",
            ]
        );
        $r[] = append($x);

        return d($r, " wrapper_login");

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
        $r[] = h('RECUPERA TUS DATOS DE ACCESO', 3,'strong');
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
                    'class' => 'fp9 top_50 black bottom_100 btn_acceder_cuenta_enid underline',
                ]
            ),
            "text-center"
        );
    }

    function nuevo_usuario($data,$param)
    {

        $r[] = d(d("Primero registremos tu usuario!","f15 bg_black borde_amarillo white"),'d-none texto_registro');
        $r[] = img_default();

        $formulario[] = _titulo('Registro');
        $formulario[] = frm_registro($data, $param);
        $r[] = d($formulario,'formulario_registro');

        $r[] = ya_registro();

        return d($r, "seccion_registro_nuevo_usuario_enid_service");

    }

    function frm_registro($data, $param)
    {

        $config = [
            "class" => "form-miembro-enid-service",
            "id" => "form-miembro-enid-service"
        ];
        $r[] = form_open("", $config);
        $r[] = input_frm(
            "mt-5", "NOMBRE",
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
        $r[] = input_frm("mt-5", "email",
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


        
        $perfil[] = gestion_perfil($param);

    
        $r[] = create_select(
            $perfil,
            'perfil',
            'perfil form-control mt-5 borde_black black d-none',
            'perfil',
            'nombre_perfil',
            'id_perfil'
        );

        $r[] = place("place_password_afiliado");
        $r[] = tipo_distribucion();
        $r[] = btn('Registrar',
            [
                "class" => "mt-5 botton_registro",
            ]
        );

        $r[] = form_close(place("place_registro_miembro"));
        
        $r[] = format_link( text_icon('fa fa-google white',"Registrate Google"),
        [
            "href" => $data["link_registro_google"],
            'class' => "mt-3 registro_google"
        ],2);

        return append($r);

    }
    function gestion_perfil($param){

        $q = prm_def($param, "q");
        $perfil = [
            'nombre_perfil' => 'Quiero comprar',
            'id_perfil' => 20
        ];
        switch ($q) {
            /*Afiliado*/
            case 23874:		

                $perfil = [
                    'nombre_perfil' => 'Quiero ser afiliado - vender artículos de enid service para ganar comisiones',
                    'id_perfil' => 6
                ];
                break;
        
            
            case 18369:
                $perfil = [
                    'nombre_perfil' => 'Quiero hacer entregas',
                    'id_perfil' => 21
                ];

                break;
        
            default:
               
            break;
        }

        return $perfil;

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

    function frm_login($data)
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


        
        $form[] = h('INICIAR SESIÓN', 2,'text-uppercase strong');
        $form[] = d("Vamos a comprobar si ya tienes una cuenta",'black mb-3');

        //$form[] = h('Correo electrónico', 5,'text-uppercase mt-4');
        $form[] = input(            
            [
                "type" => "email",
                "name" => 'mail',                
                "id" => "mail_acceso",
                "onkeypress" => "minusculas(this);",
                "placeholder" => "Correo electrónico",
                "class" =>" input-field mh_50 border border-dark  solid_bottom_hover_3     form-control "
                
            ], _text_correo
        );
        

        $input_password = input(            
            [
                "type" => "password",
                "placeholder" => "Contraseña",
                "name" => 'pw',
                "id" => "pw",  
                "class" => " input-field mh_50 border border-dark  solid_bottom_hover_3 form-control "
            ],
            _text_password
        );

        $iconos = _text_(
            icon("fa fa-eye mostrar_password"),
            icon("fa fa-eye-slash ocultar_password d-none")
        );
        $form[] = flex($input_password, $iconos,
         _text_(_between,'mt-4'), 
         "w-100",
        "border border-dark p-4"
    );


        $form[] = btn("CONTINUAR", ["class" => "mt-5"]);
        $form[] = form_close();
     


        $form_google[] = format_link( 
            text_icon('fa fa-google ',"Accede con Google"),
            ["href" => $data["auth_url"]],0);

        $form[] =  d($form_google,'borde_black mt-5');
        
        return append($form);

    }

}
