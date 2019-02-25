<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_form_ubicacion')) {

        function get_form_ubicacion($servicio)
        {

            $r[] = form_open("", ["class" => "form-horizontal form_correo"]);
            $r[] = label(" NOMBRE ", ["class" => "col-lg-4 control-label"]);
            $r[] = div(input([
                "id" => "nombre",
                "name" => "nombre",
                "type" => "text",
                "placeholder" => "Tu nombre ",
                "class" => "form-control input-md nombre"
            ]), ["class" => "col-lg-8"]);

            $r[] = label(icon("fa fa-envelope-o") . " CORREO ", ["class" => "col-lg-4 control-label"]);
            $r[] = input_hidden(["class" => "servicio", "value" => $servicio, "name" => "servicio"]);

            $r[] = div(append_data([

                input([
                    "id" => "correo",
                    "name" => "email",
                    "type" => "email",
                    "placeholder" => "@",
                    "class" => "form-control input-md correo_electronico"
                ])
                ,


                div("INGRESA TU EMAIL  PARA RECIBIR NUESTRA UBICACIÓN")


            ]), ["class" => "col-lg-8"]);


            $r[] = guardar("RECIBIR  UBICACIÓN", ["class" => "top_20"]);
            $r[] = form_close();
            return append_data($r);


        }
    }

    if (!function_exists('get_form_whatsapp')) {

        function get_form_whatsapp($servicio)
        {

            $r[] = form_open("", ["class" => "form-horizontal form_whatsapp"]);
            $r[] = label(" NOMBRE ", ["class" => "col-lg-4 control-label"]);

            $r[] = div(input([
                "id" => "nombre",
                "name" => "nombre",
                "type" => "text",
                "placeholder" => "Tu nombre ",
                "class" => "form-control input-md nombre_whatsapp"
            ]), ["class" => "col-lg-8"]);

            $r[] = label(icon(".fa fa-whatsapp") . " WHATSAPP", ["class" => "col-lg-4 control-label"]);
            $r[] = div(input([
                "id" => "whatsapp",
                "name" => "whatsapp",
                "type" => "tel",
                "class" => "form-control input-md tel telefono_info_contacto",
                "required" => true
            ]), ["class" => "col-lg-8"]);

            $r[] = div("INGRESA TU WHATSAPP PARA RECIBIR NUESTRA UBICACIÓN");
            $r[] = input_hidden(["class" => "servicio", "value" => $servicio, "name" => "servicio"]);

            $r[] = guardar("RECIBIR  UBICACIÓN", ["class" => "top_20"]);
            $r[] = form_close();
            return append_data($r);


        }
    }
    if (!function_exists('get_form_contactar')) {
        function get_form_contactar($departamentos, $nombre, $email, $telefono)
        {


            $r[] = '<form id="form_contacto" action="../q/index.php/api/contacto/format/json/" method="post">';
            $r[] = div(p("Departamento ", ['class' => 'white']), ["class" => "col-sm-3"]);
            $r[] = div(create_select(
                $departamentos,
                "departamento",
                "departamento form-control input_enid",
                "departamento",
                "nombre",
                "id_departamento"), ["class" => "col-sm-9"]);
            $r[] = div(p("Nombre", ['class' => 'white']), ["class" => "col-sm-2"]);
            $r[] = div(input([
                "type" => "text"
                , "id" => "nombre"
                , "name" => "nombre"
                , "class" => "input-sm input input_enid"
                , "placeholder" => "Nombre"
                , "value" => $nombre
            ]), ["class" => "col-sm-10"]);

            $r[] = div(p("Correo", ['class' => 'white']), ["class" => "col-sm-2"]);
            $r[] = div(input([
                "onkeypress" => "minusculas(this);",
                "type" => "email",
                "id" => "emp_email",
                "name" => "email",
                "value" => $email,
                "class" => "input-sm input_enid",
                "placeholder" => "Email"
            ]), ["class" => "col-sm-10"]);
            $r[] = place('place_mail_contacto', ["id" => 'place_mail_contacto']);
            $r[] = div(p("Teléfono", ['class' => 'white']), ["class" => "col-sm-2"]);
            $r[] = div(input([
                "id" => "tel",
                "name" => "tel",
                "type" => "tel",
                "class" => "input-sm telefono_info_contacto input_enid",
                "placeholder" => "Teléfono  de contacto",
                "value" => $telefono
            ]), ["class" => "col-sm-10"]);
            $r[] = place('place_tel_contacto', ["id" => 'place_tel_contacto']);


            $r[] = p("Mensaje", ['class' => 'white']);

            $r[] = textarea([
                "id" => "message",
                "name" => "mensaje",
                "placeholder" => "Mensaje"
            ]);

            $r[] = place("place_registro_contacto");
            $r[] = addNRow(guardar("Enviar mensaje", ["id" => 'btn_envio_mensaje'], 1));
            $r[] = form_close();

            return append_data($r);

        }

    }
    if (!function_exists('get_form_mensaje')) {
        function get_form_mensaje($departamentos, $email,$telefono)
        {

            $r[] = '<form id="form_contacto" action="../msj/index.php/api/emp/contacto/format/json/" method="post">';
            $r[] = div("Departamento ", ["class" => "col-sm-3 white strong"]);
            $r[] = create_select(
                $departamentos,
                "departamento",
                "departamento form-control input_enid col-sm-9",
                "departamento",
                "nombre",
                "id_departamento");;
            $r[] = div("Nombre", ["class" => "col-sm-2"]);
            $r[] = input([
                "type" => "text",
                "id" => "nombre",
                "name" => "nombre",
                "class" => "input-sm input input_enid col-sm-10",
                "placeholder" => "Nombre",
                "value" => $departamentos
            ]);
            $r[] = div("Correo", ["class" => "col-sm-2"]);
            $r[] = input([
                "onkeypress" => "minusculas(this);",
                "type" => "email",
                "id" => "emp_email",
                "name" => "email",
                "value" => $email,
                "class" => "input-sm input_enid col-sm-10",
                "placeholder" => "Email"
            ]);
            $r[] = place("place_mail_contacto", ["id" => "place_mail_contacto"]);
            $r[] = div("Teléfono", ["class" => "col-sm-2"]);
            $r[] = input([
                "id" => "tel",
                "name" => "tel",
                "type" => "tel",
                "class" => "input-sm telefono_info_contacto input_enid col-sm-10",
                "placeholder" => "Teléfono  de contacto",
                "value" => $telefono
            ]);
            $r[] = place("place_tel_contacto", ["id" => 'place_tel_contacto']);
            $r[] = div("Mensaje", ["class" => "col-sm-12"]);
            $r[] = textarea([
                "id" => "message",
                "name" => "mensaje",
                "placeholder" => "Mensaje"
            ], 1);
            $r[] = place("place_registro_contacto");
            $r[] = div(guardar("Enviar mensaje",
                ["type" => "submit", "class" => "btn input-sm", "id" => 'btn_envio_mensaje']),
                ["class" => "col-lg-6"]);
            $r[] = form_close();

            return append_data($r);

        }

    }

}

