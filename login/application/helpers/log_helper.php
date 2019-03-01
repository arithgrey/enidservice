<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function get_format_olvide_pw($action){

        $r[] = place("place_acceso_sistema top_20 bottom_20");
        $r[] = anchor_enid(
            "¿OLVIDASTE TU CONTRASEÑA?",
            [
                "id" => "olvide-pass",
                "class" => "recupara-pass  olvide_pass "
            ],
            1
        );
        $r[] = anchor_enid(
            div(strong("¿ERES NUEVO?", ["class" => "black"]) . "  REGISTRA UNA AHORA!", ['class' => 'llamada-a-la-accion '])
            ,
            ['class' => 'registrar-cuenta registrar_cuenta']
        ) ;
        $r[] = get_mensaje_cuenta($action);
        return append_data($r);

    }
    function get_format_recuperacion_pw(){
        $r[] =  anchor_enid("ACCEDER AHORA!",
            [
                "class" => "btn_acceder_cuenta_enid a_enid_blue",
                "id" => "btn_acceder_cuenta_enid",
                "style" => "color: white!important"
            ],
            1
        );
        $r[] =  anchor_enid(div(div(img(["src" => "../img_tema/enid_service_logo.jpg"]), ["class" => "col-lg-6 col-lg-offset-3"]), ["class" => "col-lg-4 col-lg-offset-4"]), ["href" => "../"], 1);

        $r[] = get_btw(
                heading('RECUPERA TUS DATOS DE ACCESO', 3),
                get_form_recuperacion(),
            "col-lg-4 col-lg-offset-4"

        );
        return append_data($r);

    }
    function get_format_nuevo_usuario()
    {
        $r[] = anchor_enid(
            "ACCEDER AHORA",
            [
                "class" => "btn_acceder_cuenta_enid a_enid_blue",
                "id" => "btn_acceder_cuenta_enid",
                'style' => "color:white!important"

            ]
        );
        $r[] = addNRow(div(div(anchor_enid(img(["src" => "../img_tema/enid_service_logo.jpg"])), ["class" => "col-lg-6 col-lg-offset-3"]), ["class" => "col-lg-4 col-lg-offset-4"]));
        $r[] = addNRow(div(heading('ÚNETE A ENID SERVICE', 3), ["class" => "col-lg-4 col-lg-offset-4"]));
        $r[] = div(get_form_registro(), ["class" => "col-lg-4 col-lg-offset-4"]);
        return append_data($r);


    }

    function get_mensaje_cuenta($action)
    {

        $text = ($action === "registro") ? div("COMPRA O VENDE ACCEDIENDO A TU CUENTA!", ["class" => "mensaje_bienvenida"]) : "";
        return $text;
    }

    function get_form_recuperacion()
    {

        $r[] = "<form class='form-pass' id='form-pass' action='" . url_recuperacion_password() . "'>";
        $r[] = input([
            "type" => "email",
            "id" => "email_recuperacion",
            "name" => 'mail',
            "placeholder" => "Email",
            "class" => "form-control input-sm",
            "required" => true]);
        $r[] = div(
            "Ingresa tu correo electrónico para que tu contraseña 
                                pueda ser enviada",
            ["class" => 'msj-recuperacion'],
            1
        );
        $r[] = guardar("Enviar",
            ["class" => "btn_nnuevo recupera_password btn a_enid_blue"]);


        $r[] = form_close(place("place_recuperacion_pw") . place("recuperacion_pw"));

        return append_data($r);

    }

    function get_form_registro()
    {

        $r[] = '<form class="form-miembro-enid-service" id="form-miembro-enid-service">';
        $r[] = input([

            "name" => "email",
            "placeholder" => "CORREO ELECTRÓNICO",
            "class" => "form-control input-sm email email",
            "type" => "email",
            "required" => true,
            "onkeypress" => "minusculas(this);"]);

        $r[] = place("place_correo_incorrecto");

        $r[] = input([
            "name" => "nombre",
            "placeholder" => "TU NOMBRE",
            "class" => "form-control input-sm  nombre nombre_persona",
            "type" => "text",
            "required" => true]);
        $r[] = place("place_nombre_info");

        $r[] = input([
            "id" => "password",
            "placeholder" => "UNA CONTRASEÑA ",
            "class" => "form-control input-sm password",
            "type" => "password",
            "required" => true]);

        $r[] = place("place_password_afiliado");
        $r[] = guardar('Registrar');
        $r[] = form_close(place("place_registro_miembro"));
        return append_data($r);


    }

    if (!function_exists('get_form_login')) {

        function get_form_login()
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
                "class" => 'form-control input-sm ',
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
                "id" => "pw"], 1);

            $r[] = add_element(
                "INICIAR SESIÓN",
                "button",
                ['class' => 'a_enid_blue'],
                1);

            $r[] = form_close();
            return append_data($r);


        }

    }

}