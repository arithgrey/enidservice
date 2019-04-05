<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_faq()
    {

        $r[] = form_open("", [
            "accept-charset" => "utf-8",
            "method" => "POST",
            "id" => "form_img_enid_faq",
            "class" => "form_img_enid_faq",
            "enctype" => "multipart/form-data"
        ]);
        $r[] = input(["type" => "file",
            "id" => 'imagen_img_faq',
            "class" => 'imagen_img_faq',
            "name" => "imagen"]);
        $r[] = input_hidden(["name" => 'q', "value" => 'faq']);
        $r[] = input_hidden(
            ["class" => 'dinamic_img_faq',
                "id" => 'dinamic_img_faq',
                "name" => 'dinamic_img_faq',
                "value" => $id_faq]
        );
        $r[] = place("separate-enid");
        $r[] = guardar(icon("fa fa-check"),
            [
                "type" => "submit",
                "class" => 'btn btn btn-sm guardar_img_enid pull-right',
                "id" => 'guardar_img_faq',
                "style" => 'color:white;'
            ]);
        $r[] = place("separate-enid");
        $r[] = place("lista_imagenes_faq", ["id" => 'lista_imagenes_faq']);
        $r[] = form_close(place("place_load_img_faq"));

        return append_data($r);


    }

    function form_img_usuario($nombre_archivo = 'perfil_usuario')
    {
        $r[] = form_open_multipart('',

            [
                "accept-charset" => "utf-8",
                "method" => "POST",
                "id" => "form_img_enid",
                "class" => "form_img_enid",
                "enctype" => "multipart/form-data"

            ]
        );

        $r[] = input([
            "type" => "file",
            "id" => "imagen_img",
            "class" => "imagen_img",
            "name" => "imagen"
        ]);

        $r[] = input_hidden(["name" => 'q', "value" => $nombre_archivo]);
        $r[] = input_hidden(["class" => 'dinamic_img', "id" => 'dinamic_img', "name" => 'dinamic_img']);

        $r[] = guardar("AGREGAR IMAGEN" . icon("fa fa-check"),
            [
                "class" => 'guardar_img_enid display_none ',
                "id" => 'guardar_img'
            ],
            1,
            1
        );

        $r[] = place("place_load_img", ["id" => "place_load_img"]);
        $r[] = form_close();

        return append_data($r);

    }

    function form_img($q, $q2, $q3)
    {


        $r[] = form_open_multipart('',

            [
                "accept-charset" => "utf-8",
                "method" => "POST",
                "id" => "form_img_enid",
                "class" => "form_img_enid",
                "enctype" => "multipart/form-data"

            ]
        );

        $r[] = input([
            "type" => "file",
            "id" => "imagen_img",
            "class" => "imagen_img",
            "name" => "imagen",
            "enctype" => "multipart/form-data",
            "size" => "20"
        ]);

        $r[] = input_hidden(["name" => 'q', "value" => $q, "class" => "q_imagen"]);
        $r[] = input_hidden(["name" => $q2, "value" => $q3, "class" => "q2_imagen"]);
        $r[] = input_hidden(["class" => 'dinamic_img', "id" => 'dinamic_img', "name" => 'dinamic_img']);


        $r[] = place("separate-enid");
        $r[] = place("place_load_img", ["id" => 'place_load_img']);
        $r[] = place("separate-enid");

        $r[] = guardar("AGREGAR IMAGEN" . icon("fa fa-check"),
            [
                "class" => 'guardar_img_enid ',
                "id" => 'guardar_img'
            ],
            1,
            1
        );

        $r[] = form_close(place("previsualizacion", ["id" => "previsualizacion"]));
        return append_data($r);

    }

}

