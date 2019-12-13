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

        return d(d(append($r), 4, 1), "col-lg-12");

    }

    function frm_acceso($action)
    {
        $r[] = img_default();
        $r[] = frm_login();
        if ($action === "registro") {

            $r[] = contaiter(
                d("Tu usuario fué registrado, accede ahora!",
                    "inf_usuario_registrado strong mt-5 bg-light p-2 text-right"
                )
                ,
                1
            );
        }
        $r[] = place("place_acceso_sistema mt-5 mb-5", 1);
        $x[] = a_enid("¿ERES NUEVO?   REGISTRATE!", ["class" => 'strong black registrar_cuenta f16 strong']);
        $x[] = a_enid(
            "¿OLVIDASTE TU CONTRASEÑA?",
            [
                "id" => "olvide-pass",
                "class" => "recupara-pass  olvide_pass top_30 underline",
            ]
        );
        $r[] = append($x);

        return d(append($r), "text-center  wrapper_login");

    }

    function img_default()
    {
        return contaiter(
            d(
                a_enid(
                    img_enid(
                        [
                            "class" => "w-75"
                        ]
                    ),

                    path_enid("home")

                ), "text-center"
            )
        );
    }

    function recuperacion()
    {

        $r[] = img_default();
        $r[] = h('RECUPERA TUS DATOS DE ACCESO', 3);
        $r[] = "<form class='form-pass' id='form-pass' action='" . url_recuperacion_password() . "'>";
        $r[] = input(
            [
                "type" => "email",
                "id" => "email_recuperacion",
                "name" => 'mail',
                "placeholder" => "Email",
                "class" => " top_10",
                "required" => true,
            ]
        );
        $r[] = d("Ingresa tu correo electrónico y tu contraseña será enviada", 'mt-4');
        $r[] = btn("Enviar",
            [
                "class" => "btn_nnuevo recupera_password  a_enid_blue top_20",
            ]
        );
        $extra = add_text(
            place("place_recuperacion_pw"), place("recuperacion_pw"));
        $r[] = form_close($extra);
        $r[] = ya_registro();
        $response = d(append($r), "contenedor_recuperacion_password display_none");

        return $response;

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
        $r[] = h('ÚNETE', 3);
        $r[] = frm_registro();
        $r[] = ya_registro();

        return d(append($r), "seccion_registro_nuevo_usuario_enid_service");

    }

    function frm_registro()
    {

        $r[] = form_open("", ["class" => "form-miembro-enid-service", "id" => "form-miembro-enid-service"]);

        $r[] = input_frm(
            "mt-5", "TU NOMBRE",
            [
                "name" => "nombre",
                "placeholder" => "TU NOMBRE",
                "class" => "nombre_persona",
                "type" => "text",
                "required" => true,
                "id" => "registro_nombre",
            ]
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
            ]
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

            ]
        );
        $r[] = place("place_password_afiliado");
        $r[] = btn('Registrar',
            [
                "class" => "top_20",
            ]
        );
        $r[] = form_close(place("place_registro_miembro"));

        return append($r);

    }

    function frm_login()
    {

        $attr = add_attributes(
            [
                "class" => "form_sesion_enid",
                "id" => "in",
                "method" => "POST",
                "action" => base_url('index.php/api/sess/start/format/json'),
            ]
        );
        $r[] = "<form " . $attr . ">";
        $r[] = input(
            [
                "name" => mt_rand(),
                "value" => mt_rand(),
                "type" => "hidden",
            ]
        );
        $r[] = input(
            [
                "type" => 'hidden',
                "name" => 'secret',
                "id" => "secret",
            ]
        );
        $r[] = input_frm(
            " mt-4", "CORREO ELECTRÓNICO",
            [

                "type" => "email",
                "name" => 'mail',
                "id" => "mail_acceso",
                "onkeypress" => "minusculas(this);",
                "placeholder" => "ej. jonathan@gmail.com",
            ]
        );
        $r[] = input_frm(
            "mt-5", "PASSWORD",
            [
                "type" => "password",
                "placeholder" => "Tu contraseña",
                "name" => 'pw',
                "id" => "pw",

                "placeholder" => "****",
            ]
        );
        $r[] = btn("INICIAR", ["class" => "mt-5"]);
        $r[] = form_close();

        return append($r);

    }

}
