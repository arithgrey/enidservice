<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function page_sigin($action)
    {

        $r[] = format_nuevo_usuario();
        $r[] = format_recuperacion_pw();
        $r[] = frm_acceso($action);
        $r[] = input_hidden(
            [
                "class" => "action",
                "value" => $action],
            1
        );

        $response = d(append($r), 4, 1);
        return d($response, 1);


    }

    function frm_acceso($action)
    {


        $r[] = a_enid(img_enid(),
            [
                "href" => path_enid("home"),
                "class" => "col-lg-8 col-lg-offset-2"
            ]
            , 1
        );

        $r[] = d(frm_login(), 1);
        $r[] = place("place_acceso_sistema top_20 bottom_20");
        $x[] = a_enid("¿ERES NUEVO?   REGISTRATE!", ["class" => 'registrar-cuenta registrar_cuenta']);
        $x[] = a_enid(
            "¿OLVIDASTE TU CONTRASEÑA?",
            [
                "id" => "olvide-pass",
                "class" => "recupara-pass  olvide_pass top_30"
            ],
            1
        );

        $r[] = d(append($x), "text-center top_50 bottom_100");
        $r[] = ($action === "registro") ? d("COMPRA O VENDE ACCEDIENDO A TU CUENTA!", "mensaje_bienvenida") : "";
        $response = d(append($r));
        return d($response, "wrapper_login", 1);

    }

    function format_recuperacion_pw()
    {

        $r[] = a_enid(img_enid(),
            [
                "href" => path_enid("home"),
                "class" => "col-lg-8 col-lg-offset-2"
            ], 1
        );

        $r[] = heading('RECUPERA TUS DATOS DE ACCESO', 3, 1);

        $r[] = "<form class='form-pass' id='form-pass' action='" . url_recuperacion_password() . "'>";
        $r[] = input(
            [
                "type" => "email",
                "id" => "email_recuperacion",
                "name" => 'mail',
                "placeholder" => "Email",
                "class" => "form-control input-sm top_10",
                "required" => true
            ]);
        $r[] = d("Ingresa tu correo electrónico para que tu contraseña pueda ser enviada", 'msj-recuperacion top_10', 1);
        $r[] = btn("Enviar",
            [
                "class" => "btn_nnuevo recupera_password  a_enid_blue top_20"
            ]);

        $r[] = form_close(append([place("place_recuperacion_pw"), place("recuperacion_pw")]));
        $r[] = d(
            a_enid("¿YA ESTÁS REGISTRADO?  ACCEDE!",
                [
                    'class' => 'btn_acceder_cuenta_enid top_50 bottom_100  ',
                    "id" => "btn_acceder_cuenta_enid"
                ]
            ),
            "text-center"
        );

        $response = d(append($r), "contenedor_recuperacion_password display_none", 1);
        return $response;

    }

    function format_nuevo_usuario()
    {


        $r[] = a_enid(img_enid(), ["href" => "../", "class" => "col-lg-8 col-lg-offset-2"], 1);
        $r[] = heading('ÚNETE A ENID SERVICE', 3, 1);
        $r[] = d(get_form_registro(), 1);
        $r[] = d(
            a_enid("¿YA ESTÁS REGISTRADO?  ACCEDE!",
                [
                    'class' => 'btn_acceder_cuenta_enid top_50 inline-block bottom_100',
                    "id" => "btn_acceder_cuenta_enid"
                ]),
            "text-center"
        );


        $response = d(append($r), "seccion_registro_nuevo_usuario_enid_service", 1);
        return $response;


    }

    function get_form_registro()
    {

        $r[] = '<form class="form-miembro-enid-service" id="form-miembro-enid-service">';
        $r[] = input(
            [
                "name" => "email",
                "placeholder" => "CORREO ELECTRÓNICO",
                "class" => "form-control input-sm email email",
                "type" => "email",
                "required" => true,
                "onkeypress" => "minusculas(this);"]);

        $r[] = place("place_correo_incorrecto");

        $r[] = input(
            [
                "name" => "nombre",
                "placeholder" => "TU NOMBRE",
                "class" => "form-control input-sm  nombre nombre_persona top_10",
                "type" => "text",
                "required" => true]);
        $r[] = place("place_nombre_info");

        $r[] = input(
            [
                "id" => "password",
                "placeholder" => "UNA CONTRASEÑA ",
                "class" => "form-control input-sm password top_10",
                "type" => "password",
                "required" => true]);

        $r[] = place("place_password_afiliado");
        $r[] = btn('Registrar',
            [
                "class" => "top_20"
            ]);
        $r[] = form_close(place("place_registro_miembro"));
        return append($r);


    }

    if (!function_exists('frm_login')) {

        function frm_login()
        {

            $attr = add_attributes([
                "class" => "form_sesion_enid",
                "id" => "in",
                "method" => "POST",
                "action" => base_url('index.php/api/sess/start/format/json')]);

            $r[] = "<form " . $attr . ">";

            $r[] = input([
                "name" => get_random(),
                "value" => get_random(),
                "type" => "hidden"]);

            $r[] = input([
                "type" => 'hidden',
                "name" => 'secret',
                "id" => "secret"]);

            $r[] = input([
                "class" => 'form-control input-sm top_10',
                "type" => "mail",
                "name" => 'mail',
                "id" => "mail",
                "onkeypress" => "minusculas(this);",
                "placeholder" => "TU CORREO ELECTRÓNICO"
            ]);

            $r[] = input([
                "type" => "password",
                "placeholder" => "Tu contraseña",
                "name" => 'pw',
                "id" => "pw",
                "class" => "top_10"
            ], 1);

            $r[] = add_element(
                "INICIAR SESIÓN",
                "button",
                ['class' => 'a_enid_blue top_20'],
                1);

            $r[] = form_close();
            return append($r);

        }

    }

}