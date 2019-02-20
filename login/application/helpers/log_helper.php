<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

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