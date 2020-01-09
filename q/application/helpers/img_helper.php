<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_faq($id_faq)
    {

        $r[] = form_open("", [

            "accept-charset" => "utf-8",
            "method" => "POST",
            "id" => "form_img_enid_faq",
            "class" => "form_img_enid_faq",
            "enctype" => "multipart/form-data"

        ]);
        $r[] = input(
            [
                "type" => "file",
                "id" => 'imagen_img_faq',
                "class" => 'imagen_img_faq',
                "name" => "imagen"
            ]
        );
        $r[] = hiddens(
            [
                "name" => 'q',
                "value" => 'faq'
            ]
        );
        $r[] = hiddens(
            [
                "class" => 'dinamic_img_faq',
                "id" => 'dinamic_img_faq',
                "name" => 'id_faq',
                "value" => $id_faq
            ]
        );

        $x[] = place("lista_imagenes_faq", ["id" => 'lista_imagenes_faq']);

        $x[] = btn(
            text_icon("fa fa-check", " AGREGAR "),
            [
                "type" => "submit",
                "id" => 'guardar_img_faq',
                "style" => 'color:white;'
            ]
        );

        $r[] = d(append($x), 6, 1);

        $r[] = form_close(place("place_load_img_faq"));

        return append($r);


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

        $r[] = input(
            [
                "type" => "file",
                "id" => "imagen_img",
                "class" => "imagen_img",
                "name" => "imagen"
            ]
        );

        $r[] = hiddens(
            [
                "name" => 'q',
                "value" => $nombre_archivo
            ]
        );
        $r[] = hiddens(
            [
                "class" => 'dinamic_img',
                "id" => 'dinamic_img',
                "name" => 'dinamic_img'
            ]
        );

        $r[] = btn(
            text_icon("fa fa-check", "AGREGAR IMAGEN")
            ,
            [
                "class" => 'guardar_img_enid display_none bottom_30 display_none',
                "id" => 'guardar_img'
            ],
            1,
            1
        );

        $r[] = place(
            "place_load_img",
            [
                "id" => "place_load_img"
            ]
        );
        $r[] = form_close();

        return append($r);

    }

    function form_img($q, $q2, $q3)
    {


        $r[] = form_open_multipart('',

            [
                "accept-charset" => "utf-8",
                "method" => "POST",
                "id" => "form_img_enid",
                "class" => "form_img_enid"
            ]
        );

        $r[] = input(
            [
                "type" => "file",
                "id" => "imagen_img",
                "class" => "imagen_img",
                "name" => "imagen",
                "enctype" => "multipart/form-data",
                "size" => "25",
                "multiple" => true
            ], 0, 0
        );

        $r[] = hiddens(["name" => 'q', "value" => $q, "class" => "q_imagen"]);
        $r[] = hiddens(["name" => $q2, "value" => $q3, "class" => "q2_imagen"]);
        $r[] = hiddens(["class" => 'dinamic_img', "id" => 'dinamic_img', "name" => 'dinamic_img']);
        $r[] = d(place("place_load_img row", ["id" => 'place_load_img']), 12);

        $width = (is_mobile()) ? 'w-100' : 'w-50';
        $r[] = d(
            btn(
                text_icon("fa fa-check", "AGREGAR IMAGEN"),
                [
                    "class" => 'guardar_img_enid mt-3',
                    "id" => 'guardar_img'
                ]
            ), _text_("d-none btn_guardar_imagen my-auto mx-auto", $width));

        $place = place("previsualizacion",
            [
                "id" => "previsualizacion"
            ]
        );
        $r[] = form_close($place);
        return append($r);

    }

}

