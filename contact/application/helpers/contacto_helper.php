<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_format_proceso_compra')) {
        function get_format_proceso_compra()
        {

            $r[] = div(heading_enid("¿Quieres aparta tu pedido?", 2, ["class" => "strong"]), 1);
            $r[] = div(get_selector_direccion(), 1);
            return div(append_data($r), 10, 1);


        }
    }
    if (!function_exists('get_format_eleccion')) {
        function get_format_eleccion()
        {

            $config = [
                "class" => "easy_select_enid cursor_pointer selector",
                "id" => 1
            ];

            $r[] = div(icon("fa fa-envelope-o") . " CORREO",
                $config
            );

            $r[] = div(icon("fa fa-whatsapp") . " WHATSAPP", ["class" => "easy_select_enid cursor_pointer selector"
                ,
                "id" => 2]);

            return append_data($r);

        }
    }
    if (!function_exists('get_selector_direccion')) {
        function get_selector_direccion()
        {

            $r[] = anchor_enid(div(icon("fa fa-shopping-cart") . " SI",
                ["class" => "easy_select_enid cursor_pointer selector selector_proceso",
                    "id" => 1]),
                ["href" => "../lista_deseos"]);

            $r[] = anchor_enid(div(icon("fa fa-map-marker") . "NO, VER DIRECCIÓN DE COMPRA",
                [
                    "class" => "easy_select_enid cursor_pointer selector selector_proceso",
                    "id" => 2
                ]), ["href" => "../contact/?ubicacion=1#direccion"]);

            return append_data($r);

        }
    }
    if (!function_exists('get_form_proceso_compra')) {

        function get_form_proceso_compra()
        {

            $r[] = '<form action="../contact/?w=1" method="post" class="form_proceso_compra">';
            $r[] = input_hidden(["class" => "proceso_compra", "value" => 1, "name" => "proceso_compra"]);
            $r[] = form_close();
            return append_data($r);

        }

    }
    if (!function_exists('format_direccion')) {

        function format_direccion($ubicacion, $departamentos, $nombre, $email, $telefono)
        {

            $r[] = get_format_visitanos($ubicacion);
            $r[] = format_direccion_map($ubicacion);
            $r[] = get_form_contactar($ubicacion, $departamentos, $nombre, $email, $telefono);

            return append_data($r);

        }

    }
    if (!function_exists('format_direccion_map')) {
        function format_direccion_map($ubicacion)
        {

            $r[] = get_formar_direccion($ubicacion);
            $r[] = iframe([
                "src" => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.556617993217!2d-99.14322968509335!3d19.431554086884976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDI1JzUzLjYiTiA5OcKwMDgnMjcuOCJX!5e0!3m2!1ses!2s!4v1489122764846",
                "width" => "100%",
                "height" => "380"
            ]);

            return div(append_data($r), 6);
        }
    }
    if (!function_exists('get_formar_direccion')) {

        function get_formar_direccion($ubicacion)
        {

            $response = "";
            if ($ubicacion < 1) {
                $response = heading(
                    "Eje Central Lázaro Cárdenas 38, Centro Histórico C.P. 06000 CDMX, local número 406",
                    4,
                    ["class" => "white"
                    ]
                );

            }
            return $response;
        }
    }
    if (!function_exists('get_format_visitanos')) {

        function get_format_visitanos($ubicacion)
        {

            $response = "";
            if ($ubicacion > 0) {
                $r[] = heading("VISÍTANOS!", 1, ["class" => "white"]);
                $r[] = br();
                $r[] = heading(
                    "Eje Central Lázaro Cárdenas 38, Centro Histórico C.P. 06000 CDMX, local número 406",
                    4,
                    [
                        "class" => "white"
                    ]
                );

                $response = div(append_data($r), 6);
            }
            return $response;


        }

    }
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
            ]), 8);

            $r[] = label(icon("fa fa-envelope-o") . " CORREO ", 4);
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


            ]), 8);


            $r[] = guardar("RECIBIR  UBICACIÓN", ["class" => "top_20"]);
            $r[] = form_close();
            return append_data($r);


        }
    }

    if (!function_exists('get_form_whatsapp')) {

        function get_form_whatsapp($servicio)
        {

            $r[] = form_open("", ["class" => "form-horizontal form_whatsapp"]);
            $r[] = div(" NOMBRE ", 4);

            $r[] = div(input([
                "id" => "nombre",
                "name" => "nombre",
                "type" => "text",
                "placeholder" => "Tu nombre ",
                "class" => "form-control input-md nombre_whatsapp"
            ]), 8);

            $r[] = div(icon(".fa fa-whatsapp") . " WHATSAPP", 4);
            $r[] = div(input([
                "id" => "whatsapp",
                "name" => "whatsapp",
                "type" => "tel",
                "class" => "form-control input-md tel telefono_info_contacto",
                "required" => true
            ]), 8);

            $r[] = div("INGRESA TU WHATSAPP PARA RECIBIR NUESTRA UBICACIÓN");
            $r[] = input_hidden(["class" => "servicio", "value" => $servicio, "name" => "servicio"]);

            $r[] = guardar("RECIBIR  UBICACIÓN", ["class" => "top_20"]);
            $r[] = form_close();
            return append_data($r);


        }
    }
    if (!function_exists('get_form_contactar')) {
        function get_form_contactar($ubicacion, $departamentos, $nombre, $email, $telefono)
        {


            $response = "";
            if ($ubicacion < 1) {


                $r[] = '<form id="form_contacto" action="../q/index.php/api/contacto/format/json/" method="post">';
                $r[] = div(p("Departamento ", ['class' => 'white']), 3);
                $r[] = div(create_select(
                    $departamentos,
                    "departamento",
                    "departamento form-control input_enid",
                    "departamento",
                    "nombre",
                    "id_departamento"), 9);
                $r[] = div(p("Nombre", ['class' => 'white']), 2);
                $r[] = div(input([
                    "type" => "text"
                    , "id" => "nombre"
                    , "name" => "nombre"
                    , "class" => "input-sm input input_enid"
                    , "placeholder" => "Nombre"
                    , "value" => $nombre
                ]), 10);

                $r[] = div(p("Correo", ['class' => 'white']), 2);
                $r[] = div(input([
                    "onkeypress" => "minusculas(this);",
                    "type" => "email",
                    "id" => "emp_email",
                    "name" => "email",
                    "value" => $email,
                    "class" => "input-sm input_enid",
                    "placeholder" => "Email"
                ]), 10);
                $r[] = place('place_mail_contacto', ["id" => 'place_mail_contacto']);
                $r[] = div(p("Teléfono", ['class' => 'white']), 2);
                $r[] = div(input([
                    "id" => "tel",
                    "name" => "tel",
                    "type" => "tel",
                    "class" => "input-sm telefono_info_contacto input_enid",
                    "placeholder" => "Teléfono  de contacto",
                    "value" => $telefono
                ]), 10);

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

                $response = div(append_data($r), 6);

            }
            return $response;


        }

    }
    if (!function_exists('get_form_mensaje')) {
        function get_form_mensaje($departamentos, $email, $telefono)
        {

            $r[] = '<form id="form_contacto" action="../msj/index.php/api/emp/contacto/format/json/" method="post">';
            $r[] = div("Departamento ", "col-sm-3 white strong" );
            $r[] = create_select(
                $departamentos,
                "departamento",
                "departamento form-control input_enid col-sm-9",
                "departamento",
                "nombre",
                "id_departamento");;
            $r[] = div("Nombre", 2);
            $r[] = div(input([
                "type" => "text",
                "id" => "nombre",
                "name" => "nombre",
                "class" => "input-sm input input_enid",
                "placeholder" => "Nombre",
                "value" => $departamentos
            ]), 10);
            $r[] = div("Correo", 2);
            $r[] = div(input([
                "onkeypress" => "minusculas(this);",
                "type" => "email",
                "id" => "emp_email",
                "name" => "email",
                "value" => $email,
                "class" => "input-sm input_enid",
                "placeholder" => "Email"
            ]), 10);
            $r[] = place("place_mail_contacto", ["id" => "place_mail_contacto"]);
            $r[] = div("Teléfono", 2);
            $r[] = div(input([
                "id" => "tel",
                "name" => "tel",
                "type" => "tel",
                "class" => "input-sm telefono_info_contacto input_enid",
                "placeholder" => "Teléfono  de contacto",
                "value" => $telefono
            ]), 10);
            $r[] = place("place_tel_contacto", ["id" => 'place_tel_contacto']);
            $r[] = div("Mensaje", 12);
            $r[] = textarea([
                "id" => "message",
                "name" => "mensaje",
                "placeholder" => "Mensaje"
            ], 1);
            $r[] = place("place_registro_contacto");
            $r[] = div(guardar("Enviar mensaje",
                ["type" => "submit", "class" => "btn input-sm", "id" => 'btn_envio_mensaje']),
                6);
            $r[] = form_close();

            return append_data($r);

        }

    }

}

